<?php
namespace Apps\Raidmanager\Controller;

use Core\Lib\Amvc\Controller;

class CalendarController extends Controller
{
 =>  => public function Index($id_raid)
 =>  => {
 =>  =>  =>  => $data = $this->model->getCalendar($id_raid);

 =>  =>  =>  => $this->setVar(array(
 =>  =>  =>  =>  =>  => 'list_recent' => $datarecent,
 =>  =>  =>  =>  =>  => 'list_future' => $datafuture,
 =>  =>  =>  =>  =>  => 'headline' => $this->txt('calendar_headline'),
 =>  =>  =>  =>  =>  => 'no_raids' => $this->txt('calendar_none'),
 =>  =>  =>  =>  =>  => 'current' => $this->txt('calendar_current'),
 =>  =>  =>  =>  =>  => 'future' => $this->txt('calendar_future'),
 =>  =>  =>  =>  =>  => 'recent' => $this->txt('calendar_recent')
 =>  =>  =>  => ));
 =>  => }

 =>  => public function WidgetNextRaid()
 =>  => {
 =>  =>  =>  => if (!$this->appgeneralAccess())
 =>  =>  =>  =>  =>  => return false;

 =>  =>  =>  => $data = $this->model->nextRaid();

 =>  =>  =>  => if (!$data)
 =>  =>  =>  =>  =>  => return false;

 =>  =>  =>  => $this->setVar('raid', $data);
 =>  => }

 =>  => public function Menu()
 =>  => {
 =>  =>  =>  => $this->setVar('raid', $this->model->getMenu());
 =>  => }
}

