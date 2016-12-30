function addToFavourites(entity, id) {
	$.ajax('/api.php?method=Favourite.add', {
		type: 'POST',
		data: {
			entity: entity,
			id: id
		}
	});
}

function removeFromFavourites(entity, id) {
	$.ajax('/api.php?method=Favourite.remove', {
		type: 'POST',
		data: {
			entity: entity,
			id: id
		}
	}).success(function () {
		getFavouritesList(entity);
	});
}

function getFavouritesList(entity) {
	$.ajax('/api.php?method=Favourite.list', {
		type: 'GET',
		data: {
			entity: entity
		}
	}).success(function (data) {
		repaceHtmlWithFade('#favourites-products-list', data.response);
	});
}


$(document).ready(function () {

	$('#main-container').click(function (e) {
		var elem = $(e.target);

		if (elem.hasClass('btn-wishlist')) {
			addToFavourites('product', elem.data('id'));
			elem.removeClass('btn-wishlist');
			elem.addClass('btn-unwishlist');
			console.log(1);
			return;
		}

		if (elem.hasClass('btn-unwishlist')) {
			removeFromFavourites('product', elem.data('id'));
			$(elem).removeClass('btn-unwishlist');
			$(elem).addClass('btn-wishlist');
			console.log(2);
			return;
		}
	});
});
