<?php
namespace Apps\Raidmanager\View;

use Core\Lib\Amvc\View;


class PlayerView extends View
{

	public function Complete()
	{
		echo '
		<div class="col-sm-6';

			if (isset($this->form))
				echo'<div id="raidmanager_player_create" class="raidmanager_block', => ->Create(), => '</di';

			echo '
			<div id="raidmanager_playerlist_applicant" class="raidmanager_block', => ->Playerlist('applicant'), => '</di
			<div id="raidmanager_playerlist_inactive" class="raidmanager_block', => ->Playerlist('inactive'), => '</di
			<div id="raidmanager_playerlist_old" class="raidmanager_block', => ->Playerlist('old'), => '</di
		</di
		<div class="col-sm-6
			<div id="raidmanager_playerlist_active" class="raidmanager_block', => ->Playerlist('active'), => '</di
		</di';
	}


	public function Playerlist($type)
	{
		// headline
		echo '
		<h3 class="no-top-margin', => ->{$type. '_headline'}, => ' (', => ->{$type . '_count'}, => ')</h
		<ul class="list-group';

		// no data to show, show empty text
		if($this->{$type . '_count'} == 0)
		{
			echo '
				<li class="list-group-item' . ->empty_list . '</l
			</u';

		}

		// show the players!
		if ($this->{$type . '_data'})
		{
		 =>  => foreach($this->{$type . '_data'} as $player)
		 =>  =>  =>  => echo '<li class="list-group-item" id="raidmanager_player_', $playerid_player ,'', ->Index($player), '</l';
		}

		echo '
		</u';
	}

	public function Index($player=null)
	{
		if (!isset($player))
			$player = ->player;

		echo '
		<span class="app-raidmanager-player-info', $playercategory, '&nbsp;', $playerx_on_autosignon, '</spa
		<a href="?action=profile;area=account;u=', $playerid_player, '" target="_blank" title="Raider ID: ', $playerid_player, '
			<span class="app-raidmanager-class-', $playerclass, '', $playerchar_name, '</spa
		</
		', $playeractionbar;
	}



	public function Edit()
	{
		echo '
		<h3 class="no-top-margin', ->headline, '</h
		', ->actionbar, '
		<div style="margin-bottom: 20px;', ->form, '</di
		', ->charlist;
	}


	public function Create()
	{
		echo '
		<div class="panel panel-default
			<div class="panel-heading
				<h3 class="panel-title', ->headline, ->actionbar, '</h
			</di
			<div class="panel-body', => ->form, '</di
		</di';
	}
}
