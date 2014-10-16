<?php
// -------------------------------------------------------
// GLOBAL
// -------------------------------------------------------
return [

	'name' => 'Raidmanager',

	// an- u. abmelden
	'action_sub' => ' anmelden',
	'action_unsub' => ' abmelden',

	// -------------------------------------------------------
	// PERMISSIONS
	// -------------------------------------------------------
	'permissiongroup_raidmanager_classic_perm' => 'App: Raidmanager verwalten',
	'permissiongroup_simple_raidmanager_simple_perm' => 'App: Raidmanager verwalten',
	'permissionname_raidmanager_perm_config' => 'Konfiguration bearbeiten ',
	'permissionhelp_raidmanager_perm_config' => 'Erlaubt den Zugriff auf die Konfiguration des Raidmanagers.',
	'permissionname_raidmanager_perm_raid' => 'Raids bearbeiten ',
	'permissionhelp_raidmanager_perm_raid' => 'Gestattet das anlegen und ändern der Daten eines Raides.',
	'permissionname_raidmanager_perm_subs' => 'Anmeldungen verwalten',
	'permissionhelp_raidmanager_perm_subs' => 'Erlaubt Anmeldungen von Spieler in den jeweiligen Raids zu verändern.',
	'permissionname_raidmanager_perm_setup' => 'Setup verwalten',
	'permissionhelp_raidmanager_perm_setup' => 'Getattet die Basisinformationen eines Setups zu bearbeiten sowie neue Setups anzulegen.',
	'permissionname_raidmanager_perm_setlist' => 'Setlisten verwalten',
	'permissionhelp_raidmanager_perm_setlist' => 'Erlaubt das setzen und entfernen von Chars in den Setups der Raids.',
	'permissionname_raidmanager_perm_stats' => 'Statistiken einsehen',
	'permissionhelp_raidmanager_perm_stats' => 'Gestattet den Zugriff auf die statistischen Auswertungen',
	'permissionname_raidmanager_perm_profiles' => 'Spielerprofile einsehen',
	'permissionhelp_raidmanager_perm_profiles' => 'Gestattet es alle und nicht nur das eigene Spielerprofil einzusehen',
	'permissionname_raidmanager_perm_player' => 'Spieler bearbeiten',
	'permissionhelp_raidmanager_perm_player' => 'Erlaubt Spieler mit ihren Chars zu verwalten. Dazu gehört die Verwaltung der Main und Twinks, den Status der Spieler und deren Option zur Autoanmeldung.',

	// -------------------------------------------------------
	// MENU
	// -------------------------------------------------------
	'raids' => 'Raids',
	'playerlist' => 'Spieler',
	'stats' => 'Statistik',
	'autoadd' => 'Autoraid',

	// -------------------------------------------------------
	// HEADLINES
	// -------------------------------------------------------
	'headline' => 'Raidmanager',
	'headline_thisraid' => 'dieser Raid',
	'headline_playerlist' => 'Spielerliste',
	'headline_raidplanner' => 'Raidplaner',
	'headline_profile' => 'Profil',
	'headline_links' => 'Links',

	// -------------------------------------------------------
	// CATEGORIES
	// -------------------------------------------------------
	'category_tank' => 'Tank',
	'category_damage' => 'Schaden',
	'category_heal' => 'Heilung',

	// -------------------------------------------------------
	// Calendar
	// -------------------------------------------------------
	'calendar_current' => 'laufende Raids',
	'calendar_future' => 'kommende Raids',
	'calendar_recent' => 'alte Raids',
	'calendar_none' => 'keine Raids vorhanden',

	// -------------------------------------------------------
	// RAID
	// -------------------------------------------------------

	/* Display */
	'raid_headline' => 'Raidinfos',
	'raid_starttime' => 'Start',
	'raid_endtime' => 'Ende',
	'raid_update' => 'letztes Update',
	'raid_specials' => 'Hinweise',
	'raid_topiclink' => 'zum Diskussionstopic',

	/* Edit */
	'raid_headline_edit' => 'Raidinfos bearbeiten',
	'raid_headline_new' => 'neuer Raid',
	'raid_destination' => 'Ziel des Raids',
	'raid_datestart' => 'Datum, Start',
	'raid_dateend' => 'Datum, Ende',
	'raid_timestart' => 'Startzeit',
	'raid_timeend' => 'Ende gegen',
	'raid_rotapoints' => 'Rotationspunkte',
	'raid_raidweek' => 'Raidwoche',
	'raid_actual' => 'aktuell',
	'raid_autosignon' => 'Autoanmeldung',

	// --------------------------------------------------------
	// PLAYER
	// --------------------------------------------------------
	'subscription_headline' => 'Anmeldesituation',
	'subscription_resigned_headline' => 'abgemeldet',
	'subscription_noresponse_headline' => 'unbekannt',
	'subscription_enrolled_headline' => 'angemeldet',
	'subscription_noplayer' => 'Niemand vorhanden',

	'raid_availlist_headline' => 'Verf&uuml,gbare Spieler',
	'raid_availlist_nodata' => 'keine Spieler angemeldet',

	/* Spielerstatus für den Raid */
	'raid_subscriptionstate_enrolled' => 'Du bist bei diesem Raid angemeldet.',
	'raid_subscriptionstate_resigned' => 'Du bist bei diesem Raid nicht angemeldet.',
	'raid_subscriptionstate_noresponse' => 'Du bist bei diesem Raid weder ab- noch angemeldet.',

	'raid_signon_change' => 'Anmeldung &auml,ndern',
	'raid_signon_confirm' => 'Soll der Spieler wirklich angemeldet werden?',
	'raid_signon_title' => 'Spieler anmelden',
	'raid_signoff_confirm' => 'Soll der Spieler wirklich abgemeldet werden?',
	'raid_signoff_title' => 'Spieler abmelden',

	/* Autoraid */
	'raid_autoraid' => 'Autoerstellung',
	'autoraid_headline' => 'Autoraid wurde durchgef&uuml,hrt',
	'autoraid_raid_destination' => 'Raid',
	'autoraid_setup_title' => 'Autosetup #1',
	'autoraid_setup_description' => 'automatisch angelegt durch Autoraid',

	// -------------------------------------------------------
	// COMMENT
	// -------------------------------------------------------
	'comment_headline' => 'Kommentare',
	'comment_enroll' => 'anmelden',
	'comment_resign' => 'abmelden',
	'comment_empty' => 'Keine Kommentare vorhanden',
	'comment_comment' => 'Kommentar schreiben...',
	'comment_placeholder' => 'Deine Nachricht ...',

	// -------------------------------------------------------
	// SETUP
	// -------------------------------------------------------
	'setup_headline' => 'Setups',
	'setup_edit' => 'Setup bearbeiten',
	'setup_new' => 'Neues Setup',
	'setup_need_tank' => 'Anzahl Tank',
	'setup_need_damage' => 'Anzahl Schaden',
	'setup_need_heal' => 'Anzahl Heilung',
	'setup_setlist' => 'Aufstellung',
	'setup_notset' => 'Optionen',
	'setup_missing_rota' => 'Die Rotapunkte f&uuml,r dieses Setup fehlen!',
	'setup_rota' => 'R',
	'setup_noneset' => 'keine feste Aufstellung vorhanden',
	'setup_title' => 'Bezeichnung',
	'setup_description' => 'Beschreibung',
	'setup_points' => 'Punktwert',
	'setup_points_desc' => 'Wert in Punkten (z.B. je Farmboss 1 Pkt und Endboss 3 Pkt)',
	'setup_position' => 'Position',

	// -------------------------------------------------------
	// SETLIST
	// -------------------------------------------------------
	'setlist_headline' => 'Aufstellung',
	'setlist_headline_avail' => 'verf&uuml,gbar',
	'setlist_headline_set' => 'gesetzt',
	'setlist_unset' => ' aus Setup entfernen',
	'setlist_tank' => ' als Tank setzen',
	'setlist_damage' => 'als DD setzen',
	'setlist_heal' => 'als Heiler setzen',
	'setlist_none_set' => 'niemand gesetzt',
	'setlist_none_avail' => 'niemand verf&uuml,gbar',

	'setup_delete_last_existing' => 'Dies ist das einzige Setup f&uuml,r diesen Raid. Es darf nicht gel&ouml,scht werden!',

	// --------------------------------------------------------
	// PLAYER
	// --------------------------------------------------------

	/* List */
	'playerlist_headline' => 'Spielerverwaltung',
	'playerlist_headline_create' => 'Spieler anlegen',
	'playerlist_headline_active' => 'Aktive Spieler',
	'playerlist_headline_inactive' => 'Inaktive Spieler',
	'playerlist_headline_applicant' => 'Bewerber',
	'playerlist_headline_old' => 'Veraltete Spieler',
	'playerlist_empty' => 'Keine Spieler in dieser Gruppe.',

	/* Profile */
	'player_headline' => 'Spielerprofil',
	'player_member' => 'Member',
	'player_char_name' => 'Charname',
	'player_id_class' => 'Klasse',
	'player_id_category' => 'Rolle',
	'player_autosignon' => 'Autoanmeldung',
	'player_autosignon_on' => 'an',
	'player_autosignon_off' => 'aus',
	'player_active' => 'Aktiv',
	'player_activity' => 'Teilnahme',
	'player_activity_desc' => '',
	'player_pm' => 'Info PM',
	'player_pm_desc' => 'Spieler m&ouml,chte Info PMs dar&uuml,ber haben, wenn er gesetzt wird.',
	'player_create' => 'Neuer Spieler',
	'player_create_confirm' => 'Spieler mit den angegebenen Daten jetzt anlegen?',
	'player_edit' => 'Spielerdaten bearbeiten',
	'player_delete' => 'Spieler l&ouml,schen',
	'player_gsprofile' => 'Raidmanager Profil anzeigen',
	'player_smfprofile' => 'SMF Profil anzeigen',
	'player_calcindes' => 'Teilnahmeindex berechnen',
	'player_charlist' => 'Charakterliste anzeigen',
	'player_state' => 'Status',
	'player_state_old' => 'veraltet',
	'player_state_applicant' => 'Bewerber',
	'player_state_inactive' => 'inaktiver Spieler',
	'player_state_active' => 'aktiver Spieler',
	'player_smfuser' => 'SMF User',

	/* Charlist */
	'charlist_headline' => 'Charakterliste',
	'charlist_add' => 'neuen Charakter anlegen',

	/* Charprofile */
	'char_headline' => 'Chardaten',
	'char_char_name' => 'Charname',
	'char_race' => 'Rasse',
	'char_id_class' => 'Klasse',
	'char_id_category' => 'Rolle',
	'char_type' => 'Type',
	'char_is_main' => 'Mainchar',
	'char_is_main_desc' => 'Dies ist der Mainchar des Spielers!',
	'char_istwink' => 'Twink',
	'char_name_placeholder' => '<< Charnamen angeben>',
	'char_name_already_taken' => 'Charname ist bereits vergeben.',
	'char_name_missing' => 'Bitte einen Charakternamen angeben',
	'char_edit_headline' => 'Charakter bearbeiten',
	'char_add_headline' => 'Neuer Charakter',
	'char_mainchar_no_delete' => 'Der Mainchar eines Spielers kann so nicht gel&ouml,scht werden. Bitte erst einen anderen Mainchar bestimmen und dann erneut den L&ouml,schvorgang starten.',
	'char_mainchar' => 'Typ',

	// -------------------------------------------------------
	// STATS
	// -------------------------------------------------------
	'stats_headline' => 'Statistiken',
	'stats_first_raid' => 'erster Raid',
	'stats_last_raid' => 'letzter Raid',
	'stats_days_in_raid' => 'Tage im Raid',

	/* Subscriptions */
	'stats_headline_subs' => 'Anmeldungen',
	'stats_num_subs' => 'Angemeldet',
	'stats_num_unsubs' => 'Abgemeldet',
	'stats_subindex_head' => 'Beteiligung',
	'stats_subindex_30' => '30 Tage',
	'stats_subindex_60' => '60 Tage',
	'stats_subindex_90' => '90 Tage',

	/* Rota */
	'stats_rota_headline' => 'Rota',
	'stats_rota_days' => 'Tage',
	'stats_rota_num_setups' => 'Setups',
	'stats_rota_num_set' => 'dabei gesetzt',
	'stats_rota_num_avail' => 'auf Ersatz',
	'stats_rota_num_maxpoints' => 'erreichbare Punkte',
	'stats_rota_num_gotpoints' => 'erhaltene Punkte',

	// -------------------------------------------------------
	// CONFIG
	// -------------------------------------------------------

	/* Group: Display */
	'cfg_group_display' => 'Darstellung',
	'cfg_group_display_desc' => 'Einstellungen zur optischen Darstellung des Raidmanager',
	'cfg_color_style' => 'Farbstil',
	'cfg_color_style_desc' => 'Hier den Namen für den zu verwendenden Farbstil CSS Datei eingeben. Diese Anwendung kann durch verschiedne Farbstile an das genutzte Theme gezielt angepasst werden. Farbstile müssen im App CSS Verzeichnis als normale CSS Datei gespeichert sein.',
	'cfg_datepicker_format' => 'Format Datumsauswahl',
	'cfg_datepicker_format_desc' => 'Betrifft die Datumwahl bei der Raidbearbeitung. Standardwert ist das deutsche Format(dd.mm.yy). Alternativ kann man auch das amerikanische Format wählen.',
	'cfg_date_format' => 'Format Datumanzeige',
	'cfg_date_format_desc' => 'Format welches bei der Darstellung von Datumsangaben verwendet werden soll.',
	'cfg_num_list_future_raids' => 'kommende Raids',
	'cfg_num_list_future_raids_desc' => 'Anzahl an kommenden Raids, die in der Raidliste angezeigt werden sollen.',
	'cfg_num_list_recent_raids' => 'vergangener Raids',
	'cfg_num_list_recent_raids_desc' => 'Anzahl an vergangenen Raids, die in der Raidliste angezeigt werden sollen.',

	/* Group: Raid */
	'cfg_group_raid' => 'Raid',
	'cfg_raid_autosignon' => 'Autoanmeldung',
	'cfg_raid_autosignon_desc' => 'Automatisches Anmelden von Spielern bei neuen Raids. Dies betrifft alle Spieler, die auf Autoanmeldung gestellt sind.',
	'cfg_raid_new_days_ahead' => 'Tage voraus',
	'cfg_raid_new_days_ahead_desc' => 'Anzahl an Tagen, die vorausgehend eingehalten werden sollen. Die Differenz zwischen vorhandenen Raidtagen und diesem Wert wird als neue Raids automatisch angelegt.',
	'cfg_raid_days' => 'Raidtage',
	'cfg_raid_days_desc' => 'Für die ausgewählten Tage werden automatisch neue Raids angelegt, so die Anzahl kommender Raids die gewünschte Menge unterschreitet.',
	'cfg_raid_destination' => 'Raidziel',
	'cfg_raid_destination_desc' => 'Wird bei der automatischen Raiderstellung als Raidziel eingetragen.',
	'cfg_raid_specials' => 'Hinweise',
	'cfg_raid_specials_desc' => 'Raidhinweise, die bei jedem neuen Raid automatisch mit angegeben werden sollen.',
	'cfg_raid_time_start' => 'Startzeit',
	'cfg_raid_time_start_desc' => 'Uhrzeit zu der die Raids beginnen. Die Zeitangabe muss das Format hh::ss haben.',
	'cfg_raid_duration' => 'Dauer',
	'cfg_raid_duration_desc' => 'Dauer des Raides in Minuten. Dieser Wert wird bei der automatischen Raiderstellung als Wert für die Berechnung der Raidendzeit verwendet.',
	'cfg_raid_weekday_start' => 'Wochentag',
	'cfg_raid_weekday_start_desc' => 'Tag der Woche, an dem der die Raidwoche beginnt (0=Sonntag, 6=Samstag). Bei WoW üblicherweise 2 für Dienstag oder 3 für Mittwoch.',

	/* Group: Setup */
	'cfg_group_setup' => 'Setup',
	'cfg_setup_title' => 'Setupname',
	'cfg_setup_title_desc' => 'Diese Bezeichnung wird bei der automatischen Raiderstellung für das erste Setup gewählt.',
	'cfg_setup_notes' => 'Hinweise',
	'cfg_setup_notes_desc' => 'Diese Hinweise werden bei der automatischen Raiderstellung für das erste Setup eingetragen.',
	'cfg_setup_tank' => 'Tank',
	'cfg_setup_tank_desc' => 'Anzahl an Tanks für neue Setups',
	'cfg_setup_damage' => 'Schaden',
	'cfg_setup_damage_desc' => 'Anzahl an Damagedealern für neue Setups',
	'cfg_setup_heal' => 'Heiler',
	'cfg_setup_heal_desc' => 'Anzahl an Heilern für neue Setups',

	/* Group: Rotation */
	'cfg_group_rotation' => 'Rotation',
	'cfg_rotation_away_multiplicator' => 'Abwesenheitsmultiplikator',
	'cfg_rotation_away_multiplicator_desc' => 'Wird bei der Berechnung der Rotation als multiplikator auf Setuppunkte angewendet.',
	'cfg_rotation_period' => 'Zeitraum',
	'cfg_rotation_period_desc' => 'Der für die Berechnung der Rotation zu berücksichtigende Zeitraum in Raidtagen.',

	/* Group Stats */
	'cfg_group_stats' => 'Statistik',
	'cfg_wanted_subindex' => 'Anmeldequote',
	'cfg_wanted_subindex_desc' => 'Wert der gewünschten Anmeldequote in Prozent. Dieser wird bei der Darstellung der Spielerstatisktik genutzt.',

	/* Group: Calendar */
	'cfg_group_raidlist' => 'Raidlisten',

	/* Group: Forum */
	'cfg_group_forum' => 'Forum',
	'cfg_use_forum' => 'Topic erstellen',
	'cfg_use_forum_desc' => 'Wenn aktiviert, dann wird für jeden neuen Raid ein Topic im ausgewählten Board gelegt.',
	'cfg_topic_board' => 'Boardauswahl',
	'cfg_topic_board_desc' => 'Das Board, in dem das Raidtopic erstellt werden soll. Wenn das gewünschte Board noch nich existiert, dann <a href="' . BASEURL . '?action=admin,area=manageboards,sa=mainhier anlegen</ und die Konfiguration erneut aufrufen.',
	'cfg_topic_intro' => 'Topicintro',
	'cfg_topic_intro_desc' => 'Dieser Text wird als automatisches Intro für jedes neue Raidtopic eingefügt. Der Standartwert für dieses Feld ist in der jeweiligen Sprachdatei hinterlegt.',
	'raid_topic_text' => 'Dieses Topic wurde als Basis für Diskussionen rund um den zugehörigen Raid angelegt',
	'cfg_use_calendar' => 'Kalendereintrag',
	'cfg_use_calendar_desc' => 'Wenn aktiviert, dann wird zusätzlich zum Topic ein Eintrag in den SMF Kalender vorgenommen. (setzt "Topic erstellen" voraus)',

	// -------------------------------------------------------------------
	// CLASSES
	// -------------------------------------------------------------------

	/* Warrior */
	'class_warrior' => 'Krieger',
	'class_warrior_fury' => 'Furor',
	'class_warrior_arms' => 'Waffen',
	'class_warrior_protection' => 'Schutz',

	/* Paladin */
	'class_paladin' => 'Paladin',
	'class_paladin_holy' => 'Heilig',
	'class_paladin_protection' => 'Schutz',
	'class_paladin_retribution' => 'Vergeltung',

	/* Druid */
	'class_druid' => 'Druide',
	'class_druid_balance' => 'Gleichgewicht',
	'class_druid_feral' => 'Wilder Kampf',
	'class_druid_restoration' => 'Wiederherstellung',

	/* Hunter */
	'class_hunter' => 'J&auml,ger',
	'class_hunter_beatmaster' => 'Tierherrschaft',
	'class_hunter_marksman' => 'Treffsicherheit',
	'class_hunter_survival' => 'Überleben',

	/* Warlock */
	'class_warlock' => 'Hexenmeister',
	'class_warlock_demonology' => 'D&auml,monologie',
	'class_warlock_affliction' => 'Gebrechen => ',
	'class_warlock_destruction' => 'Zerst&ouml,rung',

	/* Mage */
	'class_mage' => 'Magier',
	'class_mage_frost' => 'Frost',
	'class_mage_fire' => 'Feuer',
	'class_mage_arcane' => 'Arkan',

	/* Priest */
	'class_priest' => 'Priester',
	'class_priest_discipline' => 'Disziplin',
	'class_priest_holy' => 'Heilig',
	'class_priest_shadow' => 'Schatten',

	/* Shaman */
	'class_shaman' => 'Schamane',
	'class_shaman_elemental' => 'Elementar',
	'class_shaman_enhancement' => 'Verst&auml,rkung',
	'class_shaman_restoration' => 'Wiederherstellung',

	/* Rogue */
	'class_rogue' => 'Schurke',
	'class_rogue_assassination' => 'Meucheln',
	'class_rogue_combat' => 'Kampf',
	'class_rogue_subtlety' => 'T&auml,uschung',

	/* Deathknight */
	'class_deathknight' => 'Todesritter',
	'class_deathknight_blood' => 'Blut',
	'class_deathknight_unholy' => 'Unheilig',
	'class_deathknight_frost' => 'Frost',

	/* Monk */
	'class_monk' => 'M&ouml,nch',
	'class_monk_windwaker' => 'Windwalker',
	'class_monk_brewmaster' => 'Brewmaster',
	'class_monk_mistweaver' => 'Mistweaver',

	// -------------------------------------------------------
	// ERRORS
	// -------------------------------------------------------
	'raid_start_after_end' => 'Der Raidstart darf nicht nach dem Raidende liegen.',
	'raid_end_before_start' => 'Das Raidende darf nicht vor dem Raidstart liegen.'
];
