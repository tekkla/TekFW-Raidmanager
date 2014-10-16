<?php
namespace Apps\Raidmanager\Controller;

use Core\Lib\Amvc\Controller;
use Core\Lib\Url;
use Core\Lib\Content\Html\Controls\Actionbar;
use Core\Helper\FormDesigner;
use Core\Lib\Content\Html\Elements\Link;
use Core\Lib\Menu;

// Check for direct file access
if (!defined('TEKFW'))
	die('Cannot run without TekFW framework...');

/**
 * Player Controller
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.d
 * @package TekFW
 * @subpackage Global
 * @license MIT
 * @copyright 2014 by author
 * @final
 */
final class PlayerController extends Controller
{
 =>  => // Accessmanagment on actions
 =>  => protected $access = array(
 =>  => 	'*' => 'raidmanager_perm_player'
 =>  => );

 =>  => /**
 =>  =>  * Complete player overview
 =>  =>  */
 =>  => public function Complete()
 =>  => {
 =>  =>  =>  => ->Create();
 =>  =>  =>  => ->Playerlist('old');
 =>  =>  =>  => ->Playerlist('applicant');
 =>  =>  =>  => ->Playerlist('inactive');
 =>  =>  =>  => ->Playerlist('active');

 =>  =>  =>  => ->setAjaxTarget('#raidmanager');
 =>  => }

 =>  => /**
 =>  =>  * Playerlist for a special playertype
 =>  =>  * @param string $type
 =>  =>  */
 =>  => public function Playerlist($type)
 =>  => {
 =>  =>  =>  => $this->setVar(array(
 =>  =>  =>  =>  =>  => $type . '_headline' => $this->txt('playerlist_headline_' . $type),
 =>  =>  =>  =>  =>  => 'empty_list' => $this->txt('playerlist_empty'),
 =>  =>  =>  =>  =>  => $type . '_data' => $this->model->getPlayerlist($type),
 =>  =>  =>  =>  =>  => $type . '_count' => $this->model->countData()
 =>  =>  =>  => ));

 =>  =>  =>  => // Targetdefinition for ajax response
 =>  =>  =>  => ->setAjaxTarget('#raidmanager_playerlist_' . $type);
 =>  => }

 =>  => /**
 =>  =>  * Single player
 =>  =>  * @param int $id_player
 =>  =>  */
 =>  => public function Index($id_player)
 =>  => {
 =>  =>  =>  => $this->setVar('player', $this->model->getPlayer($id_player));
 =>  =>  =>  => ->setAjaxTarget('#raidmanager_player_' . $id_player);
 =>  => }

