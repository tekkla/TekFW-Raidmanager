<?php
namespace Apps\Raidmanager\Model;

use Core\Lib\Amvc\Model;
use Core\Lib\Data\Data;
use Core\Lib\Error;

if (!defined('TEKFW'))
 =>  => die('Cannot run without TekFW framework...');

/**
 * Setup model
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.d
 * @package TekFW
 * @subpackage App Raidmanager
 * @license MIT
 * @copyright 2014 by author
 */
final class SetupModel extends Model
{
 =>  => protected $tbl = 'app_raidmanager_setups';
 =>  => protected $alias = 'setups';
 =>  => protected $pk = 'id_setup';
 =>  => public $validate = array(
 =>  =>  =>  => 'title' => array(
 =>  =>  =>  =>  =>  => 'empty'
 =>  =>  =>  => ),
 =>  =>  =>  => 'need_tank' => array(
 =>  =>  =>  =>  =>  => 'empty',
 =>  =>  =>  =>  =>  => array('min', array(0, 'number'))
 =>  =>  =>  => ),
 =>  =>  =>  => 'need_damage' => array(
 =>  =>  =>  =>  =>  => 'empty',
 =>  =>  =>  =>  =>  => array('min', array(0, 'number'))
 =>  =>  =>  => ),
 =>  =>  =>  => 'need_heal' => array(
 =>  =>  =>  =>  =>  => 'empty',
 =>  =>  =>  =>  =>  => array('min', array(0, 'number'))
 =>  =>  =>  => ),
 =>  =>  =>  => 'position' => array(
 =>  =>  =>  =>  =>  => array('min', array(0, 'number'))
 =>  =>  =>  => )
 =>  => );

 =>  => /**
 =>  =>  * Returns data for setup create/edit
 =>  =>  * @param int $id_raid
 =>  =>  * @param int $id_setup
 =>  =>  * @throws ParameterNotSetError
 =>  =>  * @return \Core\Lib\Data\Data
 =>  =>  */
 =>  => public function getEditSetup($id_raid = null, $id_setup = null)
 =>  => {
 =>  =>  =>  => if (isset($id_setup))
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => ->find($id_setup);
 =>  =>  =>  =>  =>  => ->datamode = 'edit';
 =>  =>  =>  => }
 =>  =>  =>  => else
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => if (!isset($id_raid))
 =>  =>  =>  =>  =>  =>  =>  => Throw new Error('Needed parameter not set', 1001, array('id_raid'));

 =>  =>  =>  =>  =>  => // Create default data
 =>  =>  =>  =>  =>  => $data = new Data();
 =>  =>  =>  =>  =>  => $dataid_raid = $id_raid;
 =>  =>  =>  =>  =>  => $datatitle = $this->cfg('setup_title');
 =>  =>  =>  =>  =>  => $datadescription = $this->cfg('setup_notes');
 =>  =>  =>  =>  =>  => $datanotes = $this->cfg('setup_notes');
 =>  =>  =>  =>  =>  => $dataneed_tank = $this->cfg('setup_tank');
 =>  =>  =>  =>  =>  => $dataneed_damage = $this->cfg('setup_damage');
 =>  =>  =>  =>  =>  => $dataneed_heal = $this->cfg('setup_heal');
 =>  =>  =>  =>  =>  => $dataposition = 0;
 =>  =>  =>  =>  =>  => $datapoints = 0;
 =>  =>  =>  =>  =>  => $datakilled = 0;
 =>  =>  =>  =>  =>  => $datamode = 'new';

