<?php
namespace Apps\Raidmanager\Model;

use Core\Lib\Amvc\Model;
use Core\Lib\Url;
use Core\Lib\User;
use Core\Lib\Smf;
use Core\Lib\Amvc\App;
use Core\Lib\Data\Data;
use Core\Lib\Error;

if (!defined('TEKFW'))
 =>  => die('Cannot run without TekFW framework...');

/**
 * Player model
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.d
 * @package TekFW
 * @subpackage App Raidmanager
 * @license MIT
 * @copyright 2014 by author
 */
final class RaidModel extends Model
{
 =>  => protected $tbl = 'app_raidmanager_raids';
 =>  => protected $alias = 'raids';
 =>  => protected $pk = 'id_raid';
 =>  => public $validate = array(
 =>  =>  =>  => 'destination' => array(
 =>  =>  =>  =>  =>  => 'empty'
 =>  =>  =>  => ),
 =>  =>  =>  => 'starttime' => array(
 =>  =>  =>  =>  =>  => 'empty',
 =>  =>  =>  =>  =>  => 'date'
 =>  =>  =>  => ),
 =>  =>  =>  => 'endtime' => array(
 =>  =>  =>  =>  =>  => 'empty',
 =>  =>  =>  =>  =>  => 'date'
 =>  =>  =>  => )
 =>  => );

 =>  => /**
 =>  =>  * Loads an returns data for a specific raid
 =>  =>  * @param int $id_raid
 =>  =>  * @return \Core\Lib\Data\Data
 =>  =>  */
 =>  => public function getInfos($id_raid)
 =>  => {
 =>  =>  =>  => ->find($id_raid);

 =>  =>  =>  => // Create a link to the
 =>  =>  =>  => if ($this->dataid_topic && $this->cfg('use_forum'))
 =>  =>  =>  =>  =>  => ->datatopic_url = Url::factory()->setTopic($this->dataid_topic)->getUrl();

 =>  =>  =>  => return $this->data;
 =>  => }

 =>  => /**
 =>  =>  * Loads and returns raid data to be used for edit. When $id_raid is not set, this method assumes an empty record
 =>  =>  * for a new raid is requested and returns a new raid with default values set in app config.
 =>  =>  * @param int $id_raid
 =>  =>  * @return \Core\Lib\Data\Data
 =>  =>  */
 =>  => public function getEdit($id_raid = null)
 =>  => {
 =>  =>  =>  => // For edits
 =>  =>  =>  => if (isset($id_raid))
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // Load data of the raid only if hasErrors() indicates that there is already no data
 =>  =>  =>  =>  =>  => if ($this->hasErrors() == false)
 =>  =>  =>  =>  =>  =>  =>  => ->find($id_raid);

 =>  =>  =>  =>  =>  => ->datamode = 'edit';
 =>  =>  =>  => }

 =>  =>  =>  => // For new raids
 =>  =>  =>  => if (!isset($id_raid))
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // Create empty data container
 =>  =>  =>  =>  =>  => ->data = new Data();

 =>  =>  =>  =>  =>  => // Some default values and dateconversions for the datepicker
 =>  =>  =>  =>  =>  => ->datadestination = $this->cfg('raid_destination');
 =>  =>  =>  =>  =>  => ->datastarttime = strtotime(date('Y-m-d') . ' ' . $this->cfg('raid_time_start'));
 =>  =>  =>  =>  =>  => ->dataendtime = strtotime('+' . $this->cfg('raid_duration') . ' Minutes', ->datastarttime);
 =>  =>  =>  =>  =>  => ->dataspecials = '';

