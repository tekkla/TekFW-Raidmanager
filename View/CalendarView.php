<?php
namespace Apps\Raidmanager\View;

use Core\Lib\Amvc\View;

class CalendarView extends View
{
	public function Index()
	{
		echo '
		<div class="btn-group app-raidmanager-calendar-selection
		', ->calendar_by_type('future', 'left'), '
		', ->calendar_by_type('recent', 'right'), '
		</di';
	}

	public function calendar_by_type($type, $side='left')
	{
		// No raids to show, no list to show ;)
		if ($this->{'list_' . $type}count() == 0)
			return;

		echo '
		<div class="btn-group btn-group-sm
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown', ->{$type}, ' <span class="caret</spa</butto
			<ul class="dropdown-menu pull-' . $side .'';

			foreach ($this->{'list_' . $type} as $link)
				echo '<l', $link, '</l';

			echo '
			</u
		</di';
	}

	public function WidgetNextRaid()
	{
		echo '
		<div class="panel panel-info
			<div class="panel-body
				<stronNächster Raid:</stron <a href="', ->raidurl, '', timeformat($this->raidstarttime), ' - ', ->raiddestination, ' <span class="badge', ->raidplayers, '</spa</
			</di
		</di';
	}

}

