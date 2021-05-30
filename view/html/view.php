<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style_accueil/style_default.css" />
    <link rel="stylesheet" href="../css/style_recherche/style_pages.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-4.6.0-dist/css/bootstrap-grid.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap-4.6.0-dist/css/bootstrap.css">
    <title>Test Tweet</title>
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
                <p>Profil</p>
            </div>
            <div class="cover"></div>
            <div class="container">
                <div class="container_header_">
                    <div class="photo_profil"></div>
                    <div class="edito">
                        <p class='p_edito'>Suivre</p>
                    </div>
                </div>
                <div class="container_body_">
                    <div class="usr_name">
                        <div class="username"></div>
                        <div class="arobase"></div>
                    </div>
                    <div class="biographie"></div>
                    <div class="localisation"></div>
					<div class="jsp_">

						<div class="modal fade" id="modalAbonnements" tabindex="-1" role="dialog"
							aria-labelledby="modalAbonnementsLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="modalAbonnementsLabel">Abonnements : </h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
									</div>
								</div>
							</div>
						</div>

						<div class="modal fade" id="modalAbonnes" tabindex="-1" role="dialog"
							aria-labelledby="modalAbonnesLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="modalAbonnesLabel">Abonnés : </h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
									</div>
								</div>
							</div>
						</div>
					</div>
                </div>
                <div class="container_footer_">
                    <ul class="tab-list">
                        <li id="_tweets" class="active">
                            <a class="nav-link" href="#item1">Tweets</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane">
                    <div class="content" id="item1">
                    </div>
                </div>
            </div>
            <div class="nav_responsive">
                    <div class="accueil_responsive"></div>
                    <div class="profil_responsive"></div>
                    <div class="message_responsive"></div>
                    <div class="parametre_responsive"></div>
                </div>
        </div>
        <div class="column right">
            <div class="recherche_">
                <div class="logo_recherche"></div>
                <div class="input_recherche">
                    <form action="../../controller/checkResult.php" method="POST">
                        <input type="text" name="recherche" placeholder="Recherche Twitter" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../script/recherche.js"></script>
    <script src="../script/view.js"></script>
    <script src="../script/responsive_nav.js"></script>
    <script src="../css/bootstrap-4.6.0-dist/js/bootstrap.js"></script>
    <script src="../script/liens.js"></script>
    <script src="../script/buttons_style.js"></script>


</body>

</html>