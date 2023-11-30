<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource\Http\Controllers;

use GammaMatrix\Playground\Http\Controllers\Controller;
use GammaMatrix\Playground\Matrix\Models\Tag;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Tag\CreateRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Tag\DestroyRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Tag\EditRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Tag\IndexRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Tag\LockRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Tag\RestoreRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Tag\ShowRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Tag\StoreRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Tag\UnlockRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Requests\Tag\UpdateRequest;
use GammaMatrix\Playground\Matrix\Resource\Http\Resources\Tag as TagResource;
use GammaMatrix\Playground\Matrix\Resource\Http\Resources\TagCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * \GammaMatrix\Playground\Matrix\Resource\Http\Controllers\TagController
 */
class TagController extends Controller
{
    public array $packageInfo = [
        'model_attribute'     => 'label',
        'model_label'         => 'Tag',
        'model_label_plural'  => 'Tags',
        'model_route'         => 'playground.matrix.resource.tags',
        'model_slug'          => 'tag',
        'model_slug_plural'   => 'tags',
        'module_label'        => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route'        => 'playground.matrix.resource',
        'module_slug'         => 'matrix',
        'privilege'           => 'playground-matrix-resource:tag',
        'table'               => 'matrix_tags',
        'view'                => 'playground-matrix-resource::tag',
    ];

    /**
     * CREATE the Tag resource in storage.
     *
     * @route GET /resource/matrix/tags/create playground.matrix.resource.tags.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $tag = new Tag($validated);

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => null,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $tag,
            'meta' => $meta,
            '_method' => 'post',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $tag->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (!$request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view(
            'playground-matrix-resource::tag/form',
            $data
        );
    }

    /**
     * Edit the Tag resource in storage.
     *
     * @route GET /resource/matrix/tags/edit playground.matrix.resource.tags.edit
     */
    public function edit(
        Tag $tag,
        EditRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => $tag->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $tag,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $tag->toArray();

        if (!empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        session()->flashInput($flash);

        return view(
            'playground-matrix-resource::tag/form',
            $data
        );
    }

    /**
     * Remove the Tag resource from storage.
     *
     * @route DELETE /resource/matrix/{tag} playground.matrix.resource.tags.destroy
     */
    public function destroy(
        Tag $tag,
        DestroyRequest $request
    ): Response|RedirectResponse {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $tag->delete();
        } else {
            $tag->forceDelete();
        }

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.tags'));
    }

    /**
     * Lock the Tag resource in storage.
     *
     * @route PUT /resource/matrix/{tag} playground.matrix.resource.tags.lock
     */
    public function lock(
        Tag $tag,
        LockRequest $request
    ): JsonResponse|RedirectResponse|TagResource {
        $validated = $request->validated();

        $user = $request->user();

        $tag->locked = true;

        $tag->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => $tag->id,
            'timestamp'       => Carbon::now()->toJson(),
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new TagResource($tag))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.tags.show', ['tag' => $tag->id]));
    }

    /**
     * Display a listing of Tag resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.tags
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|View {
        $user = $request->user();

        $validated = $request->validated();

        $query = Tag::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

        $query->sort($validated['sort'] ?? null);

        if (!empty($validated['filter']) && is_array($validated['filter'])) {
            $query->filterTrash($validated['filter']['trash'] ?? null);

            $query->filterIds(
                $request->getPaginationIds(),
                $validated
            );

            $query->filterFlags(
                $request->getPaginationFlags(),
                $validated
            );

            $query->filterDates(
                $request->getPaginationDates(),
                $validated
            );

            $query->filterColumns(
                $request->getPaginationColumns(),
                $validated
            );
        }

        $paginator = $query->paginate($validated['perPage'] ?? null);

        $paginator->appends($validated);

        if ($request->expectsJson()) {
            return (new TagCollection($paginator))->additional(['meta' => [
                'session_user_id' => $user?->id,
                'validated'       => $validated,
            ]]);
        }

        $meta = [
            'session_user_id' => $user?->id,
            'columns'         => $request->getPaginationColumns(),
            'dates'           => $request->getPaginationDates(),
            'flags'           => $request->getPaginationFlags(),
            'ids'             => $request->getPaginationIds(),
            'rules'           => $request->rules(),
            'sortable'        => $request->getSortable(),
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        $data = [
            'paginator' => $paginator,
            'meta' => $meta,
        ];

        return view(
            'playground-matrix-resource::tag/index',
            $data
        );
    }

    /**
     * Restore the Tag resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{tag} playground.matrix.resource.tags.restore
     */
    public function restore(
        Tag $tag,
        RestoreRequest $request
    ): JsonResponse|RedirectResponse|TagResource {
        $validated = $request->validated();

        $user = $request->user();

        $tag->restore();

        if ($request->expectsJson()) {
            return (new TagResource($tag))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.tags.show', ['tag' => $tag->id]));
    }

    /**
     * Display the Tag resource.
     *
     * @route GET /resource/matrix/{tag} playground.matrix.resource.tags.show
     */
    public function show(
        Tag $tag,
        ShowRequest $request
    ): JsonResponse|View|TagResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id'              => $tag->id,
            'timestamp'       => Carbon::now()->toJson(),
            'validated'       => $validated,
            'info'            => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return new TagResource($tag);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $tag,
            'meta' => $meta,
        ];

        return view(
            'playground-matrix-resource::tag/detail',
            $data
        );
    }

    /**
      * Store a newly created API Tag resource in storage.
      *
      * @route POST /resource/matrix playground.matrix.resource.tags.post
      */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|TagResource {
        $validated = $request->validated();

        $user = $request->user();

        $tag = new Tag($validated);

        $tag->save();

        if ($request->expectsJson()) {
            return (new TagResource($tag))->response($request);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.tags.show', ['tag' => $tag->id]));
    }

    /**
     * Unlock the Tag resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{tag} playground.matrix.resource.tags.unlock
     */
    public function unlock(
        Tag $tag,
        UnlockRequest $request
    ): JsonResponse|RedirectResponse|TagResource {
        $validated = $request->validated();

        $user = $request->user();

        $tag->locked = false;

        $tag->save();

        if ($request->expectsJson()) {
            return (new TagResource($tag))->response($request);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.tags.show', ['tag' => $tag->id]));
    }

    /**
     * Update the Tag resource in storage.
     *
     * @route PATCH /resource/matrix/{tag} playground.matrix.resource.tags.patch
     */
    public function update(
        Tag $tag,
        UpdateRequest $request
    ): JsonResponse|RedirectResponse|TagResource {
        $validated = $request->validated();

        $user = $request->user();

        $tag->update($validated);

        if ($request->expectsJson()) {
            return (new TagResource($tag))->response($request);
        }

        $returnUrl = $validated['return_url'] ?? '';

        if ($returnUrl) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.matrix.resource.tags.show', ['tag' => $tag->id]));
    }
}
