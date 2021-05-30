$('.nav-link').click(changeClass);

function changeClass() {
	if ($('.nav-link').parent().hasClass('active')) {
		$('.nav-link').parent().removeClass('active');
	}
	$(this).parent().addClass('active');
}
