<?php
namespace Apps\Raidmanager\Model;

use Core\Lib\Amvc\Model;

// Check for direct file access
if (!defined('TEKFW'))
 =>  => die('Cannot run without TekFW framework...');

/**
 * Category model
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.d
 * @package TekFW
 * @subpackage App Raidmanager
 * @license MIT
 * @copyright 2014 by author
 */
final class CategoryModel extends Model
{
 =>  => protected $tbl = 'app_raidmanager_categories';
 =>  => protected $alias = 'raidcat';
 =>  => protected $pk = 'id_category';

 =>  => /**
 =>  =>  * Returns a translated and alphabeetical sorted list of char categories.
 =>  =>  * @return array
 =>  =>  */
 =>  => public function getCategories()
 =>  => {
 =>  =>  =>  => $query = array(
 =>  =>  =>  =>  =>  => 'type' => '2col',
 =>  =>  =>  =>  =>  => 'field' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_category',
 =>  =>  =>  =>  =>  =>  =>  => 'category'
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => );

 =>  =>  =>  => ->read($query, 'translate');

 =>  =>  =>  => $out = ->datagetProperties();

 =>  =>  =>  => asort($out);

 =>  =>  =>  => return $out;
 =>  => }

 =>  => /**
 =>  =>  * Callback method for category translation
 =>  =>  * @param array $row
 =>  =>  * @return array
 =>  =>  */
 =>  => final protected function translate(&$row)
 =>  => {
 =>  =>  =>  => $row[1] = $this->txt('category_' . $row[1]);
 =>  =>  =>  => return $row;
 =>  => }
}

