<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PromotionResources extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'promo_code' => $this->promo_code,
            'promo_start' => $this->promo_start,
            'promo_end' => $this->promo_end,
            "status" => $this->status,
            'areas' => $this->whenLoaded('areas', function () {
                return $this->areas->map(function ($areas) {
                    return [
                        'area_name' => $areas->area_name
                    ];
                });
            })
        ];
    }
}
