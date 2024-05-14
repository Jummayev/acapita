<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Models\History;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group History
 */
class HistoryController extends Controller
{
    /**
     * @var History
     */
    protected mixed $modelClass = History::class;

    public function index(Request $request)
    {
        $query = $this->generateQuery($request);
        $query->where("histories.status", 1);

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

        return createdResponse($model);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $model = $this->modelClass::findOrFail($id);
        $model->update($request->all());

        $this->defaultAppendAndInclude($model, $request);

        return okResponse($model);
    }

    public function destroy(int $id): JsonResponse
    {
        $model = $this->modelClass::findOrFail($id);

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
