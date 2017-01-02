//In progress

var Comments = {
	type: null,
	id: null,

	initialize: function (type, id) {
		Comments.id = id;
		Comments.type = type;
		$('.comment-text').on('click', function () {
			Comments.toggleControls(true);
		});

		$('.comment-cancel').on('click', function () {
			Comments.toggleControls(false);
			$('.comment-text').val('');
		});

		$('.comment-send').on('click', function () {
			Comments.send();
		});

		$('.comment-reply').on('click', function (e) {
			e.preventDefault();
		});

		Comments.list();
	},

	list: function () {
		$.ajax('/api.php?method=Comments.list', {
			type: 'POST', data: {
				id: Comments.id,
				type: Comments.type
			}
		}).then(function () {
			$('.comments-list').val('');
		});
	},

	send: function () {
		var value = $('.comment-text').val().trim();
		if (value) {
			$.ajax('/api.php?method=Comments.post', {
				type: 'POST', data: {
					id: Comments.id,
					type: Comments.type,
					text: value
				}
			}).then(function () {
				//$('.comment-text').val('');
				window.location.reload();
			});
		}
	},

	toggleControls: function (visible) {
		var visibility = visible ? 'visible' : 'hidden';
		$('.comment-controls').css({ visibility: visibility});
	}
};
