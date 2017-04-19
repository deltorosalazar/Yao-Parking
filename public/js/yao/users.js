$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
});

$('.create-modal').on('click', function() {
    $('#users-modal .modal-title').text('Agregar Usuario');
    $('#modal-action-button').text('Agregar');
    $('#modal-action-button').addClass('store-button');
    $('#modal-action-button').removeClass('update-button');
});

$('.edit-modal').on('click', function() {
    $('#users-modal  .modal-title').text('Editar Usuario');
    $('#modal-action-button').text('Editar');
    $('#modal-action-button').addClass('update-button');
    $('#modal-action-button').removeClass('store-button');

    $('input[name=user-id]').val($(this).data('id')),
    $('input[name=user-name]').val($(this).data('name')),
    $('select[name=user-role]').val($(this).data('role')),
    $('input[name=user-phone]').val($(this).data('phone')),
    $('input[name=user-email]').val($(this).data('email')),
    $('input[name=user-password]').val($(this).data('password')),
    $('input[name=user-password-c]').val($(this).data('password'))

});

$('.modal-footer').on('click', '.store-button', function() {
    $.ajax({
        type: 'POST',
        url: '/users/store',
        data: {
            'name': $('input[name=user-name]').val(),
            'role_id': $('select[name=user-role]').val(),
            'phone': $('input[name=user-phone]').val(),
            'email': $('input[name=user-email]').val(),
            'password': $('input[name=user-password]').val()
        },
        success: function(data) {
            if ((data.errors)){
                // $('.error').removeClass('hidden');
                // $('.error').text(data.errors.name);
            } else {
                $('#users-table tbody').append(`
                    <tr>
                        <td>` + data.name + `</td>
                        <td>` + data.role_name + `</td>
                        <td>` + data.phone + `</td>
                        <td>` + data.email + `</td>
                        <td>
                            <button type="button" class="pull-right btn btn-danger">Eliminar</button>
                            <button
                                type="button"
                                class="pull-right btn btn-primary edit-modal"
                                data-toggle="modal"
                                data-target="#users-modal"
                                data-id="` + data.id + `"
                                data-name="` + data.name + `"
                                data-role="` + data.role_id + `"
                                data-phone="` + data.phone + `"
                                data-email="` + data.email + `"
                                data-password="` + data.password + `"
                                >Editar
                            </button>
                        </td>
                    </tr>`
                );

                // $(document).ajaxComplete(function() {
                //
                // });

                $('#user-name').val('');
                $('#user-role').val('');
                $('#user-phone').val('');
                $('#user-email').val('');
                $('#user-password').val('');
                $('#user-password-c').val('');

                $('#users-modal').modal('hide');
            }
        }
    });
});

$('.modal-footer').on('click', '.update-button', function() {
    $.ajax({
        type: 'POST',
        url: '/users/update',
        data: {
            'id': $('input[name=user-id]').val(),
            'name': $('input[name=user-name]').val(),
            'role_id': $('select[name=user-role]').val(),
            'phone': $('input[name=user-phone]').val(),
            'email': $('input[name=user-email]').val(),
            'password': $('input[name=user-password]').val()
        },
        success: function(data) {
            if ((data.errors)){
                // $('.error').removeClass('hidden');
                // $('.error').text(data.errors.name);
            } else {
                $('#user-' + data.id).replaceWith(`
                    <tr>
                        <td>` + data.name + `</td>
                        <td>` + data.role_name + `</td>
                        <td>` + data.phone + `</td>
                        <td>` + data.email + `</td>
                        <td>
                            <button type="button" class="pull-right btn btn-danger">Eliminar</button>
                            <button
                                type="button"
                                class="pull-right btn btn-primary edit-modal"
                                data-toggle="modal"
                                data-target="#users-modal"
                                data-id="` + data.id + `"
                                data-name="` + data.name + `"
                                data-role="` + data.role_id + `"
                                data-phone="` + data.phone + `"
                                data-email="` + data.email + `"
                                data-password="` + data.password + `"
                                >Editar
                            </button>
                        </td>
                    </tr>`
                );

                // $(document).ajaxComplete(function() {
                //
                // });

                $('#user-name').val('');
                $('#user-role').val('');
                $('#user-phone').val('');
                $('#user-email').val('');
                $('#user-password').val('');
                $('#user-password-c').val('');

                $('#users-modal').modal('hide');
            }
        }
    });
});

$('.state-button').on('click', function() {
    $.ajax({
        type: 'POST',
        url: '/users/changeState',
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
                    //,nvar dis = '.edit-' + data.id;
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
