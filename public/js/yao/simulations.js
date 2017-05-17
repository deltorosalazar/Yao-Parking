$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
});

// $('.edit-modal').on('click', function() {
//     $('#role-name-modal').val($(this).data('name'));
//     $('#role-id-modal').val($(this).data('id'));
// });

$('#store-button').on('click', function() {
    $.ajax({
        type: 'POST',
        url: '/simulations/store',
        data: {
            'start_date': $('input[name=start_date]').val(),
            'end_date': $('input[name=end_date]').val()
        },
        success: function(data) {
            if ((data.errors)){
                if (data.errors.start_date) {
                    $('.start_date_error').removeClass('hidden');
                    $('.start_date_error .myError').text(data.errors.start_date);
                    $('#start_date').addClass('input-errors');
                }

                if (data.errors.end_date) {
                    $('.end_date_error').removeClass('hidden');
                    $('.end_date_error .myError').text(data.errors.end_date);
                    $('#end_date').addClass('input-errors');
                }

                setTimeout(function(){
                    $('.start_date_error').fadeOut( "slow" );
                    $('.end_date_error').fadeOut( "slow" );
                }, 2000);

            } else {
                $('.error').remove();
                $('#simulations-table tbody').append(`
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
                        </td>
                    </tr>`
                );

                $(document).ajaxComplete(function() {
                    $('[data-toggle="popover"]').popover({
                        placement: 'bottom'
                    });
                });

                $('#start_date').val('');
                $('#end_date').val('');
            }
        }
    });
});

$('.state-button').on('click', function() {
    console.log('clicked');
    $.ajax({
        type: 'POST',
        url: '/simulations/changeState',
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
