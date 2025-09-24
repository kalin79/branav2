<div class="row row-alert"></div>

<form action="{{ route('categories.store') }}" method="POST" id="form-categoria-create"
    class="form-horizontal needs-validation">
    @csrf
    <input type="hidden" name="parent_id" value="{{$parent_id}}">
    <div class="modal-body admin-form">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="name">@if($parent_id==0)Categoría (*) @else Sub-Categoría (*) @endif</label>
                <label class="field">
                    <input class="form-control gui-input" id="titulo" name="titulo" placeholder=""
                           required
                           type="text">
                </label>

            </div>
            @if($parent_id==0)
            <div class="form-group col-md-6">
                <label for="color">Color</label>
                <label class="field">
                    <input class="form-control gui-input" id="color" name="color" placeholder="" type="text">
                </label>

            </div>
            @endif
        </div>

        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea class="form-control" name="descripcion" id="description"></textarea>
        </div>

        @if($parent_id==0)
        <div class="row" >
            <div class="form-group col-sm-6" >
                <label for="avatar">Imagen</label>
                <div class="custom-file">
                    <input accept="image/*" class="custom-file-input" id="poster"
                           lang="es" type="file" name="images">
                    <label id="file-image" class="custom-file-label" for="avatar"></label>
                </div>
                <small>* [420*210] Sólo imágenes JPG y PNG, Máximo de 1M</small>
            </div>
            <div class="form-group col-sm-6">
                <label for="image_mobile">Imagen Movil(*) </label>
                <div class="custom-file">
                    <input accept="image/*" name="image_mobile" class="custom-file-input" id="image_mobile"
                           lang="es" type="file" >
                    <label id="file-mobile" class="custom-file-label" for="image_mobile"></label>
                </div>
            </div>
        </div>

        <div class="row" >
            <div class="col-sm-6">
                <div class="font-icon-wrapper float-left mr-3 mb-3">
                    <img src="" class="rounded-circle img-custom"
                         id='img-upload'
                         width="100"/>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="font-icon-wrapper float-left mr-3 mb-3">
                    <img src="" class="rounded-circle img-custom"
                         id='img-upload-mobile'
                         width="100"/>
                </div>
            </div>
        </div>

        <div class="row" >
            <div class="form-group col-sm-6" >
                <label for="icon">Icono</label>
                <div class="custom-file">
                    <input accept="image/*" class="custom-file-input" id="icon"
                           lang="es" type="file" name="icon">
                    <label id="file-icono" class="custom-file-label" for="avatar"></label>
                </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-sm-6">
                <div class="font-icon-wrapper float-left mr-3 mb-3">
                    <img src="" class="rounded-circle img-custom"
                         id='img-upload-icon'
                         width="100" height="100"/>
                </div>
            </div>
        </div>
        @endif
    </div>

</form>
