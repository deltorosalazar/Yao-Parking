$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
});

$('#store-button').on('click', function() {
    $.ajax({
        type: 'POST',
        url: '/parkings/store',
        data: {

        },
        success: function(data) {
            console.log(data);
                $('#parkings-table tbody').append(`
                    <tr id=parking-` + data.id + `>
                        <td>
                            <a
                                data-toggle="popover"
                                title="<b>Detalles</b>"
                                data-html="true"
                                data-content="
                                    <b>Fecha de Creación: </b>` + data.created_at + `<br>
                                    <b>Última Modificación: </b>` + data.updated_at + `"
                                style="cursor: pointer">` + data.id + `
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



        }
    });
});


$('.state-button').on('click', function() {
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
