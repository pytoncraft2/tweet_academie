let token = localStorage.getItem('token');
if (!token) document.location.href = "../html/inscription.html";

$.ajax({
	type: 'POST',
	url: '../../controller/profil.php',
	data: 'token_info_user=' + token,
	dataType: 'text',
	success: function (data) {
		let data_ = JSON.parse(data);
		$('.username').append(data_[0]);
		$('.arobase').append(data_[1]);
		$('.biographie').append(data_[2]);
		$('.localisation').append(data_[3]);
		$('.photo_profil').css('background-image', 'url('+data_[4]+')')
		$('.cover').css('background-image', 'url('+data_[5]+')')
		$('.jsp_').append('<div class="abonnements" data-toggle="modal" data-target="#modalAbonnements" ><b>' + data_[6] + '</b> Abonnements </div>');
		$('.jsp_').append('<div class="abonnes" data-toggle="modal" data-target="#modalAbonnes" ><b>' + data_[7] + '</b> Abonnés </div>');
	},
});

$.ajax({
	type: 'POST',
	url: '../../controller/profil.php',
	data: 'token_follow=' + token,
	dataType: 'text',
	success: function (data) {
		let data_ = JSON.parse(data);
		$(data_).each(function () {
			$('#modalAbonnements .modal-body').append('<div class="container">')
			$('#modalAbonnements .container').last().append('<div class="container_header">');
			$('#modalAbonnements .container_header').last().append('<div class="photo" style="background-image:url(' + this['image_url'] + ')">');
			$('#modalAbonnements .container_header').last().append('<div class="usr_name">');
			$('#modalAbonnements .usr_name').last().append('<div class="username">' + this['username']);
			$('#modalAbonnements .usr_name').last().append('<div class="arobase">' + this['arobase']);
		})
	},
});

$.ajax({
	type: 'POST',
	url: '../../controller/profil.php',
	data: 'token_follower=' + token,
	dataType: 'text',
	success: function (data) {
		let data_ = JSON.parse(data);
		$(data_).each(function () {
			$('#modalAbonnes .modal-body').append('<div class="container">')
			$('#modalAbonnes .container').last().append('<div class="container_header">');
			$('#modalAbonnes .container_header').last().append('<div class="photo" style="background-image:url(' + this['image_url'] + ')">');
			$('#modalAbonnes .container_header').last().append('<div class="usr_name">');
			$('#modalAbonnes .usr_name').last().append('<div class="username">' + this['username']);
			$('#modalAbonnes .usr_name').last().append('<div class="arobase">' + this['arobase']);
		})
	},
});

$('.confirmer').click(function () {
	let flag = 1;
	let modif = {};
	$('.modal_input').each(function () {
		if ($(this).val() === '') {
			alert('Veuillez renseignez tout les champs');
			flag = 0;
		} else {
			modif[$(this).attr('name')] = $(this).val();
		}
	});

	if (flag === 1) {
		$.ajax({
			type: 'POST',
			url: '../../controller/profil_modif.php',
			data:
				'token=' +
				token +
				'&pseudo=' +
				modif.Pseudo +
				'&biographie=' +
				modif.Biographie +
				'&localisation=' +
				modif.Localisation,
			dataType: 'text',
			success: function (data) {
				if (data === 1) {
					alert('Modification appliqué');
					document.location.reload();
				} else if (data === 0) {
					alert("Une erreur s'est produite");
				}
			},
		});
	}
    if ($('#profil_cover')[0].files.length !== 0) {
        upload_image('profil_cover');
    }

    if ($('#profil_photo')[0].files.length !== 0) {
        upload_image('profil_photo');
    }
});

function displayTweet (data, item) {
	$(data).each(function () {
		$('.column.middle ' + item).append('<div class="container">')
		$(item + ' .container').last().append('<div class="container_header">');
		$(item + ' .container_header').last().append('<div class="photo" style="background-image:url(' + this['image_url'] + ')">');
		$(item + ' .container_header').last().append('<div class="usr_name">');
		$(item + ' .usr_name').last().append('<div class="username">' + this['username']);
		$(item + ' .usr_name').last().append('<div class="arobase">' + this['arobase']);
		$(item + ' .container').last().append('<div class="container_body">');
		$(item + ' .container_body').last().append('<div class="contenu_tweet">' + this['contenu']);
		if (this['url_image'] != null) {
			$(item + ' .container_body').last().append('<div class="contenu_image"><img src="' + this['url_image'] + '" alt="tweet_image">');
		}
		$(item + ' .container_body').last().append('<div class="date_tweet">' + this['date_tweet']);
		$(item + ' .container').last().append('<div class="container_footer">');
		$(item + ' .container_footer').last().append('<div class="jsp">');
		$(item + ' .jsp').last().append('<div class="rt">');
		$(item + ' .rt').last().append('<b>' + this['Nombre retweet'] + '</b> Retweet');
		$(item + ' .jsp').last().append('<div class="likes">');
		$(item + ' .likes').last().append('<b>' + this['Nombre like'] + '</b> Likes');
		$(item + ' .container_footer').last().append('<div class="boutons" id_post="' + this['id_post'] + '">');
		$(item + ' .boutons').last().append('<div isClose="false" class="reply">');
		$(item + ' .boutons').last().append('<div class="retweet">');
		if (this['User retweet'] === 'oui') $('.boutons .retweet').last().addClass('retweet_active')
		$(item + ' .boutons').last().append('<div class="like">');
		if (this['User like'] === 'oui') $('.boutons .like').last().addClass('like_active')
	})
}

$('#tweets').click(function () {
	$('#item1').empty();
	$.ajax({
		type: 'POST',
		url: '../../controller/profil.php',
		data: 'token_tweet=' + token,
		dataType: 'json',
		success: function (data) {
			console.log(data);
			displayTweet(data, '#item1');
		}
	});
});

$('#medias').click(function () {
	$('#item3').empty();
	$.ajax({
		type: 'POST',
		url: '../../controller/profil.php',
		data: 'token_media=' + token,
		dataType: 'json',
		success: function (data) {
			console.log(data);
			displayTweet(data, '#item3');
		}
	});
});

$('#jaime').click(function () {
	$('#item4').empty();
	$.ajax({
		type: 'POST',
		url: '../../controller/profil.php',
		data: 'token_jaime=' + token,
		dataType: 'json',
		success: function (data) {
			console.log(data);
			displayTweet(data, '#item4');
		}
	});
});

function upload_image(image) {
    let profil_image = $('#' + image)[0].files[0],
    max_size = 300000,
    valid_ext = ['.jpg', '.jpeg', '.png'],
    file_ext = profil_image['name'].toLowerCase().substr(profil_image['name'].indexOf("."));
	let file_size = profil_image['size'];

    if($.inArray(file_ext, valid_ext) === -1) {
        alert("Le fichier n'est pas une image");
        return;
    }

    if(max_size < file_size) {
        alert("L'image est trop volumineuse");
        return;
    }

    let formData = new FormData();
    formData.append(image, profil_image);
    formData.append('token', token);

    console.log(profil_image);

    $.ajax({
        type: "POST",
        url: "../../controller/profil_image.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            // $('.modal_content').append('<img src="' + data + '"/>')
            // console.log(data);
        }
    });
}