<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'poster' => $this->poster_url ?? '',
            'poster_mobile' => $this->poster_mobile_url ?? '',
            'button' => $this->button,
            'link' => $this->link,
            'abrir_otra_ventana' => (bool) $this->abrir_otra_ventana,
            'position' => $this->position,
            'active' => (bool) $this->active,
        ];
    }
}
