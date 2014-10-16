<?php
namespace Apps\Raidmanager\Model;

use Core\Lib\Amvc\Model;
use Core\Lib\Data\Data;
use Core\Lib\Content\Html\Controls\Actionbar;

// Check for direct file access
if (!defined('TEKFW'))
 =>  => die('Cannot run without TekFW framework...');

/**
 * Char model
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.d
 * @package TekFW
 * @subpackage App Raidmanager
 * @license MIT
 * @copyright 2014 by author
 */
final class CharModel extends Model
{
 =>  => protected $tbl = 'app_raidmanager_chars';
 =>  => protected $alias = 'chars';
 =>  => protected $pk = 'id_char';
 =>  => public $validate = array(
 =>  =>  =>  => 'char_name' => array(
 =>  =>  =>  =>  =>  => 'required',
 =>  =>  =>  =>  =>  => 'empty',
 =>  =>  =>  =>  =>  => array('min', 3)
 =>  =>  =>  => ),
 =>  =>  =>  => 'id_player' => array(
 =>  =>  =>  =>  =>  => 'required',
 =>  =>  =>  =>  =>  => 'empty'
 =>  =>  =>  => ),
 =>  =>  =>  => 'id_category' => array(
 =>  =>  =>  =>  =>  => 'required',
 =>  =>  =>  =>  =>  => 'empty'
 =>  =>  =>  => ),
 =>  =>  =>  => 'id_class' => array(
 =>  =>  =>  =>  =>  => 'required',
 =>  =>  =>  =>  =>  => 'empty'
 =>  =>  =>  => )
 =>  => );

 =>  => /**
 =>  =>  * Returns a list for mainchar/twink selections
 =>  =>  * @return array
 =>  =>  */
 =>  => public function getCharTypes()
 =>  => {
 =>  =>  =>  => return array(
 =>  =>  =>  =>  =>  => 0 => $this->txt('char_istwink'),
 =>  =>  =>  =>  =>  => 1 => $this->txt('char_ismain')
 =>  =>  =>  => );
 =>  => }

 =>  => /**
 =>  =>  * Loads the charlist of a specific player.
 =>  =>  * @param int $id_player
 =>  =>  * @return array
 =>  =>  */
 =>  => public function getCharlist($id_player)
 =>  => {
 =>  =>  =>  => $query = array(
 =>  =>  =>  =>  =>  => 'type' => '*',
 =>  =>  =>  =>  =>  => 'field' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'chars.id_char',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.id_player',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.char_name',
 =>  =>  =>  =>  =>  =>  =>  => 'chars.is_main',
 =>  =>  =>  =>  =>  =>  =>  => 'class.class',
 =>  =>  =>  =>  =>  =>  =>  => 'class.color',
 =>  =>  =>  =>  =>  =>  =>  => 'class.css',
 =>  =>  =>  =>  =>  =>  =>  => 'cats.category'
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'join' => array(
 =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_classes',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'class',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.id_class=class.id_class'
 =>  =>  =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_categories',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'cats',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.id_category=cats.id_category'
 =>  =>  =>  =>  =>  =>  =>  => )
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'filter' => 'chars.id_player={int:id_player}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_player' => $id_player
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'order' => 'chars.is_main DESC'
 =>  =>  =>  => );

 =>  =>  =>  => return $this->read($query, 'extendChar');
 =>  => }

 =>  => /**
 =>  =>  * Callback method to extend a char with actionbar and informations about mainchar and category
 =>  =>  * @param Data $char
 =>  =>  * @return \Core\Lib\Data\Data
 =>  =>  */
 =>  => final protected function extendChar(&$char)
 =>  => {
 =>  =>  =>  => if (!$this->checkAccess('raidmanager_perm_player'))
 =>  =>  =>  =>  =>  => return $char;

 =>  =>  =>  => $actionbar = new Actionbar();

 =>  =>  =>  => $param = array(
 =>  =>  =>  =>  =>  => 'id_char' => $charid_char,
 =>  =>  =>  =>  =>  => 'id_player' => $charid_player
 =>  =>  =>  => );

 =>  =>  =>  => // The edit button
 =>  =>  =>  => $actionbarcreateButton('edit', 'ajax', 'icon')->setRoute('raidmanager_char_edit', $param);

 =>  =>  =>  => // Delete button only on non mainchars
 =>  =>  =>  => if ($charis_main == 0)
 =>  =>  =>  =>  =>  => $actionbarcreateButton('delete', 'ajax', 'icon')->setRoute('raidmanager_char_delete', $param);

 =>  =>  =>  => $charactionbar = $actionbarbuild();

 =>  =>  =>  => if ($charis_main == 1)
 =>  =>  =>  =>  =>  => $charchar_name .= ' (Main)';

 =>  =>  =>  => // Translated category name
 =>  =>  =>  => $charcategory = $this->txt('category_' . $charcategory);

 =>  =>  =>  => return $char;
 =>  => }

 =>  => /**
 =>  =>  * Returns the mainchar name of specific player
 =>  =>  * @param int $id_player
 =>  =>  * @return string
 =>  =>  */
 =>  => public function getMaincharName($id_player)
 =>  => {
 =>  =>  =>  => return $this->read(array(
 =>  =>  =>  =>  =>  => 'type' => 'val',
 =>  =>  =>  =>  =>  => 'field' => 'chars.char_name',
 =>  =>  =>  =>  =>  => 'filter' => 'chars.id_player={int:id_player} AND chars.is_main=1',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_player' => $id_player
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));
 =>  => }

