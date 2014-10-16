<?php
namespace Apps\Raidmanager\View;

use Core\Lib\Amvc\View;

class CommentView extends View
{
 =>  => public function Index()
 =>  => {
 =>  =>  =>  => echo => '
 =>  =>  =>  => <div class="panel panel-default
 =>  =>  =>  =>  =>  => <div class="panel-body
 =>  =>  =>  =>  =>  =>  =>  => <h3 class="no-top-margin', ->headline, '</h';

 =>  =>  =>  =>  =>  =>  =>  => if ($this->isVar('actionbar'))
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => echo ->actionbar;

 =>  =>  =>  =>  =>  =>  =>  => // no comments to show
 =>  =>  =>  =>  =>  =>  =>  => if(!$this->comments)
 =>  =>  =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => echo '<', ->empty, '</</di</di';
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => return;
 =>  =>  =>  =>  =>  =>  =>  => }

 =>  =>  =>  =>  =>  =>  =>  => // create commenttable
 =>  =>  =>  =>  =>  =>  =>  => echo '
 =>  =>  =>  =>  =>  =>  =>  => <div class="app-raidmanager-commentlist clearfix';

 =>  =>  =>  =>  =>  =>  =>  => foreach($this->comments as $comment)
 =>  =>  =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => echo '
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => <div class="panel panel-default
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => <div class="panel-body';

 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => if ($commentdelete)
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => echo $commentdelete;

 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => echo '
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => <div class="app-raidmanager-comment
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => <span class="app-raidmanager-class-', $commentclass, ' ', $commentchar_name, ' <smal(', date('Y-m-d H:i', $commentstamp), ')</smal</spa
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => <div class="app-raidmanager-commenttext text-' . $commentcolor_msg . '', $commentmsg, '</di
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => </di
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => </di
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => </di';
 =>  =>  =>  =>  =>  =>  =>  => }

 =>  =>  =>  =>  =>  =>  =>  => echo '
 =>  =>  =>  =>  =>  =>  =>  => </di
 =>  =>  =>  =>  =>  => </di
 =>  =>  =>  => </di';
 =>  => }
}

