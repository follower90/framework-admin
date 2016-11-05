<?php

namespace Admin;

use \Core\View;

class Snippet
{
	public static function active($id, $path, $state)
	{
		$view = View::renderString(
			'<input class="switcher" data-id="{1}" type="checkbox" name="active" {2} />',
			[$id, $state ? 'checked' : '']
		);

		$scripts = View::renderString(
			'<script>
					$(\'.switcher\').bootstrapSwitch({
					size: "mini",
					onSwitchChange: function (event, state) {
					$.ajax(\'/admin/api.php?method={1}.active\', {
							method: \'post\',
							data: {id: $(this).attr(\'data-id\'), active: state ? 1 : 0}
						});
					}
				});

				$(\'#delete_item\').on(\'click\', function() {
					return confirm(\'{2}\');
				});

				$(\'#duplicate_item\').on(\'click\', function() {
					return confirm(\'{3}\');
				});
			</script>', [
			ucfirst($path),
			Utils::translate('Are you sure you want to delete this item?'),
			Utils::translate('Are you sure you want to duplicate this item?')
		]);

		return $view . $scripts;
	}

	public static function actions($id, $path, $actions)
	{
		array_push($actions, 'edit');

		$html = View::renderString('<div class="btn-group btn-sm">
		  <a href="/admin/{1}/edit/{2}" class="btn btn-sm btn-default">{3}</a>
		  <button class="btn dropdown-toggle btn-sm btn-default" data-toggle="dropdown">
		    <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu">',
			[$path, $id, Utils::translate('Edit')]
		);

		if (in_array('duplicate', $actions)) {
			$html .= View::renderString('<li><a id="duplicate_item" href="/admin/{1}/duplicate/{2}">{3}</a></li>',
				[$path, $id, Utils::translate('Duplicate')]);
		}
		if (in_array('delete', $actions)) {
			$html .= View::renderString('<li><a id="delete_item" href="/admin/{1}/delete/{2}">{3}</a></li>',
				[$path, $id, Utils::translate('Delete')]);
		}

		$html .= View::renderString('</ul></div>');

		return $html;
	}
}
