<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Models\Partner;
use App\Models\Socialable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Partner
 */
class PartnerController extends Controller
{
    /**
     * @var Partner
     */
    protected mixed $modelClass = Partner::class;

    public function index(Request $request)
    {
        $query = $this->generateQuery($request);
        if ($request->filled('first')) {
            return okResponse($query->first());
        }
        $query->where("partners.status", 1);
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
        $model = $query->findOrFail($id);

        return okResponse($model);
    }

    public function store(Request $request): JsonResponse
    {
        $model = $this->modelClass::create($request->all());
        $this->defaultAppendAndInclude($model, $request);
        if ($request->filled('socials')) {
            $socials = $request->get('socials', []);
            foreach ($socials as $social) {
                Socialable::create([
                    'socialable_id' => $model->id,
                    'socialable_type' => $model->getMorphClass(),
                    'social_id' => $social['social_id'],
                    'link' => $social['link'],
                ]);
            }
        }

        return createdResponse($model);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $model = $this->modelClass::findOrFail($id);
        $model->update($request->all());
        Socialable::where('socialable_id', $id)
            ->where('socialable_type', $model->getMorphClass())
            ->delete();
        if ($request->filled('socials')) {
            $socials = $request->get('socials', []);
            foreach ($socials as $social) {
                Socialable::create([
                    'socialable_id' => $model->id,
                    'socialable_type' => $model->getMorphClass(),
                    'social_id' => $social['social_id'],
                    'link' => $social['link'],
                ]);
            }
        }

        $this->defaultAppendAndInclude($model, $request);

        return okResponse($model);
    }

    public function destroy(int $id): JsonResponse
    {
        $model = $this->modelClass::findOrFail($id);
        Socialable::where('socialable_id', $id)
            ->where('socialable_type', $model->getMorphClass())
            ->delete();
        $model->delete();

        return okResponse($model);
    }

    public function frontShow(Request $request, int $id): JsonResponse
    {
        $model = $this->generateQuery($request)
            ->findOrFail($id);

        return okResponse($model);
    }
}
