<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use App\Http\Enums\TypeArchivoImage;
use App\Models\Banner;
use App\Models\Campanas;
use App\Models\Categorias;
use App\Models\Marcas;
use App\Models\Product;
use App\Models\District;
use App\Models\Province;
use App\Models\Department;

use App\Models\Schedule;
use App\Models\Tags;
use App\Models\Video;
use App\Traits\ApiResponser;

use Illuminate\Http\Request;
use DB;

class MarcaController  extends Controller
{
    use ApiResponser;

    public function index($slug_marca)
    {
        $data = new \stdClass();
        $marca = Marcas::where('slug', '=', $slug_marca)->firstOrFail();

        $data->videos              = $this->videos($marca->id);
        $data->productos                   = $this->productos($marca->id);
        $data->campanas            =$this->campanas($marca->id);
        $data->categoria_videos            =$this->vategoriasVideo($marca->id);
        $data->tags                 =$this->getTags();
        $data->banner               =$this->banners($marca->id);
        $status = 1;
        $code = 200;
        $data = $data;

        return $this->apiResponse($status, $code, $data);
    }

    public function videos($marca_id)
    {
        $response_valores = [];
        $videos = Video::where('marca_id',$marca_id)->orderBy('id', 'desc')->take(10)->get();

        if (count($videos) > 0) {
            foreach ($videos as $video) {
                $row = new \stdClass();
                $row->title =  $video->title_large;
                $row->idMarca = $video->marca_id;
                $row->marca = $video->marca->nombre;
                $row->slug=  $video->slug;
                $row->image = !empty($video->poster) ? asset('images/videos/' .$video->id.'/'.$video->poster) : '';
                $row->imagemobile = !empty($video->poster_mobile) ? asset('images/videos/'.$video->id.'/' . $video->poster_mobile) : '';
                $row->video= $video->link_video;
                $row->colorMarca= $video->marca->tipoColor->nombre; // colorGloria
                $response_valores[] = $row;
            }
        }

        return $response_valores;
    }

    public function productos($marca_id)
    {
        $response_valores = [];
        $productos = Product::where('marca_id',$marca_id)->orderBy('id', 'desc')->take(10)->get();

        if (count($productos) > 0) {
            foreach ($productos as $producto) {
                $row = new \stdClass();
                /*title: string;
                presentacion: string;
                idMarca: number;
                marca: string;
                slug: string;
                imagen: string;
                receta: boolean;*/
                $row->title =  $producto->title_large;
                $row->idMarca = $producto->marca_id;
                $row->marca = $producto->marca->nombre;
                $row->slug=  $producto->slug;
                $row->image = !empty($producto->poster) ? $producto->poster : '';
                $row->imagemobile = !empty($producto->poster_mobile) ?  $producto->poster_mobile: '';
                $row->presentacion = '';
                $row->receta = false;
                $response_valores[] = $row;
            }
        }

        return $response_valores;
    }

    public function campanas($marca_id)
    {
        $response_campanas = [];
        $campanas = Campanas::where('marca_id',$marca_id)->orderBy('id', 'desc')->take(10)->get();

        if (count($campanas) > 0) {
            foreach ($campanas as $campana) {
                $row = new \stdClass();
                /*title: string;
                subTitle: string;
                idMarca: number;
                marca: string;
                slug: string;
                imagen: string;*/
                $row->title =  $campana->title_large;
                $row->subTitle = $campana->title_small;
                $row->idMarca = $campana->marca_id;
                $row->marca = $campana->marca->nombre;
                $row->slug=  $campana->slug;
                $row->image = !empty($campana->poster) ? $campana->poster: '';
                $row->imagemobile = !empty($campana->poster_mobile) ?  $campana->poster_mobile: '';
                $row->video= $campana->link_video;
                $response_campanas[] = $row;
            }
        }

        return $response_campanas;
    }

    public function vategoriasVideo($marca_id)
    {
        $response = [];
        $menus = Categorias::where('active', 1)->where('marca_id',$marca_id)->orderBy('titulo', "asc")->get();

        if ($menus && count($menus) > 0) {
            foreach ($menus as $menu) {
                $row = new \stdClass();
                $row->id = $menu->id;
                $row->name = $menu->titulo ? trim($menu->titulo) : '';
                $row->slug = $menu->slug;
                $response[] = $row;
            }
        }


        return $response;
    }

    public function getTags(){
        $response = [];
        $menus = Tags::where('status', 1)->orderBy('name', "asc")->get();

        if ($menus && count($menus) > 0) {
            foreach ($menus as $menu) {
                $row = new \stdClass();
                $row->id = $menu->id;
                $row->name = $menu->name ? trim($menu->name) : '';
                $row->slug = $menu->slug;
                $response[] = $row;
            }
        }


        return $response;
    }

    public function banners($marca_id)
    {
       // $response = [];
        $video = Video::activos()->where('marca_id',$marca_id)->where('es_principal',1)->first();
        $row = new \stdClass();
        if($video){
            $row->id = $video->id;
            $row->title =  $video->title_large;
            $row->subTitle = $video->title_small;
            $row->idMarca = $video->marca_id;
            $row->marca = $video->marca->nombre;
            $row->slugMarca = $video->marca->slug;

            $row->multimedia = $video->link_video;
            $row->image = !empty($video->poster) ? $video->poster : '';
            $row->like = $video->likes;
            $row->imagemobile = !empty($video->poster_mobile) ? $video->poster_mobile : '';
            $row->slug = $video->slug;
            $row->duracion = $video->duracion;

        }

        return $row;
    }

}
