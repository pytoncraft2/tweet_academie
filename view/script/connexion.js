$(document).ready(function () {
	$('.login').click(function () {
		function check_form() {
			$('.login_form .alert-danger').remove();

			let valid = true,
				email_pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

			$('.login_form :input').each(function () {
				let $this = $(this),
					input_name = $this.attr('name');

				if ($this.val() === 0) {
					valid = false;
					$this
						.parent()
						.append(
							"<div class='alert alert-danger' role='alert'>Merci de remplir le champ <strong>" +
								input_name +
								'</strong></div>'
						);
				}

				if (input_name === 'email' && $this.val() !== '') {
					if (!email_pattern.test($this.val())) {
						$this
							.parent()
							.append(
								"<div class='alert alert-danger' role='alert'>Merci de remplir le champ <strong>" +
									input_name +
									'</strong> au bon format</div>'
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
			let data_array = $('.login_form').serializeArray(),
				len = data_array.length,
				form_data = {};

			for (let i = 0; i < len; i++) {
				form_data[data_array[i].name] = data_array[i].value;
			}
			return form_data;
		}

		if (check_form() === false) return;

        let form_data = get_data();
       
        let req = $.ajax({
            url: "../../controller/connexion.php",
            type: "post",
            data: form_data,
        });

        req.done((res) => {
            let data = JSON.parse(res);
            console.log(data);
            if (data !== false) {
                localStorage.setItem("token", data[0]);
                $(".login_form").html("<p>Connexion réussie !</p>");
                location.href = "../html/accueil.html";

            } else {
				$('.alert.alert-danger').remove();
                $(".login_form").append("<div class='alert alert-danger' role='alert'>La connexion a échoué, merci de vérifier vos identifiants.</div>");
            }
        });
    });
});