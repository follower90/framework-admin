function updateCartCount() {
	$.ajax('/api.php?method=Cart.count')
		.success(function (data) {
			$('#cart-count').html(data.response.count);
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

function confirmOrder() {
	$.ajax('/api.php?method=Order.create', {
		
	}).success(function () {
		updateCartCount();
	});
}

updateCartCount();
