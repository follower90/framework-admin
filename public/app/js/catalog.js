function requestProducts(catalogId)
{
	var filters = [];
	var sort = $('#products-sort').val();
	$('#products-filters input[type=checkbox]').each(function (n, i) {
		if ($(i).is(':checked')) filters.push($(i).val());
	});

	$.ajax('/api.php?method=Catalog.products', {
		method: 'POST',
		data: {
			filters: filters,
			catalog: catalogId,
			sort: sort
		}
		,
		success: function (data) {
			var url = window.location.href.split('?')[0];
				url += '?sort=' + sort;

			filters.forEach(function (filter) {
				url += '&filters[]=' + filter;
			});

			window.history.pushState('', '', url);

			repaceHtmlWithFade('#products-list', data.response.products);
			$('#products-filters').html(data.response.filters);
		},
		error: function (e) {
			$('#products-list').html(e);
		}
	});
}

function repaceHtmlWithFade(elem, data) {
	$(elem).css({opacity: 0.5});
	$(elem).html(data);
	$(elem).animate({opacity: 1}, 800);
}