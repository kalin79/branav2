jQuery(function() {

    $(document).on('focusin', function(e) {
        if ($(e.target).closest(".mce-window").length) {
            e.stopImmediatePropagation();
        }
    });
    load();
    var data_fields = [
        { "id": 1, "text": "marca", type: 'text', field: 'nombre' },
    ];
    $("#cmb-field").select2({
        theme: "bootstrap4",
        "data": data_fields,
        placeholder: "Buscar por "
    });

    CI.filter({
        controls: { field: '#cmb-field', operator: '#cmb-operator', value: '#text-value' },
        data: data_fields,
        default_filter: 'byField',
        elemnt_action: '#btn-add-filter',
        text_value: '#text-value',
        content_filters: '#content-filters',

        load: function() {
            load();
        }
    });



    ModalCRUD.create({
        title: 'Tienda',
        element: '.entity-create',
        form_element: '#form-create-marca',
        element_is_load: true,
        isLoadFromAjax: false,
        rules: rules,
        url: function(elemt) {
            return $(elemt).attr('href');
        },
        initialized: function() {

        },
        afterSuccess: function() {
            tinymce.remove();
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
        title: "Eliminar registro",
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
        title: "Activar registro",
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
                            swal("Activado correctamente", {
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

function desactivar($id, $url, $token) {
    swal({
        title: "Desactivar registro",
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
                            swal("Desactivado correctamente", {
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

function load(url = null) {
    var filters = get_filters();
    var url = url ? url : url_tags_load;

    $.get(url, filters, function(data) {
        $('#table-content').html(data);
        init_functions();
    });
}

var init_functions = function() {
    ModalCRUD.edit({
        title: 'Tienda',
        element: '.edit-entity',
        element_is_load: true,
        form_element: '#form-update-marca',
        isLoadFromAjax: false,
        rules: rules_edit,
        url: function(element) {
            return $(element).attr("href");
        },
        initialized: function() {



        },
        afterSuccess: function() {
            load();
        }
    });
}

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
    name: { required: true },

}
var rules_edit = $.extend(true, {}, customize_rules);
rules_edit.rules = {
    name: { required: true },
    //descripcion: { required: true },
    //logo_principal: { required: true },
    //avatar_detalle: { required: true },
    //image_detalle: { required: true },

}
