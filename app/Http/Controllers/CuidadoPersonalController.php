<?php

namespace App\Http\Controllers;

use App\Models\MensajesCuidadoPersonal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CuidadoPersonalController extends Controller
{
    public function index(){

        return view('pages.cuidado-personal.index');
    }
    public function load(Request $request){

        if(!$request->ajax()) return redirect('/');

        $cuidados = MensajesCuidadoPersonal::orderBy('orden', 'asc')->paginate(10);
        return view('pages.cuidado-personal.partials.load',compact('cuidados'));
    }


    public function create(){

        return view('pages.cuidado-personal.modals.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        if(!$request->ajax()) return redirect('/');
        $data = $request->all();
        $data['orden'] = (MensajesCuidadoPersonal::where('active', true)->count() + 1);
        $cuidadoPersonal = MensajesCuidadoPersonal::create($data);
        $cuidadoPersonal->updateIcon($request->file('images'));

        return response()->json($cuidadoPersonal,201);
    }
    public function edit(Request $request, MensajesCuidadoPersonal $cuidado_personal){

        return view('pages.cuidado-personal.modals.edit',compact('cuidado_personal'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,MensajesCuidadoPersonal $cuidado_personal)
    {
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $cuidado_personal->update($request->all());
            $cuidado_personal->updateIcon($request->file('images'));
            DB::commit();
        } catch (\Exception $exc) {
            DB::rollBack();
            abort(500);
        }
        return response()->json($cuidado_personal,202);


    }

    public function show(Request $request, MensajesCuidadoPersonal $cuidado_personal){

        return view('pages.cuidado-personal.show',compact('cuidado_personal'));
    }

    public function desactive(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $cuidado_personal = MensajesCuidadoPersonal::findOrFail($request->id);
        $cuidado_personal->active = 0;
        if($cuidado_personal->save()){
            return response()->json(["rpt"=>1]);
        }
    }

    public function active(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $cuidado_personal = MensajesCuidadoPersonal::findOrFail($request->id);
        $cuidado_personal->active = 1;
        if($cuidado_personal->save()){
            return response()->json(["rpt"=>1]);
        }
    }

    public function destroy(Request $request, MensajesCuidadoPersonal $cuidado_personal){
        if(!$request->ajax()) return redirect('/');

        DB::beginTransaction();
        try {

            $cuidado_personal->delete();

            DB::commit();
        } catch (\Exception $exc) {
            DB::rollBack();

            abort(500);
        }
        return response()->json(["rpt"=>1]);
    }

    public function updateOrder(Request $request){
        $ids = $request->page_id_array;
        $cuidado_personal = MensajesCuidadoPersonal::whereIn('id',$ids )->orderby('orden', 'asc')->get();
        $min = $cuidado_personal->min('orden');

        $min = $min === 0 ? 1 : $min;

        foreach ($cuidado_personal as $category) {
            $key = array_search($category->id, $ids);
            if (!is_bool($key)) {
                $category->orden = $min + $key;
                $category->save();
            }
        }
    }
}
