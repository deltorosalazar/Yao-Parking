$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
});

$('#monthly_button').on('click', function() {

    $.ajax({
        type: 'POST',
        url: '/simulations/monthly_earnings',
        data: {
            'parking': $('select[name=monthly_parking]').val(),
            'year': $('select[name=monthly_year]').val()
        },
        success: function(data) {
            if ((data.errors)){
                // $('.error').removeClass('hidden');
                // $('.error').text(data.errors.name);
            } else {

                var head = "";
                var rows = "";
                var totalEarnings = 0;
                var parking = data[2];

                $.each(data[1], function(index, value) {
                    head += head + '<th>' + value.name + ' (-' + value.percentage + '%)';
                });

                $.each(data[0], function(indexMonth, valueMonth) {
                    rows += `
                        <tr>
                            <td>` +
                                valueMonth.m + `
                            </td>
                            <td>$ ` +
                                valueMonth.total + `
                            </td>
                            `;
                        $.each(data[1], function(indexTax, valueTax) {
                            rows += `
                                <td> $` +
                                    Math.round(valueMonth.total - (valueMonth.total * (valueTax.percentage / 100))) + `
                                </td>`;
                        });

                        totalEarnings += Number(valueMonth.total);

                    rows += '<tr>'
                });

                $('.monthly_table').append(`
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" id="monthly-table">
                                <b>Parqueadero #` +
                                    parking +
                                ` </b>
                                <thead>
                                    <tr>
                                        <th>Mes</th>
                                        <th>Total Recaudado</th>` +
                                        head +  `
                                    </tr>
                                </thead>
                                <tbody>` + rows + `
                                    <tr class="warning">
                                        <td>
                                            <b>TOTAL<b>
                                        </td>
                                        <td>$ ` + totalEarnings + `
                                        </td>` + String(computeTaxes(data[1], totalEarnings)) + `
                                    </tr>
                                </tbody>

                            <table>
                        <div>
                    <div>`
                );
            }
        }
    });
});

function computeTaxes(taxes, totalEarnings) {
    var t = "";

    $.each(taxes, function(indexTax, valueTax) {
        t += `
            <td> $` +
                Math.round(totalEarnings * (valueTax.percentage / 100)) + `
            </td>`;
    });

    return t;
}
