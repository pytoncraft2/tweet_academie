$(window).on( "load", function() { 

    let token = localStorage.getItem('token');
    let baseTweet, newTweet
    if (!token) document.location.href = "../html/inscription.html";

    function displayTweet() {

        $.post(
            "../../controller/tweet.php/", 
            {
                get_tweet_token: token,
            },
        
            function(data)
            { 
                baseTweet = data;
                $(data).each(function () {
                    $('.column.middle ').append('<div class="container">')
                    $('.column.middle .container').last().append('<div class="container_header">');
                    $('.column.middle .container_header').last().append('<div class="photo" style="background-image:url(' + this['image_url'] + ')">');
                    $('.column.middle .container_header').last().append('<div class="usr_name">');
                    $('.column.middle .usr_name').last().append('<div class="username">' + this['username']);
                    $('.column.middle .usr_name').last().append('<div class="arobase">' + this['arobase']);
                    $('.column.middle .container').last().append('<div class="container_body">');
                    $('.column.middle .container_body').last().append('<div class="contenu_tweet">' + this['contenu']);
                    if (this['url_image'] != null) {
                        $('.column.middle .container_body').last().append('<div class="contenu_image"><img src="' + this['url_image'] + '" alt="photo_tweeter">');
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
                    if (this['User retweet'] === 'oui') $('.boutons .retweet').last().addClass('retweet_active')
                    $('.column.middle .boutons').last().append('<div class="like">');
                    if (this['User like'] === 'oui') $('.boutons .like').last().addClass('like_active')
                })
            },
            'json' 
        );
    }
    
    function get_user_photo() {

        $.post(
            "../../controller/tweet.php/", 
            {
                get_photo_token: token,
            },
        
            function(result)
            { 
                $('.photo_').css('background-image', 'url('+result+')')
            },
            'text' 
        );
    }

    function send_tweet_text(content) {
        $.post(
            "../../controller/tweet.php/", 
            {
                token: token,
                content: content
            },
        
            function(result)
            { 
            },
            'text' 
        );
    }

    function send_tweet_text_image(content) {
        $.ajax({
            type: "POST",
            url: "../../controller/tweet.php/",
            data: content,
            processData: false,
            contentType: false,
            success: function (data) {
            }
        });
    }

    $('.tweet_button').on('click', function() {

        let textarea = $('.quoi_de_neuf textarea').val();

        if (textarea === "" && $('#tweet_image')[0].files.length === 0) {
            return;
        }

        if (textarea !== "" && $('#tweet_image')[0].files.length === 0) {
            send_tweet_text(textarea);
        }

        if (textarea === "" && $('#tweet_image')[0].files.length !== 0) {
            let tweet_image = upload_image('tweet_image', token);
            if (tweet_image === false) return;
            send_tweet_text_image(tweet_image);
        }

        if (textarea !== "" && $('#tweet_image')[0].files.length !== 0) {
            let tweet_text_image = upload_image('tweet_image', token);
            if (tweet_text_image === false) return;
            tweet_text_image.append('content', textarea);
            send_tweet_text_image(tweet_text_image);
        }

        let clearTextarea = $('.quoi_de_neuf textarea').val('');
        let clearInputFile = $('#tweet_image').val('');
        $('.column.middle .container').remove();
        displayTweet();
    })

    displayTweet();
    get_user_photo();

    setInterval(function() {

        $.post(
            "../../controller/tweet.php/", 
            {
                get_tweet_token: token,
            },
        
            function(data)
            { 
                newTweet = data;
                appendNewTweet(baseTweet, newTweet);

            },
            'json' 
        );

    }, 10000);

    function appendNewTweet(tweet1, tweet2) {

        if(tweet1.length == tweet2.length) {
            return;
        } else {

            numberNewTweet = tweet2.length - tweet1.length;

            for (let i = numberNewTweet - 1 ; i >= 0 ; i--) {
                $('.column.middle .container').first().before('<div class="container">')
                $('.column.middle .container').first().append('<div class="container_header">');
                $('.column.middle .container_header').first().append('<div class="photo" style="background-image:url(' + tweet2[i]['image_url'] + ')">');
                $('.column.middle .container_header').first().append('<div class="usr_name">');
                $('.column.middle .usr_name').first().append('<div class="username">' + tweet2[i]['username']);
                $('.column.middle .usr_name').first().append('<div class="arobase">' + tweet2[i]['arobase']);
                $('.column.middle .container').first().append('<div class="container_body">');
                $('.column.middle .container_body').first().append('<div class="contenu_tweet">' + tweet2[i]['contenu']);
                if (tweet2[i]['url_image'] != null) {
                    $('.column.middle .container_body').first().append('<div class="contenu_image"><img src="' + tweet2[i]['url_image'] + '">');
                }
                $('.column.middle .container_body').first().append('<div class="date_tweet">' + tweet2[i]['date_tweet']);
                $('.column.middle .container').first().append('<div class="container_footer">');
                $('.column.middle .container_footer').first().append('<div class="jsp">');
                $('.column.middle .jsp').first().append('<div class="rt">');
                $('.column.middle .rt').first().append('<b>' + tweet2[i]['Nombre retweet'] + '</b> Retweet');
                $('.column.middle .jsp').first().append('<div class="likes">');
                $('.column.middle .likes').first().append('<b>' + tweet2[i]['Nombre like'] + '</b> Likes');
                $('.column.middle .container_footer').first().append('<div class="boutons" id_post="' + tweet2[i]['id_post'] + '">');
                $('.column.middle .boutons').first().append('<div class="reply">');
                $('.column.middle .boutons').first().append('<div class="retweet">');
                if (tweet2[i]['User retweet'] == 'oui') $('.boutons .retweet').first().addClass('retweet_active')
                $('.column.middle .boutons').first().append('<div class="like">');
                if (tweet2[i]['User like'] == 'oui') $('.boutons .like').first().addClass('like_active')
            }

            baseTweet = tweet2;
            return;

        }
    }

})