<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Filters\Product\ProductFilter;
use App\Models\Categorias;
use App\Models\Productos;
use App\Models\ProductoImagenes;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class ProductoController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.productos.index');
        //return new ProductResource(Productos::finterAndPaginate(request('q'), request('cat'),$paginate,$from,$promotion_rule_id));
    }

    public function load(ProductFilter $filters){
        $productos=Productos::finterAndPaginate($filters);
        return view('pages.productos.partials.load',compact('productos'));
    }

    public function create(){
        $categorias = Categorias::where('active', true)->where('parent_id', 0)
            ->orderBy('position')
            ->orderBy('titulo','asc')
            ->get();
        return view('pages.productos.create',compact('categorias'));
    }

    public function updatePositions(Request $request)
    {


        //$productCategories = ProductCategorias::where('categorie_id', $request->get('cat'))->orderBy('position', 'asc');
        if ($request->get('ids')) {
            foreach ($request->get('ids') as $idn => $idProduct) {
                $productCategory = ProductCategorias::where('categorie_id', $request->get('cat'))->where('product_id', $idProduct)->first();
                if ($productCategory) {
                    $productCategory->position = ($idn + 1);
                    $productCategory->update();
                }
            }
        }
    }



    public function store(Request $request)
    {
        try {
            $product = DB::transaction(function () use ($request) {
                $data = $request->all();
                $tituloLimpio = strip_tags($data['title_large']);
                $slug = Str::slug($tituloLimpio);
                if (Productos::where('slug', $slug)->withTrashed()->count() > 0) {
                    $slug = Str::slug($tituloLimpio . "-" . rand(99, 9999));
                }

                $data['slug'] = $slug;
                $product = Productos::create($data);
                // Subir imágenes si existen
                if ($request->hasFile('poster')) {
                    $product->updateImagePoster($request->file('poster'));
                }

                if ($request->hasFile('poster_mobile')) {
                    $product->updateImagePosterMobile($request->file('poster_mobile'));
                }

                if ($request->hasFile('imagen_acerca_producto')) {
                    $product->updateImageAcercaProducto($request->file('imagen_acerca_producto'));
                }

                if ($request->hasFile('imagen_como_usarlo')) {
                    $product->updateImageComoUsarlo($request->file('imagen_como_usarlo'));
                }

                if ($request->hasFile('gallery')) {
                    $product->storeGallery($request->file('gallery'));
                }

                return $product;
            });

            session()->flash('message', 'Registro creado satisfactoriamente.');
            return response()->json(['route' => route('products.index')]);

        } catch (\Throwable $e) {
            \Log::error('Error al guardar la categoria: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Ocurrió un error al guardar la categoria.',
            ], 500);
        }
    }

    public function edit(Productos $product){
        //dd($producto);
        $categorias = Categorias::where('active', true)->where('parent_id', 0)
            ->orderBy('position')
            ->orderBy('titulo','asc')
            ->get();

        $sub_categorias = Categorias::where('parent_id', $product->categoria_id)
            ->orderBy('titulo','asc')
            ->get();
        return view('pages.productos.edit',compact('categorias','product','sub_categorias'));
    }

    public function update(Request $request, Productos $product)
    {
        /*if (Gate::denies('product_edit')) {
            return abort(401);
        }*/
        $data = $request->all();



        $slug = Str::slug($data['title_large']);
        if (Productos::where('slug', $slug)->where("id", "!=", $product->id)->withTrashed()->count() > 0) {
            $slug = Str::slug($data['title_large'] . "-" . rand(99, 9999));
        }
        $data['slug'] = $slug;

        //$product = Productos::findOrFail($id);
        $product->update($data);
        // Subir imágenes si existen
        if ($request->hasFile('poster')) {
            $product->updateImagePoster($request->file('poster'));
        }

        if ($request->hasFile('poster_mobile')) {
            $product->updateImagePosterMobile($request->file('poster_mobile'));
        }

        if ($request->hasFile('imagen_acerca_producto')) {
            $product->updateImageAcercaProducto($request->file('imagen_acerca_producto'));
        }

        if ($request->hasFile('imagen_como_usarlo')) {
            $product->updateImageComoUsarlo($request->file('imagen_como_usarlo'));
        }

        if ($request->hasFile('gallery')) {
            $product->storeGallery($request->file('gallery'));
        }
        $post_route = route('products.index');
        session()->flash('message', 'Registro actualizado satisfactoriamente.');
        return response()->json(['route' => $post_route]);
        //return response()->json($product,202);

    }

    public function destroy($id)
    {
        /*if (Gate::denies('product_delete')) {
            return abort(401);
        }*/

        $product = Productos::findOrFail($id);
        $product->delete();

        return response()->json(["rpt"=>1]);
    }
    public function active(Request $request){
        $producto = Productos::findOrFail($request->id);
        $producto->active = 1;
        if($producto->save()){

            return response()->json(["rpt"=>1]);
        }
    }
    public function desactive(Request $request){
        $producto = Productos::findOrFail($request->id);
        $producto->active = 0;
        if($producto->save()){

            return response()->json(["rpt"=>1]);
        }
    }

    public function updateActivated(Request $request, $id)
    {
        if (Gate::denies('product_edit')) {
            return abort(401);
        }
        $product = Productos::findOrFail($id);

        $product->active = ($request->get('active') === "true") ? true : false;
        $product->save();
        /*return (new ProductResource($product))
            ->response()
            ->setStatusCode(202);*/
    }

    public function loadImages(Request $request)
    {
        if (Gate::denies('product_edit')) {
            return abort(401);
        }

        $images = [];

        $product = Productos::findOrFail($request->id);
        if ($product->poster) {
            $images[] = [
                'id' => -1,
                'image' => $product->poster,
                'type' => 'principal'
            ];
        }

        /*$productImages = ProductImageLoad::collection($product->productImages->whereNull('deleted_at')->sortBy('order'));
        foreach ($productImages as $product_image) {
            if (!empty($product_image->image)) {
                $images[] = [
                    'id' => $product_image->id,
                    'image' => $product_image->image,
                    'type' => 'gallery',
                    'temp' => false
                ];
            }
        }*/

        return response()->json([
            'images' => $images
        ]);
    }

    public function loadGallery(Productos $product)
    {
        $gallery =$product->loadGallery();
        return view('pages.productos.partials.load-gallery',compact('gallery','product'));
    }

    public function updateOrderImageGallery(Request $request){
        $ids = $request->page_id_array;
        $gallery = ProductoImagenes::whereIn('id',$ids )->orderby('order', 'asc')->get();
        $min = $gallery->min('order');

        $min = $min === 0 ? 1 : $min;

        foreach ($gallery as $image) {
            $key = array_search($image->id, $ids);
            if (!is_bool($key)) {
                $image->order = $min + $key;
                $image->save();
            }
        }
    }

    public function destroyImageGallery(Request $request, Productos $product, ProductoImagenes $product_image)
    {
        if(!$request->ajax()) return redirect('/');

        DB::beginTransaction();
        try {
            $product_image->delete();
            ProductoImagenes::reorder($product->id);
            DB::commit();
        } catch (\Exception $exc) {
            DB::rollBack();

            abort(500);
        }

        return response()->json(["rpt"=>1]);
    }
}
