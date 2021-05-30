$(':radio[name=theme]').change(function () {
	let value = this.value;
	localStorage.setItem('theme', value);
	location.reload();
});
switch (true) {
	case localStorage.getItem('theme') === '1':
		$('link')[0].outerHTML = '<link rel="stylesheet" href="../css/style_accueil/style_default.css">';
		$(':radio[name=theme]').prop('checked', false);
		$("input[name=theme][value='1']").prop('checked', true);

		break;
	case localStorage.getItem('theme') === '2':
		$('link')[0].outerHTML = '<link rel="stylesheet" href="../css/style_accueil/style_bleu.css">';
		$(':radio[name=theme]').prop('checked', false);
		$("input[name=theme][value='2']").prop('checked', true);
		break;
	case localStorage.getItem('theme') === '3':
		$('link')[0].outerHTML = '<link rel="stylesheet" href="../css/style_accueil/style_noir.css">';
		$(':radio[name=theme]').prop('checked', false);
		$("input[name=theme][value='3']").prop('checked', true);
		break;
	default:
		$('link')[0].outerHTML = '<link rel="stylesheet" href="../css/style_accueil/style_default.css">';
		$(':radio[name=theme]').prop('checked', false);
		$("input[name=theme][value='1']").prop('checked', true);
}
