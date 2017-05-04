//In progress

var Comments = {
	type: null,
	id: null,
	limit: null,

	initialize: function (type, id, limit) {
		Comments.id = id;
		Comments.type = type;
		Comments.limit = limit;

		$('.comment-send').on('click', function () {
			Comments.send();
		});
	},

	list: function () {
		$.get('/api.php?method=Comments.list', {
			id: Comments.id,
			type: Comments.type,
			limit: Comments.limit

		}).then(function (data) {
			$('.comments-list').html(data.response.comments);
		});
	},

	send: function () {
		var name = $('.comment-name').val().trim();
		var value = $('.comment-text').val().trim();
		if (value) {
			$.ajax('/api.php?method=Comments.post', {
				type: 'POST', data: {
					id: Comments.id,
					type: Comments.type,
					name: name,
					text: value
				}
			}).then(function (data) {
				$('.comments-list').append(data.response.comment);
				$('.comment-text').val('');
			});
		}
	}
};
