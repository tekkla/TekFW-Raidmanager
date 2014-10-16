<?php
namespace Apps\Raidmanager\Controller;

use Core\Lib\Amvc\Controller;
use Core\Lib\Content\Html\Controls\Actionbar;

if (!defined('TEKFW'))
	die('Cannot run without TekFW framework...');

/**
 * Char controller
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.d
 * @package TekFW
 * @subpackage App Raidmanager
 * @license MIT
 * @copyright 2014 by author
 */
final class CharController extends Controller
{
 =>  => public $access = array(
 =>  =>  =>  => '*' => array('raidmananger_perm_player'),
 =>  => );

 =>  => public function Index($id_player)
 =>  => {
 =>  =>  =>  => ->Charlist($id_player);
 =>  => }

 =>  => public function Charlist($id_player)
 =>  => {
 =>  =>  =>  => // Load and pulish charlist data
 =>  =>  =>  => $this->setVar('charlist', $this->model->getCharlist($id_player));

 =>  =>  =>  => // Headline and frame id
 =>  =>  =>  => $this->setVar(array(
 =>  =>  =>  =>  =>  => 'headline' => $this->txt('charlist_headline') . ' (' . $this->model->countData() . ')',
 =>  =>  =>  =>  =>  => 'frame_id' => 'raidmanager_charlist_' . $id_player
 =>  =>  =>  => ));

 =>  =>  =>  => // Create and publish actionbar
 =>  =>  =>  => if ($this->checkUserrights('raidmanager_player_edit') === true)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => $actionbar = new Actionbar();
 =>  =>  =>  =>  =>  => $actionbarcreateButton('new', 'ajax', 'icon')->setRoute('raidmanager_char_add', array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_player' => $id_player
 =>  =>  =>  =>  =>  => ));
 =>  =>  =>  =>  =>  => $this->setVar('actionbar', $actionbar);
 =>  =>  =>  => }

 =>  =>  =>  => // Set target for ajax response
 =>  =>  =>  => ->setAjaxTarget('#raidmanager_charlist_' . $id_player);
 =>  => }

 =>  => public function Edit($id_player, $id_char = null)
 =>  => {
 =>  =>  =>  => ## DATA ########################################################################################################

 =>  =>  =>  => // Get the posted data
 =>  =>  =>  => $post = $this->request->getPost();

 =>  =>  =>  => if ($post)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // Attach player id to posted data
 =>  =>  =>  =>  =>  => $postid_player = $id_player;

 =>  =>  =>  =>  =>  => // Attach set char id to posted data
 =>  =>  =>  =>  =>  => if (isset($id_char))
 =>  =>  =>  =>  =>  =>  =>  => $postid_char = $id_char;

 =>  =>  =>  =>  =>  => // Try to save our char data
 =>  =>  =>  =>  =>  => $this->model->saveChar($post);

 =>  =>  =>  =>  =>  => // Any errors? No? Refresh the pageparts
 =>  =>  =>  =>  =>  => if ($this->model->hasNoErrors())
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => // Parameter both functions need
 =>  =>  =>  =>  =>  =>  =>  => $param = array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'id_player' => $id_player
 =>  =>  =>  =>  =>  =>  =>  => );

 =>  =>  =>  =>  =>  =>  =>  => // If we edited a mainchar, we have to reload the complete player editor. And we only want an ajax result!
 =>  =>  =>  =>  =>  =>  =>  => if ($this->model->datais_main)
 =>  =>  =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => ->getController('Player')ajax('Edit', $param);
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => return false;
 =>  =>  =>  =>  =>  =>  =>  => }
 =>  =>  =>  =>  =>  =>  =>  => else
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => ->run('Charlist', $param);

 =>  =>  =>  =>  =>  =>  =>  => // End here
 =>  =>  =>  =>  =>  =>  =>  => return;
 =>  =>  =>  =>  =>  => }
 =>  =>  =>  => }

 =>  =>  =>  => // load data from model if char id is given
 =>  =>  =>  => // otherwise assume it is a new char
 =>  =>  =>  => if ($this->model->hasNoData())
 =>  =>  =>  =>  =>  => $this->model->getEditChar($id_player, $id_char);

 =>  =>  =>  => // Publish headlien
 =>  =>  =>  => $this->setVar('headline', $this->txt('char_' . $this->model->datamode . '_headline'));

 =>  =>  =>  => ## Form ########################################################################################################

 =>  =>  =>  => // General parameter list
 =>  =>  =>  => $param = array(
 =>  =>  =>  =>  =>  => 'id_player' => $id_player
 =>  =>  =>  => );

 =>  =>  =>  => // Add set char id as parameter
 =>  =>  =>  => if (!empty($id_char))
 =>  =>  =>  =>  =>  => $param['id_char'] = $id_char;

 =>  =>  =>  => // Get new FormDesigner
 =>  =>  =>  => $form = ->getFormDesigner();

 =>  =>  =>  => // Set route as a form action
 =>  =>  =>  => $form->setActionRoute($this->request->getCurrentRoute(), $param);

 =>  =>  =>  => // No buttons needed. Using Actionbar.
 =>  =>  =>  => $form->noButtons();

 =>  =>  =>  => // Hidden mode field
 =>  =>  =>  => $form->createElement('hidden', 'mode');

 =>  =>  =>  => // Input: char name
 =>  =>  =>  => $form->createElement('text', 'char_name')hasCompare(true);

 =>  =>  =>  => // Select: class
 =>  =>  =>  => $control = $form->createElement('dataselect', 'id_class')->setDataSource('Raidmanager', 'Charclass', 'getClasses');

 =>  =>  =>  => if (isset($this->model->dataid_class))
 =>  =>  =>  =>  =>  => $control->setSelectedValue($this->model->dataid_class);

 =>  =>  =>  => // Select: category
 =>  =>  =>  => $control = $form->createElement('dataselect', 'id_category')->setDataSource('Raidmanager', 'Category', 'getCategories');

 =>  =>  =>  => if (isset($this->model->dataid_category))
 =>  =>  =>  =>  =>  => $control->setSelectedValue($this->model->dataid_category);

 =>  =>  =>  => // Mainchar selection only on chars which are not mains
 =>  =>  =>  => if (isset($this->model->datais_main) && $this->model->datais_main == 0)
 =>  =>  =>  =>  =>  => $form->createElement('switch', 'is_main');

 =>  =>  =>  => // Publish form
 =>  =>  =>  => $this->setVar('form', $form);

 =>  =>  =>  => ## Actionbar

 =>  =>  =>  => $actionbar = new Actionbar();

 =>  =>  =>  => // cancel button
 =>  =>  =>  => $actionbarcreateButton('cancel', 'ajax', 'icon')->setRoute('raidmanager_char_list', $param);

 =>  =>  =>  => // save button
 =>  =>  =>  => $actionbarcreateButton('save', 'ajax', 'icon')->setForm($form->getId())->setRoute($this->request->getCurrentRoute(), $param);

 =>  =>  =>  => // Publish actionbar to view.
 =>  =>  =>  => $this->setVar('actionbar', $actionbar);

 =>  =>  =>  => // Define ajax ajax target
 =>  =>  =>  => ->setAjaxTarget('#raidmanager_charlist_' . $id_player);
 =>  => }

 =>  => /**
 =>  =>  * Delete a char of a player
 =>  =>  * @param int $id_player
 =>  =>  * @param int $id_char
 =>  =>  */
 =>  => public function Delete($id_player, $id_char)
 =>  => {
 =>  =>  =>  => $this->model->deleteChar($id_char);
 =>  =>  =>  => ->ajax('Charlist', array(
 =>  =>  =>  =>  =>  => 'id_player' => $id_player
 =>  =>  =>  => ));
 =>  => }
}

