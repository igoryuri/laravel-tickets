$(document).ready(function () {
    var department_id = $('#department_id').val();
    var category_id = $('#category_id').val();
    //ajax
    $.get('/bioclin/ajax-category?department_id=' + department_id, function (data) {
        //success data
        $('#category_id').empty();
        for (i = 0; i < data.length; i++) {
            if (category_id == data[i].id) {
                $('#category_id').append('<option value="' + data[i].id + '" selected>' + data[i].name + '</option>');
            } else {
                $('#category_id').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
        }
    })
});