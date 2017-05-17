function requestProducts(catalogId, args)
{
	var filters = {};
	var args = JSON.parse(args);
	var sort = $('#products-sort').val();
	var page = $('#paging li.active a').data('page') || '';


	$('#products-filters .list-group-item').each(function (g, group) {
		filters[g] = [];
		$(group).find('input[type=checkbox]').each(function (n, i) {
			if ($(i).is(':checked')) filters[g].push($(i).val());
		});
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

			for (var i in filters) {
				if (filters.hasOwnProperty(i)) {
					filters[i].forEach(function (filterId) {
						url += '&filters[' + i + '][]=' + filterId;
					});
				}
			}

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