 =>  => /**
 =>  =>  * Loads and return char data.
 =>  =>  * The method takes care about loading existing data
 =>  =>  * when $id_char parameter isset and a new char when $id_char is null.
 =>  =>  * @param int $id_player
 =>  =>  * @param int $id_char
 =>  =>  * @return \Core\Lib\Data\Data
 =>  =>  */
 =>  => public function getEditChar($id_player, $id_char = null)
 =>  => {
 =>  =>  =>  => // Load data from model if char id is given
 =>  =>  =>  => if (isset($id_char))
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // char edit, get some char data for use in form
 =>  =>  =>  =>  =>  => ->read(array(
 =>  =>  =>  =>  =>  =>  =>  => 'field' => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.id_char',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.char_name',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.is_main',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.id_class',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.id_category',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'class.class',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'class.color',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'class.css',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'cats.category'
 =>  =>  =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  =>  =>  => 'join' => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_classes',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'class',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.id_class=class.id_class'
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'app_raidmanager_categories',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'cats',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'INNER',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'chars.id_category=cats.id_category'
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => )
 =>  =>  =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  =>  =>  => 'filter' => 'chars.id_char={int:id_char}',
 =>  =>  =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'id_char' => $id_char
 =>  =>  =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  =>  =>  => 'order' => 'chars.is_main'
 =>  =>  =>  =>  =>  => ));

 =>  =>  =>  =>  =>  => ->datamode = 'edit';
 =>  =>  =>  => }
 =>  =>  =>  => // Otherwise assume it is a new char
 =>  =>  =>  => else
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => ->data = new Data();

 =>  =>  =>  =>  =>  => // new char, set default values
 =>  =>  =>  =>  =>  => ->dataid_player = $id_player;
 =>  =>  =>  =>  =>  => ->datachar_name = '';
 =>  =>  =>  =>  =>  => ->datais_main = 0;
 =>  =>  =>  =>  =>  => ->dataid_class = 0;
 =>  =>  =>  =>  =>  => ->dataid_category = 0;
 =>  =>  =>  =>  =>  => ->datamode = 'add';
 =>  =>  =>  => }

 =>  =>  =>  => return $this->data;
 =>  => }

 =>  => /**
 =>  =>  * Checks for existiance of a charname and attaches an error to field char_name if this name is already taken.
 =>  =>  */
 =>  => public function checkNameExists()
 =>  => {
 =>  =>  =>  => // Do nothing if the char name is the same as the name in char name compare field
 =>  =>  =>  => if (isset($this->datachar_name) && isset($this->datachar_name_compare) && ->datachar_name == ->datachar_name_compare)
 =>  =>  =>  =>  =>  => return;

 =>  =>  =>  => $filter = 'chars.char_name={string:char_name}';
 =>  =>  =>  => $param = array(
 =>  =>  =>  =>  =>  => 'char_name' => ->datachar_name
 =>  =>  =>  => );

 =>  =>  =>  => if (isset($this->dataid_char))
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => $filter .= ' AND chars.id_char{int:id_char}';
 =>  =>  =>  =>  =>  => $param['id_char'] = ->dataid_char;
 =>  =>  =>  => }

 =>  =>  =>  => if ($this->getModel()count($filter, $param) != 0)
 =>  =>  =>  =>  =>  => ->addError('char_name', $this->txt('char_name_already_taken'));
 =>  => }

 =>  => /**
 =>  =>  * Creates the first char of a player by using the provided data
 =>  =>  * @param Data $data
 =>  =>  */
 =>  => public function createFirstChar($data)
 =>  => {
 =>  =>  =>  => ->data = $data;
 =>  =>  =>  => ->save();
 =>  => }

 =>  => /**
 =>  =>  * Sets all chars of one player (except the char provided by id_char) to be alts
 =>  =>  * @param int $id_player
 =>  =>  * @param int $id_char
 =>  =>  */
 =>  => public function setCharsToTwink($id_player, $id_char)
 =>  => {
 =>  =>  =>  => $this->getModel()update(array(
 =>  =>  =>  =>  =>  => 'field' => 'is_main',
 =>  =>  =>  =>  =>  => 'filter' => 'id_player={int:id_player} AND id_char{int:id_char}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'is_main' => 0,
 =>  =>  =>  =>  =>  =>  =>  => 'id_player' => $id_player,
 =>  =>  =>  =>  =>  =>  =>  => 'id_char' => $id_char
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));
 =>  => }

 =>  => /**
 =>  =>  * Saves char data
 =>  =>  * @param Data $data
 =>  =>  */
 =>  => public function saveChar($data)
 =>  => {
 =>  =>  =>  => ->data = $data;

 =>  =>  =>  => // on changed cha name we have to check for already existing charname
 =>  =>  =>  => ->checkNameExists();

 =>  =>  =>  => if ($this->hasErrors())
 =>  =>  =>  =>  =>  => return;

 =>  =>  =>  =>  =>  => // save our chardata to db
 =>  =>  =>  => ->save();

 =>  =>  =>  => // var_dump($this->data);

 =>  =>  =>  => // if this is the new mainchar, change all other chars than this to twinks
 =>  =>  =>  => if ($this->hasNoErrors() && isset($this->datais_main) && ->datais_main == 1)
 =>  =>  =>  =>  =>  => ->setCharsToTwink($this->dataid_player, ->dataid_char);
 =>  => }

 =>  => /**
 =>  =>  * Deletes the char with the provided char id.
 =>  =>  * @param int $id_char
 =>  =>  */
 =>  => public function deleteChar($id_char)
 =>  => {
 =>  =>  =>  => // Remove char from setlists
 =>  =>  =>  => $this->getModel('Setlist')delete(array(
 =>  =>  =>  =>  =>  => 'filter' => 'id_char={int:id_char}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_char' => $id_char
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));

 =>  =>  =>  => // Delete char itself
 =>  =>  =>  => ->delete($id_char);
 =>  => }
}

