$(document).ready(function () {
    let from = localStorage.getItem("token");
    if(!from) document.location.href = "../html/inscription.html";
    console.log(localStorage.getItem("token"));
    let tab_id_user = [];

    $("#to").keyup(function () {

        $("#res").load("../../controller/getInputNameMsg.php", { b: $(this).val() }, function (data) {
            console.log(data);
        });


    });

        $('body').on({ 
            click: function () {
                tab_id_user = []
                tab_id_user.push($(this).attr("value"));
                $("#to").val($(this).text());
                $(".nom").remove();

                let time = setInterval(reloads, 500);
                function reloads() {
                    $("#chat").load("../../controller/receiveMessages.php", { from: localStorage.getItem("token"), to: tab_id_user[0] }, function(data) {
                    }); 
               }
            }
        }, '.nom')


    $("#submit").click(function (e) {
        e.preventDefault();
        $.post(
            '../../controller/sendMessages.php',
            {
                from: from,
                contenu: $("#contenu").val(),
                to: tab_id_user[0]
            },

            function () {
                $("textarea").val("");
            },
            'text'
        );
    });

});