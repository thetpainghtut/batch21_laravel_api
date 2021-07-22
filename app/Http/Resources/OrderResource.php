<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'order_id' => $this->id,
            'order_date' => $this->orderdate,
            'order_voucherno' => $this->voucherno,
            'order_total' => $this->total,
            'order_note' => $this->note,
            'order_status' => $this->status,
            'order_user' => new UserResource($this->user),
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }
}
