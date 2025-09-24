<?php

namespace App\Http\Controllers;

use App\Http\Filters\Product\ProductFilter;
use App\Models\ProductoRelacionados;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoRelacionadoController extends Controller
{
    public function index(Productos $product){

        return view('pages.productos.relacionadas.index',compact('product'));
    }
    public function load(Request $request,Productos $product){

        if(!$request->ajax()) return redirect('/');

        $relacionadas = $product->relationProduct()->orderBy('created_at', 'asc')->paginate(10);
        //dd($relacionadas);
        return view('pages.productos.relacionadas.partials.load',compact('relacionadas'));
    }

    public function create(Productos $product){

        //dd($product);


        return view('pages.productos.modals.list-product-index');
    }
    public function listProductLoad(ProductFilter $filters,Productos $product){
        $relacionadas = $product->relationProduct()->get()->pluck('producto_relacionado_id')->toArray();
        array_push($relacionadas,$product->id);

        $productos = Productos::filterDynamic($filters)->whereNotIn('id',$relacionadas)->paginate(5);
        return view('pages.productos.partials.list-product-load',compact('productos','product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!$request->ajax()) return redirect('/');
        // DB::beginTransaction();
        //try {
        $producto_relacionada = ProductoRelacionados::create($request->all());

        /*    DB::commit();
        } catch (Exception $exc) {
            DB::rollBack();
            abort(500);
        }*/
        /* $post_route = route('admin.noticia.relacionada.index');
         session()->flash('message', 'Los registros se actualizaron satisfactoriamente.');*/
        return response()->json(true);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,ProductoRelacionados $producto_relacionada)
    {
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {

            $producto_relacionada->update($request->all());


            DB::commit();
        } catch (Exception $exc) {
            DB::rollBack();
            abort(500);
        }
        $post_route = route('admin.noticia.relacionada.index',$producto_relacionada->product_id);
        session()->flash('message', 'Los registros se actualizaron satisfactoriamente.');

        return response()->json(['route' => $post_route]);

    }

    public function desactive(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $producto_relacionada = ProductoRelacionados::findOrFail($request->id);
        $producto_relacionada->active = false;
        if($producto_relacionada->save()){
            return response()->json(["rpt"=>1]);
        }
    }

    public function active(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $producto_relacionada = ProductoRelacionados::findOrFail($request->id);
        $producto_relacionada->active = true;
        if($producto_relacionada->save()){
            return response()->json(["rpt"=>1]);
        }
    }

    public function destroy(Request $request, ProductoRelacionados $producto_relacionada){
        if(!$request->ajax()) return redirect('/');

        DB::beginTransaction();
        try {

            $producto_relacionada->delete();

            DB::commit();
        } catch (Exception $exc) {
            DB::rollBack();

            abort(500);
        }
        return response()->json(["rpt"=>1]);
    }
}
