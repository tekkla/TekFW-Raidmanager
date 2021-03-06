<?php
namespace Apps\Raidmanager\Model;

use Core\Lib\Amvc\Model;
use Core\Lib\Error;
use Core\Lib\User;
use Core\Lib\Data\Data;
use Core\Lib\Content\Html\Controls\UiButton;

if (!defined('TEKFW'))
 =>  => die('Cannot run without TekFW framework...');

/**
 * Subscription Model
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.d
 * @package Raidmanager
 * @subpackage Model
 * @license MIT
 * @copyright 2014 by author
 */
final class SubscriptionModel extends Model
{
 =>  => protected $tbl = 'app_raidmanager_subscriptions';
 =>  => protected $alias = 'subs';
 =>  => protected $pk = 'id_subscription';
 =>  => protected $validate = array(
 =>  =>  =>  => 'msg' => array(
 =>  =>  =>  =>  =>  => 'empty',
 =>  =>  =>  =>  =>  => array('range', array(10, 100))
 =>  =>  =>  => )
 =>  => );

 =>  => /**
 =>  =>  * Returns the enrollstate of the current player on a specified raid
 =>  =>  * @param int $id_raid <ID of the raid to check for enrollstate</
 =>  =>  */
 =>  => public function getEnrollstateOnRaid($id_raid, $id_player)
 =>  => {
 =>  =>  =>  => ->setField('state');
 =>  =>  =>  => ->setFilter('id_raid={int:id_raid} AND id_player={int:id_player}');
 =>  =>  =>  => ->setParameter(array(
 =>  =>  =>  =>  =>  => 'id_raid' => $id_raid,
 =>  =>  =>  =>  =>  => 'id_player' => $id_player
 =>  =>  =>  => ));
 =>  =>  =>  => return $this->read('val');
 =>  => }

