<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CuidadoPersonalResource extends JsonResource
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
            'icono' => $this->icono,
            'color' => $this->color,
            'descripcion' => $this->descripcion,
            'orden' => $this->orden,
            'active' => (bool) $this->active,
        ];
    }
}
