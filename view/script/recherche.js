$(document).ready(function () {
$(".recherche_").after("<div id=resultat></div>");
    $("input[name*='recherche']").keyup(function () {

        let val = $(this).val();
        if (val === "@" || val === "#" || val === "") {
            $("#resultat").empty();
            return false;
        }
        
        $("#resultat").load("../../controller/recherche.php", { key: val }, function (data) {
            console.log(data);
        });
    });
});