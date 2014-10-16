<?php


return [

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