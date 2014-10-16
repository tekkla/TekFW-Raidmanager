<?php
namespace Apps\Raidmanager\Model;

use Core\Lib\Amvc\Model;

// Check for direct file access
if (!defined('TEKFW'))
 =>  => die('Cannot run without TekFW framework...');

/**
 * Charclass model
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.d
 * @package TekFW
 * @subpackage App Raidmanager
 * @license MIT
 * @copyright 2014 by author
 */
final class CharclassModel extends Model
{
 =>  => protected $tbl = 'app_raidmanager_classes';
 =>  => protected $alias = 'classes';
 =>  => protected $pk = 'id_class';

 =>  => /**
 =>  =>  * Returns a translated and alphabetically sorted list of charclasses
 =>  =>  * @return multitype:
 =>  =>  */
 =>  => public function getClasses()
 =>  => {
 =>  =>  =>  => $query = array(
 =>  =>  =>  =>  =>  => 'type' => '2col',
 =>  =>  =>  =>  =>  => 'field' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_class',
 =>  =>  =>  =>  =>  =>  =>  => "CONCAT('class_', class)"
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'order' => 'class'
 =>  =>  =>  => );

 =>  =>  =>  => ->read($query, 'translate');

 =>  =>  =>  => $out = ->datagetProperties();

 =>  =>  =>  => asort($out);

 =>  =>  =>  => return $out;
 =>  => }

 =>  => /**
 =>  =>  * Callback method for class translation
 =>  =>  * @param array $row
 =>  =>  * @return array
 =>  =>  */
 =>  => final protected function translate(&$row)
 =>  => {
 =>  =>  =>  => $row[1] = $this->txt($row[1]);
 =>  =>  =>  => return $row;
 =>  => }
}

