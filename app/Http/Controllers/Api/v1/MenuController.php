<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Menu
 */
class MenuController extends Controller
{
    protected mixed $modelClass = Menu::class;

    public function index(Request $request)
    {
        $query = $this->generateQuery($request);
        $query->where("status", 1);
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
        $menu = $query->findOrFail($id);

        return okResponse($menu);
    }

    public function store(Request $request): JsonResponse
    {
        $model = Menu::query()->create($request->all());
        $this->defaultAppendAndInclude($model, $request);

        return createdResponse($model);
    }

    public function update(Request $request, $menu): JsonResponse
    {
        $menu = $this->modelClass::findOrFail($menu);
        $request['updated_at'] = now();
        $menu->update($request->all());
        $this->defaultAppendAndInclude($menu, $request);

        return okResponse($menu);
    }

    public function destroy(Menu $menu): JsonResponse
    {
        $menu->delete();

        return okResponse($menu);
    }

    public function frontShow(Request $request, int $id): JsonResponse
    {
        $menu = $this->generateQuery($request)->findOrFail($id);

        return okResponse($menu);
    }
}
