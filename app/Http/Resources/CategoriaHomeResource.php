<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriaHomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'titulo' => $this->titulo,
            'slug' => $this->slug,
            'poster' => $this->poster_url ?? '',
            'poster_mobile' => $this->poster_mobile_url ?? '',
            'icono' => $this->icono_url ?? '',
            'color' => $this->color,
            'descripcion' => $this->descripcion,
            'productos' => ProductoCardResource::collection($this->whenLoaded('productos')),
        ];
    }
}
