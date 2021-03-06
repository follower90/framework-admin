<?php

namespace Admin;

use \Core\View;

class Snippet
{
	public static function active($id, $path, $state, $field = 'active')
	{
		$view = View::renderString(
			'<input class="switcher" data-id="{1}" type="checkbox" name="' . $field . '" {2} />',
			[$id, $state ? 'checked' : '']
		);

		$pathChunks = explode('_', $path);
		$path = implode('_', array_map(function ($p) {
			return ucfirst($p);
		}, $pathChunks));

		$scripts = View::renderString(
			'<script>
					$(\'.switcher\').bootstrapSwitch({
					size: "mini",
					onSwitchChange: function (event, state) {
					$.ajax(\'/admin/api.php?method={1}.' . $field . '\', {
							method: \'post\',
							data: {id: $(this).attr(\'data-id\'), ' . $field . ': state ? 1 : 0}
						});
					}
				});

				$(document).ready(function() {
					$(\'.delete_item_' . $id . '\').on(\'click\', function() {
						return confirm(\'{2}\');
					});
	
					$(\'.duplicate_item_' . $id . '\').on(\'click\', function() {
						return confirm(\'{3}\');
					});
				});
			</script>', [
			$path,
			__('Are you sure you want to delete this item?'),
			__('Are you sure you want to duplicate this item?')
		]);

		return $view . $scripts;
	}

	public static function actions($id, $path, array $actions)
	{
		$actions[] = 'edit';
		$html = View::renderString('<div class="btn-group btn-sm">
		  <a href="/admin/{1}/edit/{2}" class="btn btn-sm btn-default">{3}</a>
		  <button class="btn dropdown-toggle btn-sm btn-default" data-toggle="dropdown">
		    <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu">',
			[$path, $id, Utils::translate('Edit')]
		);

		if (in_array('duplicate', $actions, true)) {
			$html .= View::renderString('<li><a class="duplicate_item_' . $id . '" href="/admin/{1}/duplicate/{2}">{3}</a></li>',
				[$path, $id, __('Duplicate')]);
		}
		if (in_array('delete', $actions, true)) {
			$html .= View::renderString('<li><a class="delete_item_' . $id . '" href="/admin/{1}/delete/{2}">{3}</a></li>',
				[$path, $id, __('Delete')]);
		}

		$html .= View::renderString('</ul></div>');

		return $html;
	}
}