 =>  => public function createSubscriptionForRaid($id_raid, $autosignon)
 =>  => {
 =>  =>  =>  => // load active players => state=3
 =>  =>  =>  => $players = $this->getModel('Player')->getPlayerByState(3);

 =>  =>  =>  => foreach ( $players as $player )
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => $data = new Data();

 =>  =>  =>  =>  =>  => $dataid_player = $playerid_player;
 =>  =>  =>  =>  =>  => $dataid_raid = $id_raid;

 =>  =>  =>  =>  =>  => // ------------------------------------
 =>  =>  =>  =>  =>  => // different states for different
 =>  =>  =>  =>  =>  => // combinations of signon flags
 =>  =>  =>  =>  =>  => // ------------------------------------

 =>  =>  =>  =>  =>  => // autosign on active but player is not on autosignon
 =>  =>  =>  =>  =>  => if ($autosignon == 1 && $playerautosignon == 0)
 =>  =>  =>  =>  =>  =>  =>  => $datastate = 0; // state without ajax

 =>  =>  =>  =>  =>  => // autosign on active and player is on autosignon
 =>  =>  =>  =>  =>  => if ($autosignon == 1 && $playerautosignon == 1)
 =>  =>  =>  =>  =>  =>  =>  => $datastate = 1; // state enrolled

 =>  =>  =>  =>  =>  => // autosign on inactive
 =>  =>  =>  =>  =>  => if ($autosignon == 0)
 =>  =>  =>  =>  =>  =>  =>  => $datastate = 0; // state for all on no ajax

 =>  =>  =>  =>  =>  => ->data = $data;
 =>  =>  =>  =>  =>  => ->save();
 =>  =>  =>  => }
 =>  => }

 =>  => /**
 =>  =>  * Deletes all subscriptions of a specific raid
 =>  =>  * @param int $id_raid
 =>  =>  */
 =>  => public function deleteByRaid($id_raid)
 =>  => {
 =>  =>  =>  => ->delete(array(
 =>  =>  =>  =>  =>  => 'filter' => 'id_raid={int:id_raid}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_raid' => $id_raid
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));
 =>  => }

 =>  => /**
 =>  =>  * Deletes a specific subscription
 =>  =>  * @param int $id_subscription
 =>  =>  */
 =>  => public function deleteSubscriptionByID($id_subscription)
 =>  => {
 =>  =>  =>  => ->delete($id_subscription);
 =>  => }

 =>  => /**
 =>  =>  * Deletes all subscritions for one specific player
 =>  =>  * @param int $id_player
 =>  =>  */
 =>  => public function deleteSubscriptionByPlayer($id_player)
 =>  => {
 =>  =>  =>  => ->delete(array(
 =>  =>  =>  =>  =>  => 'filter' => 'id_player={int:id_player}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_player' => $id_player
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));
 =>  => }

 =>  => /**
 =>  =>  * Load subscriptions of a raid by a specific enrollstate.
 =>  =>  * @param int $id_raid
 =>  =>  * @param int $state
 =>  =>  * @return false Data
 =>  =>  */
 =>  => public function getBySubsstate($id_raid, $state)
 =>  => {
 =>  =>  =>  => return $this->read(array(
 =>  =>  =>  =>  =>  => 'type' => '*',
 =>  =>  =>  =>  =>  => 'field' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'subs.id_player',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.char_name',
 =>  =>  =>  =>  =>  =>  =>  => 'cats.category',
 =>  =>  =>  =>  =>  =>  =>  => 'class.class',
 =>  =>  =>  =>  =>  =>  =>  => 'class.color'
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'join' => array(
 =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_chars',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'subs.id_player=chars.id_player'
 =>  =>  =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_categories',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'cats',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.id_category=cats.id_category'
 =>  =>  =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_classes',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'class',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.id_class=class.id_class'
 =>  =>  =>  =>  =>  =>  =>  => )
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'filter' => 'subs.state={int:state} AND subs.id_raid={int:id_raid} AND chars.is_main=1',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_raid' => $id_raid,
 =>  =>  =>  =>  =>  =>  =>  => 'state' => $state
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'order' => 'chars.char_name'
 =>  =>  =>  => ));
 =>  => }

 =>  => public function getEditSubscriptions($id_raid, $type)
 =>  => {
 =>  =>  =>  => $filter = 'subs.id_raid={int:id_raid} AND chars.is_main=1 AND subs.state ';

 =>  =>  =>  => switch ($type)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // Get player who are away or without any ajax
 =>  =>  =>  =>  =>  => case 'resigned' :
 =>  =>  =>  =>  =>  =>  =>  => $filter .= 'IN(0,2)';
 =>  =>  =>  =>  =>  =>  =>  => break;

 =>  =>  =>  =>  =>  => // Get the lisst of enrolled player
 =>  =>  =>  =>  =>  => case 'enrolled' :
 =>  =>  =>  =>  =>  =>  =>  => $filter .= '=1';
 =>  =>  =>  =>  =>  =>  =>  => break;

 =>  =>  =>  =>  =>  => default :
 =>  =>  =>  =>  =>  =>  =>  => Throw new Error('The given subscriptiontype is wrong.', 1000, array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'enrolled',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'resigned'
 =>  =>  =>  =>  =>  =>  =>  => ));
 =>  =>  =>  => }

 =>  =>  =>  => return $this->read(array(
 =>  =>  =>  =>  =>  => 'type' => '*',
 =>  =>  =>  =>  =>  => 'field' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'subs.id_raid',
 =>  =>  =>  =>  =>  =>  =>  => 'subs.id_subscription',
 =>  =>  =>  =>  =>  =>  =>  => 'subs.id_player',
 =>  =>  =>  =>  =>  =>  =>  => 'subs.state',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.char_name',
 =>  =>  =>  =>  =>  =>  =>  => 'cats.category',
 =>  =>  =>  =>  =>  =>  =>  => 'class.class',
 =>  =>  =>  =>  =>  =>  =>  => 'class.color'
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'join' => array(
 =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_chars',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'subs.id_player=chars.id_player'
 =>  =>  =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_categories',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'cats',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.id_category=cats.id_category'
 =>  =>  =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_classes',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'class',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.id_class=class.id_class'
 =>  =>  =>  =>  =>  =>  =>  => )
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'filter' => $filter,
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_raid' => $id_raid,
 =>  =>  =>  =>  =>  =>  =>  => 'id_player' => User::getId()
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'order' => 'chars.char_name'
 =>  =>  =>  => ), 'createSubsButton');
 =>  => }

 =>  => protected function createSubsButton($player)
 =>  => {
 =>  =>  =>  => switch ($playerstate)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => case 0 :
 =>  =>  =>  =>  =>  => case 2 :
 =>  =>  =>  =>  =>  =>  =>  => // get player who are away or without any ajax
 =>  =>  =>  =>  =>  =>  =>  => $btn_type = 'btn-success';
 =>  =>  =>  =>  =>  =>  =>  => $icon = 'smile-o';
 =>  =>  =>  =>  =>  =>  =>  => $title = 'raidmanager_comment_enroll';
 =>  =>  =>  =>  =>  =>  =>  => $state = 1;
 =>  =>  =>  =>  =>  =>  =>  => break;

 =>  =>  =>  =>  =>  => case 1 :
 =>  =>  =>  =>  =>  =>  =>  => // get the lisst of enrolled player
 =>  =>  =>  =>  =>  =>  =>  => $btn_type = 'btn-danger';
 =>  =>  =>  =>  =>  =>  =>  => $icon = 'frown-o';
 =>  =>  =>  =>  =>  =>  =>  => $title = 'raidmanager_comment_resign';
 =>  =>  =>  =>  =>  =>  =>  => $state = 2;
 =>  =>  =>  =>  =>  =>  =>  => break;

 =>  =>  =>  =>  =>  => default :
 =>  =>  =>  =>  =>  =>  =>  => Throw new Error('The given subscription set type is wrong.', 1000, array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 0,
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 1,
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 2
 =>  =>  =>  =>  =>  =>  =>  => ));
 =>  =>  =>  => }

 =>  =>  =>  => // build enrollbuttons
 =>  =>  =>  => $button = UiButton::factory('ajax', 'imgbutton');
 =>  =>  =>  => $buttonsetIcon($icon);
 =>  =>  =>  => $buttonsetText($playerchar_name);
 =>  =>  =>  => $buttonsetTitle($this->txt($title));

 =>  =>  =>  => $buttonaddCss('btn-block');
 =>  =>  =>  => $buttonaddCss($btn_type);

 =>  =>  =>  => $buttonsetRoute('raidmanager_subscription_enrollform', array(
 =>  =>  =>  =>  =>  => 'state' => $state,
 =>  =>  =>  =>  =>  => 'from' => 'subscription',
 =>  =>  =>  =>  =>  => 'id_raid' => $playerid_raid,
 =>  =>  =>  =>  =>  => 'id_player' => $playerid_player,
 =>  =>  =>  =>  =>  => 'id_subscription' => $playerid_subscription
 =>  =>  =>  => ));

 =>  =>  =>  => $buttonsetTarget('raidmanager_subscriptions');

 =>  =>  =>  => $playerlink = $buttonbuild();

 =>  =>  =>  => return $player;
 =>  => }

 =>  => /**
 =>  =>  * Save the enrollform in which the subscriptionstate can be changed and comments are stored in DB
 =>  =>  */
 =>  => public function saveEnrollform($data)
 =>  => {
 =>  =>  =>  => ->data = $data;

 =>  =>  =>  => // normal users onl can changer their own subscription state. we need to prevent users from changing other
 =>  =>  =>  => // users state. if user is different then the player of the subscription to change and the user lacks needed
 =>  =>  =>  => // permissions, override the subscriptions player id with the id of the user.
 =>  =>  =>  => // admin can change the subscriptionstate for all player
 =>  =>  =>  => if ($this->dataid_player != User::getId() && $this->checkAccess('raidmanager_perm_subs') === false)
 =>  =>  =>  =>  =>  => ->dataid_player = User::getId();

 =>  =>  =>  =>  =>  => // state 1 stands for enroll and 2 for resign. both stands for an subscription action to save
 =>  =>  =>  => if ($this->datastate != 0)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => ->save();

 =>  =>  =>  =>  =>  => // on resign, the players chars need to be removed
 =>  =>  =>  =>  =>  => // from possible setlists of this raid
 =>  =>  =>  =>  =>  => if ($this->datastate == 2)
 =>  =>  =>  =>  =>  =>  =>  => $this->getModel('Setlist')removePlayerByRaid($this->dataid_raid, ->dataid_player);
 =>  =>  =>  => }

 =>  =>  =>  => // Create comment if the subscription save is without error
 =>  =>  =>  => if (!$this->hasErrors())
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // extend data to fit as comment
 =>  =>  =>  =>  =>  => ->dataid_poster = User::getId();
 =>  =>  =>  =>  =>  => ->datastamp = time();

 =>  =>  =>  =>  =>  => // create comment
 =>  =>  =>  =>  =>  => $comment_model = $this->getModel('Comment');
 =>  =>  =>  =>  =>  => $comment_modelcreateComment($this->data);

 =>  =>  =>  =>  =>  => if ($comment_modelhasErrors())
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => $comment_errors = $comment_modelgetErrors();

 =>  =>  =>  =>  =>  =>  =>  => foreach ( $comment_errors as $fld => $msg )
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => ->addError($fld, $msg);
 =>  =>  =>  =>  =>  => }
 =>  =>  =>  => }
 =>  => }

 =>  => /**
 =>  =>  * Change substate of player
 =>  =>  * @param int $id_subscription
 =>  =>  * @param int $state 1=enrolled | 2=resigned
 =>  =>  */
 =>  => private function changePlayerSubscription($id_subscription, $state)
 =>  => {
 =>  =>  =>  => $model = $this->getModel();
 =>  =>  =>  => $modeldataid_subscription = $id_subscription;
 =>  =>  =>  => $modeldatastate = $state;
 =>  =>  =>  => $modelsave();
 =>  => }

 =>  => public function getIdAndState($id_raid, $id_player)
 =>  => {
 =>  =>  =>  => ->setField(array(
 =>  =>  =>  =>  =>  => 'id_subscription',
 =>  =>  =>  =>  =>  => 'state'
 =>  =>  =>  => ));
 =>  =>  =>  => ->setFilter('id_raid={int:id_raid} AND id_player={int:id_player}');
 =>  =>  =>  => ->setParameter(array(
 =>  =>  =>  =>  =>  => 'id_raid' => $id_raid,
 =>  =>  =>  =>  =>  => 'id_player' => $id_player
 =>  =>  =>  => ));
 =>  =>  =>  => return $this->read();
 =>  => }

 =>  => public function getRaidId($id_subscription)
 =>  => {
 =>  =>  =>  => ->setField('id_raid');
 =>  =>  =>  => ->setFilter('id_subscription={int:id_subscription}');
 =>  =>  =>  => ->setParameter('id_subscription', $id_subscription);
 =>  =>  =>  => return $this->read('val');
 =>  => }

 =>  => /**
 =>  =>  * Add player to subscription table
 =>  =>  * The signonstate is related to the parameter this method gets and the state of the raid itself.
 =>  =>  * Only if both are true e.g. 1 the player will be flagged as subscribed. Otherwise the player will
 =>  =>  * be flagges to no ajax (1)
 =>  =>  *
 =>  =>  * @param int $id_player
 =>  =>  * @param int $state (0|1)
 =>  =>  */
 =>  => public function addPlayerToFutureSubs($id_player, $state)
 =>  => {
 =>  =>  =>  => // get future raids
 =>  =>  =>  => $raids = $this->getModel('Raid')->getFutureRaidIDsAndAutosignon();

 =>  =>  =>  => // create data for each raid
 =>  =>  =>  => foreach ( $raids as $raid )
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // prepare data container
 =>  =>  =>  =>  =>  => $sub = new Data();

 =>  =>  =>  =>  =>  => // get raid id from raid record
 =>  =>  =>  =>  =>  => $subid_raid = $raidid_raid;

 =>  =>  =>  =>  =>  => // set player id
 =>  =>  =>  =>  =>  => $subid_player = $id_player;

 =>  =>  =>  =>  =>  => // set signon state according to autosignon of raid and autosignon state of player
 =>  =>  =>  =>  =>  => $substate = $raidautosignon == 1 && $state == 1 ? 1 : 0;

 =>  =>  =>  =>  =>  => // add data container to model and save
 =>  =>  =>  =>  =>  => ->data = $sub;
 =>  =>  =>  =>  =>  => ->save(false);
 =>  =>  =>  => }
 =>  => }

 =>  => /**
 =>  =>  * Removes all future subscriptions of one specific player
 =>  =>  * @param int $id_player
 =>  =>  */
 =>  => public function deletePlayerFromFutureRaidSub($id_player)
 =>  => {
 =>  =>  =>  => ->delete(array(
 =>  =>  =>  =>  =>  => 'filter' => 'id_raid IN ({array_int:raids}) AND id_player={int:id_player}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'raids' => $this->getModel('Raid')->getFutureRaidIDs(),
 =>  =>  =>  =>  =>  =>  =>  => 'id_player' => $id_player
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));
 =>  => }

 =>  => /**
 =>  =>  * Sets the enrollstate on all future subscriptions for one specific player
 =>  =>  * @param int $id_player
 =>  =>  * @param int $state
 =>  =>  */
 =>  => public function setPlayerStateOnFutureSubs($id_player, $state)
 =>  => {
 =>  =>  =>  => ->update(array(
 =>  =>  =>  =>  =>  => 'field' => 'state',
 =>  =>  =>  =>  =>  => 'filter' => 'subs.id_raid IN({array_int:raids}) AND subs.id_player={int:id_player}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'raids' => $this->getModel('Raid')->getFutureRaidIDs(),
 =>  =>  =>  =>  =>  =>  =>  => 'id_player' => $id_player,
 =>  =>  =>  =>  =>  =>  =>  => 'state' => $state
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));
 =>  => }

 =>  => /**
 =>  =>  * Counts and returns the number of enrolled players on a raid
 =>  =>  * @param int $id_raid
 =>  =>  * @return int
 =>  =>  */
 =>  => public function countEnrolledPlayers($id_raid)
 =>  => {
 =>  =>  =>  => return $this->count('id_raid={int:id_raid} AND state=1', array(
 =>  =>  =>  =>  =>  => 'id_raid' => $id_raid
 =>  =>  =>  => ));
 =>  => }
}

