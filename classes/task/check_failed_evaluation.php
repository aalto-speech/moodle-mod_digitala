<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * The mod_digitala task for sending attempt to evaluation.
 *
 * @package     mod_digitala
 * @author      Alanen, Tuomas; Erkkilä, Joona; Harjunpää, Topi; Heijala, Maikki.
 * @copyright   2022 Helsingin Yliopisto
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_digitala\task;
defined('MOODLE_INTERNAL') || die();
require_once(__DIR__.'/../../locallib.php');

/**
 * An example of a scheduled task.
 *
 * @package     mod_digitala
 * @author      Alanen, Tuomas; Erkkilä, Joona; Harjunpää, Topi; Heijala, Maikki.
 * @copyright   2022 Helsingin Yliopisto
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class check_failed_evaluation extends \core\task\scheduled_task {

    /**
     * Return the task's name as shown in admin screens.
     *
     * @return string - task's name
     */
    public function get_name() {
        return get_string('task-check_failed_evaluation', 'digitala');
    }

    /**
     * Execute the task.
     */
    public function execute() {
        global $DB;
        $time = time() - 7200; // Checks if attempt has been waiting for over two hour before re-evaluation.
        $waiting = $DB->get_records_select('digitala_attempts', "status='waiting' AND timemodified < ".$time);
        foreach ($waiting as $attempt) {
            set_attempt_status($attempt, 'retry');
            mtrace('Setting attempt '.$attempt->id.' to status retry');
        }

        $attempts = $DB->get_records('digitala_attempts', array('status' => 'retry'));

        foreach ($attempts as $attempt) {
            if ($DB->record_exists('digitala', array('id' => $attempt->digitala))) {
                $activity = $DB->get_record('digitala', array('id' => $attempt->digitala), '*', MUST_EXIST);
                $course = $DB->get_record('course', array('id' => $activity->course), '*', MUST_EXIST);
                $cm = get_coursemodule_from_instance('digitala', $activity->id, $course->id, false, MUST_EXIST);
                $modulecontext = \context_module::instance($cm->id);

                $assignment = new \stdClass();
                $assignment->instanceid = $attempt->digitala;
                $assignment->userid = $attempt->userid;
                $assignment->attemptlang = $activity->attemptlang;
                $assignment->attempttype = $activity->attempttype;

                if ($activity->attempttype == 'readaloud') {
                    $assignment->servertext = format_string($activity->resources);
                } else {
                    $assignment->servertext = format_string($activity->assignment);
                }

                $fileinfo = new \stdClass();
                $fileinfo->contextid = $modulecontext->id;
                $fileinfo->component = 'mod_digitala';
                $fileinfo->filearea = 'recordings';
                $fileinfo->itemid = get_file_item_id($attempt->id, $attempt->attemptnumber);
                $fileinfo->filepath = '/';
                $fileinfo->filename = $attempt->file;

                mtrace('Creating send to evaluation task for attempt '.$attempt->id);
                send_answerrecording_for_evaluation($fileinfo, $assignment, $attempt->recordinglength);
            }
        }

    }
}
