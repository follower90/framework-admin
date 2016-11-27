function requestProducts(catalogId)
{
	var filters = [];
	var sort = $('#catalog-sort').val();
	$('#catalog-filters input[type=checkbox]').each(function (n, i) {
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
			$('#products-list').html(data.response);
		},
		error: function (e) {
			$('#products-list').html(e);
		}
	});
}
