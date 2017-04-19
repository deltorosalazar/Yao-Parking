$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
});

$('.edit-modal').on('click', function() {
    $('#role-name-modal').val($(this).data('name'));
    $('#role-id-modal').val($(this).data('id'));    
});

$('#store-button').on('click', function() {
    $.ajax({
        type: 'POST',
        url: '/roles/store',
        data: {
            'name': $('input[name=role-name]').val()
        },
        success: function(data) {
            if ((data.errors)){
                // $('.error').removeClass('hidden');
                // $('.error').text(data.errors.name);
            } else {
                $('#roles-table tbody').append(`
                    <tr id=role-` + data.id + `>
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
                                data-target="#roles-modal"
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

                $('#role-name').val('');
            }
        }
    });
});

$('#update-button').on('click', function() {
    $.ajax({
        type: 'POST',
        url: '/roles/update',
        data: {
            'id': $('input[name=role-id-modal]').val(),
            'name': $('input[name=role-name-modal]').val()
        },
        success: function(data) {
            if ((data.errors)){
                // $('.error').removeClass('hidden');
                // $('.error').text(data.errors.name);
            } else {
                $('#role-' + data.id).replaceWith(`
                    <tr id=role-` + data.id + `>
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
                                data-target="#roles-modal"
                                data-id="` + data.id + `"
                                data-name="` + data.name +`"
                                class="pull-right btn btn-primary edit-modal edit-` + data.id + `">
                            Editar
                            </button>
                        </td>
                    </tr>`
                );

                $(document).ajaxComplete(function() {
                    $('#roles-modal').modal('hide');

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
        url: '/roles/changeState',
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
