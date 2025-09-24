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

class VideoController  extends Controller
{
    use ApiResponser;

    public function index($slug)
    {
        $data = new \stdClass();
        $video = Video::where('slug', '=', $slug)->firstOrFail();

        $data                               = new \stdClass();
        //$data->category                     = $this->category($product);
        //$data->breadcrumb                   = $this->breadcrumb($product);
        $data->video                      = $this->video($video, true);
        //$data->gallery                      = $this->gallery($product);
        $data->related_video            = $this->relatedVideo($video);
        //$data->complementary_products       = $this->complementaryProducts($product);

        $status = 1;
        $code   = 200;
        $data   = $data;

        return $this->apiResponse($status, $code, $data);
    }

    public function video(Video $product,  $with_gallery = false)
    {
        $row                = new \stdClass();
        $row->id            = $product->id;
        $row->title_large         = $product->title_large ? trim($product->title_large) : '';
        $row->sub_title         = $product->title_small ? trim($product->title_small) : '';
        $row->slug         = $product->slug;
        $row->marca      = $product->marca;
        $row->categoria      = $product->categoria;
        $row->categoria_nombre = $product->categoria?$product->categoria->titulo:'';
        $row->descripcion               = $product->description ? trim($product->description) : '';
        $row->image         = !empty($product->poster) ? $product->poster: '';
        $row->imagemobile   = !empty($product->poster_mobile) ? $product->poster_mobile : '';
        $row->link_video          = $product->link_video;
        $row->fecha_estreno = $product->anio;
        $row->duracion          = $product->duracion;
        $row->elenco = $product->creditos;
        $row->clasificacion = $product->clasificacion;
        $row->autor_nombre = $product->autor_nombre;
        $row->autor_profesion = $product->autor_profesion;
        $row->autor_imagen = $product->autor_imagen;

        if ($with_gallery) {
            $row->gallery          = $this->gallery($product);
        }
        return $row;
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


    public function relatedVideo(Video $video)
    {
        $related_products = $video->relationProduct()->get()->pluck('video_relation_id')->toArray();
        $products = Video::where('active',1)->whereIn('id', $related_products)->get();
        $response_products = [];
        foreach ($products as $product) {

            $response_products[]   = $this->video($product);
        }
        return $response_products;
    }

    public function gallery(Video $product)
    {
        $gallery = $product->loadGallery();
        $response_gallery = [];
        foreach ($gallery as $image) {
            $response_gallery[]   = $image->image;
        }
        return $response_gallery;
    }

}
