<?php
namespace Apps\Raidmanager\Controller;

use Core\Lib\Error;
use Core\Lib\Amvc\Controller;
use Core\Lib\Url;
use Core\Lib\Content\Html\Controls\Actionbar;
use Core\Lib\Content\Html\Controls\UiButton;

if (!defined('TEKFW'))
 =>  => die('Cannot run without TekFW framework...');

/**
 * Raid controller
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.d
 * @package TekFW
 * @subpackage App Raidmanager
 * @license MIT
 * @copyright 2014 by author
 */
final class RaidController extends Controller
{
 =>  => protected $access = array(
 =>  =>  =>  => 'Edit' => 'raidmanager_perm_raid',
 =>  =>  =>  => 'Save' => 'raidmanager_perm_raid',
 =>  =>  =>  => 'Delete' => 'raidmanager_perm_raid'
 =>  => );
 =>  => protected $events = array(
 =>  =>  =>  => 'Complete' => array(
 =>  =>  =>  =>  =>  => 'before' => 'checkForRaidId'
 =>  =>  =>  => ),
 =>  =>  =>  => 'WidgetNextRaid' => array(
 =>  =>  =>  =>  =>  => 'before' => 'checkForRaidId'
 =>  =>  =>  => )
 =>  => );

 =>  => /**
 =>  =>  *
 =>  =>  * @param int $id_raid
 =>  =>  */
 =>  => public function Complete($id_raid)
 =>  => {
 =>  =>  =>  => // load calendar
 =>  =>  =>  => ->Calendar($id_raid);

 =>  =>  =>  => // load raid
 =>  =>  =>  => ->Index($id_raid);

 =>  =>  =>  => // Set the target where to put the contennt of this action on ajax requests
 =>  =>  =>  => ->setAjaxTarget('#raidmanager');
 =>  => }

