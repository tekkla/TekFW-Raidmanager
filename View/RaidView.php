<?php
namespace Apps\Raidmanager\View;


use Core\Lib\Amvc\View;

class RaidView extends View
{
	public function Complete()
	{
		echo'
		<div id="raidmanager_calendar" class="col-sm-6', ->calendar, '</di
		<div id="raidmanager_raid" class="col-sm-12', ->Index(), '</di';
	}


	public function Index()
	{
		echo'
		<div class="row
			<div class="col-sm-12
				<div id="raidmanager_infos', ->Infos(), '</di
			</di
		</di
		<div class="row
			<div class="col-md-6
				<div id="raidmanager_subscriptions', ->subscriptions, '</di
				<div id="raidmanager_comments	', ->comments. '</di
			</di
			<div class="col-md-6
				<div id="raidmanager_setups', ->setups, '</di
			</di
		</di';
	}

	/**
	 * Creates the basic raidinformations
	 *
	 * @return string $html Data to display
	 */
	public function Infos()
	{
		echo'
		<div class="panel panel-default
			<div class="panel-body
				<h4 class="no-top-margin', timeformat($this->datastarttime, true), '</h
				<h2 class="no-top-margin', ->datadestination .'</h';

				echo ->actionbar;

			if ($this->isVar('topic_url'))
				echo '<a href="', ->datatopic_url, '', $this->txt_topiclink, '</';

			if($this->dataspecials)
			{
				echo '
				<h', $this->txt_specials, '</h
				<', ->dataspecials, '</';
			}

			echo '
			</di
		</di';
	}

	public function Edit()
	{
		echo'
		<div class="panel panel-default
			<div class="panel-body
				<h3 id="ajax" class="no-top-margin', ->headline, ->actionbar, '</h
				', ->form, '
			</di
		</di';
	}

	public function Autoadd()
	{
		echo'
		<section id="raidmanager_errors
			<hError on AutoAdd Raids</h
			', implode('<b', ->errors), '
		</sectio';
	}
}
