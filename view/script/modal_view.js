$('#inscrire').click(function () {
	$('.modal_inscription').css('display', 'flex');
});
$('#connexion').click(function () {
	$('.modal_connexion').css('display', 'flex');
});
$('.edito').click(function () {
	$('.modal_edit_profil').css('display', 'flex');
});
$('.annuler').click(function () {
	$('.modal_edit_profil').css('display', 'none');
});
$(document).keyup(function (e) {
	if (e.keyCode === 27) {
		$('.modal_inscription').css('display', 'none');
		$('.modal_connexion').css('display', 'none');
		$('.modal_edit_profil').css('display', 'none');
		$('.modal_edit_parametres').css('display', 'none');
    $('.modal_desactivation').css('display', 'none');
	}
});
$("#btn_modif").click(function () {
    $(".modal_edit_parametres").css("display", "flex");
});
$("#btn_cancel").click(function () {
	$(".modal_edit_parametres").hide();
});
$("#btn_desactive").click(function () {
  $(".modal_desactivation").css("display", "flex");
});
$("#btn_cancel_desactive").click(function () {
$(".modal_desactivation").hide();
});
$(".modal_edit_parametres").click(function (e) 
{
   if(!$(e.target).closest(".modal_content").length && !$(e.target).is(".modal_content")) {
     $(".modal_edit_parametres").hide();
   }     
});
$(".modal_edit_profil").click(function (e) 
{
   if(!$(e.target).closest(".modal_content").length && !$(e.target).is(".modal_content")) {
     $(".modal_edit_profil").hide();
   }     
});
$(".modal_inscription").click(function (e) 
{
   if(!$(e.target).closest(".modal_content").length && !$(e.target).is(".modal_content")) {
     $(".modal_inscription").hide();
   }     
});
$(".modal_connexion").click(function (e) 
{
   if(!$(e.target).closest(".modal_content").length && !$(e.target).is(".modal_content")) {
     $(".modal_connexion").hide();
   }     
});
$(".modal_desactivation").click(function (e) 
{
   if(!$(e.target).closest(".modal_content").length && !$(e.target).is(".modal_content")) {
     $(".modal_desactivation").hide();
   }     
});
