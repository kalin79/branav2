jQuery(function() {
    load();
    /*var data_fields =   [
      {"id": 1, "text": "nombres", type:'text', filter : 'byNombres'},
      {"id": 2, "text": "nro. documento", type:'text', field : 'document'},
      {"id": 3, "text": "email", type:'text', field : 'email'},
      {"id": 4, "text": "celular", type:'text', field : 'phone'}
    ];

    $("#cmb-field").select2({
        "data": data_fields,
    });

    CI.filter({
        controls: {field:'#cmb-field', operator:'#cmb-operator', value:'#text-value'},
        data: data_fields,
        default_filter: 'byField',
        elemnt_action: '#btn-add-filter',
        text_value: '#text-value',
        content_filters: '#content-filters',
        load: function() {
          load();
        }
    });*/

    var customize_rules = {

        /* @validation states + elements
        ------------------------------------------- */
        ignore: [],
        errorClass: "state-error",
        validClass: "state-success",
        errorElement: "em",

        /*  rules
        ------------------------------------------ */
        rules: {
            //title: { required: true },
            //description: {required: true},
        },

        /* @validation error messages
        ---------------------------------------------- */
        messages: {},

        /* @validation highlighting + error placement
        ---------------------------------------------------- */
        highlight: function(element, errorClass, validClass) {
            $(element).closest('.field').addClass(errorClass).removeClass(validClass);
            $(element).parent().find('.select2 > .selection > .select2-selection').addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).closest('.field').removeClass(errorClass).addClass(validClass);
            $(element).parent().find('.select2 > .selection > .select2-selection').removeClass(errorClass).addClass(validClass);
        },
        errorPlacement: function(error, element) {
            if (element.is(":radio") || element.is(":checkbox")) {
                element.closest('.option-group').after(error);
            } else {
                error.insertAfter(element.parent());
                error.insertAfter(element.closest(".field"));
            }
        }
    };

    var rules = $.extend(true, {}, customize_rules);
    rules.rules = {
        title: { required: true },
        tipo_archivo_id: { required: true }
    }

    ModalCRUD.create({
        title: 'Banners',
        element: '.entity-create',
        mode: 'lg',
        form_element: '#form-banners-create',
        element_is_load: true,
        isLoadFromAjax: false,
        rules: rules,
        url: function(elemt) {
            return $(elemt).attr('href');
        },
        initialized: function() {
            load_functions();
        },
        afterSuccess: function() {
            load();
        }
    });
    ModalCRUD.edit({
        title: 'Banners',
        element: '.edit-entity',
        mode: 'lg',
        element_is_load: true,
        form_element: '#form-banners-edit',
        isLoadFromAjax: true,
        rules: rules,
        url: function(element) {
            return $(element).attr("href");
        },
        initialized: function() {
            load_functions();
        },
        afterSuccess: function() {
            load();
        }
    });


    $(document).on('click', '.pagination li a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        load(url);
    })
});



function eliminar($id, $url, $token) {
    swal({
        title: "Eliminar Registro",
        text: "Estas seguro de eliminar este registro",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                $.ajax({
                    url: $url, // "{{ url('/dashboard/role/delete') }}",
                    method: 'post',
                    data: {
                        id: $id,
                        _token: $token
                    },
                    beforeSend: function() {
                        showLoading('Eliminando registro...');
                    },
                    success: function(dataJson) {
                        if (dataJson.rpt === 1) {
                            swal("Registro eliminado correctamente", {
                                icon: "success",
                            })
                                .then((result) => {
                                    if (result) {
                                        load();
                                    }
                                });
                        }

                    }
                });


            }
        });
}

function activar($id, $url, $token) {
    swal({
        title: "Activar Registro",
        text: "Estas seguro de activar?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                $.ajax({
                    url: $url, // "{{ url('/dashboard/role/active') }}",
                    method: 'post',
                    data: {
                        id: $id,
                        _token: $token
                    },
                    beforeSend: function() {
                        showLoading('Activando registro...');
                    },
                    success: function(dataJson) {
                        if (dataJson.rpt === 1) {
                            load();
                            swal("Activado correctamente", {
                                icon: "success",
                            })
                                .then((result) => {
                                    if (result) {

                                    }
                                });
                        }

                    }
                });


            }
        });
}

