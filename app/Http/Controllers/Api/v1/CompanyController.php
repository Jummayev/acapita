<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Models\Company;
use App\Models\CompanyImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Company
 */
class CompanyController extends Controller
{
    /**
     * @var Company
     */
    protected mixed $modelClass = Company::class;

    public function index(Request $request)
    {
        $query = $this->generateQuery($request);
        $query->where("companies.status", 1);

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
        if ($request->filled('images')) {
            $images = $request->get('images', []);
            foreach ($images as $image) {
                CompanyImage::create([
                    'company_id' => $model->id,
                    'image_id' => $image['image_id'],
                    'link' => $image['link'],
                    'name' => $image['name'],
                ]);
            }
        }

        return createdResponse($model);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $model = $this->modelClass::findOrFail($id);
        $model->update($request->all());
        CompanyImage::where('company_id', $id)->delete();
        if ($request->filled('images')) {
            $images = $request->get('images', []);
            foreach ($images as $image) {
                CompanyImage::create([
                    'company_id' => $model->id,
                    'image_id' => $image['image_id'],
                    'link' => $image['link'],
                    'name' => $image['name'],
                ]);
            }
        }

        $this->defaultAppendAndInclude($model, $request);

        return okResponse($model);
    }

    public function destroy(int $id): JsonResponse
    {
        $model = $this->modelClass::findOrFail($id);
        $model->images()->delete();
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
