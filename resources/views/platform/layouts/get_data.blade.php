<script>
    getData()
    // input date js

    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        getData({page : $(this).attr('href').split('page=')[1]})
    });

    $(document).on('click', '.reloadTable', function (e) {
        e.preventDefault();
        getData()
    });


    $('.table_loader').fadeOut('slow');


    function getData(array) {
        $.ajax({
            type: "get",
            url: "{{$index_route}}",
            data: array,
            dataType: "json",
            cache: false ,
            beforeSend: function() {
                $('.table_loader').fadeIn('slow');
            },
            success: function (response) {
                $('.table_content_append').html(response.html)
                $('.table_loader').fadeOut('slow');
            }
        });
    }

    $('.clean-input').on('click' ,function(){
        $(this).siblings('input').val(null);
        $(this).siblings('select').val(null);
        getData()
    });
</script>
