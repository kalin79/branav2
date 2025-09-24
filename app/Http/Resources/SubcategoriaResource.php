<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubcategoriaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'titulo' => $this->titulo,
            'slug' => $this->slug,
            'poster' => $this->poster,
            'poster_mobile' => $this->poster_mobile,
            'icono' => $this->icono,
            'color' => $this->color,
            'descripcion' => $this->descripcion,
            //'productos' => ProductoResource::collection($this->whenLoaded('productos')),
        ];
    }
}
