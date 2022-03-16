(function($) {
    "use strict";

    $(document).ready(function() {
        $('#roleID, #classeID').on('change', function() {
            var roleID = $('#roleID').val();
            var classeID = $('#classeID').val();
            $.ajax({
                type: "POST",
                url: THEME_BASE_URL + 'idcardreport/get_member',
                data: { 'roleID': roleID, 'classeID': classeID },
                dataType: 'html',
                success: function(data) {
                    $("#memberID").empty();
                    $('#memberID').html(data).data('fastselect').destroy();
                    $('#memberID').fastselect();
                }
            });
        });

        $('#roleID, #memberID,#classeID, #type').on('change', function() {
            $('.divhide').hide();
        });
    });

})(jQuery);