<?php
namespace Apps\Raidmanager;

use Core\Lib\Amvc\App;

/**
 * Main app class of Raidmanager app
 *
 * @author Michael Zorn (tekkla@tekkla.de)
 * @copyright 2014
 */
final class Raidmanager extends App
{

	// Uses language system
	protected $language = true;

	// Has css file
	protected $css_file = true;

	// Has js file
	protected $js_file = true;

	// Apps default config
	protected $config = [

		// group: raid
		'raid_destination' => [
			'group' => 'raid',
			'default' => 'New raid',
			'control' => [
				'text',
				[
					'size' => 50
				]
			],
			'validate' => [
				'required',
				'empty'
			]
		],
		'raid_specials' => [
			'group' => 'raid',
			'default' => '',
			'control' => [
				'textarea',
				[
					'cols' => 50,
					'rows' => 5
				]
			]
		],
		'raid_autosignon' => [
			'group' => 'raid',
			'default' => 1,
			'control' => 'switch'
		],
		'raid_weekday_start' => [
			'group' => 'raid',
			'default' => 3,
			'control' => [
				'number',
				[
					'min' => 0,
					'max' => 6
				]
			],
			'validate' => [
				'required',
				'int',
				[
					'range',
					[
						0,
						6
					]
				]
			]
		],
		'raid_new_days_ahead' => [
			'group' => 'raid',
			'default' => 5,
			'control' => [
				'number',
				[
					'min' => 1
				]
			],
			'validate' => [
				'required',
				[
					'min',
					1
				]
			]
		],
		'raid_days' => [
			'group' => 'raid',
			'control' => 'optiongroup',
			'data' => [
				'model',
				'Raidmanager::Calendar::getDays'
			]
		],
		'raid_time_start' => [
			'group' => 'raid',
			'default' => '20:15',
			'control' => 'time-24',
			'validate' => [
				'required',
				'time24'
			]
		],
		'raid_duration' => [
			'group' => 'raid',
			'default' => 180,
			'control' => [
				'number',
				[
					'min' => 1,
					'max' => 1440
				]
			],
			'validate' => [
				'required',
				'int',
				[
					'min',
					1
				]
			]
		],

		// group: setup
		'setup_title' => [
			'group' => 'setup',
			'default' => 'Autosetup',
			'control' => [
				'text',
				[
					'size' => 50
				]
			],
			'validate' => [
				'required',
				'empty'
			]
		],
		'setup_notes' => [
			'group' => 'setup',
			'default' => null,
			'control' => [
				'textarea',
				[
					'rows' => 5,
					'cols' => 50
				]
			]
		],
		'setup_tank' => [
			'group' => 'setup',
			'default' => 2,
			'control' => [
				'number',
				[
					'min' => 0,
					'max' => 100,
					'size' => 4
				]
			],
			'validate' => [
				'blank',
				'int',
				[
					'range',
					[
						0,
						100
					]
				]
			]
		],
		'setup_damage' => [
			'group' => 'setup',
			'default' => 6,
			'control' => [
				'number',
				[
					'min' => 0,
					'max' => 100,
					'size' => 4
				]
			],
			'validate' => [
				'blank',
				'int',
				[
					'range',
					[
						0,
						100
					]
				]
			]
		],
		'setup_heal' => [
			'group' => 'setup',
			'default' => 2,
			'control' => [
				'number',
				[
					'min' => 0,
					'max' => 100,
					'size' => 4
				]
			],
			'validate' => [
				'blank',
				'int',
				[
					'range',
					[
						0,
						100
					]
				]
			]
		],

		// group calendar
		'num_list_future_raids' => [
			'group' => 'raidlist',
			'default' => 10,
			'control' => [
				'number',
				[
					'min' => 1,
					'max' => 30
				]
			],
			'validate' => [
				'required',
				[
					'range',
					[
						1,
						30
					]
				]
			],
			'open' => true
		],
		'num_list_recent_raids' => [
			'group' => 'raidlist',
			'default' => 10,
			'control' => [
				'number',
				[
					'min' => 1,
					'max' => 30
				]
			],
			'validate' => [
				'required',
				[
					'range',
					[
						1,
						30
					]
				]
			],
			'open' => true
		],

		// forum topics
		'use_forum' => [
			'group' => 'forum',
			'default' => 0,
			'control' => 'switch'
		],
		'topic_board' => [
			'group' => 'forum',
			'control' => 'select',
			'data' => [
				'model',
				'Forum::Board::getBoardlist'
			]
		],
		'topic_intro' => [
			'group' => 'forum',
			'control' => [
				'textarea',
				[
					'cols' => 50,
					'rows' => 5
				]
			]
		],
		'use_calendar' => [
			'group' => 'forum',
			'default' => 0,
			'control' => 'switch'
		]
	];

