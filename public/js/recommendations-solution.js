var id_solution;
function solutionId(id) {
    id_solution = id;
}
function solutionRecommendations() {
    $.get("/bioclin/solutions/"+id_solution , function (data) {
        $('#top-charms').empty().html(data);
    })
}