$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
});

$('.edit-modal').on('click', function() {
    $('#parking-name-modal').val($(this).data('name'));
    $('#parking-id-modal').val($(this).data('id'));
});

$('#store-button').on('click', function() {
    $.ajax({
        type: 'POST',
        url: '/parkings/store',
        data: {
            'name': $('input[name=parking_name]').val()
        },
        success: function(data) {
            if ((data.errors)){

                if (data.errors.parking_name) {
                    console.log('entre');
                    $('.parking_name_error').removeClass('hidden');
                    $('.parking_name_error .myError').text(data.errors.parking_name);
                    $('#parking_name').addClass('input-errors');
                }

                setTimeout(function(){
                    $('.parking_name_error').fadeOut( "slow" );
                }, 2000);
            } else {
                $('#parking-table tbody').append(`
                    <tr id=parking-` + data.id + `>
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
                                data-target="#parkings-modal"
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

                $('#parking_name').val('');
            }
        }
    });
});

$('#update-button').on('click', function() {
    $.ajax({
        type: 'POST',
        url: '/parkings/update',
        data: {
            'id': $('input[name=parking-id-modal]').val(),
            'name': $('input[name=parking-name-modal]').val()
        },
        success: function(data) {
            if ((data.errors)){
                // $('.error').removeClass('hidden');
                // $('.error').text(data.errors.name);
            } else {
                $('#parking-' + data.id).replaceWith(`
                    <tr id=parking-` + data.id + `>
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
                                data-target="#parkings-modal"
                                data-id="` + data.id + `"
                                data-name="` + data.name +`"
                                class="pull-right btn btn-primary edit-modal edit-` + data.id + `">
                            Editar
                            </button>
                        </td>
                    </tr>`
                );

                $(document).ajaxComplete(function() {
                    $('#parkings-modal').modal('hide');

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
        url: '/parkings/changeState',
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
