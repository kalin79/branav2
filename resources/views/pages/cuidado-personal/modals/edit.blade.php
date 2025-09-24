<div class="row row-alert"></div>

<form action="{{ route('cuidado-personal.update',$cuidado_personal->id) }}" method="POST" id="form-banners-edit"
    class="form-horizontal needs-validation">
    @csrf
    <div class="modal-body admin-form">
        <div class="form-group">
            <label for="title">Título </label>
            <label class="field">
                <input type="text" id="title" required class="form-control gui-input"
                   name="titulo"
                   placeholder="Ingresar Título" value="{{$cuidado_personal->titulo}}"
                   >
            </label>


        </div>
        <div class="form-group ">
            <label for="button">Color</label>
            <input type="text" id="button" class="form-control"
                   name="color"
                   placeholder="Color"
                   value="{{$cuidado_personal->color}}"
            >

        </div>
        <div class="form-group">
            <label for="description">Descripción </label>
            <textarea id="description" class=" form-control"
                      name="descripcion"
                      placeholder="Ingresar descripción" >{{$cuidado_personal->descripcion}}</textarea>
        </div>

        <div class="form-group">
            <label for="avatar">Imagen (*) </label>
            <div class="custom-file">
                <input accept="image/*" name="images" class="custom-file-input" id="avatar"
                       lang="es" type="file" >
                <label id="file-desktop" class="custom-file-label" for="avatar"></label>
            </div>
            <small>* [1440*550] Sólo imágenes JPG y PNG, Máximo de 1M</small>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="font-icon-wrapper float-left mr-3 mb-3">
                    <img src="{{asset('images/cuidado-personal')}}/{{$cuidado_personal->id}}/{{$cuidado_personal->icono}}" class="rounded-circle img-custom"
                         id='img-upload'
                         width="100"/>
                </div>
            </div>
        </div>

    </div>
</form>
