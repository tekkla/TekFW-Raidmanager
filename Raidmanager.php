<?php
namespace Apps\Raidmanager;

use Core\Lib\Url;
use Core\Lib\Amvc\App;
use Core\Lib\User;

if (!defined('TEKFW'))
	die('Cannot run without TekFW framework...');

/**
 * Main app class of Raidmanager app
 * @author Michael Zorn (tekkla@tekkla.de)
 * @copyright 2014
 */
final class Raidmanager extends App
{
	/**
	 * To show at content start
	 */
	public function onBefore()
	{
		$html = '
		<hRaidmanager</h
		<div id="raidmanager" class="row';

		return $html;
	}

	/**
	 * To show at content end
	 * @return string
	 */
	public function onAfter()
	{
		$html = '
		</di';

		return $html;
	}

	/*
	 * Creates the arrayelements of Raidmanager menu.
	 */
	public function addMenuButtons(&$menu_buttons=array())
	{
		// Without general access no menu will be created
		if (!$this->generalAccess())
			return $menu_buttons;

		// User has general access so lets see what we have for him.
		$buttons = [];

		// Try to load comming raids
		$calendar = $this->getModel('Calendar')->getMenu();

		// Add raids button with raids when calendar is not false
		if ($calendar)
		{
			$buttons['raidmanager_raid_head'] = array(
				'title' => $this->txt('raids'),
				'show' => true,
				'href' => Url::getNamedRouteUrl('raidmanager_raid_start'),
				'sub_buttons' => $calendar
			);
		}
		else
		{
			// Otherwise check for raidadmin rights and active players to add autoraid button
			if ($this->checkAccess('raidmanager_perm_raid') && $this->getModel('Player')->hasActivePlayer())
			{
				$buttons['raidmanager_menu_raid_autoadd'] = array(
					'title' => $this->txt('raid_autoraid'),
					'href' => Url::getNamedRouteUrl('raidmanager_raid_autoadd'),
					'show' => true,
					'sub_buttons' => array()
				);
			}
		}

		// Add rest of buttons
		$buttons += array(
			'raidmanager_playerlist' => array(
				'title' => $this->txt('playerlist'),
				'href' => Url::getNamedRouteUrl('raidmanager_player_start'),
				'show' => $this->checkAccess('raidmanager_perm_player'),
				'sub_buttons' => array()
			),
			'raidmanager_config' => array(
				'title' => $this->txt('config'),
				'href' => Url::getNamedRouteUrl('admin_app_config', array('app_name' => 'raidmanager')),
				'show' => $this->checkAccess('raidmanager_perm_config'),
				'sub_buttons' => array()
			)
		);

		// The Raidmanager menubutton will only be shown to users if the have an active char
		$menu_buttons['raidmanager'] = array(
			'title' => 'Raidmanager',
			'href' => '#',
			'show' => $this->generalAccess(),
			'sub_buttons' => $buttons,
			'noslice' => true
		);

		return $menu_buttons;
	}

	/**
	 * Raidmanger specific method to check genereal access on raidmanager.
	 * This method checks for active chars of an user. Without a char won't
	 * see the raidmanager.
	 * @return bool
	 */
	public function generalAccess()
	{
		// User logged in?
		if (User::isLogged())
		{
			// If user is an admin => grant access
			if ($this->user->isAdmin())
				return true;

			// All other will be checked for existing playerprofile
			$query = array(
				'type' => 'val',
				'field' => 'players.state',
				'filter' => 'players.id_player={int:id_user}',
				'param' => array(
					'id_user' => User::getId()
				)
			);

			if ($this->getModel('Player')->read($query) == 3)
				return true;
		}

		return false;
	}
}

