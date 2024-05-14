<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group Page
 */
class PageController extends Controller
{
    protected mixed $modelClass = Page::class;

    public function index(Request $request)
    {
        $query = $this->generateQuery($request);
        $query->where("pages.status", 1);

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
        $page = $query->findOrFail($id);

        return okResponse($page);
    }

    public function store(Request $request): JsonResponse
    {
        $model = Page::query()->create($request->all());
        $this->defaultAppendAndInclude($model, $request);

        return createdResponse($model);
    }

    public function update(Request $request, Page $page): JsonResponse
    {
        $page = $page->update($request->all());
        $this->defaultAppendAndInclude($page, $request);

        return okResponse($page);
    }

    public function destroy(Page $page): JsonResponse
    {
        $page->delete();

        return okResponse($page);
    }

    public function frontShow(Request $request, $slug): JsonResponse
    {
        $page = $this->generateQuery($request)
            ->where('status', 1)
            ->where('slug', $slug)
            ->firstOrFail();

        return okResponse($page);
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
}