 =>  =>  =>  =>  =>  => ->datamode = 'new';
 =>  =>  =>  => }

 =>  =>  =>  => ->datastarttime = date('Y-m-d H:i', ->datastarttime);
 =>  =>  =>  => ->dataendtime = date('Y-m-d H:i', ->dataendtime);

 =>  =>  =>  => return $this->data;
 =>  => }

 =>  => /**
 =>  =>  * Saves raid data to database.
 =>  =>  * @param Data $data
 =>  =>  */
 =>  => public function saveInfos($data)
 =>  => {
 =>  =>  =>  => // Attach data to model
 =>  =>  =>  => ->data = $data;

 =>  =>  =>  => // We need timestamp from todays date for compare the starts and ends
 =>  =>  =>  => $now = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

 =>  =>  =>  => // Before saving data, let's see if this is a new raid to add.
 =>  =>  =>  => // A set value for id_raid indicates that we have an existing raid to update
 =>  =>  =>  => // Without set id_raid it is a new raid with further actions to run after the raid has been created
 =>  =>  =>  => // and the id_raid has been set as pk value from the insert.
 =>  =>  =>  => $is_new = isset($this->dataid_raid) ? false : true;

 =>  =>  =>  => // Validate the data
 =>  =>  =>  => ->validate();

 =>  =>  =>  => // Check for startime after endtime
 =>  =>  =>  => $start = strtotime($this->datastarttime);
 =>  =>  =>  => $end = strtotime($this->dataendtime);

 =>  =>  =>  => if ($start $end)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => ->addError('starttime', $this->txt('raid_start_after_end'));
 =>  =>  =>  =>  =>  => ->addError('endtime', $this->txt('raid_end_before_start'));
 =>  =>  =>  => }

 =>  =>  =>  => // Validation errors?
 =>  =>  =>  => if ($this->hasErrors())
 =>  =>  =>  => 	return;

 =>  =>  =>  => // Write timestamps to data
 =>  =>  =>  => ->datastarttime = $start;
 =>  =>  =>  => ->dataendtime = $end;

 =>  =>  =>  => // And save raid data without further validation
 =>  =>  =>  => ->save(false);

 =>  =>  =>  => // On new raids we need to create the playersubscriptions and a first default setup
 =>  =>  =>  => if ($is_new)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // Add subs to this raid
 =>  =>  =>  =>  =>  => $this->getModel('Subscription')createSubscriptionForRaid($this->dataid_raid, ->dataautosignon);

 =>  =>  =>  =>  =>  => // Create one blank setup
 =>  =>  =>  =>  =>  => $this->getModel('Setup')createDefaultSetup($this->dataid_raid);

 =>  =>  =>  =>  =>  => // New raids will be loaded completly
 =>  =>  =>  =>  =>  => ->dataaction = 'Index';
 =>  =>  =>  => }
 =>  =>  =>  => else
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => ->dataaction = 'Infos';

 =>  =>  =>  =>  =>  => // extend the already existing raiddata with topic and calendar infos
 =>  =>  =>  =>  =>  => ->read(array(
 =>  =>  =>  =>  =>  =>  =>  => 'type' => 'ext',
 =>  =>  =>  =>  =>  =>  =>  => 'field' => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'raids.id_topic',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'raids.id_message',
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'raids.id_event'
 =>  =>  =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  =>  =>  => 'filter' => 'raids.id_raid={int:id_raid}',
 =>  =>  =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'id_raid' => ->dataid_raid
 =>  =>  =>  =>  =>  =>  =>  => )
 =>  =>  =>  =>  =>  => ));
 =>  =>  =>  => }

 =>  =>  =>  => ->manageTopic();
 =>  => }

 =>  => /*
 =>  =>  * + Deletes a raid and it's child data
 =>  =>  */
 =>  => public function deleteRaid($id_raid)
 =>  => {
 =>  =>  =>  => // Delete all the child raiddata
 =>  =>  =>  => $model_names = array(
 =>  =>  =>  =>  =>  => 'Setup',
 =>  =>  =>  =>  =>  => 'Comment',
 =>  =>  =>  =>  =>  => 'Subscription',
 =>  =>  =>  =>  =>  => 'Setlist'
 =>  =>  =>  => );

 =>  =>  =>  => foreach ( $model_names as $model )
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => $this->getModel($model)delete(array(
 =>  =>  =>  =>  =>  =>  =>  => 'filter' => 'id_raid={int:pk}',
 =>  =>  =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => 'pk' => $id_raid
 =>  =>  =>  =>  =>  =>  =>  => )
 =>  =>  =>  =>  =>  => ));
 =>  =>  =>  => }

 =>  =>  =>  => // Load raiddata to get informations about topics and events
 =>  =>  =>  => ->find($id_raid);

 =>  =>  =>  => // Remove possible topics and events
 =>  =>  =>  => ->manageTopic(true);

 =>  =>  =>  => // Delete the raid
 =>  =>  =>  => ->delete($id_raid);

 =>  =>  =>  => // Remove all present raiddata from memory
 =>  =>  =>  => ->reset(true);

 =>  =>  =>  => // and return the next raid id, so we can load
 =>  =>  =>  => return $this->getNextRaidID();
 =>  => }

 =>  => /**
 =>  =>  * Returns the ID of the next upcomming raid if there is no next raidid, the method will return false
 =>  =>  * @return int|boolean
 =>  =>  */
 =>  => public function getNextRaidId()
 =>  => {
 =>  =>  =>  => $id_raid = ->read(array(
 =>  =>  =>  =>  =>  => 'type' => 'val',
 =>  =>  =>  =>  =>  => 'field' => 'id_raid',
 =>  =>  =>  =>  =>  => 'filter' => '(starttim={int:starttime} OR {int:starttime} BETWEEN raids.starttime AND raids.endtime)',
 =>  =>  =>  =>  =>  => 'param' => array('starttime' => time()),
 =>  =>  =>  =>  =>  => 'order' => 'starttime ASC',
 =>  =>  =>  =>  =>  => 'limit' => 1
 =>  =>  =>  => ));

 =>  =>  =>  => // Do we have a raid id?
 =>  =>  =>  => if (!$id_raid)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // No, which means we have no raids at all. Lets try to add raids by calling
 =>  =>  =>  =>  =>  => // the autoAddRaids() Mmethod. Which returns either the id of the last added raid
 =>  =>  =>  =>  =>  => // or false if something went wrong.
 =>  =>  =>  =>  =>  => return $this->autoAddRaids();
 =>  =>  =>  => }
 =>  =>  =>  => else
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // Yesm return it
 =>  =>  =>  =>  =>  => return $id_raid;
 =>  =>  =>  => }
 =>  => }

 =>  => /**
 =>  =>  * Adds automatically new raids to the raidlist
 =>  =>  */
 =>  => public function autoAddRaids()
 =>  => {
 =>  =>  =>  => // Get the raiddays from settings
 =>  =>  =>  => $raiddays = $this->cfg('raid_days');

 =>  =>  =>  => // No raiddays no raid creation
 =>  =>  =>  => if (!$raiddays)
 =>  =>  =>  =>  =>  => return false;

 =>  =>  =>  => // Calculate the number of raids we have to add
 =>  =>  =>  => $num_raids_to_add = $this->cfg('raid_new_days_ahead') - ->getNumFutureRaids();

 =>  =>  =>  => // No raids to add?
 =>  =>  =>  => if ($num_raids_to_add == 0)
 =>  =>  =>  =>  =>  => return false;

 =>  =>  =>  => // We have raids to add so we need the start timestamp from the last future raid
 =>  =>  =>  => $last_raid_starttime = ->read(array(
 =>  =>  =>  =>  =>  => 'type' => 'val',
 =>  =>  =>  =>  =>  => 'field' => 'starttime',
 =>  =>  =>  =>  =>  => 'filter' => 'starttime={int:starttime}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'starttime' => time()
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'order' => 'starttime DESC',
 =>  =>  =>  =>  =>  => 'limit' => 1
 =>  =>  =>  => ));

 =>  =>  =>  => ->firelog($last_raid_starttime);

 =>  =>  =>  => // Reset the modelfilter
 =>  =>  =>  => ->resetFilter();

 =>  =>  =>  => // Some time calculations for later use
 =>  =>  =>  => $time_start = explode(':', $this->cfg('raid_time_start'));

 =>  =>  =>  => // Do we have a timestamp of the last recent raid?
 =>  =>  =>  => if ($last_raid_starttime && $last_raid_starttime 0)
 =>  =>  =>  =>  =>  => // yay, use the date of this timestamp
 =>  =>  =>  =>  =>  => $starttime = mktime($time_start[0], $time_start[1], 0, date('m', $last_raid_starttime), date('d', $last_raid_starttime), date('Y', $last_raid_starttime));
 =>  =>  =>  => else
 =>  =>  =>  =>  =>  => // no, use the date of today
 =>  =>  =>  =>  =>  => $starttime = mktime($time_start[0], $time_start[1], 0, date('m'), date('d'), date('Y'));

 =>  =>  =>  => //
 =>  =>  =>  => $starttime_previous = $starttime;

 =>  =>  =>  => //
 =>  =>  =>  => $raids = [];

 =>  =>  =>  => $error_count = 0;
 =>  =>  =>  => $max_count = 100;

 =>  =>  =>  => // add raids until the number of raids to add is reached
 =>  =>  =>  => for($counter = 0; $counter < $num_raids_to_add; $error_count++)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // add 24 hours to the current starttime
 =>  =>  =>  =>  =>  => $starttime = strtotime('+1 day', $starttime);
 =>  =>  =>  =>  =>  => $checkday = date('w', $starttime);

 =>  =>  =>  =>  =>  => // is this weekday a raid day?
 =>  =>  =>  =>  =>  => if (isset($raiddays{$checkday}))
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => $counter++;

 =>  =>  =>  =>  =>  =>  =>  => // Calculate endtime
 =>  =>  =>  =>  =>  =>  =>  => $endtime = strtotime('+' . $this->cfg('raid_duration') . ' minutes', $starttime);

 =>  =>  =>  =>  =>  =>  =>  => // seems to be a valid raidday. create it.
 =>  =>  =>  =>  =>  =>  =>  => $data = new Data();

 =>  =>  =>  =>  =>  =>  =>  => // Destination default value ca
 =>  =>  =>  =>  =>  =>  =>  => $datadestination = $this->cfg('raid_destination');

 =>  =>  =>  =>  =>  =>  =>  => // Set calculated start and end time
 =>  =>  =>  =>  =>  =>  =>  => $datastarttime = $starttime;
 =>  =>  =>  =>  =>  =>  =>  => $dataendtime = $endtime;

 =>  =>  =>  =>  =>  =>  =>  => // Get the raidweek related to the start day of a week set in config
 =>  =>  =>  =>  =>  =>  =>  => $raidweek = date('w', $starttime) < $this->cfg('raid_weekday_start') ? date('W', $starttime_previous) : date('W', $starttime);
 =>  =>  =>  =>  =>  =>  =>  => $dataraidweek = (int) $raidweek;

 =>  =>  =>  =>  =>  =>  =>  => // Info text to be used set in config
 =>  =>  =>  =>  =>  =>  =>  => if ($this->cfg('raid_specials'))
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => $dataspecials = $this->cfg('raid_specials');

 =>  =>  =>  =>  =>  =>  =>  => // Flag raids autosignon by value set in config
 =>  =>  =>  =>  =>  =>  =>  => $dataautosignon = $this->cfg('raid_autosignon');

 =>  =>  =>  =>  =>  =>  =>  => // Create raid without validation
 =>  =>  =>  =>  =>  =>  =>  => ->data = $data;
 =>  =>  =>  =>  =>  =>  =>  => ->save(false);

 =>  =>  =>  =>  =>  =>  =>  => // Any errors?
 =>  =>  =>  =>  =>  =>  =>  => if ($this->hasErrors())
 =>  =>  =>  =>  =>  =>  =>  =>  =>  => Throw new Error('Error on Raidmanager: autoAdd()', 1000, ->errors);

 =>  =>  =>  =>  =>  =>  =>  => // Go and create the playersubscriptions
 =>  =>  =>  =>  =>  =>  =>  => $this->getModel('Subscription')createSubscriptionForRaid($this->dataid_raid, $this->cfg('raid_autosignon'));

 =>  =>  =>  =>  =>  =>  =>  => // And create the first default setup
 =>  =>  =>  =>  =>  =>  =>  => $this->getModel('Setup')createDefaultSetup($this->dataid_raid);

 =>  =>  =>  =>  =>  =>  =>  => // Finally manage the Topic and Calendar
 =>  =>  =>  =>  =>  =>  =>  => ->manageTopic();

 =>  =>  =>  =>  =>  =>  =>  => // Store id of new created raid
 =>  =>  =>  =>  =>  =>  =>  => $raids[] = ->dataid_raid;
 =>  =>  =>  =>  =>  => }

 =>  =>  =>  =>  =>  => // Our current starttime will be the previous one for the next raid to add.
 =>  =>  =>  =>  =>  => $starttime_previous = $starttime;

 =>  =>  =>  =>  =>  => if ($error_count == $max_count)
 =>  =>  =>  =>  =>  =>  =>  => Throw new Error('Errorcount (' . $error_count . '/' . $max_count . ') on Raidmanagerautoadd raid.', 1000);
 =>  =>  =>  => }

 =>  =>  =>  => return $raids[0];
 =>  => }

 =>  => /**
 =>  =>  * Loads id and autosignon infos of all future raids. Returns boolean false when no raid is found.
 =>  =>  * @return boolean|arrayl
 =>  =>  */
 =>  => public function getFutureRaidIDsAndAutosignon()
 =>  => {
 =>  =>  =>  => return $this->read(array(
 =>  =>  =>  =>  =>  => 'type' => '*',
 =>  =>  =>  =>  =>  => 'field' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'id_raid',
 =>  =>  =>  =>  =>  =>  =>  => 'autosignon'
 =>  =>  =>  =>  =>  => ),
 =>  =>  =>  =>  =>  => 'filter' => 'starttim{int:starttime}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'starttime' => time()
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));
 =>  => }

 =>  => /**
 =>  =>  * Returns raid ids of future raids
 =>  =>  * @return array
 =>  =>  */
 =>  => public function getFutureRaidIDs()
 =>  => {
 =>  =>  =>  => return $this->read(array(
 =>  =>  =>  =>  =>  => 'type' => 'key',
 =>  =>  =>  =>  =>  => 'filter' => 'starttim{int:starttime}',
 =>  =>  =>  =>  =>  => 'param' => array(
 =>  =>  =>  =>  =>  =>  =>  => 'starttime' => time()
 =>  =>  =>  =>  =>  => )
 =>  =>  =>  => ));
 =>  => }

 =>  => /**
 =>  =>  * Returns the number of future raids
 =>  =>  * @return int
 =>  =>  */
 =>  => public function getNumFutureRaids()
 =>  => {
 =>  =>  =>  => return $this->count('starttim{int:starttime}', array('starttime' => time()));
 =>  => }

 =>  => /**
 =>  =>  * Truncates raid, setup, setlist, comment and subscription table
 =>  =>  */
 =>  => public function clearAllRaids()
 =>  => {
 =>  =>  =>  => ->truncate();

 =>  =>  =>  => $model_names = array(
 =>  =>  =>  =>  =>  => 'Subscription',
 =>  =>  =>  =>  =>  => 'Setlist',
 =>  =>  =>  =>  =>  => 'Comment',
 =>  =>  =>  =>  =>  => 'Setup'
 =>  =>  =>  => );

 =>  =>  =>  => foreach ( $model_names as $model )
 =>  =>  =>  =>  =>  => $this->getModel($model)truncate();
 =>  => }

 =>  => /**
 =>  =>  * Manages topic and event creation/deletion for raids
 =>  =>  * @param boolean $delete Flag to use this method for topic and event removal
 =>  =>  * @return void boolean
 =>  =>  */
 =>  => private function manageTopic($delete = false)
 =>  => {
 =>  =>  =>  => // Delete requested?
 =>  =>  =>  => if ($delete==true)
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => // Do only when topic id present
 =>  =>  =>  =>  =>  => if (isset($this->dataid_topic))
 =>  =>  =>  =>  =>  =>  =>  => App::getInstance('Forum')->getModel('Topic')deleteTopic($this->dataid_topic, true, true);

 =>  =>  =>  =>  =>  => // Remove also possible calendar event
 =>  =>  =>  =>  =>  => if (isset($this->dataid_event))
 =>  =>  =>  =>  =>  => {
 =>  =>  =>  =>  =>  =>  =>  => Smf::useSource('Subs-Calendar');
 =>  =>  =>  =>  =>  =>  =>  => removeEvent($this->dataid_event);
 =>  =>  =>  =>  =>  => }

 =>  =>  =>  =>  =>  => return;
 =>  =>  =>  => }

 =>  =>  =>  => ## Topic

 =>  =>  =>  => // Do only when topic using is switched on in config
 =>  =>  =>  => if (!$this->cfg('use_forum'))
 =>  =>  =>  =>  =>  => return;

 =>  =>  =>  => // Create message body
 =>  =>  =>  => $body = '[b]Intro:[/b]' . PHP_EOL . $this->cfg('topic_intro');

 =>  =>  =>  => // Add special infos on exist
 =>  =>  =>  => if (isset($this->dataspecials))
 =>  =>  =>  =>  =>  => $body .= PHP_EOL . PHP_EOL . '[b]' . $this->txt('raid_specials') . ':[/b]' . PHP_EOL . ->dataspecials;

 =>  =>  =>  => // Add direct link to raid
 =>  =>  =>  => $body .= PHP_EOL . PHP_EOL . '[b]Raidmanager Link:[/b]' . PHP_EOL . Url::factory('raidmanager_raid_selected', array(
 =>  =>  =>  =>  =>  => 'id_raid' => ->dataid_raid
 =>  =>  =>  => ))->getUrl();

 =>  =>  =>  => // Create the topics message
 =>  =>  =>  => $msgOptions = array(
 =>  =>  =>  =>  =>  => 'body' => $body,
 =>  =>  =>  =>  =>  => 'subject' => date('Y-m-d H:i', ->datastarttime) . ' - ' . ->datadestination
 =>  =>  =>  => );

 =>  =>  =>  => // Is this an update to an existing message?
 =>  =>  =>  => if (isset($this->dataid_message))
 =>  =>  =>  =>  =>  => $msgOptions['id'] = ->dataid_message;

 =>  =>  =>  => // Set some topic parameters
 =>  =>  =>  => $topicOptions = array(
 =>  =>  =>  =>  =>  => 'mark_as_read' => false,
 =>  =>  =>  =>  =>  => 'lock_mode' => 0,
 =>  =>  =>  =>  =>  => 'sticky_mode' => 0
 =>  =>  =>  => );

 =>  =>  =>  => // Important!!! With set topic id, this is an update otherwise this is a new post
 =>  =>  =>  => if (isset($this->dataid_topic))
 =>  =>  =>  =>  =>  => $topicOptions['id'] = ->dataid_topic;
 =>  =>  =>  => else
 =>  =>  =>  =>  =>  => $topicOptions['board'] = $this->cfg('topic_board');

 =>  =>  =>  => // Infos about poster
 =>  =>  =>  => $posterOptions = array(
 =>  =>  =>  =>  =>  => 'id' => User::getId()
 =>  =>  =>  => );

 =>  =>  =>  => // Run topic creation. If this is an CREATE the return value will be an array with data about the topic created
 =>  =>  =>  => $topic = App::getInstance('Forum')->getModel('Topic')saveTopic($msgOptions, $topicOptions, $posterOptions);

 =>  =>  =>  => // Is there topic data?
 =>  =>  =>  => if (!$topic)
 =>  =>  =>  =>  =>  => return false;

 =>  =>  =>  => ->dataid_topic = $topicid_topic;
 =>  =>  =>  => ->dataid_message = $topicid_message;

 =>  =>  =>  => ## Calendar

 =>  =>  =>  => // Create calendar event?
 =>  =>  =>  => if ($this->cfg('use_calendar'))
 =>  =>  =>  => {
 =>  =>  =>  =>  =>  => Smf::useSource('Subs-Calendar');

 =>  =>  =>  =>  =>  => $eventOptions = array(
 =>  =>  =>  =>  =>  =>  =>  => 'title' => date('H:i', ->datastarttime) . ' - ' . ->datadestination,
 =>  =>  =>  =>  =>  =>  =>  => 'start_date' => date('Y-m-d', ->datastarttime),
 =>  =>  =>  =>  =>  =>  =>  => 'board' => $topicOptions['board'],
 =>  =>  =>  =>  =>  =>  =>  => 'topic' => $topicid_topic,
 =>  =>  =>  =>  =>  =>  =>  => 'member' => User::getId()
 =>  =>  =>  =>  =>  => );

 =>  =>  =>  =>  =>  => insertEvent($eventOptions);

 =>  =>  =>  =>  =>  => ->dataid_event = $eventOptions['id'];
 =>  =>  =>  => }

 =>  =>  =>  => // Save raidinfos
 =>  =>  =>  => ->save(false);
 =>  => }
}

