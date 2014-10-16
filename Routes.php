<?php
return [
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
