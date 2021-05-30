<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style_accueil/style_default.css">
    <title>Twitter</title>
</head>

<body>
    <div class="row">
        <div class="column left">
            <div class="menu">
					<div class="twitter"></div>
					<div class="accueil_">
                        <div class="logo_accueil"></div>
						<a href="./accueil.html">Accueil</a>
					</div>
					<div class="messages">
                        <div class="logo_messages"></div>
						<a href="./message.html">Messages</a>
					</div>
					<div class="profil">
                        <div class="logo_profil"></div>
						<a href="profil.html">Profil</a>
					</div>
					<div class="parametre">
                        <div class="logo_parametre"></div>
						<a href="parametre.html">Paramètres</a>
					</div>
					<div class="tweeter_">
						<input type="button" value="Tweeter" />
					</div>
				</div>
        </div>
        <div class="column middle">
            <div class="accueil">
                <div class="recherche_">
                    <div class="logo_recherche"></div>
                    <div class="input_recherche">
                    <form action="../../controller/checkResult.php" method="POST">
                    <input type="text" name="recherche" placeholder="Recherche Twitter" />
                    </form>
                    </div>
                </div>
            </div>
           <div id="result">resultat</div>
           <div class="nav_responsive">
                    <div class="accueil_responsive"></div>
                    <div class="profil_responsive"></div>
                    <div class="message_responsive"></div>
                    <div class="parametre_responsive"></div>
                </div>
        </div>
        <style>
       .search-found {
           text-decoration: underline;
       }


        </style>
        <div class="column right">

        </div>
    </div>
    <script src="../script/profil.js"></script>
    <script src="../script/account_style.js"></script>
    <script src="../script/nav_profile.js"></script>
    <script src="../script/buttons_style.js"></script>
    <script src="../script/result.js"></script>
    <script src="../script/recherche.js"></script>
    <script src="../script/responsive_nav.js"></script>

</body>

</html>