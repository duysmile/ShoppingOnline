$(document).ready(function() {
    $(document).on('click', '.btn-del[data-id]', function (e) {
        var id = $(this).attr('data-id');
        var dialog = $(this).attr('data-target');
        $(dialog).find('input[name="del-id"]').attr('value', id);
    })
})
