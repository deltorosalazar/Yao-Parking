$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
});

$('.edit-modal').on('click', function() {
    $('#price-name-modal').val($(this).data('name'));
    $('#price-id-modal').val($(this).data('id'));
});

$('#store-button').on('click', function() {
    $.ajax({
        type: 'POST',
        url: '/prices/store',
        data: {
            'name': $('input[name=price-name]').val()
        },
        success: function(data) {
            if ((data.errors)){
                // $('.error').removeClass('hidden');
                // $('.error').text(data.errors.name);
            } else {
                $('#prices-table tbody').append(`
                    <tr id=price-` + data.id + `>
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
                        </td>
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
                                data-target="#prices-modal"
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

                $('#price-name').val('');
            }
        }
    });
});

$('#update-button').on('click', function() {
    $.ajax({
        type: 'POST',
        url: '/prices/update',
        data: {
            'id': $('input[name=price-id-modal]').val(),
            'name': $('input[name=price-name-modal]').val()
        },
        success: function(data) {
            if ((data.errors)){
                // $('.error').removeClass('hidden');
                // $('.error').text(data.errors.name);
            } else {
                $('#price-' + data.id).replaceWith(`
                    <tr id=price-` + data.id + `>
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
                        </td>
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
                                data-target="#prices-modal"
                                data-id="` + data.id + `"
                                data-name="` + data.name +`"
                                class="pull-right btn btn-primary edit-modal edit-` + data.id + `">
                            Editar
                            </button>
                        </td>
                    </tr>`
                );

                $(document).ajaxComplete(function() {
                    $('#prices-modal').modal('hide');

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
        url: '/prices/changeState',
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
