<?php

namespace Admin;

class Snippet
{
	public static function active($id, $state)
	{
		return '<input class="switcher" data-id="' . $id . '" type="checkbox" name="active" ' . ($state ? 'checked' : '') . ' />';
	}

	public static function actions($id, $actions)
	{
		array_push($actions, 'edit');

		$html = '<div class="btn-group btn-sm">
		  <a href="/admin/page/edit/' . $id . '" class="btn btn-sm btn-default">Edit</a>
		  <button class="btn dropdown-toggle btn-sm btn-default" data-toggle="dropdown">
		    <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu">';

		if (in_array('duplicate', $actions)) $html .= '<li><a id="duplicate_item" href="/admin/page/duplicate/' . $id . '">Duplicate</a></li>';
		if (in_array('delete', $actions)) $html .= '<li><a id="delete_item" href="/admin/page/delete/' . $id . '">Delete</a></li>';

		$html .= '</ul></div>';

		return $html;
	}
}