 =>  =>  =>  =>  =>  => ->data = $data;
 =>  =>  =>  => }

 =>  =>  =>  => return $this->data;
 =>  => }

 =>  => /**
 =>  =>  * Loads setup IDs of a specific raid
 =>  =>  * @param int $id_raid
 =>  =>  */
 =>  => public function getIdsByRaid($id_raid)
 =>  => {
 =>  =>  =>  => return $this->read(array(
 =>  =>  =>  =>  =>  => 'type' => 'key',
 =>  =>  =>  =>  =>  => 'filter' => 'id_raid={int:id_raid}',
 =>  =>  =>  =>  =>  => 'param' => array('id_raid' => $id_raid),
 =>  =>  =>  =>  =>  => 'order' => 'position, id_setup'
 =>  =>  =>  => ));
 =>  => }

 =>  => /**
 =>  =>  * Creates and stores a new setup for a specific raid and returns the complete data of it.
 =>  =>  * @param int $id_raid
 =>  =>  */
 =>  => public function createDefaultSetup($id_raid)
 =>  => {
 =>  =>  =>  => $data = new Data();

 =>  =>  =>  => $dataid_raid = $id_raid;
 =>  =>  =>  => $datatitle = $this->cfg('setup_title');
 =>  =>  =>  => $datadescription = $this->cfg('setup_notes');
 =>  =>  =>  => $dataneed_tank = $this->cfg('setup_tank');
 =>  =>  =>  => $dataneed_damage = $this->cfg('setup_damage');
 =>  =>  =>  => $dataneed_heal = $this->cfg('setup_heal');
 =>  =>  =>  => $dataposition = 0;
 =>  =>  =>  => $datapoints = 0;
 =>  =>  =>  => $datakilled = 0;

 =>  =>  =>  => ->data = $data;

 =>  =>  =>  => // Save without validation
 =>  =>  =>  => ->save(false);

 =>  =>  =>  => return $this->data;
 =>  => }

 =>  => /**
 =>  =>  * Returns data of a specific setup.
 =>  =>  * @param int $id_setup
 =>  =>  * @return \Core\Lib\Data\Data
 =>  =>  */
 =>  => public function getInfos($id_setup)
 =>  => {
 =>  =>  =>  => // Get setupdata
 =>  =>  =>  => ->find($id_setup);

 =>  =>  =>  => // How many setups?
 =>  =>  =>  => ->read(array(
 =>  =>  =>  =>  =>  => 'type' => 'ext',
 =>  =>  =>  =>  =>  => 'field' => 'COUNT(setups.id_setup) AS num_setups',
 =>  =>  =>  =>  =>  => 'filter' => 'id_raid={int:id_raid}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_raid' => ->dataid_raid
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  => ));

 =>  =>  =>  => // Build complete headline
 =>  =>  =>  => if ($this->dataneed_tank || ->dataneed_damage || ->dataneed_heal)
 =>  =>  =>  =>  =>  => ->datatitle .= ' (' . ->dataneed_tank . '/' . ->dataneed_damage . '/' . ->dataneed_heal . ')';

 =>  =>  =>  => return $this->data;
 =>  => }

 =>  => /**
 =>  =>  * Saves setup data to db
 =>  =>  * @param Data $data
 =>  =>  */
 =>  => public function saveSetup(Data $data)
 =>  => {
 =>  =>  =>  => ->data = $data;

 =>  =>  =>  => // What edit mode do we have?
 =>  =>  =>  => $mode = isset($this->dataid_setup) ? 'update' : 'new';

 =>  =>  =>  => // We need to check a change in setup position (only on updates. new setups will be added to the end.)
 =>  =>  =>  => if (isset($this->dataid_setup))
 =>  =>  =>  =>  =>  => $position_is_same = ->compare('position');

 =>  =>  =>  => // Save dataset to db
 =>  =>  =>  => ->save();

 =>  =>  =>  => if (!$this->hasErrors() && $mode == 'new')
 =>  =>  =>  =>  =>  => // For lazy raidadmins we copy the setlist of the setup we came from as the edit startet to the new setup we created
 =>  =>  =>  =>  =>  => $this->getModel('Setlist')copySetlist($this->dataid_from, ->dataid_setup);

 =>  =>  =>  => // If the posiotion of the setup has been changed, we flag the mode to 'new' so the controller
 =>  =>  =>  => // reloads the complete setuplist.
 =>  =>  =>  => if ($position_is_same == false)
 =>  =>  =>  =>  =>  => $mode = 'new';
 =>  => }

 =>  => /**
 =>  =>  * Returns the all setup IDs of all future raids
 =>  =>  * @return Data List of setup IDs
 =>  =>  */
 =>  => public function getFutureSetupIDs()
 =>  => {
 =>  =>  =>  => return $this->read(array(
 =>  =>  =>  =>  =>  => 'type' => 'key',
 =>  =>  =>  =>  =>  => 'field' => 'setups.id_setup',
 =>  =>  =>  =>  =>  => 'join' => array(
 =>  =>  =>  =>  =>  =>  =>  => array('app_raidmanager_raids', 'raids', 'INNER', 'setups.id_raid = raids.id_raid')
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'filter' => 'raids.starttim{int:starttime}',
 =>  =>  =>  =>  =>  => 'param' => array('starttime' => time())
 =>  =>  =>  =>  ));
 =>  => }

 =>  => /**
 =>  =>  * Returns the raid id of a setup
 =>  =>  * @param int $id_setup
 =>  =>  * @return int
 =>  =>  */
 =>  => public function getRaidId($id_setup)
 =>  => {
 =>  =>  =>  => return $this->read(array(
 =>  =>  =>  =>  =>  => 'type' => 'val',
 =>  =>  =>  =>  =>  => 'field' => 'id_raid',
 =>  =>  =>  =>  =>  => 'filter' => 'id_setup={int:id_setup}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_setup' => $id_setup
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));
 =>  => }
}

