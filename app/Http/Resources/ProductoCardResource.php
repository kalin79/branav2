<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titulo' => $this->title_large,
            'subtitulo' => $this->title_small,
            'slug' => $this->slug,
            'precio_actual' => $this->precio_normal,
            'precio_anterior' => $this->precio_online,
            'poster' =>!empty($this->poster) ? asset('images/products/' .$this->id.'/'.$this->poster) : '',
            'poster_mobile' => !empty($this->poster_mobile) ? asset('images/products/'.$this->id.'/' . $this->poster_mobile) : '',
            'categoria' => $this->whenLoaded('categoria', function () {
                return [
                    'id' => $this->categoria->id,
                    'titulo' => $this->categoria->titulo,
                    'slug' => $this->categoria->slug,
                ];
            }),
            'subcategoria' => $this->whenLoaded('subcategoria', function () {
                return [
                    'id' => $this->subcategoria->id,
                    'titulo' => $this->subcategoria->titulo,
                    'slug' => $this->subcategoria->slug,
                ];
            }),
        ];
    }
}
