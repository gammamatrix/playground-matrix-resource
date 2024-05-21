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
use Playground\Matrix\Models\Source;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;

/**
 * \Playground\Matrix\Resource\Http\Controllers\SourceController
 */
class SourceController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Source',
        'model_label_plural' => 'Sources',
        'model_route' => 'playground.matrix.resource.sources',
        'model_slug' => 'source',
        'model_slug_plural' => 'sources',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:source',
        'table' => 'matrix_sources',
        'view' => 'playground-matrix-resource::source',
    ];

    /**
     * Create the Source resource in storage.
     *
     * @route GET /resource/matrix/sources/create playground.matrix.resource.sources.create
     */
    public function create(
        Requests\Source\CreateRequest $request
    ): JsonResponse|View|Resources\Source {

        $validated = $request->validated();

        $user = $request->user();

        $source = new Source($validated);

        if ($request->expectsJson()) {
            return (new Resources\Source($source))->additional(['meta' => [
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
            'data' => $source,
            'meta' => $meta,
            '_method' => 'post',
        ];

        $flash = $source->toArray();

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
     * Edit the Source resource in storage.
     *
     * @route GET /resource/matrix/sources/edit playground.matrix.resource.sources.edit
     */
    public function edit(
        Source $source,
        Requests\Source\EditRequest $request
    ): JsonResponse|View|Resources\Source {

        $validated = $request->validated();

        $user = $request->user();

        if ($request->expectsJson()) {
            return (new Resources\Source($source))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $flash = $source->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $source->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $source,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        session()->flashInput($flash);

        return view(sprintf('%1$s/form', $this->packageInfo['view']), $data);
    }

    /**
     * Remove the Source resource from storage.
     *
     * @route DELETE /resource/matrix/{source} playground.matrix.resource.sources.destroy
     */
    public function destroy(
        Source $source,
        Requests\Source\DestroyRequest $request
    ): Response|RedirectResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $source->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $source->delete();
        } else {
            $source->forceDelete();
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
     * Lock the Source resource in storage.
     *
     * @route PUT /resource/matrix/{source} playground.matrix.resource.sources.lock
     */
    public function lock(
        Source $source,
        Requests\Source\LockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Source {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $source->modified_by_id = $user->id;
        }

        $source->locked = true;

        $source->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $source->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Source($source))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['source' => $source->id]));
    }

    /**
     * Display a listing of Source resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.sources
     */
    public function index(
        Requests\Source\IndexRequest $request
    ): JsonResponse|View|Resources\SourceCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Source::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
            return (new Resources\SourceCollection($paginator))->response($request);
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
     * Restore the Source resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{source} playground.matrix.resource.sources.restore
     */
    public function restore(
        Source $source,
        Requests\Source\RestoreRequest $request
    ): JsonResponse|RedirectResponse|Resources\Source {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $source->modified_by_id = $user->id;
        }

        $source->restore();

        if ($request->expectsJson()) {
            return (new Resources\Source($source))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['source' => $source->id]));
    }

    /**
     * Display the Source resource.
     *
     * @route GET /resource/matrix/{source} playground.matrix.resource.sources.show
     */
    public function show(
        Source $source,
        Requests\Source\ShowRequest $request
    ): JsonResponse|View|Resources\Source {

        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $source->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Source($source))->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $source,
            'meta' => $meta,
        ];

        return view(sprintf('%1$s/detail', $this->packageInfo['view']), $data);
    }

    /**
     * Store a newly created API Source resource in storage.
     *
     * @route POST /resource/matrix playground.matrix.resource.sources.post
     */
    public function store(
        Requests\Source\StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|Resources\Source {

        $validated = $request->validated();

        $user = $request->user();

        $source = new Source($validated);

        if ($user?->id) {
            $source->created_by_id = $user->id;
        }

        $source->save();

        if ($request->expectsJson()) {
            return (new Resources\Source($source))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['source' => $source->id]));
    }

    /**
     * Unlock the Source resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{source} playground.matrix.resource.sources.unlock
     */
    public function unlock(
        Source $source,
        Requests\Source\UnlockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Source {

        $validated = $request->validated();

        $user = $request->user();

        $source->locked = false;

        if ($user?->id) {
            $source->modified_by_id = $user->id;
        }

        $source->save();

        if ($request->expectsJson()) {
            return (new Resources\Source($source))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['source' => $source->id]));
    }

    /**
     * Update the Source resource in storage.
     *
     * @route PATCH /resource/matrix/{source} playground.matrix.resource.sources.patch
     */
    public function update(
        Source $source,
        Requests\Source\UpdateRequest $request
    ): JsonResponse|RedirectResponse|Resources\Source {

        $validated = $request->validated();

        $user = $request->user();

        $source->update($validated);

        if ($user?->id) {
            $source->modified_by_id = $user->id;
        }

        if ($request->expectsJson()) {
            return (new Resources\Source($source))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['source' => $source->id]));
    }
}
