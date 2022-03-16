(function($) {
    "use strict";

    $(document).ready(function() {
        $('#bookcategoryID, #booktypeID').on('change', function() {
            var bookcategoryID = $('#bookcategoryID').val();
            var booktypeID = $('#booktypeID').val();
            $.ajax({
                type: "POST",
                url: THEME_BASE_URL + 'bookbarcodereport/get_book',
                data: { 'booktypeID': booktypeID, 'bookcategoryID': bookcategoryID },
                dataType: 'html',
                success: function(data) {
                    $("#bookID").empty();
                    $('#bookID').html(data).data('fastselect').destroy();
                    $('#bookID').fastselect();
                }
            });
        });

        $('#bookcategoryID, #bookID, #booktypeID').on('change', function() {
            $('.divhide').hide();
        });
    });

})(jQuery);