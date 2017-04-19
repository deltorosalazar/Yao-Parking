$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
});

$('.edit-modal').on('click', function() {
    $('#vehicle-type-name-modal').val($(this).data('name'));
    $('#vehicle-type-id-modal').val($(this).data('id'));

    var vehicle_type_id = $(this).data('id');

    $("#vehicle-types-table .vehicle-type-" + vehicle_type_id).each(function() {

        var d = $(this).data('price-id');

        $('#vehicle-type-prices-modal-' + d).val($(this).html().substr($(this).html().indexOf('$')+1).trim());
    });
});

$('#store-button').on('click', function() {

    var map = {};
    $("#vehicle-type-prices input").each(function() {
        map[$(this).attr("name")] = $(this).val();
    });

    $.ajax({
        type: 'POST',
        url: '/vehicle_types/store',
        data: {
            'name': $('input[name=vehicle-type-name]').val(),
            'prices': map
        },
        success: function(data) {
            if ((data.errors)){
                // $('.error').removeClass('hidden');
                // $('.error').text(data.errors.name);
            } else {

                console.log(data);

                var vehicle_prices = "";

                for (var price_id in map) {
                    vehicle_prices = vehicle_prices + `
                        <td
                            class="vehicle-type-` + data.id + `"
                            data-price-id="` + price_id + `">
                            $ ` + map[price_id] + `
                        </td>
                    `;
                }

                $('#vehicle-types-table tbody').append(`
                    <tr id=vehicle-type-` + data.id + `>
                        <td>
                            <a
                                data-toggle="popover"
                                title="<b>Detalles</b>"
                                data-html="true"
                                data-content="
                                    <b>ID:</b>` + data.id + `<br>
                                    <b>Fecha de Creación: </b>` + data.created_at + `<br>
                                    <b>Última Modificación: </b>` + data.updated_at + `"
                                style="cursor: pointer">` + data.name + `
                            </a>
                        </td> ` +
                        vehicle_prices +
                        `
                        <td>
                            <button
                                type="button"
                                data-id="` + data.id + `"
                                class="pull-right state-button change-state-`+ data.id + ` btn btn-danger">
                            Desactivar
                            </button>
                            <button
                                type="button"
                                data-toggle="modal"
                                data-target="#vehicle-type-modal"
                                data-id="` + data.id + `"
                                data-name="` + data.name +`"
                                class="pull-right btn btn-primary edit-modal edit-` + data.id + `">
                            Editar
                            </button>
                        </td>
                    </tr>`
                );

                $(document).ajaxComplete(function() {
                    $('[data-toggle="popover"]').popover({
                        placement: 'bottom'
                    });
                });

                $(".panel-body input").each(function() {
                    $(this).val('');
                });

            }
        }
    });
});

$('#update-button').on('click', function() {

    var map = {};
    $("#vehicle-type-prices-modal input").each(function() {
        map[$(this).attr("name")] = $(this).val();
    });

    $.ajax({
        type: 'POST',
        url: '/vehicle_types/update',
        data: {
            'id': $('input[name=vehicle-type-id-modal]').val(),
            'name': $('input[name=vehicle-type-name-modal]').val(),
            'prices': map
        },
        success: function(data) {
            if ((data.errors)){
                // $('.error').removeClass('hidden');
                // $('.error').text(data.errors.name);
            } else {

                var vehicle_prices = "";

                for (var price_id in map) {
                    vehicle_prices = vehicle_prices + `
                        <td
                            class="vehicle-type-` + data.id + `"
                            data-price-id="` + price_id + `">
                            $ ` + map[price_id] + `
                        </td>
                    `;
                }

                $('#vehicle-type-' + data.id).replaceWith(`
                    <tr id=vehicle-type-` + data.id + `>
                        <td>
                            <a
                                data-toggle="popover"
                                title="<b>Detalles</b>"
                                data-html="true"
                                data-content="
                                    <b>ID:</b>` + data.id + `<br>
                                    <b>Fecha de Creación: </b>` + data.created_at + `<br>
                                    <b>Última Modificación: </b>` + data.updated_at + `"
                                style="cursor: pointer">` + data.name + `
                            </a>
                        </td>` +
                        vehicle_prices +
                        `
                        <td>
                            <button
                                type="button"
                                data-id="` + data.id + `"
                                class="pull-right state-button change-state-`+ data.id + ` btn btn-danger">
                            Desactivar
                            </button>
                            <button
                                type="button"
                                data-toggle="modal"
                                data-target="#vehicle-prices-modal"
                                data-id="` + data.id + `"
                                data-name="` + data.name +`"
                                class="pull-right btn btn-primary edit-modal edit-` + data.id + `">
                            Editar
                            </button>
                        </td>
                    </tr>`
                );

                $(document).ajaxComplete(function() {
                    $('#vehicle-types-modal').modal('hide');

                    $('[data-toggle="popover"]').popover({
                        placement: 'bottom'
                    });
                });
            }
        }
    });
})

$('.state-button').on('click', function() {
    console.log('clicked');
    $.ajax({
        type: 'POST',
        url: '/vehicle_types/changeState',
        data: {
            'id': $(this).data('id')
        },
        success: function(data) {
            if ((data.errors)){
                // $('.error').removeClass('hidden');
                // $('.error').text(data.errors.name);
            } else {
                var record = '.change-state-' + data.id;
                if (data.active === 0) {
                    //var dis = '.edit-' + data.id;
                    $(record).removeClass('btn-danger');
                    $(record).addClass('btn-success');
                    $(record).text('Activar');
                    $('.edit-' + data.id).prop('disabled', true);
                } else {
                    $(record).removeClass('btn-success');
                    $(record).addClass('btn-danger');
                    $(record).text('Desactivar');
                    $('.edit-' + data.id).prop('disabled', false);
                }
            }
        }
    });
})
