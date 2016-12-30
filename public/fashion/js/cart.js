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
	});
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