 =>  => /**
 =>  =>  * Checks for the current raid id in request.
 =>  =>  * If no raid id in request,
 =>  =>  * it tries to get the id of the next upcomming raid. If this also fails,
 =>  =>  * because of no raids, the raid autoadd function will be started.
 =>  =>  */
 =>  => public function checkForRaidId()
 =>  => {
 =>  =>  =>  => // Is there a raid id in the request?
 =>  =>  =>  => if ($this->request->checkParam('id_raid') === false)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // Try to get raid id from database
 =>  =>  =>  =>  =>  => $id_raid = $this->model->getNextRaidID();

 =>  =>  =>  =>  =>  => if ($id_raid)
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => // add id_raid to current controllers parameter
 =>  =>  =>  =>  =>  =>  =>  => ->addParam('id_raid', $id_raid);

 =>  =>  =>  =>  =>  =>  =>  => // And publish it via request for other controllers which may need it
 =>  =>  =>  =>  =>  =>  =>  => $this->request->addParam('id_raid', $id_raid);
 =>  =>  =>  =>  =>  => } else
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => // The following belongs only to users with config userrights
 =>  =>  =>  =>  =>  =>  =>  => if ($this->checkAccess('raidmanager_perm_config'))
 =>  =>  =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => // Autoraid failed and we have no raids in db. Check for not set raiddays.
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => if (!$this->cfg('raid_days'))
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => // No raiddays found, redirect user to raidmanager config and set a flash message
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => // to select the days to use for raids
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => ->messagewarning($this->txt('no_raid_days_selected'));
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => $this->redirectExit(Url::factory('admin_app_config', array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_name' => 'raidmanager'
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => ))->getUrl());
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => }

 =>  =>  =>  =>  =>  =>  =>  =>  =>  => // At this point there is whether a raid id as parameter nor as id from the db.
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => // We have to assume that no future raids exist. show error message and offer a
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => // link to create a raid.
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $button = UiButton::routeLink('raidmanager_raid_add', null, 'full')->setInner($this->txt('raidmanager_action_raid_add'));

 =>  =>  =>  =>  =>  =>  =>  =>  =>  => Throw new Error($this->txt('raidmanager_raid_noraid found') . '<b' . $buttonbuild());
 =>  =>  =>  =>  =>  =>  =>  => }
 =>  =>  =>  =>  =>  => }
 =>  =>  =>  => }
 =>  => }

 =>  => function Calendar($id_raid)
 =>  => {
 =>  =>  =>  => // calendar
 =>  =>  =>  => $this->setVar('calendar', ->getController('Calendar')run('index', array(
 =>  =>  =>  =>  =>  => 'id_raid' => $id_raid
 =>  =>  =>  => )));

 =>  =>  =>  => // Set the target where to put the contennt of this action on ajax requests
 =>  =>  =>  => ->setAjaxTarget('#raidmanager_calendar');
 =>  => }

 =>  => function Index($id_raid)
 =>  => {
 =>  =>  =>  => // raidinfos
 =>  =>  =>  => ->Infos($id_raid);

 =>  =>  =>  => // -----------------------------
 =>  =>  =>  => // content from other controller
 =>  =>  =>  => // -----------------------------

 =>  =>  =>  => // comments
 =>  =>  =>  => $this->setVar('comments', ->getController('Comment')run('index', array(
 =>  =>  =>  =>  =>  => 'id_raid' => $id_raid
 =>  =>  =>  => )));

 =>  =>  =>  => // subsriptions
 =>  =>  =>  => $this->setVar('subscriptions', ->getController('Subscription')run('index', array(
 =>  =>  =>  =>  =>  => 'id_raid' => $id_raid
 =>  =>  =>  => )));

 =>  =>  =>  => // setups
 =>  =>  =>  => $this->setVar('setups', ->getController('Setup')run('complete', array(
 =>  =>  =>  =>  =>  => 'id_raid' => $id_raid
 =>  =>  =>  => )));

 =>  =>  =>  => // Set the target where to put the contennt of this action on ajax requests
 =>  =>  =>  => ->setAjaxTarget('#raidmanager_raid');
 =>  => }

 =>  => function Infos($id_raid)
 =>  => {
 =>  =>  =>  => // Create actionbar if access granted
 =>  =>  =>  => if ($this->checkUserrights('raidmanager_perm_raid'))
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => $actionbar = new Actionbar();

 =>  =>  =>  =>  =>  => $param = array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_raid' => $id_raid,
 =>  =>  =>  =>  =>  =>  =>  => 'back_to' => $id_raid,
 =>  =>  =>  =>  =>  =>  =>  => 'target' => 'raidmanager_infos'
 =>  =>  =>  =>  =>  => );

 =>  =>  =>  =>  =>  => $actionbarcreateButton('edit')->setRoute('raidmanager_raid_edit', $param);
 =>  =>  =>  =>  =>  => $actionbarcreateButton('new')->setRoute('raidmanager_raid_add', $param);
 =>  =>  =>  =>  =>  => $actionbarcreateButton('autoadd')->setRoute('raidmanager_raid_autoadd', $param)->setIcon('calendar')->setTitle($this->txt('raid_autoraid'))useFull();
 =>  =>  =>  =>  =>  => $actionbarcreateButton('delete')->setRoute('raidmanager_raid_delete', $param);

 =>  =>  =>  =>  =>  => $this->setVar('actionbar', $actionbar);
 =>  =>  =>  => }

 =>  =>  =>  => $this->setVar(array(
 =>  =>  =>  =>  =>  => 'data' => $this->model->getInfos($id_raid),
 =>  =>  =>  =>  =>  => 'txt_specials' => $this->txt('raid_specials')
 =>  =>  =>  => ));

 =>  =>  =>  => if (isset($datatopic_url))
 =>  =>  =>  =>  =>  => $this->setVar('txt_topiclink', $this->txt('raid_topiclink'));

 =>  =>  =>  => ->setAjaxTarget('#raidmanager_infos');
 =>  => }

 =>  => function Edit($back_to, $id_raid = null)
 =>  => {
 =>  =>  =>  => ## DATA ########################################################################################################

 =>  =>  =>  => $post = $this->request->getPost();

 =>  =>  =>  => if ($post)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => $this->model->saveInfos($post);

 =>  =>  =>  =>  =>  => if ($this->model->hasNoErrors())
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => $param = => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'id_raid' => $this->model->dataid_raid
 =>  =>  =>  =>  =>  =>  =>  => );

 =>  =>  =>  =>  =>  =>  =>  => // Load info display
 =>  =>  =>  =>  =>  =>  =>  => ->run($this->model->dataaction, $param);

 =>  =>  =>  =>  =>  =>  =>  => // Update calendar
 =>  =>  =>  =>  =>  =>  =>  => ->getController('Calendar')ajax('Index', $param, '#raidmanager_calendar');

 =>  =>  =>  =>  =>  =>  =>  => return;
 =>  =>  =>  =>  =>  => }
 =>  =>  =>  => }

 =>  =>  =>  => // Load data only if there is no data present
 =>  =>  =>  => if ($this->model->hasNoData())
 =>  =>  =>  =>  =>  => $this->model->getEdit($id_raid);

 =>  =>  =>  => ## FORM ########################################################################################################

 =>  =>  =>  => // Get model bound form designer object
 =>  =>  =>  => $form = ->getFormDesigner();

 =>  =>  =>  => // Predefine some general parameter
 =>  =>  =>  => $param = array(
 =>  =>  =>  =>  =>  => 'back_to' => $back_to
 =>  =>  =>  => );

 =>  =>  =>  => if (isset($id_raid))
 =>  =>  =>  =>  =>  => $param['id_raid'] = $id_raid;

 =>  =>  =>  => // Define form action
 =>  =>  =>  => $form->setActionRoute($this->request->getCurrentRoute(), $param);

 =>  =>  =>  => // No buttons please
 =>  =>  =>  => $form->noButtons();

 =>  =>  =>  => // hidden raid id field only on edit
 =>  =>  =>  => if (isset($id_raid))
 =>  =>  =>  =>  =>  => $form->createElement('hidden', 'id_raid');

 =>  =>  =>  => // Edit or new mode
 =>  =>  =>  => $form->createElement('hidden', 'mode');

 =>  =>  =>  => // Destination field
 =>  =>  =>  => $form->createElement('text', 'destination');

 =>  =>  =>  => // Open a new group for the starting date and time
 =>  =>  =>  => $form->openGroup()newRow();

 =>  =>  =>  => // date start field
 =>  =>  =>  => $form->createElement('datetime', 'starttime')->setElementWidth('sm-2')->setMinDate(date("Y-m-d"))->setMinuteStepping(15);

 =>  =>  =>  => // date end field
 =>  =>  =>  => $form->createElement('datetime', 'endtime')->setElementWidth('sm-2')->setMinDate(date("Y-m-d"))->setMinuteStepping(15);

 =>  =>  =>  => $form->closeGroup();

 =>  =>  =>  => // specials textarea
 =>  =>  =>  => $form->createElement('textarea', 'specials')->setRows(5);

 =>  =>  =>  => if (!isset($id_raid))
 =>  =>  =>  =>  =>  => $form->createElement('switch', 'autosignon');

 =>  =>  =>  => $this->setVar('form', $form);

 =>  =>  =>  => ## ACTIONBAR ###################################################################################################

 =>  =>  =>  => // create actionbar
 =>  =>  =>  => $actionbar = new Actionbar();

 =>  =>  =>  => // prepare button creation
 =>  =>  =>  => $app = 'raidmanager';
 =>  =>  =>  => $control = 'raid';

 =>  =>  =>  => // cancel button
 =>  =>  =>  => $button = $actionbarcreateButton('cancel');

 =>  =>  =>  => $param = array(
 =>  =>  =>  =>  =>  => 'id_raid' => $back_to
 =>  =>  =>  => );

 =>  =>  =>  => if (isset($id_raid))
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // on cancel reload only raidinfos
 =>  =>  =>  =>  =>  => $target = 'raidmanager_infos';
 =>  =>  =>  =>  =>  => $route = 'raidmanager_raid_infos';
 =>  =>  =>  => } else
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // on cancel reload complete raid
 =>  =>  =>  =>  =>  => $target = 'raidmanager_raid';
 =>  =>  =>  =>  =>  => $route = 'raidmanager_raid_data';
 =>  =>  =>  => }

 =>  =>  =>  => $buttonsetTarget($target);
 =>  =>  =>  => $buttonsetRoute($route, $param);

 =>  =>  =>  => // save button
 =>  =>  =>  => $button = $actionbarcreateButton('save');

 =>  =>  =>  => $param = array(
 =>  =>  =>  =>  =>  => 'back_to' => $back_to
 =>  =>  =>  => );

 =>  =>  =>  => if (isset($id_raid))
 =>  =>  =>  =>  =>  => $param['id_raid'] = $id_raid;

 =>  =>  =>  => $buttonsetRoute($this->request->getCurrentRoute(), $param);

 =>  =>  =>  => // set the formname we want to post
 =>  =>  =>  => $buttonsetForm($form->getId());

 =>  =>  =>  => ## VIEW ########################################################################################################

 =>  =>  =>  => // finally publish all our stuff to the view
 =>  =>  =>  => $this->setVar(array(
 =>  =>  =>  =>  =>  => 'headline' => $this->txt('raid_headline_' . $this->model->datamode),
 =>  =>  =>  =>  =>  => 'actionbar' => $actionbar,
 =>  =>  =>  =>  =>  => 'edit' => $this->model->data
 =>  =>  =>  => ));

 =>  =>  =>  => ## AJAX ########################################################################################################

 =>  =>  =>  => // Set the target where to put the contennt of this action on ajax requests
 =>  =>  =>  => ->setAjaxTarget('#' . $target);
 =>  => }

 =>  => public function Delete($id_raid)
 =>  => {
 =>  =>  =>  => ->firephp(__METHOD__);

 =>  =>  =>  => $this->model->deleteRaid($id_raid);

 =>  =>  =>  => ->firephp('Raid deleted');

 =>  =>  =>  => // redirect to the index page of raidmanager
 =>  =>  =>  => ->doRefresh(Url::factory('raidmanager_raid_start'));



 =>  =>  =>  => // This action has no render result.
 =>  =>  =>  => return false;
 =>  => }

 =>  => public function Autoadd()
 =>  => {
 =>  =>  =>  => // this action has no render result

 =>  =>  =>  => // no, so let's try to add some raid by autoadding
 =>  =>  =>  => $this->model->autoAddRaids();

 =>  =>  =>  => if ($this->model->hasErrors())
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => ->debug($this->model->errors, 'console');
 =>  =>  =>  => } else
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => $url = URL::factory('raidmanager_raid_start')->getUrl();
 =>  =>  =>  =>  =>  => $this->redirectExit($url);
 =>  =>  =>  => }
 =>  => }

 =>  => public function Reset()
 =>  => {
 =>  =>  =>  => $this->model->clearAllRaids();
 =>  =>  =>  => ->Autoadd();
 =>  => }
}

