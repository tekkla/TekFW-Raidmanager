<?php
namespace Apps\Raidmanager\View;

use Core\Lib\Amvc\View;

class SubscriptionView extends View
{
 =>  => public function Index()
 =>  => {
 =>  =>  =>  => echo '
 =>  =>  =>  => <div class="panel panel-default
 =>  =>  =>  =>  =>  => <div class="panel-body
 =>  =>  =>  =>  =>  =>  =>  => <h3 class="no-top-margin', ->headline, '</h';

 =>  =>  =>  =>  =>  =>  =>  => if (!$this->nodata && ->isVar('actionbar'))
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => echo ->actionbar;

 =>  =>  =>  =>  =>  => if ($this->nodata)
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => echo '<' . $this->txt_nodata . '</
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => </di
 =>  =>  =>  =>  =>  =>  =>  => </di';

 =>  =>  =>  =>  =>  =>  =>  => return;
 =>  =>  =>  =>  =>  => }

 =>  =>  =>  => foreach ($this->types as $type => $txt)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => if ($this->isVar($txt))
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => echo '
 =>  =>  =>  =>  =>  =>  =>  => <ul class="list-inline
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => <l
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => <stron', ->{'headline_'.$txt}, ' :</stron
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => </l';

 =>  =>  =>  =>  =>  =>  =>  => foreach($this->{$txt} as $player)
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => echo '
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => <l
 =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  =>  => <span class="app-raidmanager-class-', => $playerclass, '', $playerchar_name, '</spa
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => </l';

 =>  =>  =>  =>  =>  =>  =>  => echo '
 =>  =>  =>  =>  =>  =>  =>  => </u';
 =>  =>  =>  =>  =>  => }
 =>  =>  =>  => }

 =>  =>  =>  =>  =>  => echo '
 =>  =>  =>  =>  =>  => </di
 =>  =>  =>  => </di';
 =>  => }

 =>  => public function Enrollform()
 =>  => {
 =>  =>  =>  => echo '
 =>  =>  =>  => <div class="panel panel-default
 =>  =>  =>  =>  =>  => <div class="panel-body
 =>  =>  =>  =>  =>  =>  =>  => <h3 class="no-top-margin"', ->color, ', ->headline, ->actionbar, '</h
 =>  =>  =>  =>  =>  =>  =>  => ', ->enrollform, '
 =>  =>  =>  =>  =>  => </di
 =>  =>  =>  => </di';
 =>  => }

 =>  => function Edit()
 =>  => {
 =>  =>  =>  => echo '
 =>  =>  =>  => <div class="panel panel-default
 =>  =>  =>  =>  =>  => <div class="panel-body
 =>  =>  =>  =>  =>  =>  =>  => <h3 class="no-top-margin', ->headline, ->actionbar, '</h
 =>  =>  =>  =>  =>  =>  =>  => <div class="pull-left" style="width:48%
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => <ul class="list-unstyled';

 =>  =>  =>  =>  =>  =>  =>  => foreach($this->resigned as $player)
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => echo '<li style="margin-bottom: 1px;', $playerlink, '</l';

 =>  =>  =>  =>  =>  =>  =>  =>  =>  => echo '
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => </u
 =>  =>  =>  =>  =>  =>  =>  => </di
 =>  =>  =>  =>  =>  =>  =>  => <div class="pull-right" style="width:48%;
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => <ul class="list-unstyled';

 =>  =>  =>  =>  =>  =>  =>  => foreach($this->enrolled as $player)
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => echo '<li style="margin-bottom: 1px;', $playerlink, '</l';

 =>  =>  =>  =>  =>  =>  =>  =>  =>  => echo '
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => </u
 =>  =>  =>  =>  =>  =>  =>  => </di
 =>  =>  =>  =>  =>  => </di
 =>  =>  =>  => </di';
 =>  => }
}
