<?php

namespace App\Http\Resources;

use App\Models\Setting;
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
            'id' => $this->id,
            'titulo' => $this->title_large,
            'subtitulo' => $this->title_small,
            'slug' => $this->slug,
            'precio_actual' => $this->precio_normal,
            'precio_anterior' => $this->precio_online,
            'stock' => $this->stock,
            'description' => $this->description,
            'description_small' => $this->description_small,
            'poster' => $this->poster_url ?? '',
            'poster_mobile' => $this->poster_mobile_url ?? '',

            'presentacion' => $this->presentacion,
            'imagen_acerca_producto' => $this->imagen_acerca_producto_url ?? '',
            'acerca_producto' => $this->acerca_producto,
            'imagen_como_usarlo' => $this->imagen_como_usarlo_url ?? '',
            'como_usarlo' => $this->como_usarlo,
            'descuento_producto' => $this->descuento_producto == 1 ? true : false,
            'monto_descuento' => setting('monto_descuento_producto', 0),
            // 👇 categorías
            'categoria' => $this->whenLoaded('categoria', function () {
                return [
                    'id' => $this->categoria->id,
                    'titulo' => $this->categoria->titulo,
                    'slug' => $this->categoria->slug,
                    'color' => $this->categoria->color,
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
