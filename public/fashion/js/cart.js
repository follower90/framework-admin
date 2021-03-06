var basket = (function () {
	/*TODO rewrite functions below with this module */
	return {
		getTotals: function() {

		},
		add: function() {

		},
		remove: function() {

		},
		update: function() {

		}
	}
})();

function updateCartCount() {
	$.ajax('/api.php?method=Cart.count')
		.success(function (data) {
			$('#cart-count').html(data.response.count);
			$('#cart-total').html(data.response.total);
		});
}

function addToCart(id) {
	$.ajax('/api.php?method=Cart.add', {
		type: 'POST',
		data: {
			id: id
		}
	}).success(function () {
		updateCartCount();
		notifyAddToCart();
	});
}

function notifyAddToCart() {
	$('.cart-added').show().fadeOut(1500);
}

function removeFromCart(id) {
	$.ajax('/api.php?method=Cart.remove', {
		data: {
			id: id
		}
	}).success(function () {
		updateCartCount();
	});
}

function updateProductCount(id, count) {
	$.ajax('/api.php?method=Cart.update', {
		data: {
			id: id,
			count: count
		}
	}).success(function () {
		updateCartCount();
	});
}

updateCartCount();
