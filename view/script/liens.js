$(document).ready(function () {

    function getToken($par) {
        $.post(
            '../../controller/liens.php',
            {
                arobase: $par,
            },

            function (data) {
                $(location).attr('href', "view.php?t=" + data);
            },
            'text'
        );
    }

    $('body').on({
        click: function (e) {
            if ($(this).text().match("@")) {
                e.preventDefault();
                getToken($(this).text().substring(1));
            }
        }
    }, '.contenu_tweet a')
    
        
    $(document).ajaxComplete(function () {
            
        $(".contenu_tweet:contains('#')").each(function (e) {
            link = 'result.php?k=$1';
            $(this).html($(this).html().replace(/\B(\#[a-zA-Z]+\b)(?!;)/g, '<a href=' + link + ' style=color:#03a9f4;text-decoration:none>$1</a>'));           
            $(".contenu_tweet a").each(function (e) {
                var cur = $(this).attr("href");
                var urlnew = cur.replace("#", "%23");
                $(this).attr("href", urlnew);
            });
        });

        $(".contenu_tweet:contains('@')").each(function (e) {
            $(this).html($(this).html().replace(/\B(\@[a-zA-Z]+\b)(?!;)/g, '<a href=view.php?t= style=color:#03a9f4;text-decoration:none>$1</a>'));
            
        });     
    });         
})
