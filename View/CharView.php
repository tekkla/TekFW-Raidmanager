<?php

namespace Apps\Raidmanager\View;

use Core\Lib\Amvc\View;

class CharView extends View
{
	public function Index()
	{
		echo '<div id="', ->frame_id, '" class="panel panel-default" style="position: relative;', ->Charlist(), '</di';
	}

	public function Charlist()
	{
		echo '
		<div class="panel-heading
			<h4 class="panel-title', ->headline, '</h
			', ->actionbar, '
		</di
		<div class="panel-body
			<ul class="list-group';

			foreach ($this->charlist as $char)
				echo '
				<li class="list-group-item" id="raidmanager_char_', => $charid_char, '', $charcategory, ' <span class="app-raidmanager-class-', $charclass . '', $charchar_name, '</spa', $charactionbar, '</l';

			echo '
			</u
		</di';
	}

	public function Edit()
	{
		echo '
		<div class="panel-heading
			<h4 class="panel-title', ->headline, '</h
			', ->actionbar, '
		</di
		<div class="panel-body', ->form, '</di';
	}
}
