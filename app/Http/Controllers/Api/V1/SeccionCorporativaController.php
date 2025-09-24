<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Models\Section;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use stdClass;
use App\Http\Resources\SectionResource;
use App\Http\Resources\BlockResource;
class SeccionCorporativaController extends Controller
{
    use ApiResponser;

    public function getDataSection($slug_seccion)
    {
        $section = Section::where('slug', $slug_seccion)
            ->with(['blocks.items'])
            ->first();

        if (!$section) {
            return $this->apiResponse(0, 404, 'Sección no encontrada.');
        }

        $data = new \stdClass();
        $data->seccion = new SectionResource($section);

        foreach ($section->blocks as $block) {
            $tipo = $block->tipo;
            $data->{$tipo} = new BlockResource($block);
            if ($block->items && $block->items->isNotEmpty()) {
                $data->{$tipo . '_detalle'} = ItemResource::collection($block->items);
            }
        }

        return $this->apiResponse(1, 200, $data);
    }


    /*public function getDataSection($slug_seccion)
    {
        //dd($slug_seccion);
        $section = Section::where('slug', $slug_seccion)
            ->with(['blocks.items'])
            ->first();

        if (!$section) {
            return $this->apiResponse(0, 404, 'Sección no encontrada.');
        }

        // Preparar respuesta dinámica
        $data = new stdClass();
        $data->seccion = $section;

        // Mapear bloques por tipo
        foreach ($section->blocks as $block) {
            $tipo = $block->tipo;

            // Items si aplica
            $data->{$tipo} = $block;

            if ($block->items && $block->items->isNotEmpty()) {
                $data->{$tipo . '_detalle'} = $block->items;
            }
        }

        return $this->apiResponse(1, 200, $data);
    }*/
}
