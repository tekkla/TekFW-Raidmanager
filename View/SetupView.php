<?php
namespace Apps\Raidmanager\View;

use Core\Lib\Amvc\View;

class SetupView extends View
{
	public function Complete()
	{
		foreach($this->setup_keys as $id_setup)
			echo '
			<div id="raidmanager_setup_', $id_setup, '', ->Index($id_setup), '</di';
	}

	public function Index($id_setup)
	{
		echo '
		<div class="panel panel-default
			<div class="panel-body
				<div id="raidmanager_setup_', $id_setup, '_info', ->Info($id_setup), '</di
				<div id="raidmanager_setup_', $id_setup, '_player
					', ->{'setlist_' . $id_setup}, '
				</di
			</di
		</di';
	}


	public function Info($id_setup)
	{
		echo ->{'infos_'. $id_setup}actionbar;

		echo '<h3 class="no-top-margin', ->{'infos_' . $id_setup}title, '</h';

		if($this->{'infos_' . $id_setup}description)
			echo '<p class="raidmanager_setup_description', parse_bbc($this->{'infos_' . $id_setup}description), '</';
	}

	function Edit()
	{
		echo '
		<div class="panel panel-default
			<div class="panel-body
				<div class="raidmanager_edit raidmanager_section';

					echo ->actionbar;

					echo '
					<h3 class="no-top-margin', ->headline, '</h';

					echo ->form;

				echo '
				</di
			</di
		</di';
	}
}
