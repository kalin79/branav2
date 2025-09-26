@extends('layouts.app')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-graph text-success"></i>
                </div>
                <div>Registro de Producto
                    <div class="page-title-subheading opacity-10">
                        <nav class="" aria-label="breadcrumb">
                            <ol class="breadcrumb">

                                <li class="breadcrumb-item">
                                    <a>Producto</a>
                                </li>
                                <li class="active breadcrumb-item" aria-current="page">
                                    Registro
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="mb-1 card  m-0 p-0">
                    <div class="card-header">
                        <ul class="nav nav-justified">
                            <li class="nav-item">
                                <a data-toggle="tab" href="#tab-eg7-0" class="nav-link active">Información
                                    básica</a>
                            </li>
                            <li class="nav-item">
                                <a data-toggle="tab" href="#tab-eg7-1" class="nav-link">Acerca del producto</a>
                            </li>
                            <li class="nav-item">
                                <a data-toggle="tab" href="#tab-eg7-2" class="nav-link">¿Cómo usarlo?</a>
                            </li>
                            <li class="nav-item">
                                <a data-toggle="tab" href="#tab-eg7-3" class="nav-link">Imágenes</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="admin-form theme-primary">
                    <form method="POST" action="{{ route('products.update',$product->id) }}" id="form-product" class="form-horizontal"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id_ajax" value="">

                        <div class="card-body ">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-eg7-0" role="tabpanel">

                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label class="field">
                                                    <label for="title_large" class=""><b>Título</b></label>
                                                    <input name="title_large" id="title_large" placeholder="Título"
                                                           type="text" value="{{$product->title_large}}"
                                                           class="form-control gui-input">
                                                </label>

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-relative form-group">
                                                <label class="field">
                                                    <label for="title_small" class=""><b>Sub titulo</b></label>
                                                    <input name="title_small" id="title_small" value="{{$product->title_small}}" placeholder="Subtitulo" type="text" class="form-control gui-input">
                                                </label>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="position-relative form-group">
                                                <label for="presentacion" class=""><b>Presentación</b></label>

                                                <input name="presentacion" id="presentacion" placeholder="Presentación" type="text" class="form-control gui-input" value="{{$product->presentacion}}">
                                            </div>
                                        </div>


                                    </div>


                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="price_normal"><b>Precio Actual</b></label>
                                            <label class="field">
                                                <div class="input-group input-group">

                                                    <div class="input-group-prepend"><span
                                                            class="input-group-text text-white bg-success">S/</span>
                                                    </div>

                                                    <input type="text" id="price_normal"
                                                           class="form-control gui-input only_decimal "
                                                           name="precio_normal"
                                                           placeholder="0.00"
                                                           step=".01"
                                                           min="0"
                                                           value="{{$product->precio_normal}}">

                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="price_online"><b>Precio Anterior</b></label>
                                            <label class="field">
                                                <div class="input-group input-group">
                                                    <div class="input-group-prepend"><span
                                                            class="input-group-text text-white bg-danger">S/</span>
                                                    </div>

                                                    <input type="text" id="price_online"
                                                           class="form-control gui-input only_decimal"
                                                           name="precio_online"
                                                           step=".01"
                                                           min="0"
                                                           placeholder="0.00"
                                                           value="{{$product->precio_online}}">

                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="stock"><b>Stock</b></label>
                                            <input type="number" id="stock"
                                                   class="form-control form-control only_number"
                                                   name="stock"
                                                   min="0"
                                                   placeholder="Ingresar Stock"
                                                   value="{{$product->stock}}">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group overflow-auto vh-75 ">
                                                <label for="title_large"><b>Categorías</b></label>
                                                <label class="field select">
                                                    <select id="cmb_categoria" name="categoria_id"
                                                            class=" form-control " placeholder="Seleccione categoria"
                                                            style="width: 100% !important">
                                                        <option></option>
                                                        @foreach ($categorias as $categoria)
                                                            <option value="{{$categoria->id}}"
                                                                    @if($product->categoria_id == $categoria->id) selected @endif>{{$categoria->titulo}}</option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group overflow-auto vh-75 ">
                                                <label for="cmb_subcategoria"><b>Sub Categorías</b></label>
                                                <label class="field select">
                                                    <select id="cmb_subcategoria" name="sub_categoria_id" class=" form-control " placeholder="Seleccione categoria" style="width: 100% !important">
                                                        <option></option>
                                                        @foreach ($sub_categorias as $sub_categoria)
                                                            <option value="{{$sub_categoria->id}}" @if($sub_categoria->id==$product->sub_categoria_id) selected @endif>{{$sub_categoria->titulo}}</option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="description_corta"><b>Descripción corta</b></label>
                                            <label class="field">
                                                    <textarea id="description_small" class="form-control form-control-sm tinymce"
                                                              name="description_small"
                                                              placeholder="Descripción corta" rows="10">{{$product->description_small}}</textarea>
                                            </label>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="description"><b>Descripción completa</b></label>
                                            <label class="field ">
                                                    <textarea id="description" class="form-control form-control-sm tinymce"
                                                              name="description"
                                                              placeholder="Descripción completa" rows="10">{{$product->description}}</textarea>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox"  id="check_descuento"  class="custom-control-input" @if($product->descuento_producto) checked @endif>
                                                <label class="custom-control-label" for="check_descuento"><b>Aplicar Descuento</b></label>
                                                <input type="hidden" id="descuento_producto" name="descuento_producto" value="{{$product->descuento_producto}}">
                                            </div>
                                        </div>
                                    </div>
{{--                                    <div class="row">--}}
{{--                                        <div class="form-group col-sm-6">--}}
{{--                                            <div class="custom-checkbox custom-control">--}}
{{--                                                <input type="checkbox"  id="check_dia_especial"  class="custom-control-input" @if($product->dia_especial) checked @endif>--}}
{{--                                                <label class="custom-control-label" for="check_dia_especial">Check para agregar producto a día especial</label>--}}
{{--                                                <input type="hidden" id="valor_dia_especial" name="dia_especial" value="{{$product->dia_especial}}">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                    </div>--}}
                                </div>
                                <div class="tab-pane" id="tab-eg7-1" role="tabpanel">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="poster">Imagen</label>
                                                <div class="custom-file">
                                                    <input type="file" accept="image/*" class="custom-file-input"
                                                           id="poster-acerca-producto" name="imagen_acerca_producto" lang="es">
                                                    <label class="custom-file-label" for="poster" id="file-label-acerca-producto"></label>
                                                </div>
                                                <small>* [1000*1000] Sólo imágenes JPG y PNG, Máximo de 1M</small>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="font-icon-wrapper float-left mr-3 mb-3 "  style="height: 112px">
                                                    <img id="img-upload-acerca-producto"
                                                         src="{{asset('images/products')}}/{{$product->id}}/{{$product->imagen_acerca_producto}}"
                                                         class="rounded-circle img-custom"
                                                         width="100" height="100px"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="description_corta"><b>Descripción</b></label>
                                            <label class="field">
                                                    <textarea id="description_corta" class="form-control form-control-sm gui-input tinymce"
                                                              name="acerca_producto"
                                                              placeholder="Descripción" rows="10">{{$product->acerca_producto}}</textarea>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-eg7-2" role="tabpanel">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="poster">Imagen</label>
                                                <div class="custom-file">
                                                    <input type="file" accept="image/*" class="custom-file-input"
                                                           id="poster-como-usarlo" name="imagen_como_usarlo" lang="es">
                                                    <label class="custom-file-label" for="poster" id="file-label-como-usarlo"></label>
                                                </div>
                                                <small>* [1000*1000] Sólo imágenes JPG y PNG, Máximo de 1M</small>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="font-icon-wrapper float-left mr-3 mb-3 "  style="height: 112px">
                                                    <img id="img-upload-como-usarlo"
                                                         src="{{asset('images/products')}}/{{$product->id}}/{{$product->imagen_como_usarlo}}"
                                                         class="rounded-circle img-custom"
                                                         width="100" height="100px"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="como_usarlo"><b>Descripción</b></label>
                                            <label class="field">
                                                    <textarea id="como_usarlo" class="form-control form-control-sm gui-input tinymce"
                                                              name="como_usarlo"
                                                              placeholder="Como usarlo" rows="10">{{$product->como_usarlo}}</textarea>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-eg7-3" role="tabpanel">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="poster">Imagen PC</label>
                                                <div class="custom-file">
                                                    <input type="file" accept="image/*" class="custom-file-input"
                                                           id="poster" name="poster" lang="es">
                                                    <label class="custom-file-label" for="poster"></label>
                                                </div>
                                                <small>* [1000*1000] Sólo imágenes JPG y PNG, Máximo de 1M</small>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="font-icon-wrapper float-left mr-3 mb-3 "
                                                     style="height: 100px">
                                                    <img id="img-upload"
                                                         src="{{asset('images/products')}}/{{$product->id}}/{{$product->poster}}"
                                                         class="rounded-circle img-custom"
                                                         width="100" height="100px"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="poster_mobile">Imagen Mobile</label>
                                                <div class="custom-file">
                                                    <input type="file" accept="image/*" class="custom-file-input"
                                                           id="poster_mobile" name="poster_mobile" lang="es">
                                                    <label class="custom-file-label"  id="file-label-mobile"></label>
                                                </div>
                                                <small>* [1000*1000] Sólo imágenes JPG y PNG, Máximo de 1M</small>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="font-icon-wrapper float-left mr-3 mb-3 "  style="height: 112px">
                                                    <img id="img-upload-mobile"
                                                         src="{{asset('images/products')}}/{{$product->id}}/{{$product->poster_mobile}}"
                                                         class="rounded-circle img-custom"
                                                         width="100" height="100px"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Galería de Imágenes</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input type="file" accept="image/*" class="galeria"
                                                            id="galeria" name="gallery[]" lang="es" multiple = "multiple" >
                                                <small>* [1000*1000] Sólo imágenes JPG y PNG, Máximo de 1M</small>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="table-wrap">
                                                <div id="table-content-gallery" class="table-responsive">
                                                    <table  class="table table-striped mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Imagen</th>
                                                                <th>Orden</th>
                                                                <th>Opciones</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                    <div id="loading" class="text-center">
                                                        <i class="fa fa-spinner fa-pulse fa-lg p-5" role="status" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="d-block text-right card-footer">
                            <a href="{{route('products.index')}}" class="btn-wide   btn btn-secondary ">Cancelar</a>
                            <button type="submit" id="btn-submit-product" class="btn-wide  btn btn-primary">Guardar
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
@endsection
@push('scripts')

    <script>
        var url_list_subcategories  = "{{route('subcategories.list')}}";
        var url_gallery_load        = "{{ route('products.gallery.load',$product->id) }}";
        var update_order_banner     =  "{{ route('products.gallery.update-order') }}";
    </script>
    <script src="{{ asset( 'template-mintos/vendors/tinymce/tinymce.min.js' ) }}"></script>
     <script src="{{ asset('architec-ui/js/vendors/form-components/bootstrap-multiselect.js') }}"></script>
    <script type="text/javascript" src="{{ asset('kendo/js/kendo.all.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('kendo/js/kendo.culture.es-ES.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('app/producto/form-create.js') }}"></script>

    <!-- Validations JS -->
    @include('scripts-group.jquery-validation')
@endpush
