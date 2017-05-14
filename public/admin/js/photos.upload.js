function initAlbumsDropzone(id, remove, cancel) {
	$("#myDropzone").dropzone({
		url: "/admin/api.php?method=Photo_Album.upload",
		paramName: 'file',
		maxFilesize: 10,
		addRemoveLinks: true,
		dictRemoveFile: remove,
		dictCancelUpload: cancel,
		acceptedFiles: 'image/*',

		init: function () {
			var thisDropzone = this;
			$.post('/admin/api.php?method=Photo_Album.photos', {id: id}, function (data) {
				$.each(data.response, function (key, value) {
					var mockFile = {
						name: value.name,
						size: value.size,
						height: 120,
						width: 120
					};
					thisDropzone.options.addedfile.call(thisDropzone, mockFile);
					thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.src);
					thisDropzone.emit("complete", mockFile);
				});
			});

			this.on('removedfile', function (file) {
				$.post('/admin/api.php?method=Photo_Album.removePhoto', {
					id: id,
					filename: file.name
				});
			});

			this.on('sending', function (file, xhr, formData) {
				formData.append('id', id);
			});
		}
	});
}