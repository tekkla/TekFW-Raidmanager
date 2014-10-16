<?php
namespace Apps\Raidmanager\View;

use Core\Lib\Amvc\View;

class SetlistView extends View
{
	public function Complete()
	{
		$this->Index();
		$this->Waitlist();
	}

	public function Index()
	{
		echo '
		<div class="clearfix
			<div class="app-raidmanager-setlist-tank
				<h<stron', ->headline_tank, '</stron</h
				', ->createSetlist('tank'), '
			</di
			<div class="app-raidmanager-setlist-damage
				<h<stron', ->headline_damage, '</stron</h
				', ->createSetlist('damage'), '
			</di
			<div class="app-raidmanager-setlist-heal
				<h<stron', ->headline_heal, '</stron</h
				', ->createSetlist('heal'), '
			</di
		</di';
	}


	public function Waitlist()
	{
		if ($this->count == 0)
			return;

		echo '
		<div class="row
			<div class="app-raidmanager-waitlist col-sm-12
				<<stron', ->notset, ' (', ->availlistcount() , '):</stron ';

				foreach ($this->availlist as $char)
					echo '<span class="app-raidmanager-class-' . $charclass . '' . $charchar_name . '</spa ';

				echo '
				</
			</di
		</di';
	}

	public function Availlist()
	{
		echo '
		<h', ->notset, '</h
		<div class="clearfix
			<div class="raidmanager_waitlist_tank
				', ->createWaitlist('tank'), '
			</di
			<div class="cf raidmanager_waitlist_damage
				', ->createWaitlist('damage'), '
			</di
			<div class="cf raidmanager_waitlist_heal
				', ->createWaitlist('heal'), '
			</di
		</di';
	}

	private function createSetlist($category)
	{
		if (isset($this->setlist{$category}))
		{
			echo '
			<ul class="list-unstyled';

			foreach ($this->setlist{$category} as $char)
				echo '
				<li class="app-raidmanager-list-item
					<span class="app-raidmanager-class-', $charclass, '', $charchar_name, '</spa
				</l';

			echo '
			</u';
		}
		else
		{
			echo '<', ->noneset, '</';
		}
	}

	private function createWaitlist($category)
	{
		if (isset($this->availlist{$category}))
		{
			echo '
			<ul class="list-inline app-raidmanager-waitlist-', $category, '';

			foreach ($this->availlist{$category} as $char)
				echo '
				<l
					<span class="app-raidmanager-class-', $charclass, '', $charchar_name, '</spa
				</l';

			echo '
			</u';
		}
	}

	function Edit()
	{
		echo '
		<div class="panel panel-default
			<div class="panel-body
				<h3 class="raidmanager_headline raidmanager_underline no-top-margin', ->headline, ->actionbar, '</h';

			$categories = array('tank','damage','heal');

			foreach ($categories as $category)
			{
				echo '
				<h4 class="', ->{'headline_' . $category}, '</h
				<div class="row
					<div class="col-sm-6
					', ->createSelection('set', $category), '
					</di
					<div class="col-sm-6
					', ->createSelection('avail', $category), '
					</di
				</di';
			}

			echo '
			</di
		</di';
	}

	private function createSelection($side, $category)
	{
		if($this->{$side . '_'. $category})
		{
			foreach($this->{$side . '_'. $category} as $player)
			{
				echo '
				<div class="app-raidmanager-setlist-player app-raidmanager-class-', $playerclass, '', $playerchar_name, $playeractionbar, '</di';

			}
		}
		else
			echo '<', ->{'none_' . $side} .'</';
	}
}

