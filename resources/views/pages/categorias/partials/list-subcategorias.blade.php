<option></option>
@foreach ($sub_categorias as $categoria)
    <option value="{{$categoria->id}}">{{$categoria->titulo}}</option>
@endforeach
