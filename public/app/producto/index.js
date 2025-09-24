jQuery(function() {
    load();
    var data_fields = [
        { "id": 1, "text": "Categoria", type: 'list', field: 'categoria_id', list: function() { return list_categorias() }, 'type_select2': true },
        { "id": 2, "text": "Titulo", type: 'text', field: 'title_large' },

    ];

    function list_categorias() {
        return get_list(url_categorias_lista);
    }
    $("#cmb-field").select2({
        theme: "bootstrap4",
        "data": data_fields,
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
    var url = url ? url : url_products_load;

    $.get(url, filters, function(data) {
        $('#table-content').html(data);
    });
}
