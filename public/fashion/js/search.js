$(document).ready(function () {
	$('.main-header #search input[type=text]').on('keyup', _.debounce(function () {
		var value = $(this).val();
		if (value.length < 2) return false;
		$.ajax('/api.php?method=Product.search', {
			type: 'GET',
			data: {
				search: value,
				limit: 10
			}
		}).success(function (data) {
			var searchResults = $('#search .search-results');
			searchResults.hide();

			var result = '';
			_.each(data.response, function (product) {
				result += '<li><img src="/api.php?method=Resource.getImageResized&width=20&height=20&id=' + product.photo_id + '"/><a href="/product/view/' + product.url + '">' + product.name + '</a></li>';
			});

			if (result) {
				searchResults.html('<ul>' + result + '</ul>');
				searchResults.show();
			}
		});
	}, 500));
});
