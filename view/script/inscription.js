$(document).ready(function () {

    $("#suivant").click(function (e) {
       
        e.preventDefault();
        
        function get_age(dateString) {
            let today = new Date();
            let birthDate = new Date(dateString);
            let age = today.getFullYear() - birthDate.getFullYear();
            let m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age;
        }

        function check_form() 
        {
            $('.alert.alert-danger').remove();

            let valid = true,
            email_pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
            date = $("#date_de_naissance").val().split("-");
            date = date.join("/");

            if (get_age(date) < 18) {
                valid = false;
                $("#date_de_naissance").parent().append( 
                "<div class='alert alert-danger' role='alert'>Vous devez avoir plus de <strong>18</strong> ans pour vous inscrire !</div>"
                );
            }

            $('#sign_up :input').each(function() 
            {
                let $this = $(this),
                input_name = $this.attr("name");

                if($this.val() ==  0) {
                    valid = false;
                    $this.parent().append( 
                    "<div class='alert alert-danger' role='alert'>Veuillez remplir votre <strong>"+ input_name +"</strong></div>"
                    );
                }
                
                if(input_name == "email" && $this.val() != "")
                {
                    if(!email_pattern.test($this.val()))
                    {
                        $this.parent().append( 
                        "<div class='alert alert-danger' role='alert'>Veuillez entrer votre <strong>"+ input_name +"</strong> au bon format</div>"
                        );
                        valid  = false;
                    }
                }
            });
        
            if(!valid) {
                return false;
            }
        }

        function get_data() 
        {
            let data_array = $('#sign_up').serializeArray(),
            len = data_array.length,
            form_data = {};
        
            for (let i=0; i<len; i++)
            {
                form_data[data_array[i].name] = data_array[i].value;    
            }  
            return form_data;
        }


        if (check_form() === false) return;

        let form_data = get_data();

        let rand = function() {
            return Math.random().toString(36).substr(2);
        };
        
        let token = function() {
            return rand();
        };

        form_data['token'] = token();
        form_data['arobase'] = '@user-' + token();

        $.post(
            "../../controller/inscription.php/", 
            {
                form_data: form_data
            },
        
            function(result)
            { 
                console.log(result)
                if (result === 'exist')
                {   
                    $('.alert.alert-danger').remove();
                    $('#sign_up').after( 
                        "<div class='alert alert-danger' role='alert'><strong>Email</strong> déjà utilisé </div>"
                    );
                    return;
                }

                if (result === 'failed')
                {   
                    $('.alert.alert-danger').remove();
                    $('#sign_up').after( 
                        "<div class='alert alert-danger' role='alert'>Un <strong>problème</strong> est survenu lors de l'inscription ...</div>"
                    );

                }

                else 
                {   
                    $(".alert.alert-danger").remove();
                    $('#sign_up').html("<p>Si vous venez de vous inscrire, vous pouvez désormais vous connecter. Bienvenue !</p>");
                    $("#suivant").attr("disabled", true);
                    $('.modal_inscription').css('display', 'none');
                
                }
            },
            'text' 
        );
    });
});