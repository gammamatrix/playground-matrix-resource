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
use Playground\Matrix\Models\Matrix;
use Playground\Matrix\Resource\Http\Requests;
use Playground\Matrix\Resource\Http\Resources;

/**
 * \Playground\Matrix\Resource\Http\Controllers\MatrixController
 */
class MatrixController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Matrix',
        'model_label_plural' => 'Matrices',
        'model_route' => 'playground.matrix.resource.matrices',
        'model_slug' => 'matrix',
        'model_slug_plural' => 'matrices',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.resource',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-resource:matrix',
        'table' => 'matrix_matrices',
        'view' => 'playground-matrix-resource::matrix',
    ];

    /**
     * Create the Matrix resource in storage.
     *
     * @route GET /resource/matrix/matrices/create playground.matrix.resource.matrices.create
     */
    public function create(
        Requests\Matrix\CreateRequest $request
    ): JsonResponse|View|Resources\Matrix {

        $validated = $request->validated();

        $user = $request->user();

        $matrix = new Matrix($validated);

        if ($request->expectsJson()) {
            return (new Resources\Matrix($matrix))->additional(['meta' => [
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
            'data' => $matrix,
            'meta' => $meta,
            '_method' => 'post',
        ];

        $flash = $matrix->toArray();

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
     * Edit the Matrix resource in storage.
     *
     * @route GET /resource/matrix/matrices/edit playground.matrix.resource.matrices.edit
     */
    public function edit(
        Matrix $matrix,
        Requests\Matrix\EditRequest $request
    ): JsonResponse|View|Resources\Matrix {

        $validated = $request->validated();

        $user = $request->user();

        if ($request->expectsJson()) {
            return (new Resources\Matrix($matrix))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $flash = $matrix->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $matrix->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $matrix,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        session()->flashInput($flash);

        return view(sprintf('%1$s/form', $this->packageInfo['view']), $data);
    }

    /**
     * Remove the Matrix resource from storage.
     *
     * @route DELETE /resource/matrix/{matrix} playground.matrix.resource.matrices.destroy
     */
    public function destroy(
        Matrix $matrix,
        Requests\Matrix\DestroyRequest $request
    ): Response|RedirectResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $matrix->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $matrix->delete();
        } else {
            $matrix->forceDelete();
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
     * Lock the Matrix resource in storage.
     *
     * @route PUT /resource/matrix/{matrix} playground.matrix.resource.matrices.lock
     */
    public function lock(
        Matrix $matrix,
        Requests\Matrix\LockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Matrix {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $matrix->modified_by_id = $user->id;
        }

        $matrix->locked = true;

        $matrix->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $matrix->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Matrix($matrix))->additional(['meta' => [
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
        ), ['matrix' => $matrix->id]));
    }

    /**
     * Display a listing of Matrix resources.
     *
     * @route GET /resource/matrix playground.matrix.resource.matrices
     */
    public function index(
        Requests\Matrix\IndexRequest $request
    ): JsonResponse|View|Resources\MatrixCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Matrix::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
            return (new Resources\MatrixCollection($paginator))->response($request);
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
     * Restore the Matrix resource from the trash.
     *
     * @route PUT /resource/matrix/restore/{matrix} playground.matrix.resource.matrices.restore
     */
    public function restore(
        Matrix $matrix,
        Requests\Matrix\RestoreRequest $request
    ): JsonResponse|RedirectResponse|Resources\Matrix {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $matrix->modified_by_id = $user->id;
        }

        $matrix->restore();

        if ($request->expectsJson()) {
            return (new Resources\Matrix($matrix))->additional(['meta' => [
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
        ), ['matrix' => $matrix->id]));
    }

    /**
     * Display the Matrix resource.
     *
     * @route GET /resource/matrix/{matrix} playground.matrix.resource.matrices.show
     */
    public function show(
        Matrix $matrix,
        Requests\Matrix\ShowRequest $request
    ): JsonResponse|View|Resources\Matrix {

        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $matrix->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Matrix($matrix))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $matrix,
            'meta' => $meta,
        ];

        return view(sprintf('%1$s/detail', $this->packageInfo['view']), $data);
    }

    /**
     * Store a newly created API Matrix resource in storage.
     *
     * @route POST /resource/matrix playground.matrix.resource.matrices.post
     */
    public function store(
        Requests\Matrix\StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|Resources\Matrix {

        $validated = $request->validated();

        $user = $request->user();

        $matrix = new Matrix($validated);

        if ($user?->id) {
            $matrix->created_by_id = $user->id;
        }

        $matrix->save();

        if ($request->expectsJson()) {
            return (new Resources\Matrix($matrix))->additional(['meta' => [
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
        ), ['matrix' => $matrix->id]));
    }

    /**
     * Unlock the Matrix resource in storage.
     *
     * @route DELETE /resource/matrix/lock/{matrix} playground.matrix.resource.matrices.unlock
     */
    public function unlock(
        Matrix $matrix,
        Requests\Matrix\UnlockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Matrix {

        $validated = $request->validated();

        $user = $request->user();

        $matrix->locked = false;

        if ($user?->id) {
            $matrix->modified_by_id = $user->id;
        }

        $matrix->save();

        if ($request->expectsJson()) {
            return (new Resources\Matrix($matrix))->additional(['meta' => [
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
        ), ['matrix' => $matrix->id]));
    }

    /**
     * Update the Matrix resource in storage.
     *
     * @route PATCH /resource/matrix/{matrix} playground.matrix.resource.matrices.patch
     */
    public function update(
        Matrix $matrix,
        Requests\Matrix\UpdateRequest $request
    ): JsonResponse|RedirectResponse|Resources\Matrix {

        $validated = $request->validated();

        $user = $request->user();

        $matrix->update($validated);

        if ($user?->id) {
            $matrix->modified_by_id = $user->id;
        }

        if ($request->expectsJson()) {
            return (new Resources\Matrix($matrix))->additional(['meta' => [
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
        ), ['matrix' => $matrix->id]));
    }
}
