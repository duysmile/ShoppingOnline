$(document).ready(function () {
    $("input:checkbox[data-type|='child']").change(function () {
        if ($(this).is(':checked')) {
            var id_parent = $(this).attr('data-parent');
            $("input:checkbox[data-id|= " + id_parent + "]").prop('checked', true);;
        }
    });
    $("input:checkbox[data-type|='parent']").change(function () {
        if (!$(this).is(':checked')) {
            var id_parent = $(this).attr('data-id');
            $("input:checkbox[data-parent|= " + id_parent + "]").prop('checked', false);;
        }
    });
});
