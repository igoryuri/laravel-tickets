function editTicket() {
    var id = $('#table').data('table').getSelectedItems();
    url = "http://172.16.101.30:3000/bioclin/tickets/"+id[0][0]+"/edit";
    $(location).attr("href", url);
}

function editButton(check) {
    if (check) {
        $('#edit-button').show();
    } else {
        $('#edit-button').hide();
    }
}