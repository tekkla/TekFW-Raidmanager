<?php

namespace Apps\Raidmanager\Controller;

use Core\Lib\Amvc\Controller;
use Core\Lib\Content\Html\Controls\Actionbar;

class SetupController extends Controller
{
 =>  => protected $access = array(
 =>  =>  =>  => 'Edit' => 'raidmanager_perm_setup',
 =>  =>  =>  => 'Delete' => 'raidmanager_perm_setup'
 =>  => );

 =>  => public function Index($id_setup)
 =>  => {
 =>  =>  =>  => // create infos
 =>  =>  =>  => ->Infos($id_setup);

 =>  =>  =>  => // create setlist
 =>  =>  =>  => $this->setVar('setlist_' . $id_setup, ->getController('Setlist')run('Complete', array(
 =>  =>  =>  =>  =>  => 'id_setup' => $id_setup
 =>  =>  =>  => )));

 =>  =>  =>  => // ajax definition
 =>  =>  =>  => ->setAjaxTarget('#raidmanager_setup_' . $id_setup);
 =>  => }

 =>  => public function Complete($id_raid)
 =>  => {
 =>  =>  =>  => $setup_keys = $this->model->getIdsByRaid($id_raid);

 =>  =>  =>  => $this->setVar('setup_keys', $setup_keys);

 =>  =>  =>  => foreach ( $setup_keys as $id_setup )
 =>  =>  =>  =>  =>  => ->Index($id_setup);

 =>  =>  =>  => ->setAjaxTarget('#raidmanager_setups');
 =>  => }

 =>  => public function Infos($id_setup)
 =>  => {
 =>  =>  =>  => $this->model->getInfos($id_setup);

 =>  =>  =>  => // ------------------------------
 =>  =>  =>  => // Actionbar
 =>  =>  =>  => // ------------------------------
 =>  =>  =>  => $actionbar = new Actionbar();

 =>  =>  =>  => $param = array(
 =>  =>  =>  =>  =>  => 'id_raid' => $this->model->dataid_raid,
 =>  =>  =>  =>  =>  => 'id_setup' => $this->model->dataid_setup,
 =>  =>  =>  =>  =>  => 'back_to' => $this->model->dataid_setup
 =>  =>  =>  => );

 =>  =>  =>  => if ($this->checkAccess('raidmanager_perm_setup') === true)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // build edit button
 =>  =>  =>  =>  =>  => $actionbarcreateButton('edit')->setRoute('raidmanager_setup_edit', $param);

 =>  =>  =>  =>  =>  => // build add setup button
 =>  =>  =>  =>  =>  => $actionbarcreateButton('new')->setRoute('raidmanager_setup_add', $param);
 =>  =>  =>  => }

 =>  =>  =>  => // build add button
 =>  =>  =>  => if ($this->checkAccess('raidmanager_perm_setlist') === true && $this->getModel('Setlist')countAvail($id_setup) 0)
 =>  =>  =>  =>  =>  => $actionbarcreateButton('setup')->setIcon('user')->setRoute('raidmanager_setlist_edit', $param);

 =>  =>  =>  => // delete button only if there is more than one setup
 =>  =>  =>  => if ($this->model->datanum_setups 1 && $this->checkAccess('raidmanager_perm_setup') === true)
 =>  =>  =>  =>  =>  => $actionbarcreateButton('delete')->setRoute('raidmanager_setup_delete', $param);

 =>  =>  =>  => // build bar if access allowed
 =>  =>  =>  => $this->model->dataactionbar = $actionbarbuild();

