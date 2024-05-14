<?php

namespace Modules\Translation\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use Illuminate\Http\Request;
use Modules\Translation\App\Models\Language;
use Modules\Translation\App\Models\SystemMessage;
use Modules\Translation\App\Models\SystemMessageTranslation;

class TranslationController extends Controller
{
    public mixed $modelClass = SystemMessage::class;

    public function adminIndex(Request $request)
    {
        $query = $this->modelClass::query()->with('translations');
        $query->select('system_messages.*');
        if ($request->filled('search')) {
            $query->where('system_messages.message', 'LIKE', '%'.$request->get('search').'%');
        }
        $sources = $query->paginate($request->get('per_page'));
        $data = $sources->items();
        $translations = [];
        foreach ($data as $key => $source) {
            $translations[$key] = [
                'id' => $source->id,
                'message' => $source->message,
            ];
            foreach ($source->translations as $translation) {
                $translations[$key][$translation->language] = $translation->message;
            }
        }

        return okResponse($translations, 'ok', 'ok', [
            'meta' => [
                'current_page' => $sources->currentPage(),
                'last_page' => $sources->lastPage(),
                'total' => $sources->total(),
                'path' => $sources->path(),
                'to' => $request->get('to'),
                'per_page' => $request->get('per_page'),
            ],
        ]);
    }

    public function clientIndex()
    {
        return DefaultResource::collection($this->modelClass::all());
    }

    public function store(Request $request)
    {
        $data = $request->toArray();
        if (empty($message = array_shift($data)) && count($data) < 3) {
            return;
        }

        $model = SystemMessage::where(['message' => $message])->first();
        if ($model) {
            return $model;
        }

        $model = SystemMessage::create([
            'key' => 'react',
            'message' => $message,
        ]);
        $this->generateJson();

        return okResponse($model);
    }

    public function show()
    {
        return okResponse();
    }

    public function update(Request $request)
    {
        $data = $request->toArray();
        $model = SystemMessageTranslation::updateOrCreate([
            'system_message_id' => $data['id'],
            'language' => $data['language'],
        ], [
            'message' => $data['message'],
            'system_message_id' => $data['id'],
            'language' => $data['language'],
        ]);
        $data = $this->getData($model);
        $this->generateJson();

        return okResponse($data);
    }

    public function getData($model)
    {
        $langs = Language::where(['status' => 1])->get();
        $data_lang = [];
        foreach ($langs as $lang) {
            $src = SystemMessageTranslation::where(['system_message_id' => $model->system_message_id, 'language' => $lang->code])->first();
            if ($src) {
                $data_lang[$lang->code] = $src->message;
            }
        }
        $message = SystemMessage::where(['id' => $model->system_message_id])->first();

        return [
            'id' => $model->id,
            'message' => $message->message,
            'uz' => empty(array_key_exists('uz', $data_lang)) ? '' : $data_lang['uz'],
            'ru' => empty(array_key_exists('ru', $data_lang)) ? '' : $data_lang['ru'],
            'en' => empty(array_key_exists('en', $data_lang)) ? '' : $data_lang['en'],
            //            'oz' => empty(array_key_exists('oz', $data_lang)) ? '' : $data_lang['oz'],
        ];
    }

    private function generateJson()
    {
        //        error_reporting(2245);
        $langs = Language::where(['status' => 1])->get();
        $messages = $this->modelClass::all();
        foreach ($langs as $lang) {
            $data = [];
            foreach ($messages as $message) {
                $item = SystemMessageTranslation::query()->where([
                    'system_message_id' => $message['id'],
                    'language' => $lang->code,
                ])->first();
                if (is_object($item) && strlen($item->message) !== 0) {
                    $data[$message['message']] = $item->message;

                    continue;
                }
                $data[$message['message']] = $message['message'];
            }
            $path = config('translation.path');
            foreach ($path as $item) {
                $file_link = $item.'locales/'.$lang->code.'/translation.json';
                $folder_link = $item.'locales/'.$lang->code;
                if (! is_dir($folder_link)) {
                    mkdir($folder_link);
                }
                //                if (file_exists($file_link)) {
                ////                    unlink($file_link);
                //                }
                //                $fp = fopen($file_link, 'w');
                file_put_contents($file_link, json_encode($data, JSON_UNESCAPED_UNICODE));
                //                fwrite($fp, json_encode($data, JSON_UNESCAPED_UNICODE));
                //                fclose($fp);
            }
        }

        return true;
    }
}
