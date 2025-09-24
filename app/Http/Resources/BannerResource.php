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
            'poster' => !empty($this->poster) ? asset('images/banners/' .$this->id.'/'.$this->poster) : '',
            'poster_mobile' => !empty($this->poster_mobile) ? asset('images/banners/' .$this->id.'/'.$this->poster_mobile) : '',
            'button' => $this->button,
            'link' => $this->link,
            'abrir_otra_ventana' => (bool) $this->abrir_otra_ventana,
            'position' => $this->position,
            'active' => (bool) $this->active,
        ];
    }
}
