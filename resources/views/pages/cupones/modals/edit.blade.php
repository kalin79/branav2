<div class="row row-alert" ></div>

<form action="{{ route('tienda.update',$tienda->id) }}" method="POST" id="form-tienda-update" class="form-horizontal needs-validation">
    @csrf
    <div class="modal-body admin-form">


        <div class="form-group row">
            <label for="nombre" class="col-sm-3 control-label">Nombre</label>
            <div class="col-sm-9">
                <label class="field">
                    <input type="text" name="nombre" id="nombre" class="form-control gui-input" required  placeholder="Nombre del Usuario" value="{{$tienda->nombre}}">
                </label>
            </div>
        </div>

        <div class="form-group row">
            <label for="direccion" class="col-sm-3 control-label">Direccion</label>
            <div class="col-sm-9">
                <label class="field">
                    <input type="text" name="direccion" id="direccion" class="form-control gui-input" placeholder="direccion..." value="{{$tienda->direccion}}">
                </label>

            </div>
        </div>
        <div class="form-group row">
            <label for="tiempo_entrega" class="col-sm-3 control-label">Tiempo Entrega</label>
            <div class="col-sm-9">
                <label class="field">
                    <input type="text" name="tiempo_entrega" class="form-control gui-input" id="tiempo_entrega" placeholder="Tiempo Entrega" value="{{$tienda->tiempo_entrega}}">
                </label>
            </div>
        </div>
        <div class="form-group row">
            <label for="telefono" class="col-sm-3 control-label">Telefono</label>
            <div class="col-sm-9">
                <label class="field">
                    <input type="text" name="telefono" id ="telefono" class="form-control gui-input" placeholder="Telefono..." value="{{$tienda->telefono}}">
                </label>
            </div>
        </div>
    </div>
</form>

