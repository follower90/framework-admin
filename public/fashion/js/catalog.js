function requestProducts(catalogId, args)
{
	var filters = [];
	var args = JSON.parse(args);
	var sort = $('#products-sort').val();
	$('#products-filters input[type=checkbox]').each(function (n, i) {
		if ($(i).is(':checked')) filters.push($(i).val());
	});

	$.ajax('/api.php?method=Catalog.products', {
		method: 'GET',
		data: {
			filters: filters,
			catalog: catalogId,
			args: args,
			sort: sort
		},
		success: function (data) {
			var url = window.location.href.split('?')[0];
				url += '?search=' + args.search;
				url += '&view=' + args.view;

			if (sort) url += '&sort=' + sort;

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
