$(document).ready(function () {
	let urlSearch = $(location).attr('search');
	let myToken = urlSearch.replace('?t=', '');
	let token = localStorage.getItem('token');
	if (!token) document.location.href = '../html/inscription.html';
	let compteur = 0;
    console.log(myToken);
    console.log(token);

    urlSearch = $(location).attr('search');
    var tokenFromSearch = urlSearch.replace("?t=", "");
    let tokenUser = localStorage.getItem('token');

    $('.edito').click(function () {
        if ($('.edito').hasClass('edito_active')) {
            $('.edito').removeClass('edito_active');
            $('.p_edito')[0].innerHTML = 'Suivre';
            delete_follow();
            console.log('unfollow');
        } else {
            $('.edito').addClass('edito_active');
            $('.p_edito')[0].innerHTML = 'Suivi';
            add_follow();
            console.log('follow');
        }
    });

	function add_follow() {
		$.ajax({
			type: 'POST',
			url: '../../controller/add_follow.php',
			data: 'token_user=' + myToken + '&token=' + token,
			datatype: 'json',
			success: function (data) {
				console.log(data);
			},
		});
	}
	function delete_follow() {
		$.ajax({
			type: 'POST',
			url: '../../controller/delete_follow.php',
			data: 'token_user=' + myToken + '&token=' + token,
			datatype: 'json',
			success: function (data) {
				console.log(data);
			},
		});
	}

    $.post(
        '../../controller/resultSearch.php', 
        {
            tokenFromSearch : tokenFromSearch,
            tokenUserFollow : tokenUser
        },

        function(data)
        { 
            console.log(data);
            $('.username').append(data[0]);
            $('.arobase').append(data[1]);
            $('.biographie').append(data[2]);
            $('.localisation').append(data[3]);
            $('.photo_profil').css('background-image', 'url('+data[4]+')')
            $('.cover').css('background-image', 'url('+data[5]+')')
            if (data[6] == 'oui') {
                $('.edito').addClass('edito_active');
                $('.p_edito')[0].innerHTML = 'Suivi';
            }
            $('.jsp_').append('<div class="abonnements" data-toggle="modal" data-target="#modalAbonnements" ><b>' + data[7] + '</b> Abonnements </div>');
            $('.jsp_').append('<div class="abonnes" data-toggle="modal" data-target="#modalAbonnes"><b>' + data[8] + '</b> Abonnés </div>');
        },
        'json' 
    );

    $.ajax({
        type: 'POST',
        url: '../../controller/profil.php',
        data: 'token_follow=' + tokenFromSearch,
        dataType: 'text',
        success: function (data) {
            let data_ = JSON.parse(data);
            console.log(data_)
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
        data: 'token_follower=' + tokenFromSearch,
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

    $.ajax({
        url: '../../controller/resultSearch.php',
        type: 'POST',
        dataType: 'html',
        data: {tokenFromSearch : tokenFromSearch , tokenUser : tokenUser},
        success: function (data) {

            if (data != 'false') {
                objet = jQuery.parseJSON(data);

                $(objet).each(function () {
                    $('.column.middle ').append('<div class="container">')
                    $('.column.middle .container').last().append('<div class="container_header">');
                    $('.column.middle .container_header').last().append('<div class="photo" style="background-image:url(' + this['image_url'] + ')">');
                    $('.column.middle .container_header').last().append('<div class="usr_name">');
                    $('.column.middle .usr_name').last().append('<div class="username">' + this['username']);
                    $('.column.middle .usr_name').last().append('<div class="arobase">' + this['arobase']);
                    $('.column.middle .container').last().append('<div class="container_body">');
                    $('.column.middle .container_body').last().append('<div class="contenu_tweet">' + this['contenu']);
                    if (this['url_image'] != null) {
                        $('.column.middle .container_body').last().append('<div class="contenu_image"><img src="' + this['url_image'] + '">');
                    }
                    $('.column.middle .container_body').last().append('<div class="date_tweet">' + this['date_tweet']);
                    $('.column.middle .container').last().append('<div class="container_footer">');
                    $('.column.middle .container_footer').last().append('<div class="jsp">');
                    $('.column.middle .jsp').last().append('<div class="rt">');
                    $('.column.middle .rt').last().append('<b>' + this['Nombre retweet'] + '</b> Retweet');
                    $('.column.middle .jsp').last().append('<div class="likes">');
                    $('.column.middle .likes').last().append('<b>' + this['Nombre like'] + '</b> Likes');
                    $('.column.middle .container_footer').last().append('<div class="boutons" id_post="' + this['id_post'] + '">');
                    $('.column.middle .boutons').last().append('<div class="reply">');
                    $('.column.middle .boutons').last().append('<div class="retweet">');
                    if (this['User retweet'] == 'oui') $('.boutons .retweet').last().addClass('retweet_active')
                    $('.column.middle .boutons').last().append('<div class="like">');
                    if (this['User like'] == 'oui') $('.boutons .like').last().addClass('like_active')
                })
            }
        }
    });
})
