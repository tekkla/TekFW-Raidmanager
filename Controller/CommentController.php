<?php
namespace Apps\Raidmanager\Controller;

use Core\Lib\Amvc\Controller;
use Core\Lib\User;
use Core\Lib\Content\Html\Controls\Actionbar;

if (!defined('TEKFW'))
 =>  => die('Cannot run without TekFW framework...');

/**
 * Raidmanager Comment Controller
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.d
 */
final class CommentController extends Controller
{
 =>  => public $access = array(
 =>  =>  =>  => 'Delete' => 'raidmanager_perm_subs'
 =>  => );

 =>  => public function Index($id_raid)
 =>  => {
 =>  =>  =>  => // -----------------------------------
 =>  =>  =>  => // Button creation
 =>  =>  =>  => // -----------------------------------
 =>  =>  =>  => $buttons = [];

 =>  =>  =>  => // get subscription state of player
 =>  =>  =>  => $subscription = $this->getModel('Subscription')->getIdAndState($id_raid, User::getId());

 =>  =>  =>  => if ($subscription)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // create the enroll/resign and comment button
 =>  =>  =>  =>  =>  => $actionbar = new Actionbar();

 =>  =>  =>  =>  =>  => // player is enrolled (undefined), button is resignbutton
 =>  =>  =>  =>  =>  => if ($subscriptionstate == 1 || $subscriptionstate == 0)
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => $actionbuttons[] = array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'state' => 2,
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'txt' => 'comment_resign',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'img' => 'frown-o',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'btn' => 'btn-danger'
 =>  =>  =>  =>  =>  =>  =>  => );
 =>  =>  =>  =>  =>  => }

 =>  =>  =>  =>  =>  => // player is not enrolled, button is enrollbutton
 =>  =>  =>  =>  =>  => if ($subscriptionstate == 2 || $subscriptionstate == 0)
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => $actionbuttons[] = array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'state' => 1,
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'txt' => 'comment_enroll',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'img' => 'smile-o',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'btn' => 'btn-success'
 =>  =>  =>  =>  =>  =>  =>  => );
 =>  =>  =>  =>  =>  => }

 =>  =>  =>  =>  =>  => // add comment button
 =>  =>  =>  =>  =>  => $actionbuttons[] = array(
 =>  =>  =>  =>  =>  =>  =>  => 'state' => 0,
 =>  =>  =>  =>  =>  =>  =>  => 'txt' => 'comment_comment',
 =>  =>  =>  =>  =>  =>  =>  => 'img' => 'comment'
 =>  =>  =>  =>  =>  => );

 =>  =>  =>  =>  =>  => foreach ( $actionbuttons as $actbtn )
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => if (!$subscriptionid_subscription)
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => continue;

 =>  =>  =>  =>  =>  =>  =>  => // create subscriptionlink
 =>  =>  =>  =>  =>  =>  =>  => $button = $actionbarcreateButton($actbtn['txt'])->setIcon($actbtn['img'])->setTitle($this->txt($actbtn['txt']));

 =>  =>  =>  =>  =>  =>  =>  => if (isset($actbtn['color']))
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $buttonaddStyle('color', $actbtn['color']);

 =>  =>  =>  =>  =>  =>  =>  => if (isset($actbtn['btn']))
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $buttonaddCss($actbtn['btn']);

 =>  =>  =>  =>  =>  =>  =>  => $param = array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'id_subscription' => $subscriptionid_subscription,
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'state' => $actbtn['state'],
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'from' => 'comment',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'id_player' => User::getId(),
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'id_raid' => $id_raid
 =>  =>  =>  =>  =>  =>  =>  => );

 =>  =>  =>  =>  =>  =>  =>  => $buttonsetRoute('raidmanager_subscription_enrollform', $param);
 =>  =>  =>  =>  =>  => }

 =>  =>  =>  =>  =>  => // create actionbar
 =>  =>  =>  =>  =>  => if ($actionbarbuttons)
 =>  =>  =>  =>  =>  =>  =>  => $this->setVar('actionbar', $actionbar);
 =>  =>  =>  => }

 =>  =>  =>  => // --------------------------------
 =>  =>  =>  => // Comment data
 =>  =>  =>  => // --------------------------------
 =>  =>  =>  => $comments = $this->model->getComments($id_raid);
 =>  =>  =>  => $this->setVar('comments', $comments);

 =>  =>  =>  => $this->setVar(array(
 =>  =>  =>  =>  =>  => 'headline' => $this->txt('comment_headline') . ($comments ? ' (' . $commentscount() . ')' : ''),
 =>  =>  =>  =>  =>  => 'empty' => $this->txt('comment_empty')
 =>  =>  =>  => ));

 =>  =>  =>  => // -------------------------------
 =>  =>  =>  => // Ajax output definition
 =>  =>  =>  => // -------------------------------
 =>  =>  =>  => ->setAjaxTarget('#raidmanager_comments');
 =>  => }

 =>  => /**
 =>  =>  * Deletes comment
 =>  =>  * @param int $id_comment
 =>  =>  * @param int $id_raid
 =>  =>  */
 =>  => public function Delete($id_comment, $id_raid)
 =>  => {
 =>  =>  =>  => // still here? seems all checks were ok.
 =>  =>  =>  => $this->model->delete($id_comment);
 =>  =>  =>  => ->run('index', array(
 =>  =>  =>  =>  =>  => 'id_raid' => $id_raid
 =>  =>  =>  => ));
 =>  => }
}

