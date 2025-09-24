jQuery(function () {
    $( '#check_dia_especial' ).on( 'click', function() {
        if( $(this).is(':checked') ){
            // Hacer algo si el checkbox ha sido seleccionado
            $("#valor_dia_especial").val(1);
        } else {
            // Hacer algo si el checkbox ha sido deseleccionado
            $("#valor_dia_especial").val(0);

        }
    });
    $('#poster').on('change', function () {
        const file = this.files[0];
        $("#file-label-pc").text(file['name']);
        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                $('#img-upload').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    $('#poster_mobile').on('change', function () {
        const file = this.files[0];
        $("#file-label-mobile").text(file['name']);
        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                $('#img-upload-mobile').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    $('#autor-archivo').on('change', function () {
        const file = this.files[0];
        $("#file-label-autor-archivo").text(file['name']);
        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                $('#img-upload-autor-archivo').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    $('#meta_image').on('change', function () {
        const file = this.files[0];
        $("#file-meta-image-pc").text(file['name']);
    });

    $(".galeria").kendoUpload({
        language: "es",
        previewFileType: 'any',
        showUpload: false,
        showCaption: false,
        showRemove: false,
        autoReplace: true,
        localization: {
            select: "Seleccionar archivo...",
            remove: "Remover",
            uploadSelectedFiles: "Subir archivos"
        },
        async: {
            saveUrl: "save",
            removeUrl: "remove",
            autoUpload: false,
        },
        multiple: true,
        validation: {
            maxFileSize: 2097152,
            allowedExtensions: [".gif", ".jpg", ".png"]
        },
        select: onSelect,
    });

    $("#form-product").trigger("reset");

    tinymce.init({
        selector: '.tinymce',
        height: 200,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code textcolor'
        ],
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor',
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });

    $("#cmb_categoria").select2({
        theme: "bootstrap4",
        placeholder: "Seleccione categoria",
    })/*.on('select2:select', function (e) {
        var categories_id = $(this).val();
        $("#cmb_subcategoria").html('');
        load_subcategorias(categories_id);
    }).on('select2:unselect', function (e) {
        var categories_id = $(this).val();
        $("#cmb_subcategoria").html('');
        if (categories_id.length > 0) {
            load_subcategorias(categories_id);
        }

    });*/
    $("#cmb_marcas").select2({
        theme: "bootstrap4",
        placeholder: "Seleccione marcas"
    }).on('change', function (e) {
        var marca_id = $(this).val();
        $("#cmb_categoria").html('');
        load_categorias(marca_id);
    });

    $("#tipo").select2({
        theme: "bootstrap4",
        placeholder: "Seleccionar",
    }).on('change', function (e) {
        //var categories_id = $(this).val();
        const type = $(this).val();

        if(type=='local'){
            $(".galery-img").show();
            $("#youtube-url").hide();
        }else{

            $("#youtube-url").show();
            $(".galery-img").hide();
        }

    });

    var form = $("#form-product");

    form.validate({

        /* @validation states + elements
        ------------------------------------------- */
        ignore: [],
        errorClass: "state-error",
        validClass: "state-success",
        errorElement: "em",

        /*  rules
        ------------------------------------------ */
        rules: {
            title_large: { required: true },
            link_video: { required: true },
            price_online: { required: true },
            price_normal: { required: true },
            marca_id: { required: true },
            description: { required: true },
        },

        /* @validation error messages
        ---------------------------------------------- */
        messages: {
            archivo: {
                extension: "Por favor, selecciona un formato de archivo validado (jpg|png|pdf)"
            }

        },

        /* @validation highlighting + error placement
        ---------------------------------------------------- */
        highlight: function (element, errorClass, validClass) {
            $(element).closest('.field').addClass(errorClass).removeClass(validClass);
            $(element).parent().find('.select2 > .selection > .select2-selection').addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.field').removeClass(errorClass).addClass(validClass);
            $(element).parent().find('.select2 > .selection > .select2-selection').removeClass(errorClass).addClass(validClass);
        },
        errorPlacement: function (error, element) {
            if (element.is(":radio") || element.is(":checkbox")) {
                element.closest('.option-group').after(error);
            } else {
                error.insertAfter(element.parent());
                error.insertAfter(element.closest(".field"));
            }
        }
    });

    form.on('submit', function (e) {
        e.preventDefault();
        var fields = new FormData(this);
        if (!form.valid()) {
            $("#btn-submit-product").removeAttr("disabled");
            return false;
        }
        if (jQuery.trim(jQuery("#id_ajax").val()) == "") {
            $("#btn-submit-product").attr("disabled", true);
            jQuery("#id_ajax").val('1');
            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                data: fields,
                dataType: 'json',
                contentType: false,
                processData: false,
                beforeSend: function () {
                    showLoading('procesando...');
                },
                success: function (data) {
                    window.location.replace(data.route);
                    $("#btn-submit-product").removeAttr("disabled");
                    jQuery("#id_ajax").val("");
                },
                error: function () {
                    $("#btn-submit-product").removeAttr("disabled");
                    jQuery("#id_ajax").val("");
                }
            });
        }
    });

    if($("#table-content-gallery").html()){
        loadGallery();
    }

    jQuery('#btn-add-url-youtube').on('click', function(){

        var youtube_url = jQuery('#youtube_url').val();

        //AlertMessage.removeCurrentAlerts();

        jQuery('#tpl_url_youtube').find('.state-error').removeClass('state-error');

        if(youtube_url == ''){
            jQuery('#youtube_url').addClass("state-error");
            return;
        }

        $('#youtube_url').val("");

        add_row_componentes(youtube_url);
    });

});


/*var load_subcategorias = function (ids) {
    $.ajax({
        url: url_list_subcategories,
        data: { parent_ids: ids },
        method: 'get',
        beforeSend: function () {
            $("#cmb_subcategoria").html('<option>Cargando datos...</option>');
        },
        success: function (data) {
            $("#cmb_subcategoria").html(data);
        }
    });
}*/
var load_categorias = function (marca_id) {
    $.ajax({
        url: url_list_categorias,
        data: { marca_id: marca_id },
        method: 'get',
        beforeSend: function () {
            $("#cmb_categoria").html('<option>Cargando datos...</option>');
        },
        success: function (data) {
            $("#cmb_categoria").html(data);
        }
    });
}

var imagesPreview = function (input, previewImage) {

    if (input.files) {
        var filesAmount = input.files.length;
        if (filesAmount > 2) {
            alert("The max number of files is 2");
            return false;
        }
        $(".gallery").html('');
        for (i = 0; i < filesAmount; i++) {
            var reader = new FileReader();
            var pos = 1;
            reader.onload = function (event) {
                var img = '<div class="col-sm-2" >'
                img += '<div class="font-icon-wrapper float-left mr-3 mb-3 image-preview">'
                img += '<img src="' + event.target.result + '" class="rounded-circle img-custom" width="100"/>';
                img += '</div>';
                img += '</div>';
                $(".gallery").append(img);

                pos++;
            }

            reader.readAsDataURL(input.files[i]);
        }
    }

};

function onSelect(e) {
    var fileInfos = e.files;
    var wrapper = this.wrapper;

    fileInfos.forEach(function (fileInfo) {
        setTimeout(function () {
            addPreview(fileInfo, wrapper);
        });
    });
}

function addPreview(file, wrapper) {
    var raw = file.rawFile;
    var reader = new FileReader();

    if (raw) {
        reader.onloadend = function () {
            var preview = $("<img class='image-preview' style='position: relative;vertical-align: top;height: 70px;width:70px'>").attr("src", this.result);
            wrapper.find(".k-file[data-uid='" + file.uid + "'] .k-i-jpg")
                .replaceWith(preview);
            wrapper.find(".k-upload-selected").replaceWith($(""))
        };
        reader.readAsDataURL(raw);
    }
}

function loadGallery(){
    var url = url_gallery_load;
    $.get(url, function(data) {
        $('#table-content-gallery').html(data);
        $("#load-gallery-video").sortable({
            distance: 5,
            delay: 100,
            opacity: 0.6,
            cursor: 'move',
            update: function(e, ui) {
                var page_id_array = new Array();
                $('#load-gallery-video tr').each(function() {
                    page_id_array.push($(this).attr('id'));
                });
                update_oder(page_id_array);
            }
        });
    });
}

var update_oder = function(page_id_array) {
    $.ajax({
        url: update_order_banner,
        method: "POST",
        data: { page_id_array: page_id_array },
        success: function() {
            loadGallery();
        }
    })
}

function eliminarImageGallery ($id, $url, $token){
    swal({
        title: "Eliminar Imagen",
        text: "Estas seguro de eliminar esta imagen",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: $url,
                method: 'post',
                data: {
                    id: $id,
                    _token: $token
                },
                beforeSend: function() {
                    showLoading('Eliminando imagen...');
                },
                success: function(dataJson) {
                    if (dataJson.rpt === 1) {
                        swal("Imagen eliminada correctamente", {
                                icon: "success",
                            })
                            .then((result) => {
                                if (result) {
                                    loadGallery();
                                }
                            });
                    }
                }
            });
        }
    });
}




var add_row_componentes = function(componente_text){

    $("#tbl-url-youtube").show();
    $('#initial_row_url_youtube').hide();

    _tmp= jQuery("#tpl_url_youtube").html();
    _tmp = _tmp.replace("<!--", "");
    _tmp = _tmp.replace("-->", "");
    _tmp = _tmp.replace("%txt_url_youtube%", componente_text);
    _tmp = _tmp.replace("%url_youtube_value%", componente_text);

    jQuery("#body-table-url-youtube-selected").append(_tmp);

    reset_table_componentes();
}

var reset_table_componentes = function(){

    var count = 0;

    jQuery("#body-table-url-youtube-selected tr.row_url_youtube").each(function(index) {

        jQuery('.idx_url_youtube', this).html(index+1);
        count = index+1;

    });
    if(count < 1){
        $("#tbl-url-youtube").hide();
        $('#initial_row_url_youtube').show();
    }
}

$(document).on('click', '.delete-row-url-youtube', function(e){

    e.preventDefault();

    jQuery(this).closest('tr').remove();
    reset_table_componentes();
});
