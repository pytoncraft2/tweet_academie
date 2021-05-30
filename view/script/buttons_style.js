window.onload = () => {
	let token = localStorage.getItem('token');
	let compteur_reply = 0;

	document.body.addEventListener('click', (e) => {
		let id_post = $(e.target).parent().attr('id_post');
		if (e.target.className === 'like' || e.target.className === 'like like_active') {
			if (e.target.className === 'like like_active') {
				$(e.target).removeClass('like_active');
				$.ajax({
					type: 'POST',
					url: '../../controller/delete_like.php',
					data: 'token=' + token + '&id_post=' + id_post,
					dataType: 'text',
					success: function (data) {
						console.log(typeof data);
						console.log(data);
					},
				});
			} else {
				$(e.target).addClass('like_active');
				$.ajax({
					type: 'POST',
					url: '../../controller/ajout_like.php',
					data: 'token=' + token + '&id_post=' + id_post,
					dataType: 'text',
					success: function (data) {
						console.log(typeof data);
						console.log(data);
					},
				});
			}
		}
		if (e.target.className === 'retweet' || e.target.className === 'retweet retweet_active') {
			if (e.target.className === 'retweet retweet_active') {
				$(e.target).removeClass('retweet_active');
				$.ajax({
					type: 'POST',
					url: '../../controller/delete_retweet.php',
					data: 'token=' + token + '&id_post=' + id_post,
					dataType: 'text',
					success: function (data) {
						console.log(typeof data);
						console.log(data);
					},
				});
			} else {
				$(e.target).addClass('retweet_active');
				$.ajax({
					type: 'POST',
					url: '../../controller/ajout_retweet.php',
					data: 'token=' + token + '&id_post=' + id_post,
					dataType: 'text',
					success: function (data) {
						console.log(typeof data);
						console.log(data);
					},
				});
			}
		}
		if (e.target.className === 'reply') {
			let id_post = $(e.target).parent().attr('id_post');
			compteur_reply++;
			$.ajax({
				type: 'POST',
				url: '../../controller/reply_info.php',
				data: 'id_post=' + id_post,
				dataType: 'text',
				success: function (data) {
					let data_ = JSON.parse(data);
					console.log(data_);
					if (compteur_reply % 2 === 0) {
						$('.wrapper4').css('display', 'none');
						$('.reply_tweet').remove();
					} else {
						$(e.target)
							.parent()
							.parent()
							.parent()
							.append(
								"<div class='wrapper4'><div class='reponse'><div class='response_user'><div class='icon_response'></div><p>En réponse</p></div><textarea class='textarea' name='reponse' placeholder='Répondre à ce tweet' cols='20' rows='4' maxlength='140'></textarea></div><div class='reponse_footer'><input id_post=" +
									id_post +
									" class='reply_button' type='button' value='Répondre'/></div></div><div class='reply_tweet'></div>"
							);
					}
					for (let i = 0; i < data_.length; i++) {
						$('.reply_tweet').append(
							"<div class='wrapper5'><div class='icone_reponse'></div><div class='container_reply'><div class='container_header'><div class='photo'></div><div class='usr_name'><div class='username'>" +
								data_[i][0] +
								"</div><div class='arobase'>" +
								data_[i][1] +
								"</div></div></div><div class='container_body'><div class='contenu_tweet'>" +
								data_[i][2] +
								"</div><div class='date_tweet'>" +
								data_[i][3] +
								'</div></div></div>'
						);
						$('.wrapper5 .photo').last().css('background-image', 'url('+data_[i][4]+')')
					}
				},
			});
		}
		let textarea_;
		if (e.target.className === 'reply_button') {
			let textarea = $(e.target).parent().parent().children().children('.textarea')[0];
			textarea_ = $(textarea).val();
			let id_post = $(e.target).attr('id_post');
			id_post = parseInt(id_post);

			console.log(textarea_);

			if (textarea_ === '') {
				alert('Vous ne pouvez pas publier une réponse vide');
			} else {
				$.ajax({
					type: 'POST',
					url: '../../controller/ajout_reply.php',
					data: 'token=' + token + '&id_post=' + id_post + '&textarea=' + textarea_,
					dataType: 'text',
					success: function (data) {
						if (data == 1) {
							$(textarea).val('');
							$.ajax({
								type: 'POST',
								url: '../../controller/reply_final.php',
								data: 'token=' + token + '&id_post=' + id_post,
								dataType: 'text',
								success: function (data) {
									let _data = JSON.parse(data);
									$('.reply_tweet').append(
										"<div class='wrapper5'><div class='icone_reponse'></div><div class='container_reply'><div class='container_header'><div class='photo'></div><div class='usr_name'><div class='username'>" +
										_data[0] +
										"</div><div class='arobase'>" +
										_data[1] +
										"</div></div></div><div class='container_body'><div class='contenu_tweet'>" +
										_data[2] +
										"</div><div class='date_tweet'>" +
										_data[3] +
										'</div></div></div>'
									);
									$('.wrapper5 .photo').last().css('background-image', 'url('+_data[4]+')')
								},
							});
						}
					},
				});
			}
		}
	});
};
