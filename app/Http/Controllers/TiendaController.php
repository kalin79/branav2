<?php

namespace App\Http\Controllers;

use App\Models\Tienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TiendaController extends Controller
{
    public function index(Request $request){
        //dd($category->id);
        return view('pages.tiendas.index');
    }
    public function load(Request $request){

        if(!$request->ajax()) return redirect('/');
        $tiendas = Tienda::paginate(20);
        return view('pages.tiendas.partials.load',compact('tiendas'));
    }



    public function create(Request $request){
        return view('pages.tiendas.modals.create');
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
            'nombre' => 'required|string',
            'direccion' => 'required|string',
            //'images.*' => 'nullable|image|max:2048',
            //'image_mobile' => 'nullable|image|max:2048',
            //'icono' => 'nullable|image|max:2048',
        ]);

        try {
            $category = DB::transaction(function () use ( $request) {
                $data = $request->all();
                $category = Tienda::create($data);
                return $category;
            });

            return response()->json($category, 201);

        } catch (\Throwable $e) {
            \Log::error('Error al guardar la categoria: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Ocurrió un error al guardar la tienda.',
            ], 500);
        }
    }
    public function edit(Request $request, Tienda $tienda){
        return view('pages.tiendas.modals.edit',compact('tienda'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Tienda $tienda)
    {
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $data = $request->all();
            $tienda->update($data);
            DB::commit();
            return response()->json($tienda, 201);
        } catch (\Throwable $e) {
            // Puedes registrar el error si lo deseas
            // Log para debugging
            \Log::error('Error al actualizar la tienda: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Ocurrió un error al guardar la tienda.',
            ], 500);
        }


    }

    /*public function show(Request $request, Slider $banner){

        return view('pages.banners.show',compact('banner'));
    }*/

    public function desactive(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tienda = Tienda::findOrFail($request->id);
        $tienda->active = 0;
        if($tienda->save()){
            return response()->json(["rpt"=>1]);
        }
    }

    public function active(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tienda = Tienda::findOrFail($request->id);
        $tienda->active = 1;
        if($tienda->save()){
            return response()->json(["rpt"=>1]);
        }
    }

    public function destroy(Request $request, Tienda $tienda){
        if(!$request->ajax()) return redirect('/');

        DB::beginTransaction();
        try {

            $tienda->delete();

            DB::commit();
        } catch (\Exception $exc) {
            DB::rollBack();

            abort(500);
        }
        return response()->json(["rpt"=>1]);
    }

}
