<?php

namespace Apps\Raidmanager\Model;

use Core\Lib\Amvc\Model;
use Core\Lib\Content\Html\Controls\Actionbar;
use Core\Lib\Data\Data;

/**
 * Setlist model
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.d
 * @package TekFW
 * @subpackage App Raidmanager
 * @license MIT
 * @copyright 2014 by author
 */
final class SetlistModel extends Model
{
 =>  => protected $tbl = 'app_raidmanager_setlists';
 =>  => protected $alias = 'setlist';
 =>  => protected $pk = 'id_setlist';

 =>  => /**
 =>  =>  * Get all players set for one setup
 =>  =>  * @param int $id_setup
 =>  =>  * @return boolean Data
 =>  =>  */
 =>  => public function getSet($id_setup)
 =>  => {
 =>  =>  =>  => ->read(array(
 =>  =>  =>  =>  =>  => 'type' => '*',
 =>  =>  =>  =>  =>  => 'field' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'setlist.id_setlist',
 =>  =>  =>  =>  =>  =>  =>  => 'setlist.id_raid',
 =>  =>  =>  =>  =>  =>  =>  => 'setlist.id_player',
 =>  =>  =>  =>  =>  =>  =>  => 'setlist.id_char',
 =>  =>  =>  =>  =>  =>  =>  => 'setlist.set_as',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.char_name',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.id_class',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.id_category',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.is_main',
 =>  =>  =>  =>  =>  =>  =>  => 'class.class',
 =>  =>  =>  =>  =>  =>  =>  => 'class.color',
 =>  =>  =>  =>  =>  =>  =>  => 'cat1.category AS category_set',
 =>  =>  =>  =>  =>  =>  =>  => 'cat2.category AS category_org'
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'join' => array(
 =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_chars',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'setlist.id_char = chars.id_char'
 =>  =>  =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_classes',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'class',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.id_class = class.id_class'
 =>  =>  =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_categories',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'cat1',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'setlist.set_as = cat1.id_category'
 =>  =>  =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_categories',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'cat2',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.id_category = cat2.id_category'
 =>  =>  =>  =>  =>  =>  =>  => )
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'filter' => 'setlist.id_setup={int:id_setup}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_setup' => $id_setup
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'order' => 'setlist.set_as, class.id_class, chars.char_name'
 =>  =>  =>  => ));

 =>  =>  =>  => // no data! return false
 =>  =>  =>  => if (!$this->hasData())
 =>  =>  =>  =>  =>  => return false;

 =>  =>  =>  => $data = new Data();

 =>  =>  =>  => $datatank = [];
 =>  =>  =>  => $datadamage = [];
 =>  =>  =>  => $dataheal = [];

 =>  =>  =>  => foreach ( ->data as $set )
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => switch ($setset_as)
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => case 1 :
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $cat = 'tank';
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => break;
 =>  =>  =>  =>  =>  =>  =>  => case 2 :
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $cat = 'damage';
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => break;
 =>  =>  =>  =>  =>  =>  =>  => case 3 :
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $cat = 'heal';
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => break;
 =>  =>  =>  =>  =>  =>  =>  => default :
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $cat = 'tank';
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => break;
 =>  =>  =>  =>  =>  => }

 =>  =>  =>  =>  =>  => if ($setset_as !== $setid_category)
 =>  =>  =>  =>  =>  =>  =>  => $setchar_name .= ' (!)';

