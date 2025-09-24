<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\BannerCategory;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
class GaleryProductController extends Controller
{
    public function productDateEspecial(){
        $products = Product::where('dia_especial',1)->activos()->get();
        $data = [];
        foreach ($products as $product){
            $row = new \stdClass();
            $row->id = $product->id;
            $row->title = $product->title_large ? trim($product->title_large): '';
            $row->price = $product->price_normal;
            $row->price_old = $product->price_online;
            $row->image = !empty($product->poster) ? asset('images/products/' .$product->id.'/'.$product->poster) : '';
            $row->imagemobile = !empty($product->poster_mobile) ? asset('images/products/'.$product->id.'/' . $product->poster_mobile) : '';
            $row->link = '/'.trim($product->slug);
            $data[] = $row;
        }
        $response = [
            'status' => 1,
            'code' => 200,
            'msg' => 'OK',
            'data' => $data,
            'data_error' => []
        ];
        return response()->json( $response );
    }
    public function productByCategories(Request $request){
        $categoria = Category::where('slug',$request->categoria_slug)->where('parent_id',0)->activos()->first();
        if($categoria){
            $products = Product::where('categoria_id',$categoria->id)->activos();
            $sub_categoria_id = 0;
            if(isset($request->subcategoria_slug) && $request->subcategoria_slug){
                $sub_categoria = Category::where('slug',$request->subcategoria_slug)->where('parent_id',$categoria->id)->activos()->first();
                if($sub_categoria){
                    $sub_categoria_id = $sub_categoria->id;
                    $products = $products->where('sub_categoria_id',$sub_categoria->id);
                }
            }
            $data_categoria= $this->categories($categoria->id,$sub_categoria_id);
            $products = $products->paginate(8);
            $data = [];
            foreach ($products as $product){
                $row = new \stdClass();
                $row->id = $product->id;
                $row->title = $product->title_large ? trim($product->title_large): '';
                $row->description_small = $product->description_small ? trim($product->description_small): '';
                $row->category_name = $product->category? $product->category->name : '';
                $row->sub_category_name = $product->subCategory? $product->subCategory->name : '';
                $row->price = $product->price_normal;
                $row->price_old = $product->price_online;
                $row->image = !empty($product->poster) ? asset('images/products/' .$product->id.'/'.$product->poster) : '';
                $row->imagemobile = !empty($product->poster_mobile) ? asset('images/products/'.$product->id.'/' . $product->poster_mobile) : '';
                $row->link = 'producto/'.trim($product->slug);
                $data[] = $row;
            }

            $response = [
                'status' => 1,
                'code' => 200,
                'msg' => 'OK',
                'data_category'=>$data_categoria,
                'banner_category'=>$this->bannersByCategory($categoria->id),
                'sub_categories'=>$this->listSubCategories($categoria),
                'data' => $data,
                'pagination' => [
                    'total' => $products->total(),
                    'current_page' => $products->currentPage(),
                    'per_page' => $products->perPage(),
                    'last_page' => $products->lastPage(),
                    'from' => $products->firstItem(),
                    'to' => $products->lastItem()
                ],
                'data_error' => []
            ];
        }else{
            $response = [
                'status' => 0,
                'code' => 200,
                'msg' => 'OK',
                'data' => [],
                'data_error' => ['msg'=>'No se encontro registros']
            ];

        }
        return response()->json( $response );
    }

    public function bannersByCategory($categoria_id){
        $response = [];
        $data = BannerCategory::activos()->where('category_id',$categoria_id)->orderBy('position')->get();
        if ($data && count($data) > 0) {
            foreach ($data as $banner) {
                $row = new \stdClass();
                $row->id = $banner->id;
                $row->title = $banner->title ? trim($banner->title): '';
                $row->image = !empty($banner->poster) ? asset('images/categories/'.$categoria_id.'/banners/'.$banner->id.'/'.$banner->poster) : '';
                $row->imagemobile = !empty($banner->poster_mobile) ? asset('images/categories/'.$categoria_id.'/banners/'.$banner->id.'/'. $banner->poster_mobile) : '';
                $row->link = trim($banner->link);
                $response[] = $row;
            }
        }

        return $response;
    }

    public function categories($categoria_id,$sub_categoria){
        $response = [];

        $data = Category::activos()->with(['subCategories'=>function($query) use($sub_categoria){
            $query->activos();
            $query->where('id',$sub_categoria);
        }])->where('id',$categoria_id)->orderBy('position')->get();

        if ($data && count($data) > 0) {
            foreach ($data as $categorias) {
                $row = new \stdClass();
                $row->id = $categorias->id;
                $row->title = $categorias->name ? trim($categorias->name): '';
                $row->description = $categorias->description ? trim($categorias->description): '';
                $row->subtitle = $categorias->sub_title ? trim($categorias->sub_title): '';
                $row->slug = trim($categorias->slug);
                $row->link = '/'.trim($categorias->slug);
                $response_sub_cate = [];
                foreach ($categorias->subCategories as $sub_categorias) {
                    $row_sub_cate = new \stdClass();
                    $row_sub_cate->id = $sub_categorias->id;
                    $row_sub_cate->title = $sub_categorias->name ? trim($sub_categorias->name): '';
                    $row_sub_cate->slug = trim($sub_categorias->slug);
                    $row_sub_cate->link = '/'.trim($categorias->slug).'/'.trim($sub_categorias->slug);
                    $row_sub_cate->description = $sub_categorias->description ? trim($sub_categorias->description): '';
                    $response_sub_cate[] = $row_sub_cate;

                }
                $row->sub_categorias = $response_sub_cate;
                $response[] = $row;
            }
        }
        return $response;
    }

    public function listSubCategories($categoria){
        $sub_categorias_data = Category::where('parent_id',$categoria->id)->activos()->get();
        $response_sub_cate = [];
        if ($sub_categorias_data && count($sub_categorias_data) > 0) {
            foreach ($sub_categorias_data as $sub_categorias) {
                $row_sub_cate = new \stdClass();
                $row_sub_cate->id = $sub_categorias->id;
                $row_sub_cate->title = $sub_categorias->name ? trim($sub_categorias->name): '';
                $row_sub_cate->slug = trim($sub_categorias->slug);
                $row_sub_cate->link = '/'.trim($categoria->slug).'/'.trim($sub_categorias->slug);
                $row_sub_cate->description = $sub_categorias->description ? trim($sub_categorias->description): '';
                $response_sub_cate[] = $row_sub_cate;

            }
        }



        return $response_sub_cate;
    }
}
