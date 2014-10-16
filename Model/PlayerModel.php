<?php
namespace Apps\Raidmanager\Model;

use Core\Lib\Amvc\Model;
use Core\Lib\Content\Html\Controls\Actionbar;

if (!defined('TEKFW'))
 =>  => die('Cannot run without TekFW framework...');

/**
 * Player model
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.d
 * @package TekFW
 * @subpackage App Raidmanager
 * @license MIT
 * @copyright 2014 by author
 */
final class PlayerModel extends Model
{
 =>  => protected $tbl = 'app_raidmanager_players';
 =>  => protected $alias = 'players';
 =>  => protected $pk = 'id_player';
 =>  => public $validate = array(
 =>  =>  =>  => 'id_player' => array(
 =>  =>  =>  =>  =>  => 'required',
 =>  =>  =>  =>  =>  => 'empty'
 =>  =>  =>  => ),
 =>  =>  =>  => 'autosignon' => array(
 =>  =>  =>  =>  =>  => 'required',
 =>  =>  =>  =>  =>  => array('range', array(0, 1, 'number'))
 =>  =>  =>  => ),
 =>  =>  =>  => 'state' => array(
 =>  =>  =>  =>  =>  => 'required',
 =>  =>  =>  =>  =>  => array('range', array(0, 3, 'number'))
 =>  =>  =>  => )
 =>  => );