 =>  =>  =>  => $this->setVar('infos_' . $id_setup, $this->model->data);
 =>  => }

 =>  => public function Edit($back_to, $id_raid, $id_setup = null)
 =>  => {
 =>  =>  =>  => $post = $this->request->getPost();

 =>  =>  =>  => // start save process on posted data exists
 =>  =>  =>  => if ($post)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // set the setup id we are from as id to copy setlist from
 =>  =>  =>  =>  =>  => $postid_from = $back_to;

 =>  =>  =>  =>  =>  => // save data?
 =>  =>  =>  =>  =>  => $this->model->saveSetup($post);

 =>  =>  =>  =>  =>  => // no errors? then redirect to content to show
 =>  =>  =>  =>  =>  => if ($this->model->hasNoErrors())
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => // is this an edit or a new setup?
 =>  =>  =>  =>  =>  =>  =>  => if ($this->model->datamode == 'new' || $this->model->dataposition != $this->model->dataold_position)
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => // this is a new setup. refresh the complete setup section
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => ->run('complete', array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'id_raid' => $this->model->dataid_raid
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => ));
 =>  =>  =>  =>  =>  =>  =>  => else
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => // this is an update. refresh only the setup
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => ->run('index', array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'id_setup' => $this->model->dataid_setup
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => ));

 =>  =>  =>  =>  =>  =>  =>  => return;
 =>  =>  =>  =>  =>  => }
 =>  =>  =>  => }

 =>  =>  =>  => // Do we need to load data?
 =>  =>  =>  => if ($this->model->hasNoData())
 =>  =>  =>  =>  =>  => $this->model->getEditSetup($id_raid, $id_setup);

 =>  =>  =>  =>  =>  => // Set headline text
 =>  =>  =>  => $this->setVar('headline', $this->txt('setup_' . $this->model->datamode));

 =>  =>  =>  => // ------------------------------
 =>  =>  =>  => // FORM
 =>  =>  =>  => // ------------------------------

 =>  =>  =>  => // Prepare parameters
 =>  =>  =>  => $param = array(
 =>  =>  =>  =>  =>  => 'back_to' => $back_to,
 =>  =>  =>  =>  =>  => 'id_raid' => $id_raid
 =>  =>  =>  => );

 =>  =>  =>  => if (isset($id_setup))
 =>  =>  =>  =>  =>  => $param['id_setup'] = $id_setup;

 =>  =>  =>  => $form = ->getFormDesigner();

 =>  =>  =>  => // Set forms action route
 =>  =>  =>  => $form->setActionRoute($this->request->getCurrentRoute(), $param);

 =>  =>  =>  => // We need no buttons
 =>  =>  =>  => $form->noButtons();

 =>  =>  =>  => // Hidden controls
 =>  =>  =>  => if (isset($this->model->dataid_setup))
 =>  =>  =>  =>  =>  => $form->createElement('hidden', 'id_setup');

 =>  =>  =>  => $form->createElement('hidden', 'id_raid');
 =>  =>  =>  => $form->createElement('hidden', 'mode');

 =>  =>  =>  => // Title input
 =>  =>  =>  => $form->createElement('text', 'title');

 =>  =>  =>  => // Description textarea
 =>  =>  =>  => $form->createElement('textarea', 'description')->setAutofocus()->setCols(40)->setRows(3);

 =>  =>  =>  => // Needed categories number inputs
 =>  =>  =>  => $categories = array(
 =>  =>  =>  =>  =>  => 'tank',
 =>  =>  =>  =>  =>  => 'damage',
 =>  =>  =>  =>  =>  => 'heal'
 =>  =>  =>  => );

 =>  =>  =>  => foreach ( $categories as $cat )
 =>  =>  =>  =>  =>  => $form->createElement('number', 'need_' . $cat)->setSize(2)->setMaxlenght(2)->addAttribute('min', 0);

 =>  =>  =>  => // Other number inputs
 =>  =>  =>  => $fields = array(
 =>  =>  =>  =>  =>  => 'points',
 =>  =>  =>  =>  =>  => 'position'
 =>  =>  =>  => );

 =>  =>  =>  => foreach ( $fields as $fld )
 =>  =>  =>  =>  =>  => $form->createElement('number', $fld)->setSize(2)->setMaxlenght(2);

 =>  =>  =>  => // Send form to view
 =>  =>  =>  => $this->setVar('form', $form);

 =>  =>  =>  => // Actionbar
 =>  =>  =>  => $actionbar = new Actionbar();

 =>  =>  =>  => // Build cancel button
 =>  =>  =>  => $button = $actionbarcreateButton('cancel');

 =>  =>  =>  => if (isset($id_raid))
 =>  =>  =>  =>  =>  => $buttonsetRoute('raidmanager_setup_complete', array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_raid' => $id_raid
 =>  =>  =>  =>  =>  => ));

 =>  =>  =>  => if ($id_setup)
 =>  =>  =>  =>  =>  => $buttonsetRoute('raidmanager_setup_index', array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_setup' => $id_setup
 =>  =>  =>  =>  =>  => ));

 =>  =>  =>  =>  =>  => // Build save button
 =>  =>  =>  => $param = array(
 =>  =>  =>  =>  =>  => 'id_raid' => $id_raid,
 =>  =>  =>  =>  =>  => 'back_to' => $back_to
 =>  =>  =>  => );

 =>  =>  =>  => $actionbarcreateButton('save')->setForm($form->getId())->setRoute('raidmanager_setup_save', $param);

 =>  =>  =>  => // Build actionbar
 =>  =>  =>  => $this->setVar('actionbar', $actionbar);

 =>  =>  =>  => // Create ajax response
 =>  =>  =>  => ->setAjaxTarget($id_setup ? '#raidmanager_setup_' . $id_setup : '#raidmanager_setups');
 =>  => }

 =>  => public function Delete($id_setup, $id_raid)
 =>  => {
 =>  =>  =>  => // First delete setlists
 =>  =>  =>  => $this->getModel('Setlist')deleteBySetup($id_setup);

 =>  =>  =>  => // Then the setup
 =>  =>  =>  => $this->model->delete($id_setup);

 =>  =>  =>  => // Reload setup area
 =>  =>  =>  => ->ajax('Complete', array(
 =>  =>  =>  =>  =>  => 'id_raid' => $id_raid
 =>  =>  =>  => ));
 =>  => }
}

