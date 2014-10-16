<?php
namespace Apps\Raidmanager\Model;

use Core\Lib\Amvc\Model;
use Core\Lib\Content\Html\Controls\Actionbar;

if (!defined('TEKFW'))
 =>  => die('Cannot run without TekFW framework...');

/**
 * Comment model
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.d
 * @package TekFW
 * @subpackage App Raidmanager
 * @license MIT
 * @copyright 2014 by author
 */
final class CommentModel extends Model
{
 =>  => protected $tbl = 'app_raidmanager_comments';
 =>  => protected $alias = 'comment';
 =>  => protected $pk = 'id_comment';
 =>  => protected $validate = array(
 =>  =>  =>  => 'msg' => array(
 =>  =>  =>  =>  =>  => 'empty',
 =>  =>  =>  =>  =>  => array('range', array(10, 100))
 =>  =>  =>  => )
 =>  => );

 =>  => /**
 =>  =>  * Loads and returns all comments of a specific raid
 =>  =>  * @param int $id_raid
 =>  =>  * @return boolean|Data
 =>  =>  */
 =>  => public function getComments($id_raid)
 =>  => {
 =>  =>  =>  => return $this->read(array(
 =>  =>  =>  =>  =>  => 'type' => '*',
 =>  =>  =>  =>  =>  => 'field' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'comment.id_comment',
 =>  =>  =>  =>  =>  =>  =>  => 'comment.id_raid',
 =>  =>  =>  =>  =>  =>  =>  => 'comment.id_player',
 =>  =>  =>  =>  =>  =>  =>  => 'comment.id_poster',
 =>  =>  =>  =>  =>  =>  =>  => 'comment.msg',
 =>  =>  =>  =>  =>  =>  =>  => 'comment.state',
 =>  =>  =>  =>  =>  =>  =>  => 'comment.stamp',
 =>  =>  =>  =>  =>  =>  =>  => 'classes.class',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.char_name'
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'join' => array(
 =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_chars',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'comment.id_player=chars.id_player'
 =>  =>  =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_classes',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'classes',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.id_class=classes.id_class'
 =>  =>  =>  =>  =>  =>  =>  => )
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'filter' => 'comment.id_raid={int:id_raid} AND chars.is_main=1',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_raid' => $id_raid
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'order' => 'stamp DESC'
 =>  =>  =>  => ), 'extendComment');
 =>  => }

 =>  => /**
 =>  =>  * Callback method to extend a comment with actionbar
 =>  =>  * @param Data $comment
 =>  =>  * @return Data
 =>  =>  */
 =>  => final protected function extendComment(&$comment)
 =>  => {
 =>  =>  =>  => // create delete button
 =>  =>  =>  => if ($this->checkAccess('raidmanager_perm_subs'))
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => $param = array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_comment' => $commentid_comment,
 =>  =>  =>  =>  =>  =>  =>  => 'id_raid' => $commentid_raid
 =>  =>  =>  =>  =>  => );

 =>  =>  =>  =>  =>  => $actionbar = new Actionbar();
 =>  =>  =>  =>  =>  => $actionbarcreateButton('delete')->setRoute('raidmanager_comment_delete', $param);
 =>  =>  =>  =>  =>  => $commentdelete = $actionbarbuild();
 =>  =>  =>  => }

 =>  =>  =>  => // text color by comment type
 =>  =>  =>  => switch ($commentstate)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => case 1 :
 =>  =>  =>  =>  =>  =>  =>  => $commentcolor_msg = ' style="color: #00FF00;"';
 =>  =>  =>  =>  =>  =>  =>  => break;
 =>  =>  =>  =>  =>  => case 2 :
 =>  =>  =>  =>  =>  =>  =>  => $commentcolor_msg = ' style="color: #FF0000;"';
 =>  =>  =>  =>  =>  =>  =>  => break;
 =>  =>  =>  =>  =>  => case 3 :
 =>  =>  =>  =>  =>  =>  =>  => $commentcolor_msg = ' style="color: #2A8EFF;"';
 =>  =>  =>  =>  =>  =>  =>  => break;
 =>  =>  =>  =>  =>  => case 4 :
 =>  =>  =>  =>  =>  =>  =>  => $commentcolor_msg = ' style="color: #2A8EFF;"';
 =>  =>  =>  =>  =>  =>  =>  => break;
 =>  =>  =>  =>  =>  => default :
 =>  =>  =>  =>  =>  =>  =>  => $commentcolor_msg = '';
 =>  =>  =>  =>  =>  =>  =>  => break;
 =>  =>  =>  => }

 =>  =>  =>  => // add name of player if it's not the current player
 =>  =>  =>  => if ($commentid_player != $commentid_poster)
 =>  =>  =>  =>  =>  => $commentmsg .= ' (' . ->appgetModel('Char')->getMaincharName($commentid_poster) . ')';

 =>  =>  =>  => return $comment;
 =>  => }

 =>  => /**
 =>  =>  * Deletes all comments of a specific player
 =>  =>  * @param int $id_player
 =>  =>  */
 =>  => public function deleteByPlayer($id_player)
 =>  => {
 =>  =>  =>  => ->delete(array(
 =>  =>  =>  =>  =>  => 'filter' => 'id_player={int:id_player}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_player' => $id_player
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));
 =>  => }

 =>  => /**
 =>  =>  * Deletes all comments of a specific player with specific player state
 =>  =>  * @param int $id_player
 =>  =>  * @param int $state
 =>  =>  */
 =>  => public function deleteByPlayerAndState($id_player, $state)
 =>  => {
 =>  =>  =>  => if (!is_array($state))
 =>  =>  =>  =>  =>  => $state = array(
 =>  =>  =>  =>  =>  =>  =>  => $state
 =>  =>  =>  =>  =>  => );

 =>  =>  =>  => ->delete(array(
 =>  =>  =>  =>  =>  => 'filter' => 'id_player={int:id_player} AND state IN ({array_int:state})',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_player' => $id_player,
 =>  =>  =>  =>  =>  =>  =>  => 'state' => $state
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));
 =>  => }

 =>  => /**
 =>  =>  * Creates a comment using the provided data
 =>  =>  * @param unknown $data
 =>  =>  */
 =>  => public function createComment($data)
 =>  => {
 =>  =>  =>  => ->data = $data;
 =>  =>  =>  => ->save();

 =>  =>  =>  => // on resign or enroll delete previous comments with opposing state
 =>  =>  =>  => if (!$this->hasErrors() && ->datastate != 0)
 =>  =>  =>  =>  =>  => ->delete(array(
 =>  =>  =>  =>  =>  =>  =>  => 'filter' => 'id_raid={int:id_raid} AND id_player={int:id_player} AND state={int:state}',
 =>  =>  =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'id_raid' => ->dataid_raid,
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'id_player' => ->dataid_player,
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'state' => ->datastate == 1 ? 2 : 1
 =>  =>  =>  =>  =>  =>  =>  => )
 =>  =>  =>  =>  =>  => ));
 =>  => }
}

