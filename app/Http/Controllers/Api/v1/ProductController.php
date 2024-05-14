<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Product
 */
class ProductController extends Controller
{
    /**
     * @var Product
     */
    protected mixed $modelClass = Product::class;

    public function index(Request $request)
    {
        /**
         * @var Product $query
         */
        $query = $this->generateQuery($request);
        $query->active();
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
        $product = $query->findOrFail($id);

        return okResponse($product);
    }

    public function store(Request $request): JsonResponse
    {
        $model = $this->modelClass::create($request->all());
        $model->images()->sync($request->get('image_ids', []));

        $this->defaultAppendAndInclude($model, $request);

        return createdResponse($model);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $model = $this->modelClass::findOrFail($id);
        $request['updated_at'] = now();
        $model->update($request->all());
        $model->images()->sync($request->get('image_ids', []));
        $this->defaultAppendAndInclude($model, $request);

        return okResponse($model);
    }

    public function destroy(int $id): JsonResponse
    {
        $model = $this->modelClass::findOrFail($id);
        $model->images()->detach();
        $model->delete();

        return okResponse($model);
    }

    public function frontShow(Request $request, string $id): JsonResponse
    {
        $product = $this->generateQuery($request)->findOrFail($id);

        return okResponse($product);
    }
}
