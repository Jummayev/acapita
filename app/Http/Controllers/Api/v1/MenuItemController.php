<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Models\MenuItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group MenuItem
 */
class MenuItemController extends Controller
{
    protected mixed $modelClass = MenuItem::class;

    public function index(Request $request, int $menu)
    {
        $query = $this->generateQuery($request);
        $query->where('menu_id', $menu);
        $query->where("menu_item_parent_id", null);
        $query->where("menu_items.status", 1);
        $data = $query->paginate($request->get('per_page'));

        return DefaultResource::collection($data);
    }

    public function adminIndex(Request $request, int $menu)
    {
        $query = $this->generateQuery($request);
        $query->where('menu_id', $menu);
        $query->where("menu_item_parent_id", null);
        $data = $query->paginate($request->get('per_page'));

        return DefaultResource::collection($data);
    }

    public function show(Request $request, int $menu, int $id): JsonResponse
    {
        $query = $this->generateQuery($request);
        $query->where('menu_id', $menu);
        $model = $query->findOrFail($id);

        return okResponse($model);
    }

    public function store(Request $request, int $menu): JsonResponse
    {
        $request['menu_id'] = $menu;
        $model = $this->modelClass::create($request->all());
        $this->defaultAppendAndInclude($model, $request);

        return createdResponse($model);
    }

    public function update(Request $request, int $menu, $model): JsonResponse
    {
        $model = $this->modelClass::where('menu_id', $menu)->findOrFail($model);
        $request['menu_id'] = $menu;
        $model->update($request->all());
        $this->defaultAppendAndInclude($model, $request);

        return okResponse($model);
    }

    public function destroy(int $menu, int $id): JsonResponse
    {
        $model = $this->modelClass::where('menu_id', $menu)->findOrFail($id);
        $model->delete();

        return okResponse($model);
    }

    public function frontShow(Request $request, int $menu, int $id): JsonResponse
    {
        $model = $this->generateQuery($request)->where('menu_id', $menu)->findOrFail($id);

        return okResponse($model);
    }
}
