jQuery(function () {
    //subir_formato();
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

    /*******Linea de tiempo imagenes */

     $('#poster_linea_tiempo').on('change', function () {
        const file = this.files[0];
        $("#file-label-pc-linea-tiempo").text(file['name']);
        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                $('#img-upload-linea-tiempo').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    $('#poster_mobile_linea_tiempo').on('change', function () {
        const file = this.files[0];
        $("#file-label-mobile-linea-tiempo").text(file['name']);
        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                $('#img-upload-mobile-linea-tiempo').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    $('#poster-contenido-mobile').on('change', function () {
        const file = this.files[0];
        $("#file-label-contenido-mobile").text(file['name']);
        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                $('#img-upload-contenido-mobile').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    $('#poster-contenido').on('change', function () {
        const file = this.files[0];
        $("#file-label-contenido").text(file['name']);
        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                $('#img-upload-contenido').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
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

    /*jQuery('#btn-add-presentacion').on('click', function(){

        anio = jQuery('#txt_anio').val();
        //descripcion = jQuery('#txt_descripcion_amigo').val();
        $('#tbl-amigos').find('.state-error').removeClass('state-error');

        var titulo = jQuery('#titulo').val();

        if(jQuery('#initial_row_amigos').is("*")){
            jQuery("#initial_row_amigos").remove();
        }

        var count_rows = $('#body-table-linetime >tr.row_timelines').length;
        count_rows = count_rows + 1;
        _tmp= jQuery("#tpl_timelines").html();
        _tmp = _tmp.replace("<!--", "");
        _tmp = _tmp.replace("-->", "");
        _tmp = _tmp.replace("%ob_row_number%", count_rows);
        _tmp = _tmp.replace("%ob_row_number%", count_rows);
        _tmp = _tmp.replace("%ob_row_number%", count_rows);
        _tmp = _tmp.replace("%ob_row_number%", count_rows);
        _tmp = _tmp.replace("%ob_row_number%", count_rows);
        _tmp = _tmp.replace("%ob_row_number%", count_rows);
        _tmp = _tmp.replace("%ob_titulo%", titulo);
        _tmp = _tmp.replace("%ob_anio%", anio);
        jQuery("#body-table-linetime").append(_tmp);
        reset_table_presentaciones()
        var element = $('#body-table-linetime >tr.row_timelines ').find('#file_formato_'+count_rows);
        //subir_formato(element);

    });
    jQuery(document).on("click",".delete-line-presentancion",function(e){
        e.preventDefault();
        jQuery(this).closest('tr').remove();
        reset_table_presentaciones()
    });*/


     jQuery('#btn-add-detalle').on('click', function(){


        var titulo = jQuery('#titulo_iten_estrategia').val();
        if(titulo==''){
            return false;
        }

        if(jQuery('#initial_row_detalle_estrategia').is("*")){
            jQuery("#initial_row_detalle_estrategia").remove();
        }

        var count_rows = $('#body-table-detalle-estrategia >tr.row_detalle_estrategia').length;
        count_rows = count_rows + 1;
        _tmp= jQuery("#tpl_detalle_estrategia").html();
        _tmp = _tmp.replace("<!--", "");
        _tmp = _tmp.replace("-->", "");
        _tmp = _tmp.replace(/%ob_row_number%/g, count_rows);
        _tmp = _tmp.replace(/%ob_titulo_icono%/g, titulo);
        jQuery("#body-table-detalle-estrategia").append(_tmp);
        reset_table_detalle_estrategias()
         // Inicializar kendoUpload en el nuevo input
        let newRow = $('#body-table-detalle-estrategia tr.row_detalle_estrategia').last();
        let element = newRow.find('input[type="file"]');
       // subir_formato(element);

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


    });
    jQuery(document).on("click",".delete-line-detalle-estrategia",function(e){
        e.preventDefault();
        jQuery(this).closest('tr').remove();
        reset_table_detalle_estrategias()
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
            //description_small: { required: true },
            price_online: { required: true },
            price_normal: { required: true },
            marca_id: { required: true },
            //description: { required: true },
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



});


var reset_table_presentaciones = function(){

    var count = 0;

    jQuery("#body-table-linetime tr.row_timelines").each(function(index) {
        newIndex = index+1;
        jQuery('.ob_row', this).html(newIndex);

        // Actualizar el atributo 'name' de los inputs dentro de la fila
        jQuery('textarea[name^="txt_timelines_titulo[]', this).attr("name", "txt_timelines_titulo[" + newIndex + "][]");
        jQuery('input[name^="txt_timelines_anio[]', this).attr("name", "txt_timelines_anio[" + newIndex + "][]");
        jQuery('input[name^="txt_timelines_fecha[]', this).attr("name", "txt_timelines_fecha[" + newIndex + "][]");
        jQuery('text[name^="txt_timelines_descripcion[]', this).attr("name", "txt_timelines_descripcion[" + newIndex + "][]");
        jQuery('input[name^="file_presentacion[]', this).attr("name", "file_presentacion[" + newIndex + "][]");
        jQuery('input[type="file"]', this).attr("id", "file_formato_" + newIndex);
    });

}


var reset_table_detalle_estrategias = function() {
    jQuery("#body-table-detalle-estrategia tr.row_detalle_estrategia").each(function(index) {
        var newIndex = index;

        console.log(newIndex)
        // Actualizar número de fila visible
        jQuery('.ob_row', this).html(newIndex + 1);

        // Actualizar atributos name e id para cada input
        jQuery('input, textarea, select', this).each(function() {
            let name = jQuery(this).attr('name');
            if (name) {
                let updatedName = name.replace(/\[items\]\[\d+\]/, `[items][${newIndex}]`);
                jQuery(this).attr('name', updatedName);
            }

            // También actualizamos los IDs si es necesario
            let id = jQuery(this).attr('id');
            if (id && id.includes('file_formato_')) {
                jQuery(this).attr('id', 'file_formato_' + newIndex);
            }
        });
    });
}







var subir_formato = function(element){
    var element = element || $("body .file_formato");

   element.kendoUpload({
    async: {
        saveUrl: "",         // ❗️Evita que suba por AJAX
        autoUpload: false
    },
    multiple: false,
    showUpload: false,
    showRemove: false,
    showCaption: false,
    validation: {
        allowedExtensions: [".jpg", ".png"],
        maxFileSize: 2097152
    },
    success: function () {
        // No hacer nada
    }
});
};

