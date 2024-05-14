<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Post
 */
class PostController extends Controller
{
    protected mixed $modelClass = Post::class;

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
        $post = $query->findOrFail($id);

        return okResponse($post);
    }

    public function store(Request $request): JsonResponse
    {
        $model = Post::query()->create($request->all());
        $this->defaultAppendAndInclude($model, $request);

        return createdResponse($model);
    }

    public function update(Request $request, $post): JsonResponse
    {
        $post = $this->modelClass::findOrFail($post);
        $post->update($request->all());
        $this->defaultAppendAndInclude($post, $request);

        return okResponse($post);
    }

    public function destroy(Post $post): JsonResponse
    {
        $post->delete();

        return okResponse($post);
    }

    public function frontShow(Request $request, string $slug): JsonResponse
    {
        $post = $this->generateQuery($request)
            ->select('posts.*')
            ->leftJoin('post_translations', 'posts.id', '=', 'post_translations.translatable_id')
            ->where('post_translations.slug', $slug)
            ->firstOrFail();

        $post->increment('view_count');

        return okResponse($post);
    }
}
