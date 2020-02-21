$('#nom').on('keyup', function (e) {
    // $rechercheSite();
    $('#tbody').empty();
    // $('.loader-bloc').css("display","block");
    // $('.table-responsive-sm').css("display","none");
    currentRequest = $.ajax({
        type: 'POST',
        url: '/gererLieu/recherche',
        data: {"nom": $('#nom').val()},
        beforeSend: function () {
            if (currentRequest != null) {
                currentRequest.abort();
            }
        }
    }).done(function (data) {
        // $('.loader-bloc').css("display","none");
        // $('.table-responsive-sm').css("display","block");
        console.log(data);
        console.log(data['sites']);
        $.each(data['sites'], function (key, val) {
            $('#tbody').append(
                '<tr class="dtl-strip"><td class="td-mgn-lieu"> ' +  val['nomLieu'] + '</td>'
            +
            '<td class="td-mgn-lieu"> ' +  val['rue'] + '</td>' +
            '<td class="td-mgn-lieu"> ' +  val['latitude'] + '</td>' +
            '<td class="td-mgn-lieu"> ' +  val['longitude'] + '</td>' +
            '<td class="td-mgn-lieu"> ' +  'img' + '</td>' + '<tr'
            );


            // <tr >
        //         <td >{{ lieu.nomLieu | capitalize }} </td>
        //     <td class="gone-lieu2">{{ lieu.rue | capitalize }} </td>
        //     <td class="gone-lieu">{{ lieu.latitude | capitalize }} </td>
        //     <td class="gone-lieu">{{ lieu.longitude | capitalize }} </td>
        //     <td class="cncl-btn-lieu"><a href="{{ path ("supprimerLieu",{'id': lieu.id }) }}"><img src="{{ asset('img/cancel.png') }}"></a></td>
        //     </tr>




        })
    });
});