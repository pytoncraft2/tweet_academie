$(document).ready(function () {

    let token = localStorage.getItem("token");
    if (!token) document.location.href = "../html/inscription.html";

    $(".modal_edit_parametres").hide();
    $(".modal_desactivation").hide();

    /* DECONNEXION */
    $("#btn_deco").click(function () {

        if ("token" in localStorage) {
            localStorage.clear();
            window.location.href = "../html/inscription.html";
        }

    });

    /* MODIFICATION */
    $("#btn_modif").click(function () {
        $(".modal_edit_parametres").show();

        if ("token" in localStorage) {

            $.ajax({
                url: "../../controller/get_parametres_user.php",
                type: "post",
                data: "token=" + token,
                dataType: "text",
                success: function (data) {
                    let data_ = JSON.parse(data);
                    console.log(data_);
                    $("#arobase").val(data_[2]);
                    $("#email").val(data_[4]);
                }
            });
        };
    });
    
    $("#btn_confirm").click(function () {
        function check_form() {
            $('#edit_parametres .alert-danger').remove();
            let valid = true,
                email_pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            $('#edit_parametres :input').each(function () {
                let $this = $(this),
                    input_name = $this.attr("name");

                if ($this.val() === 0) {
                    valid = false;
                    $this.parent().append(
                        "<div class='alert alert-danger' role='alert'>Merci de remplir le champ <strong>" +
                            input_name +
                            '</strong></div>'
                    );
                }

                if (input_name === "email" && $this.val() !== "") {
                    if (!email_pattern.test($this.val())) {
                        $this.parent().append(
							"<div class='alert alert-danger' role='alert'>Merci de remplir le champ <strong>" +
								input_name +
								'</strong></div>'
						);
                        valid = false;
                    }
                }
            });

            if (!valid) {
                return false;
            }
        }

        function get_data() {
            let data_array = $('#edit_parametres').serializeArray(),
                len = data_array.length,
                form_data = {};

            for (let i = 0; i < len; i++) {
                form_data[data_array[i].name] = data_array[i].value;
            }
            return form_data;
        }

        if (check_form() === false) return;

        let form_data = get_data();
        form_data['token'] = token;
        console.log(form_data);

        $.post(
            "../../controller/edit_parametres_user.php/", {
                form_data: form_data
            },
            
            function (result) {
                console.log(result)
                if (result === 'check_modif')
                {   
                    $('#edit_parametres .alert-danger').remove();
                    $('#edit_parametres').append( 
                        "<div class='alert alert-success' role='alert'>Modification <strong>réussie</strong></div>"
                    );
                }
            },
            'text'
        );


    });

    /* DESACTIVATION */
    $("#btn_desactive").click(function () {
        $(".modal_desactivation").show();
        
        $("#btn_confirm_desactive").click(function () {
        if ("token" in localStorage) {

            let token = localStorage.getItem("token");

            let req = $.ajax({
                url: "../../controller/desactive_user.php",
                type: "post",
                data: {
                    token
                },

            });

            req.done((data) => {
                console.log(data);

                if (data !== false) {
                    localStorage.clear();
                    window.location.href = "../html/inscription.html";
                }
            });

        }

    });
    });


});