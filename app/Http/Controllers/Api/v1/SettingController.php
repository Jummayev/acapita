<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group Setting
 */
class SettingController extends Controller
{
    protected mixed $modelClass = Setting::class;

    public function index(Request $request)
    {
        $query = $this->generateQuery($request);
        $query->where("settings.status", 1);

        $data = $query->paginate($request->get('per_page'));

        return DefaultResource::collection($data);
    }

    public function adminIndex(Request $request)
    {
        $query = $this->generateQuery($request);
        $data = $query->paginate($request->get('per_page'));

        return DefaultResource::collection($data);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $query = $this->generateQuery($request);
        $setting = $query->findOrFail($id);

        return okResponse($setting);
    }

    public function store(Request $request): JsonResponse
    {
        $model = Setting::query()->create($request->all());
        $this->defaultAppendAndInclude($model, $request);

        return createdResponse($model);
    }

    public function update(Request $request, Setting $setting): JsonResponse
    {
        $setting->update($request->all());
        $this->defaultAppendAndInclude($setting, $request);

        return okResponse($setting);
    }

    public function destroy(Setting $setting): JsonResponse
    {
        $setting->delete();

        return okResponse($setting);
    }

    public function sort(Request $request): AnonymousResourceCollection
    {
        $ids = $request->get('ids');
        $i = 1;
        foreach ($ids as $index => $id) {
            $this->modelClass::query()->where('id', $id)->update(['sort' => $i++]);
        }

        $query = $this->generateQuery($request);
        $data = $query->paginate($request->get('per_page'));

        return DefaultResource::collection($data);
    }

    public function slug(Request $request, $slug)
    {
        $query = $this->generateQuery($request);
        $query->where("settings.status", 1);

        $data = $query->where('slug', $slug)->first();

        $this->defaultAppendAndInclude($data, $request);

        return okResponse($data);
    }
}