	// Apps routes
	protected $routes = [
		[
			'name' => 'raid_index',
			'route' => '/?',
			'ctrl' => 'raid',
			'action' => 'complete'
		],
		[
			'name' => 'raid_start',
			'route' => '/raid',
			'ctrl' => 'raid',
			'action' => 'complete'
		],
		[
			'name' => 'raid_selected',
			'route' => '/raid/[i:id_raid]',
			'ctrl' => 'raid',
			'action' => 'complete'
		],
		[
			'name' => 'raid_data',
			'route' => '/raid/index/[i:id_raid]',
			'ctrl' => 'raid',
			'action' => 'index'
		],
		[
			'name' => 'raid_add',
			'method' => 'GET|POST',
			'route' => '/raid/add/[i:back_to]?',
			'ctrl' => 'raid',
			'action' => 'edit'
		],
		[
			'name' => 'raid_edit',
			'method' => 'GET|POST',
			'route' => '/raid/edit/[i:id_raid]/[i:back_to]',
			'ctrl' => 'raid',
			'action' => 'edit'
		],
		[
			'name' => 'raid_infos',
			'route' => '/raid/infos/[i:id_raid]',
			'ctrl' => 'raid',
			'action' => 'infos'
		],
		[
			'name' => 'raid_autoadd',
			'route' => '/raid/autoadd',
			'ctrl' => 'raid',
			'action' => 'autoadd'
		],
		[
			'name' => 'raid_delete',
			'route' => '/raid/delete/[i:id_raid]',
			'ctrl' => 'raid',
			'action' => 'delete'
		],
		[
			'name' => 'subscription_index',
			'route' => '/raid/subscription/[i:id_raid]',
			'ctrl' => 'subscription',
			'action' => 'index'
		],
		[
			'name' => 'subscription_edit',
			'route' => '/raid/subscription/edit/[i:id_raid]',
			'ctrl' => 'subscription',
			'action' => 'edit'
		],
		[
			'name' => 'subscription_enrollform',
			'method' => 'GET|POST',
			'route' => '/raid/subscription/enrollform/[i:id_raid]/[i:id_subscription]/[i:id_player]/[i:state]/[a:from]',
			'ctrl' => 'subscription',
			'action' => 'enrollform'
		],
		[
			'name' => 'subscription_save',
			'method' => 'POST',
			'route' => '/raid/subscription/save/[a:from]/[i:id_raid]',
			'ctrl' => 'subscription',
			'action' => 'save'
		],
		[
			'name' => 'comment_index',
			'route' => '/raid/comment/index/[i:id_raid]',
			'ctrl' => 'comment',
			'action' => 'index'
		],
		[
			'name' => 'comment_delete',
			'route' => '/raid/comment/delete/[i:id_raid]/[i:id_comment]',
			'ctrl' => 'comment',
			'action' => 'delete'
		],
		[
			'name' => 'setup_index',
			'route' => '/raid/setup/index/[i:id_setup]',
			'ctrl' => 'setup',
			'action' => 'index'
		],
		[
			'name' => 'setup_complete',
			'route' => '/raid/setup/complete/[i:id_raid]',
			'ctrl' => 'setup',
			'action' => 'complete'
		],
		[
			'name' => 'setup_add',
			'method' => 'GET|POST',
			'route' => '/raid/setup/add/[i:id_raid]/[i:back_to]',
			'ctrl' => 'setup',
			'action' => 'edit'
		],
		[
			'name' => 'setup_edit',
			'method' => 'GET|POST',
			'route' => '/raid/setup/edit/[i:id_setup]/[i:id_raid]/[i:back_to]',
			'ctrl' => 'setup',
			'action' => 'edit'
		],
		[
			'name' => 'setup_save',
			'method' => 'POST',
			'route' => '/raid/setup/save/[i:id_raid]/[i:back_to]',
			'ctrl' => 'setup',
			'action' => 'save'
		],
		[
			'name' => 'setup_delete',
			'route' => '/raid/setup/delete/[i:id_setup]/[i:id_raid]',
			'ctrl' => 'setup',
			'action' => 'delete'
		],
		[
			'name' => 'setlist_edit',
			'route' => '/raid/setlist/edit/[i:id_raid]/[i:id_setup]',
			'ctrl' => 'setlist',
			'action' => 'edit'
		],
		[
			'name' => 'setlist_set',
			'route' => '/raid/setlist/set/[i:id_setup]/[i:id_char]/[i:id_category]',
			'ctrl' => 'setlist',
			'action' => 'set_player'
		],
		[
			'name' => 'setlist_switch',
			'route' => '/raid/setlist/switch/[i:id_setlist]/[i:id_category]',
			'ctrl' => 'setlist',
			'action' => 'switch_player'
		],
		[
			'name' => 'setlist_unset',
			'route' => '/raid/setlist/unset/[i:id_setlist]',
			'ctrl' => 'setlist',
			'action' => 'unset_player'
		],
		[
			'name' => 'setlist_save',
			'route' => '/raid/setlist/save/[i:id_setup]/[i:id_char]/[i:id_player]/[i:id_setlist]/[i:set_as]/[i:set_from]',
			'ctrl' => 'setlist',
			'action' => 'save'
		],
		[
			'name' => 'player_start',
			'route' => '/player',
			'ctrl' => 'player',
			'action' => 'complete'
		],
		[
			'name' => 'player_index',
			'route' => '/player/[i:id_player]',
			'ctrl' => 'player',
			'action' => 'index'
		],
		[
			'name' => 'player_edit',
			'method' => 'GET|POST',
			'route' => '/player/edit/[i:id_player]',
			'ctrl' => 'player',
			'action' => 'edit'
		],
		[
			'name' => 'player_delete',
			'route' => '/player/delete/[i:id_player]',
			'ctrl' => 'player',
			'action' => 'delete'
		],
		[
			'name' => 'player_add',
			'method' => 'POST',
			'route' => '/player/add',
			'ctrl' => 'player',
			'action' => 'create'
		],
		[
			'name' => 'char_list',
			'route' => '/charlist/[i:id_player]',
			'ctrl' => 'char',
			'action' => 'charlist'
		],
		[
			'name' => 'char_add',
			'method' => 'GET|POST',
			'route' => '/char/add/[i:id_player]',
			'ctrl' => 'char',
			'action' => 'edit'
		],
		[
			'name' => 'char_edit',
			'method' => 'GET|POST',
			'route' => '/char/edit/[i:id_player]/[i:id_char]?',
			'ctrl' => 'char',
			'action' => 'edit'
		],
		[
			'name' => 'char_delete',
			'route' => '/char/delete/[i:id_char]/[i:id_player]',
			'ctrl' => 'char',
			'action' => 'delete'
		],
		[
			'name' => 'reset',
			'route' => '/reset',
			'ctrl' => 'raid',
			'action' => 'reset'
		]
	];

