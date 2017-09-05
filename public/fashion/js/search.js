$(document).ready(function () {
	$('.main-header #search input[type=text]').on('keyup', _.debounce(function () {
		$.ajax('/api.php?method=Product.search', {
			type: 'GET',
			data: {
				search: $(this).val()
			}
		}).success(function () {
			//
		});
	}, 1000));
});
