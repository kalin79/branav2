<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'titulo' => $this->title_large,
            'subtitulo' => $this->title_small,
            'slug' => $this->slug,
            'precio_actual' => $this->precio_normal,
            'precio_anterior' => $this->precio_online,
            'stock' => $this->stock,
            'description' => $this->description,
            'description_small' => $this->description_small,
            'poster' =>!empty($this->poster) ? asset('images/products/' .$this->id.'/'.$this->poster) : '',
            'poster_mobile' => !empty($this->poster_mobile) ? asset('images/products/'.$this->id.'/' . $this->poster_mobile) : '',

            'presentacion' => $this->presentacion,
            'imagen_acerca_producto' => !empty($this->imagen_acerca_producto) ? asset('images/products/' .$this->id.'/'.$this->imagen_acerca_producto) : '',
            'acerca_producto' => $this->acerca_producto,
            'imagen_como_usarlo' => !empty($this->imagen_como_usarlo) ? asset('images/products/' .$this->id.'/'.$this->imagen_como_usarlo) : '',
            'como_usarlo' => $this->como_usarlo,
            // 👇 categorías
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

            // Relaciones
            'imagenes' => ProductoImageResource::collection($this->whenLoaded('galleries')),
            'relacionados' => ProductoCardResource::collection($this->whenLoaded('relacionados')),
        ];
    }
}