	// Apps permissions
	protected $permissions = [
		'manage_config', // access to config
		'manage_raid', // manage raidinfos
		'manage_subs', // manage player subscriptions
		'manage_setup', // manage setup infos
		'manage_setlist', // manage setlists
		'manage_player', // manage player roster
		'manage_stats', // see stats
		'manage_profiles'
	] // see all profiles
;

	/**
	 * To show at content start
	 */
	public function onBefore()
	{
		$html = '
		<h1>Raidmanager</h1>
		<div id="raidmanager" class="row">';

		return $html;
	}

	/**
	 * To show at content end
	 *
	 * @return string
	 */
	public function onAfter()
	{
		$html = '
		</div>';

		return $html;
	}

	/*
	 * Creates the arrayelements of Raidmanager menu.
	 */
	public function addMenuButtons(&$menu_buttons = array())
	{
		// Without general access no menu will be created
		if (! $this->generalAccess())
			return $menu_buttons;

			// User has general access so lets see what we have for him.
		$buttons = [];

		// Try to load comming raids
		$calendar = $this->getModel('Calendar')->getMenu();

		// Add raids button with raids when calendar is not false
		if ($calendar) {
			$buttons['raidmanager_raid_head'] = array(
				'title' => $this->txt('raids'),
				'show' => true,
				'href' => Url::getNamedRouteUrl('raidmanager_raid_start'),
				'sub_buttons' => $calendar
			);
		} else {
			// Otherwise check for raidadmin rights and active players to add autoraid button
			if ($this->checkAccess('raidmanager_perm_raid') && $this->getModel('Player')->hasActivePlayer()) {
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
				'href' => Url::getNamedRouteUrl('admin_app_config', array(
					'app_name' => 'raidmanager'
				)),
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
	 *
	 * @return bool
	 */
	public function generalAccess()
	{
		// User logged in?
		if (User::isLogged()) {
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

