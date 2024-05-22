<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Matrix\Resource\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Playground\Matrix\Models\Tag;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;

/**
 * \Playground\Matrix\Resource\Http\Controllers\TagController
 */
class TagController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Tag',
        'model_label_plural' => 'Tags',
        'model_route' => 'playground.matrix.resource.tags',
        'model_slug' => 'tag',
        'model_slug_plural' => 'tags',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:tag',
        'table' => 'matrix_tags',
        'view' => 'playground-matrix-resource::tag',
    ];

    /**
     * Create the Tag resource in storage.
     *
     * @route GET /resource/matrix/tags/create playground.matrix.resource.tags.create
     */
    public function create(
        Requests\Tag\CreateRequest $request
    ): JsonResponse|View|Resources\Tag {

        $validated = $request->validated();

        $user = $request->user();

        $tag = new Tag($validated);

        if ($request->expectsJson()) {
            return (new Resources\Tag($tag))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $meta = [
            'session_user_id' => $user?->id,
            'id' => null,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $tag,
            'meta' => $meta,
            '_method' => 'post',
        ];

        $flash = $tag->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (! $request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view(sprintf('%1$s/form', $this->packageInfo['view']), $data);
    }

    /**
     * Edit the Tag resource in storage.
     *
     * @route GET /resource/matrix/tags/edit playground.matrix.resource.tags.edit
     */
    public function edit(
        Tag $tag,
        Requests\Tag\EditRequest $request
    ): JsonResponse|View|Resources\Tag {

        $validated = $request->validated();

        $user = $request->user();

        if ($request->expectsJson()) {
            return (new Resources\Tag($tag))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $flash = $tag->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $tag->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $tag,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        session()->flashInput($flash);

        return view(sprintf('%1$s/form', $this->packageInfo['view']), $data);
    }

    /**
     * Remove the Tag resource from storage.
     *
     * @route DELETE /resource/matrix/{tag} playground.matrix.resource.tags.destroy
     */
    public function destroy(
        Tag $tag,
        Requests\Tag\DestroyRequest $request
    ): Response|RedirectResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $tag->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $tag->delete();
        } else {
            $tag->forceDelete();
        }

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route($this->packageInfo['model_route']));
    }

    /**
     * Lock the Tag resource in storage.
     *
     * @route PUT /resource/matrix/{tag} playground.matrix.resource.tags.lock
     */
    public function lock(
        Tag $tag,
        Requests\Tag\LockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Tag {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $tag->modified_by_id = $user->id;
        }

        $tag->locked = true;

        $tag->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $tag->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Tag($tag))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['tag' => $tag->id]));
    }

    /**
     * Display a listing of Tag resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.tags
     */
    public function index(
        Requests\Tag\IndexRequest $request
    ): JsonResponse|View|Resources\TagCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Tag::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

        $query->sort($validated['sort'] ?? null);

        if (! empty($validated['filter']) && is_array($validated['filter'])) {

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

        $perPage = ! empty($validated['perPage']) && is_int($validated['perPage']) ? $validated['perPage'] : null;
        $paginator = $query->paginate($perPage);

        $paginator->appends($validated);

        if ($request->expectsJson()) {
            return (new Resources\TagCollection($paginator))->response($request);
        }

        $meta = [
            'session_user_id' => $user?->id,
            'columns' => $request->getPaginationColumns(),
            'dates' => $request->getPaginationDates(),
            'flags' => $request->getPaginationFlags(),
            'ids' => $request->getPaginationIds(),
            'rules' => $request->rules(),
            'sortable' => $request->getSortable(),
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $data = [
            'paginator' => $paginator,
            'meta' => $meta,
        ];

        return view(sprintf('%1$s/index', $this->packageInfo['view']), $data);
    }

    /**
     * Restore the Tag resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{tag} playground.matrix.resource.tags.restore
     */
    public function restore(
        Tag $tag,
        Requests\Tag\RestoreRequest $request
    ): JsonResponse|RedirectResponse|Resources\Tag {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $tag->modified_by_id = $user->id;
        }

        $tag->restore();

        if ($request->expectsJson()) {
            return (new Resources\Tag($tag))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['tag' => $tag->id]));
    }

    /**
     * Display the Tag resource.
     *
     * @route GET /resource/matrix/{tag} playground.matrix.resource.tags.show
     */
    public function show(
        Tag $tag,
        Requests\Tag\ShowRequest $request
    ): JsonResponse|View|Resources\Tag {

        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $tag->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Tag($tag))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $tag,
            'meta' => $meta,
        ];

        return view(sprintf('%1$s/detail', $this->packageInfo['view']), $data);
    }

    /**
     * Store a newly created API Tag resource in storage.
     *
     * @route POST /resource/matrix playground.matrix.resource.tags.post
     */
    public function store(
        Requests\Tag\StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|Resources\Tag {

        $validated = $request->validated();

        $user = $request->user();

        $tag = new Tag($validated);

        if ($user?->id) {
            $tag->created_by_id = $user->id;
        }

        $tag->save();

        if ($request->expectsJson()) {
            return (new Resources\Tag($tag))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['tag' => $tag->id]));
    }

    /**
     * Unlock the Tag resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{tag} playground.matrix.resource.tags.unlock
     */
    public function unlock(
        Tag $tag,
        Requests\Tag\UnlockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Tag {

        $validated = $request->validated();

        $user = $request->user();

        $tag->locked = false;

        if ($user?->id) {
            $tag->modified_by_id = $user->id;
        }

        $tag->save();

        if ($request->expectsJson()) {
            return (new Resources\Tag($tag))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['tag' => $tag->id]));
    }

    /**
     * Update the Tag resource in storage.
     *
     * @route PATCH /resource/matrix/{tag} playground.matrix.resource.tags.patch
     */
    public function update(
        Tag $tag,
        Requests\Tag\UpdateRequest $request
    ): JsonResponse|RedirectResponse|Resources\Tag {

        $validated = $request->validated();

        $user = $request->user();

        $tag->update($validated);

        if ($user?->id) {
            $tag->modified_by_id = $user->id;
        }

        if ($request->expectsJson()) {
            return (new Resources\Tag($tag))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['tag' => $tag->id]));
    }
}
