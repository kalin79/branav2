<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriaController extends Controller
{
    public function index(Request $request, Categorias $categoria){
        //dd($category->id);
        return view('pages.categorias.index',compact('categoria'));
    }
    public function load(Request $request){

        if(!$request->ajax()) return redirect('/');
        $categorias = Categorias::finterAndPaginate('',$request->parent_id);
        $parent_id = $request->parent_id ? $request->parent_id : 0;
        return view('pages.categorias.partials.load',compact('categorias','parent_id'));
    }



    public function create(Request $request){
        $parent_id = $request->parent_id ? $request->parent_id : 0;
        return view('pages.categorias.modals.create',compact('parent_id'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $validated = $request->validate([
            'titulo' => 'required|string',
            'descripcion' => 'nullable|string',
            //'images.*' => 'nullable|image|max:2048',
            //'image_mobile' => 'nullable|image|max:2048',
            //'icono' => 'nullable|image|max:2048',
        ]);

        try {
            $category = DB::transaction(function () use ( $request) {
                $position = Categorias::where('parent_id',$request->parent_id)->where('active', true)->count() + 1;
                $data = $request->all();
                $data['slug'] = Str::slug($data['titulo']);
                $data['position'] = $position;
                $category = Categorias::create($data);

                // Subir imágenes si están presentes
                if ($request->hasFile('images')) {
                    $category->updateImages($request->file('images'));
                }

                if ($request->hasFile('image_mobile')) {
                    $category->updateImageMobile($request->file('image_mobile'));
                }

                if ($request->hasFile('icon')) {
                    $category->updateIcon($request->file('icon'));
                }

                return $category;
            });

            return response()->json($category, 201);

        } catch (\Throwable $e) {
            \Log::error('Error al guardar la categoria: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Ocurrió un error al guardar la categoria.',
            ], 500);
        }
    }
    public function edit(Request $request, Categorias $categoria){
        $parent_id = $categoria->parent_id ? $categoria->parent_id : 0;
        return view('pages.categorias.modals.edit',compact('categoria','parent_id'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Categorias $categoria)
    {
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['slug'] = Str::slug($data['titulo']);
            $categoria->update($data);
            // Subir imágenes si están presentes
            if ($request->hasFile('images')) {
                $categoria->updateImages($request->file('images'));
            }

            if ($request->hasFile('image_mobile')) {
                $categoria->updateImageMobile($request->file('image_mobile'));
            }

            if ($request->hasFile('icon')) {
                $categoria->updateIcon($request->file('icon'));
            }
            DB::commit();
            return response()->json($categoria, 201);
        } catch (\Throwable $e) {
            // Puedes registrar el error si lo deseas
            // Log para debugging
            \Log::error('Error al actualizar la categoria: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Ocurrió un error al guardar la categoria.',
            ], 500);
        }


    }

    /*public function show(Request $request, Slider $banner){

        return view('pages.banners.show',compact('banner'));
    }*/

    public function desactive(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $category = Categorias::findOrFail($request->id);
        $category->active = 0;
        if($category->save()){
            return response()->json(["rpt"=>1]);
        }
    }

    public function active(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $category = Categorias::findOrFail($request->id);
        $category->active = 1;
        if($category->save()){
            return response()->json(["rpt"=>1]);
        }
    }

    public function destroy(Request $request, Categorias $categoria){
        if(!$request->ajax()) return redirect('/');

        DB::beginTransaction();
        try {

            $categoria->delete();

            DB::commit();
        } catch (Exception $exc) {
            DB::rollBack();

            abort(500);
        }
        return response()->json(["rpt"=>1]);
    }

    public function updateOrder(Request $request){
        $ids = $request->page_id_array;
        $categories = Categorias::whereIn( 'id', $ids )->where('parent_id', $request->parent_id)->orderby('position', 'asc')->get();
        $min = $categories->min('position');

        $min = $min === 0 ? 1 : $min;

        foreach ($categories as $category) {
            $key = array_search($category->id, $ids);
            if (!is_bool($key)) {
                $category->position = $min + $key;
                $category->save();
            }
        }
    }
    public function getListSubCategorias(Request $request){
        //dd($request->all());
        $sub_categorias = Categorias::where('parent_id', $request->parent_ids)->orderby('position', 'asc')->get();
        return view('pages.categorias.partials.list-subcategorias',compact('sub_categorias'));
    }
    public function getListCategory(){
        $categorias = Categorias::where('parent_id', 0)->orderby('position', 'asc')->get();
        foreach ($categorias as $categoria)
        {
            $categoria->nombre = $categoria->name;
        }
        return response()->json($categorias);
    }
}
