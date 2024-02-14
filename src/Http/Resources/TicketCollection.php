<?php
namespace Playground\Matrix\Resource\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Carbon;
use Playground\Matrix\Resource\Http\Requests\AbstractIndexRequest;

class TicketCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<string, mixed>|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(Request $request)
    {
        return parent::toArray($request);
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request&AbstractIndexRequest $request
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
                'session_user_id' => $request->user()?->id,
                'sortable' => $request->getSortable(),
                'timestamp' => Carbon::now()->toJson(),
                'validated' => $request->validated(),
            ],
        ];
    }
}