 =>  => /**
 =>  =>  * Returns the data of a specific player.
 =>  =>  * @param int $id_player Id of player
 =>  =>  * @param boolean $use_actionbar Flag to add actionbar
 =>  =>  * @return Data|boolean
 =>  =>  */
 =>  => public function getPlayer($id_player, $use_actionbar = true)
 =>  => {
 =>  =>  =>  => // Query definition
 =>  =>  =>  => $query = array(
 =>  =>  =>  => 	'type' => 'row',
 =>  =>  =>  =>  =>  => 'field' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'players.id_player',
 =>  =>  =>  =>  =>  =>  =>  => 'players.autosignon',
 =>  =>  =>  =>  =>  =>  =>  => 'players.state',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.char_name',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.id_category',
 =>  =>  =>  =>  =>  =>  =>  => 'class.class',
 =>  =>  =>  =>  =>  =>  =>  => 'class.color',
 =>  =>  =>  =>  =>  =>  =>  => 'class.css',
 =>  =>  =>  =>  =>  =>  =>  => 'cats.category'
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'join' => array(
 =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_chars',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'players.id_player=chars.id_player',
 =>  =>  =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_classes',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'class',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.id_class=class.id_class'
 =>  =>  =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_categories',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'cats',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.id_category=cats.id_category'
 =>  =>  =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'filter' => 'chars.is_main=1 AND players.id_player={int:id_player}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_player' => $id_player
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => );

 =>  =>  =>  => // Define callbacks
 =>  =>  =>  => $callbacks = array('extendPlayer');

 =>  =>  =>  => if ($use_actionbar)
 =>  =>  =>  =>  =>  => $callbacks[] = 'addActionbar';

 =>  =>  =>  => return $this->read($query, $callbacks);
 =>  => }

 =>  => /**
 =>  =>  * Loads and returns all player with a specific playersate
 =>  =>  * @param int $state
 =>  =>  * @return boolean|array
 =>  =>  */
 =>  => public function getPlayerByState($state)
 =>  => {
 =>  =>  =>  => ->setFilter('state={int:state}');
 =>  =>  =>  => ->setParameter('state', $state);
 =>  =>  =>  => return $this->read('*');
 =>  => }

 =>  => /**
 =>  =>  * Loads and returns a playlist for a specific player type. When no players of this type found, the method will
 =>  =>  * return boolean false.
 =>  =>  * @param string $type
 =>  =>  * @return boolean|array
 =>  =>  */
 =>  => public function getPlayerlist($type)
 =>  => {
 =>  =>  =>  => $types = array(
 =>  =>  =>  =>  =>  => 'old' => 0,
 =>  =>  =>  =>  =>  => 'applicant' => 1,
 =>  =>  =>  =>  =>  => 'inactive' => 2,
 =>  =>  =>  =>  =>  => 'active' => 3
 =>  =>  =>  => );

 =>  =>  =>  => $query = array(
 =>  =>  =>  =>  =>  => 'type' => '*',
 =>  =>  =>  =>  =>  => 'field' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'players.id_player',
 =>  =>  =>  =>  =>  =>  =>  => 'players.autosignon',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.char_name',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.id_category',
 =>  =>  =>  =>  =>  =>  =>  => 'class.class',
 =>  =>  =>  =>  =>  =>  =>  => 'class.color',
 =>  =>  =>  =>  =>  =>  =>  => 'class.css',
 =>  =>  =>  =>  =>  =>  =>  => 'cats.category'
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'join' => array(
 =>  =>  =>  =>  =>  =>  =>  => array('app_raidmanager_chars', 'chars', 'INNER', 'players.id_player=chars.id_player'),
 =>  =>  =>  =>  =>  =>  =>  => array('app_raidmanager_classes', 'class', 'INNER', 'chars.id_class=class.id_class'),
 =>  =>  =>  =>  =>  =>  =>  => array('app_raidmanager_categories', 'cats', 'INNER', 'chars.id_category=cats.id_category'),
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'filter' => 'chars.is_main=1 AND state={int:state}',
 =>  =>  =>  =>  =>  => 'param' => array('state' => $types[$type]),
 =>  =>  =>  =>  =>  => 'order' => 'chars.char_name',
 =>  =>  =>  => );

 =>  =>  =>  => return $this->read($query, array(
 =>  =>  =>  =>  =>  => 'extendPlayer',
 =>  =>  =>  =>  =>  => 'addActionbar'
 =>  =>  =>  => ));
 =>  => }

 =>  => /**
 =>  =>  * Used for playerlist callbacks to add some statusinfos to the playerrecord
 =>  =>  */
 =>  => final protected function extendPlayer(&$player)
 =>  => {
 =>  =>  =>  => // a visual x if player is on autosignon
 =>  =>  =>  => $playerx_on_autosignon = $playerautosignon == 1 ? '<i class="fa fa-clock-o fa-fixed-width" title="' . $this->txt('raid_autosignon') . '</ ' : '';

 =>  =>  =>  => // translated category name
 =>  =>  =>  => $categories = array(
 =>  =>  =>  =>  =>  => 1 => array(
 =>  =>  =>  =>  =>  =>  =>  => 'tank',
 =>  =>  =>  =>  =>  =>  =>  => 'shield'
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 2 => array(
 =>  =>  =>  =>  =>  =>  =>  => 'damage',
 =>  =>  =>  =>  =>  =>  =>  => 'rocket'
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 3 => array(
 =>  =>  =>  =>  =>  =>  =>  => 'heal',
 =>  =>  =>  =>  =>  =>  =>  => 'medkit'
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => );

 =>  =>  =>  => $title = $this->txt('category_' . $categories[$playerid_category][0]);

 =>  =>  =>  => $playercategory = '<i class="fa fa-' . $categories[$playerid_category][1] . ' fa-fixed-width" title="' . $title . '</';

 =>  =>  =>  => return $player;
 =>  => }

 =>  => /**
 =>  =>  * Used for playerlist callbacks to add actionbars to a playerrecord.
 =>  =>  */
 =>  => final protected function addActionbar(&$player)
 =>  => {
 =>  =>  =>  => if ($this->checkAccess('raidmanager_perm_player'))
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => $actionbar = new Actionbar();

 =>  =>  =>  =>  =>  => // the edit button
 =>  =>  =>  =>  =>  => $actionbarcreateButton('edit', 'ajax', 'icon')->setRoute('raidmanager_player_edit', array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_player' => $playerid_player
 =>  =>  =>  =>  =>  => ));

 =>  =>  =>  =>  =>  => // the delete button
 =>  =>  =>  =>  =>  => $actionbarcreateButton('delete', 'ajax', 'icon')->setRoute('raidmanager_player_delete', array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_player' => $playerid_player
 =>  =>  =>  =>  =>  => ));

 =>  =>  =>  =>  =>  => $playeractionbar = $actionbarbuild();
 =>  =>  =>  => }

 =>  =>  =>  => return $player;
 =>  => }

 =>  => /**
 =>  =>  * Deletes a player completly from all raidmanager tables
 =>  =>  * @param int $id_player
 =>  =>  */
 =>  => public function deletePlayer($id_player)
 =>  => {
 =>  =>  =>  => // delete player data from this tables
 =>  =>  =>  => $models = array(
 =>  =>  =>  =>  =>  => 'Setlist',
 =>  =>  =>  =>  =>  => 'Comment',
 =>  =>  =>  =>  =>  => 'Subscription',
 =>  =>  =>  =>  =>  => 'Char'
 =>  =>  =>  => );

 =>  =>  =>  => foreach ( $models as $model_name )
 =>  =>  =>  =>  =>  => $this->getModel($model_name)delete(array(
 =>  =>  =>  =>  =>  => 	'filter' => 'id_player={int:id_player}',
 =>  =>  =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'id_player' => $id_player
 =>  =>  =>  =>  =>  =>  =>  => )
 =>  =>  =>  =>  =>  => ));

 =>  =>  =>  => // and finally delete the player self
 =>  =>  =>  => ->delete($id_player);
 =>  => }

 =>  => /**
 =>  =>  * Updates an existing player by using the data send from controller.
 =>  =>  * This method
 =>  =>  * takes care of state or autosignon changes and alters subscriptions or playerlists
 =>  =>  * accordingly.
 =>  =>  * @param Data $data Data send from controller
 =>  =>  */
 =>  => public function savePlayer($data)
 =>  => {
 =>  =>  =>  => // Attach data to model
 =>  =>  =>  => ->data = $data;

 =>  =>  =>  => // Validate userinput
 =>  =>  =>  => ->validate();

 =>  =>  =>  => // Any error?
 =>  =>  =>  => if ($this->hasErrors())
 =>  =>  =>  => 	return;

 =>  =>  =>  => // Init status flags
 =>  =>  =>  => $playerstate_changed = false;
 =>  =>  =>  => $signup_done = false;
 =>  =>  =>  => $autosignon_changed = false;

 =>  =>  =>  => // Autosign on can only be 1 or 0. All other then 0 is 1!
 =>  =>  =>  => if ($this->dataautosignon != 0)
 =>  =>  =>  =>  =>  => ->dataautosignon = 1;

 =>  =>  =>  => // Check 1: Did playerstate changed?
 =>  =>  =>  => // If a player state changed, it is important to change all raids where
 =>  =>  =>  => // the player is already subscribed.
 =>  =>  =>  => if ($this->datastate != ->datastate_compare)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // Flag this as changed playerdata
 =>  =>  =>  =>  =>  => $playerstate_changed = true;

 =>  =>  =>  =>  =>  => switch ($this->datastate)
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => // This player is active (state: 3)
 =>  =>  =>  =>  =>  =>  =>  => case 3 :
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => // Add subscription to all future raids
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $this->getModel('Subscription')->addPlayerToFutureSubs($this->dataid_player, ->dataautosignon);
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $this->getModel('Comment')deleteByPlayerAndState($this->dataid_player, array(1,2));
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $signup_done = true;
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => break;

 =>  =>  =>  =>  =>  =>  =>  => // All other than active (state: 0, 1 or 2)
 =>  =>  =>  =>  =>  =>  =>  => default :
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => // Set player on no ajax for all future raids
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $this->getModel('Subscription')deleteSubscriptionByPlayer($this->dataid_player);

 =>  =>  =>  =>  =>  =>  =>  =>  =>  => // Remove player from all setlists
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $this->getModel('Setlist')deletePlayerFromSetlist($this->dataid_player);

 =>  =>  =>  =>  =>  =>  =>  =>  =>  => // Remove all comments by player
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $this->getModel('Comment')deleteByPlayerAndState($this->dataid_player, array(1,2));
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => break;
 =>  =>  =>  =>  =>  => }
 =>  =>  =>  => }