 =>  =>  =>  =>  =>  => $data{$cat}{$setid_setlist} = $set;
 =>  =>  =>  => }

 =>  =>  =>  => ->reset();

 =>  =>  =>  => return $this->data = $data;
 =>  => }

 =>  => public function getAvail($id_setup)
 =>  => {
 =>  =>  =>  => // load the player ids of set player
 =>  =>  =>  => ->read(array(
 =>  =>  =>  =>  =>  => 'type' => 'key',
 =>  =>  =>  =>  =>  => 'field' => 'id_player',
 =>  =>  =>  =>  =>  => 'filter' => 'id_setup={int:id_setup}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_setup' => $id_setup
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));

 =>  =>  =>  => // from her we want to get the playerdata from all the players who are not set
 =>  =>  =>  => $query = array(
 =>  =>  =>  =>  =>  => 'type' => '*',
 =>  =>  =>  =>  =>  => 'field' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'chars.id_char',
 =>  =>  =>  =>  =>  =>  =>  => 'subs.id_player',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.char_name',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.is_main',
 =>  =>  =>  =>  =>  =>  =>  => 'cats.id_category',
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
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_raid' => $this->getModel('Setup')->getRaidId($id_setup),
 =>  =>  =>  =>  =>  =>  =>  => 'status' => 1
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'order' => 'chars.char_name'
 =>  =>  =>  => );

 =>  =>  =>  => // if no player is set, all player in substable will be returned
 =>  =>  =>  => if ($this->hasNoData())
 =>  =>  =>  =>  =>  => $query['filter'] = 'subs.state=1 AND subs.id_raid={int:id_raid}';
 =>  =>  =>  => else
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // there are players set, get all from subs except them.
 =>  =>  =>  =>  =>  => $query['filter'] = 'subs.state=1 AND subs.id_raid={int:id_raid} AND subs.id_player NOT IN ({array_int:setplayer})';
 =>  =>  =>  =>  =>  => $query['param']['setplayer'] = ->data;
 =>  =>  =>  => }

 =>  =>  =>  => ->data = $this->getModel('Subscription')read($query);

 =>  =>  =>  => return $this->data;
 =>  => }

 =>  => public function countAvail($id_setup)
 =>  => {
 =>  =>  =>  => // load the player ids of set player
 =>  =>  =>  => ->read(array(
 =>  =>  =>  =>  =>  => 'type' => 'key',
 =>  =>  =>  =>  =>  => 'field' => 'id_player',
 =>  =>  =>  =>  =>  => 'filter' => 'id_setup={int:id_setup}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_setup' => $id_setup
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));

 =>  =>  =>  => // from her we want to get the playerdata from all the players who are not set
 =>  =>  =>  => $query = array(
 =>  =>  =>  =>  =>  => 'type' => 'num',
 =>  =>  =>  =>  =>  => 'field' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'subs.id_player',
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_raid' => $this->getModel('Setup')->getRaidId($id_setup),
 =>  =>  =>  =>  =>  =>  =>  => 'status' => 1
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  => );

 =>  =>  =>  => // if no player is set, all player in substable will be returned
 =>  =>  =>  => if ($this->hasNoData())
 =>  =>  =>  =>  =>  => $query['filter'] = 'subs.state=1 AND subs.id_raid={int:id_raid}';
 =>  =>  =>  => else
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // there are players set, get all from subs except them.
 =>  =>  =>  =>  =>  => $query['filter'] = 'subs.state=1 AND subs.id_raid={int:id_raid} AND subs.id_player NOT IN ({array_int:setplayer})';
 =>  =>  =>  =>  =>  => $query['param']['setplayer'] = ->data;
 =>  =>  =>  => }

 =>  =>  =>  => ->data = $this->getModel('Subscription')read($query);

 =>  =>  =>  => return $this->data;
 =>  => }

 =>  => /**
 =>  =>  * Deletes setlists by raid
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
 =>  =>  * Deletes setlists by setup
 =>  =>  * @param int $id_setup
 =>  =>  */
 =>  => public function deleteBySetup($id_setup)
 =>  => {
 =>  =>  =>  => ->delete(array(
 =>  =>  =>  =>  =>  => 'filter' => 'id_setup={int:id_setup}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_setup' => $id_setup
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));
 =>  => }

 =>  => public function getSetlist($side, $id_setup, $id_category)
 =>  => {
 =>  =>  =>  => switch ($side)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => case 'avail' :
 =>  =>  =>  =>  =>  =>  =>  => return $this->getEditAvail($id_setup, $id_category);
 =>  =>  =>  =>  =>  =>  =>  => break;

 =>  =>  =>  =>  =>  => case 'set' :
 =>  =>  =>  =>  =>  =>  =>  => return $this->getEditSet($id_setup, $id_category);
 =>  =>  =>  =>  =>  =>  =>  => break;
 =>  =>  =>  => }
 =>  => }

 =>  => public function getEditSet($id_setup, $id_category)
 =>  => {
 =>  =>  =>  => $query = array(
 =>  =>  =>  =>  =>  => 'type' => '*',
 =>  =>  =>  =>  =>  => 'field' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'setlist.id_setlist',
 =>  =>  =>  =>  =>  =>  =>  => 'setlist.id_setup',
 =>  =>  =>  =>  =>  =>  =>  => 'setlist.id_player',
 =>  =>  =>  =>  =>  =>  =>  => 'setlist.id_char',
 =>  =>  =>  =>  =>  =>  =>  => 'setlist.set_as',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.char_name',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.is_main',
 =>  =>  =>  =>  =>  =>  =>  => 'cats.id_category',
 =>  =>  =>  =>  =>  =>  =>  => 'cats.category',
 =>  =>  =>  =>  =>  =>  =>  => 'class.class',
 =>  =>  =>  =>  =>  =>  =>  => 'class.color',
 =>  =>  =>  =>  =>  =>  =>  => 'class.css'
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'join' => array(
 =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_chars',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'setlist.id_char=chars.id_char'
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
 =>  =>  =>  =>  =>  => 'filter' => 'setlist.id_setup={int:id_setup} AND setlist.set_as={int:set_as}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_setup' => $id_setup,
 =>  =>  =>  =>  =>  =>  =>  => 'set_as' => $id_category
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => );

 =>  =>  =>  => return $this->read($query, 'addSetActionbar');
 =>  => }

 =>  => /**
 =>  =>  * Callback method to add actionbar (with buttons according the current set state of player) to set player
 =>  =>  * @param Data $player
 =>  =>  * @return Data
 =>  =>  */
 =>  => public function addSetActionbar($player)
 =>  => {
 =>  =>  =>  => $actionbar = new Actionbar();

 =>  =>  =>  => // create the unset and set buttons for categories
 =>  =>  =>  => // the player ist not currently set to
 =>  =>  =>  => // 0 = unset
 =>  =>  =>  => // 1 = Tank
 =>  =>  =>  => // 2 = DD
 =>  =>  =>  => // 3 = Heal

 =>  =>  =>  => $categories = array(
 =>  =>  =>  =>  =>  => 0 => array(
 =>  =>  =>  =>  =>  =>  =>  => 'unset',
 =>  =>  =>  =>  =>  =>  =>  => 'chevron-right'
 =>  =>  =>  =>  =>  => ),
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

 =>  =>  =>  => // build links
 =>  =>  =>  => foreach ( $categories as $key => $val )
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // only if not already set as the current category
 =>  =>  =>  =>  =>  => if ($playerset_as == $key)
 =>  =>  =>  =>  =>  =>  =>  => continue;

 =>  =>  =>  =>  =>  =>  =>  => // Basic parameters
 =>  =>  =>  =>  =>  => $param = array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_setlist' => $playerid_setlist
 =>  =>  =>  =>  =>  => );

 =>  =>  =>  =>  =>  => // switch requires the new category id
 =>  =>  =>  =>  =>  => if ($key != 0)
 =>  =>  =>  =>  =>  =>  =>  => $param['id_category'] = $key;

 =>  =>  =>  =>  =>  =>  =>  => // which route?
 =>  =>  =>  =>  =>  => $route = $key == 0 ? 'unset' : 'switch';

 =>  =>  =>  =>  =>  => $actionbarcreateButton($val[1])->setIcon($val[1])->setTitle($this->txt($val[0]))->setRoute('raidmanager_setlist_' . $route, $param);
 =>  =>  =>  => }

 =>  =>  =>  => $playeractionbar = $actionbarbuild();

 =>  =>  =>  => return $player;
 =>  => }

 =>  => public function getEditAvail($id_setup, $id_category)
 =>  => {
 =>  =>  =>  => // load the player ids of set player
 =>  =>  =>  => ->read(array(
 =>  =>  =>  =>  =>  => 'type' => 'key',
 =>  =>  =>  =>  =>  => 'field' => 'id_player',
 =>  =>  =>  =>  =>  => 'filter' => 'id_setup={int:id_setup}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_setup' => $id_setup
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));

 =>  =>  =>  => // from her we want to get the playerdata from all the players who are not set
 =>  =>  =>  => $query = array(
 =>  =>  =>  =>  =>  => 'type' => '*',
 =>  =>  =>  =>  =>  => 'field' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'chars.id_char',
 =>  =>  =>  =>  =>  =>  =>  => 'subs.id_player',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.char_name',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.is_main',
 =>  =>  =>  =>  =>  =>  =>  => 'cats.id_category',
 =>  =>  =>  =>  =>  =>  =>  => 'cats.category',
 =>  =>  =>  =>  =>  =>  =>  => 'class.class',
 =>  =>  =>  =>  =>  =>  =>  => 'class.color',
 =>  =>  =>  =>  =>  =>  =>  => 'class.css',
 =>  =>  =>  =>  =>  =>  =>  => $id_setup . ' AS id_setup'
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
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_raid' => $this->getModel('Setup')->getRaidId($id_setup),
 =>  =>  =>  =>  =>  =>  =>  => 'id_category' => $id_category
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'order' => 'chars.is_main, class.class'
 =>  =>  =>  => );

 =>  =>  =>  => // if no player is set, all player in substable will be returned
 =>  =>  =>  => if ($this->hasNoData())
 =>  =>  =>  =>  =>  => $query['filter'] = 'cats.id_category={int:id_category} AND subs.state=1 AND subs.id_raid={int:id_raid}';
 =>  =>  =>  => else
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // there are players set, get all from subs except them.
 =>  =>  =>  =>  =>  => $query['filter'] = 'cats.id_category={int:id_category} AND subs.state=1 AND subs.id_raid={int:id_raid} AND subs.id_player NOT IN ({array_int:setplayer})';
 =>  =>  =>  =>  =>  => $query['param']['setplayer'] = ->data;
 =>  =>  =>  => }

 =>  =>  =>  => return $this->data = $this->getModel('Subscription')read($query, 'Setlist::addAvailActionbar');
 =>  => }

 =>  => /**
 =>  =>  * Callback method to add actionbar (with buttons according the current set state of player) to available player
 =>  =>  * @param Data $player
 =>  =>  * @return Data
 =>  =>  */
 =>  => public function addAvailActionbar($player)
 =>  => {
 =>  =>  =>  => // Character flag
 =>  =>  =>  => if ($playeris_main == 0)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => $query = array(
 =>  =>  =>  =>  =>  =>  =>  => 'field' => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.char_name',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'class.css'
 =>  =>  =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  =>  =>  => 'join' => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_classes',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'class',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.id_class=class.id_class'
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => )
 =>  =>  =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  =>  =>  => 'filter' => 'chars.id_player={int:id_player} AND chars.is_main=1',
 =>  =>  =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'id_player' => $playerid_player
 =>  =>  =>  =>  =>  =>  =>  => )
 =>  =>  =>  =>  =>  => );

 =>  =>  =>  =>  =>  => $mainchar = $this->getModel('Char')read($query);

 =>  =>  =>  =>  =>  => $playerchar_name .= ' <span class="' . $maincharcss . '(' . $maincharchar_name . ')</spa';
 =>  =>  =>  => }

 =>  =>  =>  => // create the unset and set buttons for categories
 =>  =>  =>  => // the player ist not currently set to
 =>  =>  =>  => // 0 = unset
 =>  =>  =>  => // 1 = Tank
 =>  =>  =>  => // 2 = DD
 =>  =>  =>  => // 3 = Heal

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

 =>  =>  =>  => $actionbar = new Actionbar();

 =>  =>  =>  => // build links
 =>  =>  =>  => foreach ( $categories as $key => $category )
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => $param = array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_setup' => $playerid_setup,
 =>  =>  =>  =>  =>  =>  =>  => 'id_char' => $playerid_char,
 =>  =>  =>  =>  =>  =>  =>  => 'id_category' => $key
 =>  =>  =>  =>  =>  => );

 =>  =>  =>  =>  =>  => // only if not already set as the current category
 =>  =>  =>  =>  =>  => $actionbarcreateButton($category[1])->setIcon($category[1])->setTitle($this->txt($category[0]))->setRoute('raidmanager_setlist_set', $param);
 =>  =>  =>  => }

 =>  =>  =>  => $playeractionbar = $actionbarbuild();

 =>  =>  =>  => return $player;
 =>  => }

 =>  => public function saveSetting($data)
 =>  => {
 =>  =>  =>  => if ($this->dataset_as == 0)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => ->delete($this->dataid_setlist);
 =>  =>  =>  =>  =>  => return;
 =>  =>  =>  => }

 =>  =>  =>  => ->save();
 =>  => }

 =>  => /**
 =>  =>  * Deletes a player from all raid specific setlists
 =>  =>  * @param int $id_raid
 =>  =>  * @param int $id_player
 =>  =>  */
 =>  => public function removePlayerByRaid($id_raid, $id_player)
 =>  => {
 =>  =>  =>  => ->delete(array(
 =>  =>  =>  =>  =>  => 'filter' => 'id_setup IN ({array_int:setups}) AND id_player={int:id_player}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'setups' => $this->getModel('Setup')->getIdsByRaid($id_raid),
 =>  =>  =>  =>  =>  =>  =>  => 'id_player' => $id_player
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));
 =>  => }

 =>  => /**
 =>  =>  * Deletes a player from all future setlists
 =>  =>  * @param int $id_player
 =>  =>  */
 =>  => public function deletePlayerFromFutureSetlist($id_player)
 =>  => {
 =>  =>  =>  => ->delete(array(
 =>  =>  =>  =>  =>  => 'filter' => 'id_setup IN ({array_int:setups}) AND id_player={int:id_player}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'setups' => $this->getModel('Setup')->getFutureSetupIDs(),
 =>  =>  =>  =>  =>  =>  =>  => 'id_player' => $id_player
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));
 =>  => }

 =>  => /**
 =>  =>  * Deletes a player from all setlists
 =>  =>  * @param int $id_player
 =>  =>  */
 =>  => public function deletePlayerFromSetlist($id_player)
 =>  => {
 =>  =>  =>  => ->delete(array(
 =>  =>  =>  =>  =>  => 'filter' => 'id_player={int:id_player}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_player' => $id_player
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));
 =>  => }

 =>  => /**
 =>  =>  * Deletes a char from future setlists
 =>  =>  * @param int $id_char
 =>  =>  */
 =>  => public function deleteCharFromFutureSetlist($id_char)
 =>  => {
 =>  =>  =>  => ->delete(array(
 =>  =>  =>  =>  =>  => 'filter' => 'id_setup IN ({array_int:setups}) AND id_char={int:id_char}',
 =>  =>  =>  =>  =>  => 'params' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'setups' => $this->getModel('Setup')->getFutureSetupIDs(),
 =>  =>  =>  =>  =>  =>  =>  => 'id_char' => $id_char
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));
 =>  => }

 =>  => /**
 =>  =>  * Sets a player on a setup
 =>  =>  * @param int $id_setup
 =>  =>  * @param int $id_char
 =>  =>  * @param int $id_category
 =>  =>  * @return \Core\Lib\Data\Data
 =>  =>  */
 =>  => public function setPlayer($id_setup, $id_char, $id_category)
 =>  => {
 =>  =>  =>  => // create new data object and fill it with needed setlist content
 =>  =>  =>  => $data = new Data();

 =>  =>  =>  => // Set setup id
 =>  =>  =>  => $dataid_setup = $id_setup;

 =>  =>  =>  => // Get raid id by setup data
 =>  =>  =>  => $setup = $this->getModel('Setup')find($id_setup);
 =>  =>  =>  => $dataid_raid = $setupid_raid;

 =>  =>  =>  => // Get player id by chardata
 =>  =>  =>  => $char = $this->getModel('Char')find($id_char);
 =>  =>  =>  => $dataid_player = $charid_player;

 =>  =>  =>  => // Set the char id and the category
 =>  =>  =>  => $dataid_char = $id_char;
 =>  =>  =>  => $dataset_as = $id_category;

 =>  =>  =>  => ->data = $data;

 =>  =>  =>  => // Save data without validation
 =>  =>  =>  => ->save(false);

 =>  =>  =>  => return $this->data;
 =>  => }

 =>  => /**
 =>  =>  * Switches a player in a setlist
 =>  =>  * @param int $id_setlist
 =>  =>  * @param int $id_category
 =>  =>  * @return \Core\Lib\Data\Data
 =>  =>  */
 =>  => public function switchPlayer($id_setlist, $id_category)
 =>  => {
 =>  =>  =>  => // load setlist entry
 =>  =>  =>  => ->find($id_setlist);

 =>  =>  =>  => // update set_as field
 =>  =>  =>  => ->dataset_as = $id_category;

 =>  =>  =>  => // save data
 =>  =>  =>  => ->save(false);

 =>  =>  =>  => return $this->data;
 =>  => }

 =>  => /**
 =>  =>  * Removes player from setlist
 =>  =>  * @param int $id_setlist
 =>  =>  * @return \Core\Lib\Data\Data
 =>  =>  */
 =>  => public function unsetPlayer($id_setlist)
 =>  => {
 =>  =>  =>  => // get setlist infos
 =>  =>  =>  => $setlist = ->find($id_setlist);

 =>  =>  =>  => // remove from setlist
 =>  =>  =>  => ->delete($id_setlist);

 =>  =>  =>  => return $setlist;
 =>  => }

 =>  => /**
 =>  =>  * Copies a setlist of one setup to another setup
 =>  =>  * @param int $src_id_setup
 =>  =>  * @param int $dest_id_setup
 =>  =>  */
 =>  => public function copySetlist($src_id_setup, $dest_id_setup)
 =>  => {
 =>  =>  =>  => $dest = clone $this;

 =>  =>  =>  => ->setFilter('id_setup={int:id_setup}');
 =>  =>  =>  => ->setParameter('id_setup', $src_id_setup);
 =>  =>  =>  => ->read('*');

 =>  =>  =>  => foreach ( ->data as $set )
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // remove setlist id
 =>  =>  =>  =>  =>  => unset($setid_setlist);

 =>  =>  =>  =>  =>  => // set destination setup id
 =>  =>  =>  =>  =>  => $setid_setup = $dest_id_setup;

 =>  =>  =>  =>  =>  => // and save
 =>  =>  =>  =>  =>  => $destsetData($set)save();
 =>  =>  =>  => }
 =>  => }
}

