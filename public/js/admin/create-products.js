$(document).ready(function () {
    $("input:checkbox[data-type|='child']").change(function () {
        if ($(this).is(':checked')) {
            var id_parent = $(this).attr('data-parent');
            $("input:checkbox[data-id= " + id_parent + "]").prop('checked', true);
        }
    });
    $("input:checkbox[data-type|='parent']").change(function () {
        if (!$(this).is(':checked')) {
            var id_parent = $(this).attr('data-id');
            $("input:checkbox[data-parent= " + id_parent + "]").prop('checked', false);
        }
    });

    function previewImages(input) {
        $('#preview-images').empty();
        if (input.files) {
            $.each(input.files, readURL);
        }

        function readURL(i, file) {
            if (!/\.(jpe?g|png|gif|bmp)$/i.test(file.name)){
                return alert(file.name + "không phải là một hình ảnh!");
            }
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview-images').append($('<img/>', {
                    src: e.target.result,
                    class: 'border p-2 img-upload mx-2 mb-3'
                }));
            };
            reader.readAsDataURL(file);
        }
    }

    $('input[type="file"]').on('change', function () {
        previewImages(this);
    })
});
