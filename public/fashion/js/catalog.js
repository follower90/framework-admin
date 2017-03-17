function requestProducts(catalogId, args)
{
	var filters = [];
	var args = JSON.parse(args);
	var sort = $('#products-sort').val();
	var page = $('#paging li.active a').data('page') || '';

	$('#products-filters input[type=checkbox]').each(function (n, i) {
		if ($(i).is(':checked')) filters.push($(i).val());
	});

	$.ajax('/api.php?method=Catalog.products', {
		method: 'GET',
		data: {
			filters: filters,
			catalog: catalogId,
			args: args,
			sort: sort,
			search: args.search,
			page: page
		},
		success: function (data) {
			var url = window.location.href.split('?')[0];
				url += '?search=' + (args.search || '') ;
				url += '&view=' + (args.view || '');
				url += '&page=' + (page || '');

			if (sort) url += '&sort=' + sort;

			filters.forEach(function (filter) {
				url += '&filters[]=' + filter;
			});

			window.history.pushState('', '', url);

			repaceHtmlWithFade('#products-list', data.response.products);
			$('#products-filters').html(data.response.filters);
			$('#paging').html(data.response.paging);
		},
		error: function (e) {
			$('#products-list').html(e);
		}
	});
}
