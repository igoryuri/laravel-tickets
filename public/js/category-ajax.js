$('#department_id').on('change', function (e) {
    console.log(e);

    var department_id = e.target.value;

    //ajax
    $.get('/bioclin/ajax-category?department_id=' + department_id, function (data) {
        //success data
        $('#category_id').empty();
        $.each(data, function (index, categoryObj) {
            return $('#category_id').append('<option value="' + categoryObj.id + '">' + categoryObj.name + '</option>');
        })
    })
});