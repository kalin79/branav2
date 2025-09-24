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
            'poster' => !empty($this->poster) ? asset('images/categoria/' .$this->id.'/'.$this->poster) : '',
            'poster_mobile' => !empty($this->poster_mobile) ? asset('images/categoria/' .$this->id.'/'.$this->poster_mobile) : '',
            'icono' =>!empty($this->icono) ? asset('images/categoria/' .$this->id.'/'.$this->icono) : '',
            'color' => $this->color,
            'descripcion' => $this->descripcion,
            'productos' => ProductoCardResource::collection($this->whenLoaded('productos')),
        ];
    }
}