function desactivar($id, $url, $token) {
    swal({
        title: "Desactivar Registro",
        text: "Estas seguro de desactivar",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                $.ajax({
                    url: $url, //"{{ url('/dashboard/role/desactive') }}",
                    method: 'post',
                    data: {
                        id: $id,
                        _token: $token
                    },
                    beforeSend: function() {
                        showLoading('Desactivando registro...');
                    },
                    success: function(dataJson) {
                        if (dataJson.rpt === 1) {
                            load();
                            swal("Desactivado correctamente", {
                                icon: "success",
                            })
                                .then((result) => {
                                    if (result) {

                                    }
                                });
                        }

                    }
                });


            }
        });
}

function load(url = null) {
    var filters = get_filters();
    var url = url ? url : url_banner_load;

    $.get(url, filters, function(data) {
        $("#loading").remove();
        $('#table-content').html(data);
        init_functions();
    });
}

var init_functions = function() {
    /*var fixHelperModified = function(e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function(index) {
                $(this).width($originals.eq(index).width())
            });
            return $helper;
        },
        updateIndex = function(e, ui) {
            $('td.position', ui.item.parent()).each(function(i) {
                console.log(i);
                $(this).html(i + 1);
            });
        };

    $("#tbl-slider tbody").sortable({
        helper: fixHelperModified,
        stop: updateIndex
    }).disableSelection();*/

    $("tbody").sortable({
        distance: 5,
        delay: 100,
        opacity: 0.6,
        cursor: 'move',
        update: function(e, ui) {
            var page_id_array = new Array();
            $('tbody tr').each(function() {
                page_id_array.push($(this).attr('id'));
            });
            update_oder(page_id_array);
            console.log(page_id_array);
        }
    });
}

var load_functions = function() {
    $('#avatar').on('change', function() {
        const file = this.files[0];
        $("#file-desktop").text(file['name']);
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                $('#img-upload').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    $('#image_mobile').on('change', function() {
        const file = this.files[0];
        $("#file-mobile").text(file['name']);
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                $('#img-upload-mobile').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
    $("#cmb_videos").select2({
        theme: "bootstrap4",
        placeholder: "Seleccione marcas",

    }).on('change', function (e) {
        // Obtener el option seleccionado
        var selectedOption = $(this).find('option:selected');

        // Leer el atributo data-tipo del option seleccionado
        var tipo_id = selectedOption.data('tipo');
        $("#tipo_video_id").val(tipo_id);

    });

    $("#cmb_marcas").select2({
        theme: "bootstrap4",
        placeholder: "Seleccione marcas",

    })/*.on('change', function (e) {
        var marca_id = $(this).val();
        $("#cmb_videos").html('');
        load_videos(marca_id);
    });*/

    $("#tipo").select2({
        theme: "bootstrap4",
        placeholder: "Seleccionar",
    }).on('change', function (e) {
        //var categories_id = $(this).val();
        const type = $(this).val();

        if(type=='4'){
            $(".galery-img").show();
            $("#youtube-url").hide();
        }else{
            $("#cmb_videos").html('');
            var marca_id = $("#cmb_marcas").val();
            load_videos(marca_id);
            $("#youtube-url").show();
            $(".galery-img").hide();
        }

    });
}
var load_videos = function (marca_id) {
    $.ajax({
        url: url_list_videos,
        data: { marca_id: marca_id },
        method: 'get',
        beforeSend: function () {
            $("#cmb_videos").html('<option>Cargando datos...</option>');
        },
        success: function (data) {
            $("#cmb_videos").html(data);
        }
    });
}
var update_oder = function(page_id_array) {
    $.ajax({
        url: update_order_banner,
        method: "POST",
        data: { page_id_array: page_id_array },
        success: function() {
            load();
        }
    })
}
