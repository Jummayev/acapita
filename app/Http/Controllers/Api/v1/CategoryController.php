<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Category
 */
class CategoryController extends Controller
{
    protected mixed $modelClass = Category::class;

    public function index(Request $request)
    {
        $query = $this->generateQuery($request);
        if ($request->filled('search')) {
            $query->whereHas('translations', function (Builder $builder) use ($request) {
                $builder->where('title', 'LIKE', '%' . $request->get('search') . '%');
            });
        }
        $query->where("categories.status", 1);

        $data = $query->paginate($request->get('per_page'));

        return DefaultResource::collection($data);
    }

    public function adminIndex(Request $request)
    {
        $query = $this->generateQuery($request);
        if ($request->filled('search')) {
            $query->whereHas('translations', function (Builder $builder) use ($request) {
                $builder->where('title', 'LIKE', '%' . $request->get('search') . '%');
            });
        }
        $data = $query->paginate($request->get('per_page'));

        return DefaultResource::collection($data);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $query = $this->generateQuery($request);
        $category = $query->findOrFail($id);

        return okResponse($category);
    }

    public function store(Request $request): JsonResponse
    {
        $model = Category::query()->create($request->all());

        $this->defaultAppendAndInclude($model, $request);

        return createdResponse($model);
    }

    public function update(Request $request, $category): JsonResponse
    {
        $category = $this->modelClass::findOrFail($category);
        $request['updated_at'] = now();
        $category->update($request->all());
        $this->defaultAppendAndInclude($category, $request);

        return okResponse($category);
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return okResponse($category);
    }

    public function frontShow(Request $request, string $slug): JsonResponse
    {
        $category = $this->generateQuery($request)->where('slug', $slug)->firstOrFail();

        return okResponse($category);
    }
}
