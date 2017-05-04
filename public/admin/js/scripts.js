$(document).ready(function () {

	/**
	 * Sort Admin Tables
	 * Calls Entity.sort API-method with array of ids
	 * requires:
	 * data-entity="Entity" on <table>
	 * data-id="id"on each <tr>
	 */
	$('.table-sortable').sortable({
		containerSelector: 'table',
		itemPath: '> tbody',
		itemSelector: 'tr',
		placeholder: '<tr class="fa fa-plus placeholder"/>',
		onDrop: function (item, container, _super) {
			var ids = [];
			$('.table-sortable tbody tr').each(function (i, el) {
				ids.push($(el).data('id'));
			});

			$.ajax('/admin/api.php?method=' + $('.table-sortable').data('entity') + '.sort', {
				type: 'POST',
				data: {ids: ids}
			});

			_super(item, container);
		}
	});

	if ($('#editor-1').length) CKEDITOR.replace('editor-1');

	$.datetimepicker.setLocale('ru');
	$('.datetime').datetimepicker({ format:'Y-m-d H:i:s' });

});