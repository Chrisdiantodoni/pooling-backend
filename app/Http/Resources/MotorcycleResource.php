<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MotorcycleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->type,
            'color' => $this->color,
            'otr' => $this->otr,
            'area' => $this->area,
            'user' => $this->user,
            'dealers' => $this->whenLoaded('dealers', function () {
                return $this->dealers->map(function ($dealer) {
                    return [
                        'dealer_code' => $dealer->dealer_code,
                        'dealer_name' => $dealer->dealer_name,
                    ];
                });
            }),
        ];
    }
}
