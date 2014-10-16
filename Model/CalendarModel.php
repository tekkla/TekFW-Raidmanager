<?php
namespace Apps\Raidmanager\Model;

use Core\Lib\Amvc\Model;
use Core\Lib\Url;
use Core\Lib\User;
use Core\Lib\Txt;
use Core\Lib\Data\Data;
use Core\Lib\Content\Html\Controls\UiButton;

// Check for direct file access
if (!defined('TEKFW'))
 =>  => die('Cannot run without TekFW framework...');

/**
 * Calendar Model
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.d
 * @package Raidmanager
 * @subpackage Model
 * @license MIT
 * @copyright 2014 by author
 */
final class CalendarModel extends Model
{
 =>  => protected $tbl = 'app_raidmanager_raids';
 =>  => protected $alias = 'raids';
 =>  => protected $pk = 'id_raid';

 =>  => /**
 =>  =>  * Loads the future and recent raids for calendar in raidmanager. Provided $id_raid parameter is used to flag
 =>  =>  * the currently visible raid as active.
 =>  =>  * @param int $id_raid
 =>  =>  * @return \Core\Lib\Data\Data
 =>  =>  */
 =>  => public function getCalendar($id_raid)
 =>  => {
 =>  =>  =>  => $query = array(
 =>  =>  =>  => 	'type' => '*',
 =>  =>  =>  =>  =>  => 'field' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'raids.id_raid',
 =>  =>  =>  =>  =>  =>  =>  => 'raids.destination',
 =>  =>  =>  =>  =>  =>  =>  => 'raids.starttime',
 =>  =>  =>  =>  =>  =>  =>  => 'subs.state'
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'join' => array(
 =>  =>  =>  =>  =>  =>  =>  => array('app_raidmanager_subscriptions', 'subs', 'INNER', 'raids.id_raid=subs.id_raid', true)
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'starttime' => time(),
 =>  =>  =>  =>  =>  =>  =>  => 'id_player' => User::getId()
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  => );

 =>  =>  =>  => $out = new Data();

 =>  =>  =>  => // get future raids
 =>  =>  =>  => $query['filter'] = '(raids.starttim{int:starttime} OR {int:starttime} BETWEEN raids.starttime AND raids.endtime) AND subs.id_player={int:id_player}';
 =>  =>  =>  => $query['order'] = 'raids.starttime';
 =>  =>  =>  => $query['limit'] = $this->cfg('num_list_future_raids');
 =>  =>  =>  => $outfuture = ->buildRaidlistLinks($this->read($query), $id_raid);

 =>  =>  =>  => // get recent raids
 =>  =>  =>  => $query['filter'] = 'raids.endtime<{int:starttime} AND subs.id_player={int:id_player}';
 =>  =>  =>  => $query['order'] = 'raids.starttime DESC';
 =>  =>  =>  => $query['limit'] = $this->cfg('num_list_recent_raids');
 =>  =>  =>  => $outrecent = ->buildRaidlistLinks($this->read($query), $id_raid);

 =>  =>  =>  => return $out;
 =>  => }

 =>  => /**
 =>  =>  * Loads infos about the next upcoming raid.
 =>  =>  * @return boolean|\Core\Lib\Data\Data
 =>  =>  */
 =>  => public function nextRaid()
 =>  => {
 =>  =>  =>  => ->read(array(
 =>  =>  =>  => 	'field' => array(
 =>  =>  =>  => 	 =>  => 'raids.id_raid',
 =>  =>  =>  => 	 =>  => 'raids.destination',
 =>  =>  =>  => 	 =>  => 'raids.starttime',
 =>  =>  =>  => 	 =>  => 'subs.state'
 =>  =>  =>  => 	),
 =>  =>  =>  =>  =>  => 'join' => array(
 =>  =>  =>  => 		array('app_raidmanager_subscriptions', 'subs', 'INNER', 'raids.id_raid=subs.id_raid')
 =>  =>  =>  => 	),
 =>  =>  =>  =>  =>  => 'filter' => '(raids.starttim{int:starttime} OR {int:starttime} BETWEEN raids.starttime AND raids.endtime) AND subs.id_player={int:id_player}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'starttime' => time(),
 =>  =>  =>  =>  =>  =>  =>  => 'id_player' => User::getId()
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'order' => 'raids.starttime',
 =>  =>  =>  =>  =>  => 'limit' => 1
 =>  =>  =>  => ));

 =>  =>  =>  => if (!$this->hasData())
 =>  =>  =>  =>  =>  => return false;

 =>  =>  =>  => // Add number of enrolled players
 =>  =>  =>  => ->dataplayers = $this->getModel('Subscription')countEnrolledPlayers($this->dataid_raid);

 =>  =>  =>  => // Add url to this raid
 =>  =>  =>  => ->dataurl = Url::factory('raidmanager_raid_selected', array('id_raid' => ->dataid_raid))->getUrl();

 =>  =>  =>  => return $this->data;
 =>  => }

 =>  => /**
 =>  =>  * Loads raidcalendar of coming raids to use as menulinks. Returns boolean false when no raids were found.
 =>  =>  * @return boolean|array
 =>  =>  */
 =>  => public function getMenu()
 =>  => {
 =>  =>  =>  => ->read(array(
 =>  =>  =>  =>  =>  => 'type' => '*',
 =>  =>  =>  =>  =>  => 'field' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'raids.id_raid',
 =>  =>  =>  =>  =>  =>  =>  => 'raids.destination',
 =>  =>  =>  =>  =>  =>  =>  => 'raids.starttime',
 =>  =>  =>  =>  =>  =>  =>  => 'subs.state'
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'join' => array(
 =>  =>  =>  =>  =>  =>  =>  => array('app_raidmanager_subscriptions', 'subs', 'INNER', 'raids.id_raid=subs.id_raid')
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'filter' => '(raids.starttim{int:starttime} OR {int:starttime} BETWEEN raids.starttime AND raids.endtime) AND subs.id_player={int:id_player}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'starttime' => time(),
 =>  =>  =>  =>  =>  =>  =>  => 'id_player' => User::getId()
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'order' => 'raids.starttime',
 =>  =>  =>  =>  =>  => 'limit' => $this->cfg('num_list_recent_raids')
 =>  =>  =>  => ));

 =>  =>  =>  => // No data mean we have to offer a link for raid creation
 =>  =>  =>  => if ($this->hasNoData())
 =>  =>  =>  =>  =>  => return false;

 =>  =>  =>  => // Still here? Ok. Seems that we have data to create menulinks.
 =>  =>  =>  => $menu_buttons = [];

 =>  =>  =>  => foreach ( ->data as $raid )
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => $menu_buttons['raidmanager_menu_raid_' . $raidid_raid] = array(
 =>  =>  =>  =>  =>  =>  =>  => 'title' => '<span class="small' . date('Y-m-d H:i', $raidstarttime) . '</spa ' . $raiddestination . ' <span class="badge' . ->appgetModel('Subscription')countEnrolledPlayers($raidid_raid) . '</spa',
 =>  =>  =>  =>  =>  =>  =>  => 'href' => Url::factory('raidmanager_raid_selected', array('id_raid' => $raidid_raid))->getUrl(),
 =>  =>  =>  =>  =>  =>  =>  => 'show' => true,
 =>  =>  =>  =>  =>  =>  =>  => 'sub_buttons' => array()
 =>  =>  =>  =>  =>  => );
 =>  =>  =>  => }

 =>  =>  =>  => return $menu_buttons;
 =>  => }

 =>  => /**
 =>  =>  * Internal method to create links out of provided raidlist
 =>  =>  * @param array $raidlist
 =>  =>  * @param int $id_raid
 =>  =>  * @return array
 =>  =>  */
 =>  => private function buildRaidlistLinks($raidlist, $id_raid = null)
 =>  => {
 =>  =>  =>  => $buttons = [];

 =>  =>  =>  => if (!$raidlist)
 =>  =>  =>  =>  =>  => return $buttons;

 =>  =>  =>  => foreach ( $raidlist as $raid )
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => $button = UiButton::factory('ajax', 'link');

 =>  =>  =>  =>  =>  => // special css class for the current raid
 =>  =>  =>  =>  =>  => if ($id_raid == $raidid_raid)
 =>  =>  =>  =>  =>  =>  =>  => $buttonaddCss('raidmanager_current');

 =>  =>  =>  =>  =>  =>  =>  => // set classes for viewing player enrollstate
 =>  =>  =>  =>  =>  => switch ($raidstate)
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => case 0 :
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $css = 'text-warning';
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $state = 'noajax';
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => break;
 =>  =>  =>  =>  =>  =>  =>  => case 1 :
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $css = 'text-success';
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $state = 'enrolled';
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => break;
 =>  =>  =>  =>  =>  =>  =>  => case 2 :
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $css = 'text-danger';
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $state = 'resigned';
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => break;
 =>  =>  =>  =>  =>  =>  =>  => case 3 :
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $css = 'text-success';
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $state = 'enrolled';
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => break;
 =>  =>  =>  =>  =>  => }

 =>  =>  =>  =>  =>  => $buttonaddCss('app-raidmanager-subscription-' . $state);
 =>  =>  =>  =>  =>  => $buttonsetTitle('raidmanager_raid_subscriptionstate_' . $state);

 =>  =>  =>  =>  =>  => // build link
 =>  =>  =>  =>  =>  => $buttonurlsetNamedRoute('raidmanager_raid_data')->setTarget('raidmanager_raid')->addParameter('id_raid', $raidid_raid);

 =>  =>  =>  =>  =>  => // count subscribed players for this raid
 =>  =>  =>  =>  =>  => $num_enrolled = ->appgetModel('Subscription')countEnrolledPlayers($raidid_raid);

 =>  =>  =>  =>  =>  => // build the link text with raid starttime an raid destination
 =>  =>  =>  =>  =>  => $txt = '<span class="app-raidmanager-calendar-raid ' . $css . '' . date('Y-m-d, H:i', $raidstarttime) . ' - ' . $raiddestination . ' => <span class="badge' . $num_enrolled . '</spa';
 =>  =>  =>  =>  =>  => $buttonsetText($txt);

 =>  =>  =>  =>  =>  => $buttons[] = $buttonbuild();
 =>  =>  =>  => }

 =>  =>  =>  => return $buttons;
 =>  => }

 =>  => /**
 =>  =>  * Returns an array of user lang file specific days
 =>  =>  * @return array
 =>  =>  */
 =>  => public function getDays()
 =>  => {
 =>  =>  =>  => $days = Txt::get('days', 'SMF');

 =>  =>  =>  => return array(
 =>  =>  =>  =>  =>  => 0 => $days[0],
 =>  =>  =>  =>  =>  => 1 => $days[1],
 =>  =>  =>  =>  =>  => 2 => $days[2],
 =>  =>  =>  =>  =>  => 3 => $days[3],
 =>  =>  =>  =>  =>  => 4 => $days[4],
 =>  =>  =>  =>  =>  => 5 => $days[5],
 =>  =>  =>  =>  =>  => 6 => $days[6]
 =>  =>  =>  => );
 =>  => }
}