 =>  =>  =>  => // Check 2: Has players autosignon state changed?
 =>  =>  =>  => if ($this->dataautosignon != ->dataautosignon_compare)
 =>  =>  =>  =>  =>  => $autosignon_changed = true;

 =>  =>  =>  =>  =>  => // After a change of autosignon it is important to update all future raids where this player maybe was set.
 =>  =>  =>  =>  =>  => // But we do not do this without care about the check 2 from above.
 =>  =>  =>  => if ($autosignon_changed && !$signup_done && ->datastate == 3 && $this->getModel('Raid')->getNumFutureRaids() 0)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => switch ($this->dataautosignon)
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => // Autosignon is off (0)
 =>  =>  =>  =>  =>  =>  =>  => case 0 :

 =>  =>  =>  =>  =>  =>  =>  =>  =>  => // Set player on no ajax for all future raids
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $this->getModel('Subscription')->setPlayerStateOnFutureSubs($this->dataid_player, 0);

 =>  =>  =>  =>  =>  =>  =>  =>  =>  => // Remove from all setlists of future raids
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $this->getModel('Setlist')deletePlayerFromFutureSetlist($this->dataid_player);

 =>  =>  =>  =>  =>  =>  =>  =>  =>  => // Remove all signon comments
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $this->getModel('Comment')deleteByPlayerAndState($this->dataid_player, array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => 1,
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => 2
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => ));

 =>  =>  =>  =>  =>  =>  =>  =>  =>  => break;

 =>  =>  =>  =>  =>  =>  =>  => case 1 :

 =>  =>  =>  =>  =>  =>  =>  =>  =>  => // Add subscription to all futur raids
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $this->getModel('Subscription')->setPlayerStateOnFutureSubs($this->dataid_player, 1);

 =>  =>  =>  =>  =>  =>  =>  =>  =>  => // Remove all resign comments
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $this->getModel('Comment')deleteByPlayerAndState($this->dataid_player, array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => 1,
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => 2
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => ));

 =>  =>  =>  =>  =>  =>  =>  =>  =>  => break;
 =>  =>  =>  =>  =>  => }
 =>  =>  =>  => }

 =>  =>  =>  => // Save playerdata only if something has been changed
 =>  =>  =>  => if ($playerstate_changed || $autosignon_changed)
 =>  =>  =>  =>  =>  => ->save();

 =>  =>  =>  => // We are done and do a refunc do display the changed data
 =>  =>  =>  => ->dataaction = $playerstate_changed ? 'Complete' : 'Index';
 =>  => }

 =>  => /**
 =>  =>  * Returns an array of useable playerstates.
 =>  =>  * @return array
 =>  =>  */
 =>  => public function getStateList()
 =>  => {
 =>  =>  =>  => return array(
 =>  =>  =>  =>  =>  => 0 => $this->txt('player_state_old'),
 =>  =>  =>  =>  =>  => 1 => $this->txt('player_state_applicant'),
 =>  =>  =>  =>  =>  => 2 => $this->txt('player_state_inactive'),
 =>  =>  =>  =>  =>  => 3 => $this->txt('player_state_active')
 =>  =>  =>  => );
 =>  => }

 =>  => /**
 =>  =>  * Returns an array of values for autosignon selection
 =>  =>  * @return array
 =>  =>  */
 =>  => public function getAutosignonList()
 =>  => {
 =>  =>  =>  => return array(
 =>  =>  =>  =>  =>  => 0 => $this->txt('no'),
 =>  =>  =>  =>  =>  => 1 => $this->txt('yes')
 =>  =>  =>  => );
 =>  => }

 =>  => /**
 =>  =>  * Creates the player account and the first char by using the data set in
 =>  =>  * the player creation form.
 =>  =>  * Checks for missing data and already used char name.
 =>  =>  * @param Data $data Data from the controller
 =>  =>  */
 =>  => public function createPlayer($data)
 =>  => {
 =>  =>  =>  => // Insert data into model
 =>  =>  =>  => ->setData($data);

 =>  =>  =>  => // Check for empty charname
 =>  =>  =>  => if (empty($this->datachar_name))
 =>  =>  =>  =>  =>  => ->addError('char_name', $this->txt('char_name_missing'));

 =>  =>  =>  => // Run validator manually because we do not use the save method for
 =>  =>  =>  => // playercreation (see insert() call below in this method) which means
 =>  =>  =>  => // the validator won't be called automatically
 =>  =>  =>  => ->validate();

 =>  =>  =>  => // No saving with errors present
 =>  =>  =>  => if ($this->hasErrors())
 =>  =>  =>  =>  =>  => return;

 =>  =>  =>  => // Flag this char to be mainchar
 =>  =>  =>  => ->datais_main = 1;

 =>  =>  =>  => // As we use the char creation from outside, there is no field for char
 =>  =>  =>  => // name comparision. If we do not set this field and value the name check
 =>  =>  =>  => // in chars model returns always true
 =>  =>  =>  => ->dataorg_char_name = '.';

 =>  =>  =>  => // Create an instance of the char model which we use for data validation
 =>  =>  =>  => // and creation of the first char
 =>  =>  =>  => $char_model = $this->getModel('Char');

 =>  =>  =>  => // Players can have multiple Chars. Here we create the players first char.
 =>  =>  =>  => $char_modelsaveChar($this->data);

 =>  =>  =>  => // Char model errors need to be integrated in this models errorlist
 =>  =>  =>  => if ($char_modelhasErrors())
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => foreach( $char_modelerrors as $fld => $error )
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => foreach ( $error as $msg )
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => ->addError($fld, $msg);
 =>  =>  =>  =>  =>  => }
 =>  =>  =>  => }

 =>  =>  =>  => // Any errors here that stop us?
 =>  =>  =>  => if ($this->hasErrors())
 =>  =>  =>  =>  =>  => return;

 =>  =>  =>  => // By default new players are inactive
 =>  =>  =>  => ->datastate = 2;

 =>  =>  =>  => // Uusing insert() method of model because we need to write the pk to
 =>  =>  =>  => // the table. This isn't possible with save() because a set pk
 =>  =>  =>  => // marks the data as an update.
 =>  =>  =>  => ->insert();
 =>  => }

 =>  => /**
 =>  =>  * Looks for active players.
 =>  =>  * Returns true when there are active players. Returns false on no active players.
 =>  =>  */
 =>  => public function hasActivePlayer()
 =>  => {
 =>  =>  =>  => ->read(array('type''key', 'filter''state=3'));
 =>  =>  =>  => return $this->hasData();
 =>  => }
}

