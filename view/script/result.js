$(document).ready(function () {

    let search = $(location).attr('search');
    let urlSearch = decodeURIComponent(search);
    let mySearch = urlSearch.replace("?k=", "");

    $("#result").load("../../controller/recherche.php", { key: mySearch }, function (data) {
        console.log(data);
        if (data === "") {
            $("#result").html("La recherche n'as rien trouvé &#129335;");
        }

        $("#result div:contains('#')").each(function (el) {
            $(this).html($(this).html().replace(/\B(\#[a-zA-Z]+\b)(?!;)/g, '<a href=pageDuPost.html style=color:#03a9f4>$1</a>'));
        });

    })

});