 =>  => /**
 =>  =>  * Player creation
 =>  =>  */
 =>  => public function Create()
 =>  => {
 =>  =>  =>  => // This only reacts if there are user without a player profile
 =>  =>  =>  => if ($this->appgetModel('Member')countNoProfile() == 0)
 =>  =>  =>  =>  =>  => return;

 =>  =>  =>  => // -----------------------------
 =>  =>  =>  => // Save/create player?
 =>  =>  =>  => // -----------------------------

 =>  =>  =>  => // Get posted playerdate
 =>  =>  =>  => $post = $this->request->getPost();

 =>  =>  =>  => // and create the player if there is posted data
 =>  =>  =>  => if ($post)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // Playercreation
 =>  =>  =>  =>  =>  => $this->model->createPlayer($post);

 =>  =>  =>  =>  =>  => // No errors on player creation means that we do not need the model data anymore
 =>  =>  =>  =>  =>  => // so we reset the model including the data set on save.
 =>  =>  =>  =>  =>  => if ($this->model->hasNoErrors())
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => // Inform user about successful playercreation
 =>  =>  =>  =>  =>  =>  =>  => ->messagesuccess($this->txt('player_created'));

 =>  =>  =>  =>  =>  =>  =>  => // Clear posted data
 =>  =>  =>  =>  =>  =>  =>  => $this->request->clearPost();

 =>  =>  =>  =>  =>  =>  =>  => // Reset model incl set data
 =>  =>  =>  =>  =>  =>  =>  => $this->model->reset(true);

 =>  =>  =>  =>  =>  =>  =>  => // Reload the pagecontent
 =>  =>  =>  =>  =>  =>  =>  => ->run('Complete');
 =>  =>  =>  =>  =>  =>  =>  => return;
 =>  =>  =>  =>  =>  => }
 =>  =>  =>  => }

 =>  =>  =>  => // Set headline text to view
 =>  =>  =>  => $this->setVar('headline', $this->txt('player_create'));

 =>  =>  =>  => // ------------------------------
 =>  =>  =>  => // Form
 =>  =>  =>  => // ------------------------------
 =>  =>  =>  => $form = new FormDesigner();

 =>  =>  =>  => $form->attachModel($this->model);

 =>  =>  =>  => // Route for form post action
 =>  =>  =>  => $form->setActionRoute('raidmanager_player_add');

 =>  =>  =>  => // We use actionbars as buttons, so disable the automatic send button
 =>  =>  =>  => $form->noButtons();

 =>  =>  =>  => // Smf user selection
 =>  =>  =>  => $form->createElement('dataselect', 'id_player')->setLabel($this->txt('player_smfuser'))->setDataSource('Raidmanager', 'Member', 'getNoProfile');

 =>  =>  =>  => // Create form fields
 =>  =>  =>  => $form->createElement('text', 'char_name');
 =>  =>  =>  => $form->createElement('dataselect', 'id_class')->setDataSource('Raidmanager', 'Charclass', 'getClasses');
 =>  =>  =>  => $form->createElement('dataselect', 'id_category')->setDataSource('Raidmanager', 'Category', 'getCategories');
 =>  =>  =>  => $form->createElement('switch', 'autosignon');

 =>  =>  =>  => // Publish form to view
 =>  =>  =>  => $this->setVar('form', $form);

 =>  =>  =>  => // ------------------------------
 =>  =>  =>  => // Actionbar
 =>  =>  =>  => // ------------------------------
 =>  =>  =>  => $actionbar = new Actionbar();
 =>  =>  =>  => $actionbarcreateButton('save')->setForm($form->getId());
 =>  =>  =>  => $this->setVar('actionbar', $actionbar);

 =>  =>  =>  => // ------------------------------
 =>  =>  =>  => // Ajax
 =>  =>  =>  => // ------------------------------
 =>  =>  =>  => ->setAjaxTarget('#raidmanager_player_create');
 =>  => }

 =>  => /**
 =>  =>  * Player editing
 =>  =>  * @param int $id_player
 =>  =>  */
 =>  => public function Edit($id_player)
 =>  => {
 =>  =>  =>  => // ------------------------------
 =>  =>  =>  => // Save edited player?
 =>  =>  =>  => // ------------------------------
 =>  =>  =>  => $post = $this->request->getPost('Raidmanager', 'Player');

 =>  =>  =>  => if ($post)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => $this->model->savePlayer($post);

 =>  =>  =>  =>  =>  => if ($this->model->hasNoErrors())
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => // Refresh menu when user becomes active or when he becomes inactive
 =>  =>  =>  =>  =>  =>  =>  => if ($this->model->datastate == 3 || ($this->model->datastate_compare == 3 && $this->model->datastate != 3))
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => Menu::refreshMenu();

 =>  =>  =>  =>  =>  =>  =>  => ->run($this->model->dataaction, array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'id_player' => $id_player
 =>  =>  =>  =>  =>  =>  =>  => ));
 =>  =>  =>  =>  =>  =>  =>  => return;
 =>  =>  =>  =>  =>  => }
 =>  =>  =>  => }

 =>  =>  =>  => // No data in model? Load it!
 =>  =>  =>  => if ($this->model->hasNoData())
 =>  =>  =>  =>  =>  => $this->model->getPlayer($id_player, false);

 =>  =>  =>  => // Publish playerdata to view
 =>  =>  =>  => $this->setVar('player', $this->model);

 =>  =>  =>  => // Our headline is a class coloured charname enclosed by a link to the smf profile of the player
 =>  =>  =>  => $url = Url::factory()->getUrl(array(
 =>  =>  =>  =>  =>  => 'action' => 'profile',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'area' => 'profile',
 =>  =>  =>  =>  =>  =>  =>  => 'u' => $id_player
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));
 =>  =>  =>  => $link = Link::factory()->setInner('<span class="raidmanager_class_' . $this->model->dataclass . '' . $this->model->datachar_name . '</spa')->setTitle($this->txt('player_smfprofile'))->setTarget('_blank')->setHref($url)build();
 =>  =>  =>  => $this->setVar('headline', $link);

 =>  =>  =>  => // Formdesigner
 =>  =>  =>  => $form = ->getFormDesigner();

 =>  =>  =>  => // Extend fieldnames by the player id
 =>  =>  =>  => $form->extendName($this->model->dataid_player);

 =>  =>  =>  => // Set forms action by route
 =>  =>  =>  => $form->setActionRoute($this->request->getCurrentRoute(), array(
 =>  =>  =>  =>  =>  => 'id_player' => $id_player
 =>  =>  =>  => ));

 =>  =>  =>  => // We use actionbars as buttons, so disable the automatic send button
 =>  =>  =>  => $form->noButtons();

 =>  =>  =>  => // Some hidden fields
 =>  =>  =>  => $form->createElement('hidden', 'id_player');
 =>  =>  =>  => $form->createElement('hidden', 'char_name');
 =>  =>  =>  => $form->createElement('switch', 'autosignon')->setCompare($this->model->dataautosignon);

 =>  =>  =>  => // Playerstate is a select field
 =>  =>  =>  => $control = $form->createElement('select', 'state');

 =>  =>  =>  => // These playerstates are available
 =>  =>  =>  => $states = array(
 =>  =>  =>  =>  =>  => 0 => 'old',
 =>  =>  =>  =>  =>  => 1 => 'applicant',
 =>  =>  =>  =>  =>  => 2 => 'inactive',
 =>  =>  =>  =>  =>  => 3 => 'active'
 =>  =>  =>  => );

 =>  =>  =>  => // Adding all states as option
 =>  =>  =>  => foreach ( $states as $val => $state )
 =>  =>  =>  =>  =>  => $control->newOption($val, $this->txt('player_state_' . $state), $this->model->datastate == $val ? 1 : 0);

 =>  =>  =>  => // Playerstate compare for changes
 =>  =>  =>  => $control->setCompare($this->model->datastate);

 =>  =>  =>  => // Publish form to view
 =>  =>  =>  => $this->setVar('form', $form);

 =>  =>  =>  => // Create new actionbar
 =>  =>  =>  => $actionbar = new Actionbar();

 =>  =>  =>  => // General actionbar parameter
 =>  =>  =>  => $param = array(
 =>  =>  =>  =>  =>  => 'id_player' => $id_player
 =>  =>  =>  => );

 =>  =>  =>  => // Cancel button
 =>  =>  =>  => $actionbarcreateButton('cancel')->setRoute('raidmanager_player_index', $param);

 =>  =>  =>  => // Save button
 =>  =>  =>  => $actionbarcreateButton('save')->setForm($form->getId())->setRoute('raidmanager_player_edit', $param);

 =>  =>  =>  => // Publish actionbar to view
 =>  =>  =>  => $this->setVar('actionbar', $actionbar);

 =>  =>  =>  => // Get result of charlist controller and publih it to view
 =>  =>  =>  => $this->setVar('charlist', ->getController('Char')run('Index'));

 =>  =>  =>  => // Ajax response target
 =>  =>  =>  => ->setAjaxTarget('#raidmanager_player_' . $id_player);
 =>  => }

 =>  => /**
 =>  =>  * Deletes a player from the playertable and from all tables whre it's id is
 =>  =>  * stored in
 =>  =>  */
 =>  => public function Delete($id_player)
 =>  => {
 =>  =>  =>  => // Delete the player
 =>  =>  =>  => $this->model->deletePlayer($id_player);

 =>  =>  =>  => // Delete is complete. reload the playerlist.
 =>  =>  =>  => ->run('Complete');
 =>  => }
}

