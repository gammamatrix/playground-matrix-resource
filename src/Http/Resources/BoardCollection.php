<?php
namespace Playground\Matrix\Resource\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Carbon;

class BoardCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        return [
            'meta' => [
                'columns' => $request->getPaginationColumns(),
                'dates' => $request->getPaginationDates(),
                'flags' => $request->getPaginationFlags(),
                'ids' => $request->getPaginationIds(),
                'rules' => $request->rules(),
                'session_user_id' => $request->user()->id,
                'sortable' => $request->getSortable(),
                'timestamp' => Carbon::now()->toJson(),
                'validated' => $request->validated(),
            ],
        ];
    }
}
