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
 * @package    mod_digitala
 * @copyright  2022 Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_digitala\task;
defined('MOODLE_INTERNAL') || die();
require_once(__DIR__.'/../../locallib.php');

/**
 * An example of a scheduled task.
 */
class check_failed_evaluation extends \core\task\scheduled_task {

    /**
     * Return the task's name as shown in admin screens.
     *
     * @return string
     */
    public function get_name() {
        return get_string('task-check_failed_evaluation', 'digitala');
    }

    /**
     * Execute the task.
     */
    public function execute() {
        global $DB;
        $time = time()-3600; // Checks if attempt has been waiting for over one hour before re-evaluation.
        $waiting = $DB->get_records_select('digitala_attempts', "status='waiting' AND timemodified < ".$time);
        foreach ($waiting as $attempt) {
            set_attempt_status($attempt, 'retry');
        }

        $attempts = $DB->get_records('digitala_attempts', array('status' => 'retry'));

        foreach ($attempts as $attempt) {
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
            $fileinfo->itemid = 0;
            $fileinfo->filepath = '/';
            $fileinfo->filename = $attempt->file;

            send_answerrecording_for_evaluation($fileinfo, $assignment, $attempt->recordinglength);
        }

    }
}
