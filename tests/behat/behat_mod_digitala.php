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
 * Steps definitions related with the digitala activity.
 *
 * @package     mod_digitala
 * @author      Alanen, Tuomas; Erkkilä, Joona; Harjunpää, Topi; Heijala, Maikki.
 * @copyright   2022 Helsingin Yliopisto
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../lib/behat/behat_base.php');

use Behat\Gherkin\Node\TableNode as TableNode;
/**
 * Digitala-related steps definitions.
 *
 * @package     mod_digitala
 * @author      Alanen, Tuomas; Erkkilä, Joona; Harjunpää, Topi; Heijala, Maikki.
 * @copyright   2022 Helsingin Yliopisto
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_mod_digitala extends behat_base {
    /**
     * Adds freeform attempt to databse
     *
     * @Given /^I add freeform attempt to database:$/
     *
     * @param TableNode $data
     */
    public function i_add_freeform_attempt_to_database(TableNode $data) {
        global $DB;

        foreach ($data->getHash() as $row) {
            $attempt = new \stdClass();

            $activity = $DB->get_record('digitala', array('name' => $row['name']), '*', MUST_EXIST);
            $user = $DB->get_record('user', ['username' => $row['username']], '*', MUST_EXIST);
            $cm = get_coursemodule_from_instance('digitala', $activity->id, $activity->course, false, MUST_EXIST);
            $modulecontext = context_module::instance($cm->id);
            $time = time();

            $attempt->attemptnumber = $row['attemptnumber'];
            $attempt->digitala = $activity->id;
            $attempt->userid = $user->id;
            $attempt->file = $row['file'];
            $attempt->transcript = $row['transcript'];
            $attempt->taskcompletion = $row['taskcompletion'];
            $attempt->fluency = $row['fluency'];
            $attempt->pronunciation = $row['pronunciation'];
            $attempt->lexicogrammatical = $row['lexicogrammatical'];
            $attempt->holistic = $row['holistic'];
            $attempt->timecreated = $time;
            $attempt->timemodified = $time;
            $attempt->recordinglength = $row['recordinglength'];
            $attempt->status = $row['status'];

            $attemptid = $DB->insert_record('digitala_attempts', $attempt);
            $attemptnumber = $attempt->attemptnumber;
            if ($attemptnumber < 100 && $attemptnumber > 9) {
                $number = "0".$attemptnumber;
            } else if ($attemptnumber < 10) {
                $number = "00".$attemptnumber;
            } else {
                $number = $attemptnumber;
            }
            $itemid = intval($attemptid.$number);

            $fs = get_file_storage();
            $fileinfo = new stdClass();
            $fileinfo->contextid = $modulecontext->id;
            $fileinfo->component = 'mod_digitala';
            $fileinfo->filearea = 'recordings';
            $fileinfo->filepath = '/';
            $fileinfo->filename = $attempt->file;
            $fileinfo->itemid = $itemid;
            $fs->create_file_from_string($fileinfo, 'I\'m an audio file, cool right!?');

            $file = $fs->get_file($fileinfo->contextid, $fileinfo->component, $fileinfo->filearea,
                                        $fileinfo->itemid, $fileinfo->filepath, $fileinfo->filename);
            if (!$file) {
                throw new Exception('File not created');
            }
        }
    }

    /**
     * Adds readaloud attempt to databse
     *
     * @Given /^I add readaloud attempt to database:$/
     *
     * @param TableNode $data
     */
    public function i_add_readaloud_attempt_to_database(TableNode $data) {
        global $DB;

        foreach ($data->getHash() as $row) {
            $attempt = new \stdClass();

            $activity = $DB->get_record('digitala', array('name' => $row['name']), '*', MUST_EXIST);
            $user = $DB->get_record('user', ['username' => $row['username']], '*', MUST_EXIST);
            $cm = get_coursemodule_from_instance('digitala', $activity->id, $activity->course, false, MUST_EXIST);
            $modulecontext = context_module::instance($cm->id);
            $time = time();

            $attempt->attemptnumber = $row['attemptnumber'];
            $attempt->digitala = $activity->id;
            $attempt->userid = $user->id;
            $attempt->file = $row['file'];
            $attempt->transcript = $row['transcript'];
            $attempt->feedback = $row['feedback'];
            $attempt->fluency = $row['fluency'];
            $attempt->pronunciation = $row['pronunciation'];
            $attempt->timecreated = $time;
            $attempt->timemodified = $time;
            $attempt->recordinglength = $row['recordinglength'];
            $attempt->status = $row['status'];

            $attemptid = $DB->insert_record('digitala_attempts', $attempt);

            $attemptnumber = $attempt->attemptnumber;
            if ($attemptnumber < 100 && $attemptnumber > 9) {
                $number = "0".$attemptnumber;
            } else if ($attemptnumber < 10) {
                $number = "00".$attemptnumber;
            } else {
                $number = $attemptnumber;
            }
            $itemid = intval($attemptid.$number);

            $fs = get_file_storage();
            $fileinfo = new stdClass();
            $fileinfo->contextid = $modulecontext->id;
            $fileinfo->component = 'mod_digitala';
            $fileinfo->filearea = 'recordings';
            $fileinfo->filepath = '/';
            $fileinfo->filename = $attempt->file;
            $fileinfo->itemid = $itemid;
            $fs->create_file_from_string($fileinfo, 'I\'m an audio file, cool right!?');

            $file = $fs->get_file($fileinfo->contextid, $fileinfo->component, $fileinfo->filearea,
                                        $fileinfo->itemid, $fileinfo->filepath, $fileinfo->filename);
            if (!$file) {
                throw new Exception('File not created');
            }
        }
    }

    /**
     * Checks if recording file is found
     *
     * @Given /^I check if recording exists:$/
     *
     * @param TableNode $data
     */
    public function i_check_if_recording_exists(TableNode $data) {
        global $DB;

        foreach ($data->getHash() as $row) {
            $feedback = new \stdClass();

            $activity = $DB->get_record('digitala', array('name' => $row['name']), '*', MUST_EXIST);
            $user = $DB->get_record('user', ['username' => $row['username']], '*', MUST_EXIST);
            $cm = get_coursemodule_from_instance('digitala', $activity->id, $activity->course, false, MUST_EXIST);
            $modulecontext = context_module::instance($cm->id);
            $attempt = $DB->get_record('digitala_attempts',
                                       array('digitala' => $activity->id, 'userid' => $user->id), '*', MUST_EXIST);

            $attemptid = $attempt->id;
            $attemptnumber = $attempt->attemptnumber;
            if ($attemptnumber < 100 && $attemptnumber > 9) {
                $number = "0".$attemptnumber;
            } else if ($attemptnumber < 10) {
                $number = "00".$attemptnumber;
            } else {
                $number = $attemptnumber;
            }
            $itemid = intval($attemptid.$number);

            $fs = get_file_storage();
            $fileinfo = new stdClass();
            $fileinfo->contextid = $modulecontext->id;
            $fileinfo->component = 'mod_digitala';
            $fileinfo->filearea = 'recordings';
            $fileinfo->filepath = '/';
            $fileinfo->filename = $attempt->file;
            $fileinfo->itemid = $itemid;

            $file = $fs->get_file($fileinfo->contextid, $fileinfo->component, $fileinfo->filearea,
                                        $fileinfo->itemid, $fileinfo->filepath, $fileinfo->filename);
            if (!$file) {
                throw new Exception('File not created');
            }
        }
    }

    /**
     * Adds readaloud feedback to database
     *
     * @Given /^I add readaloud feedback to database:$/
     *
     * @param TableNode $data
     */
    public function i_add_readaloud_feedback_to_database(TableNode $data) {
        global $DB;

        foreach ($data->getHash() as $row) {
            $feedback = new \stdClass();

            $activity = $DB->get_record('digitala', array('name' => $row['name']), '*', MUST_EXIST);
            $user = $DB->get_record('user', ['username' => $row['username']], '*', MUST_EXIST);
            $attempt = $DB->get_record('digitala_attempts',
                                       array('digitala' => $activity->id, 'userid' => $user->id), '*', MUST_EXIST);

            $time = time();

            $feedback->digitala = $activity->id;
            $feedback->attempt = $user->id;

            $feedback->old_fluency = $row['old_fluency'];
            $feedback->fluency = $row['fluency'];
            $feedback->fluency_reason = $row['fluency_reason'];

            $feedback->old_pronunciation = $row['old_pronunciation'];
            $feedback->pronunciation = $row['pronunciation'];
            $feedback->pronunciation_reason = $row['pronunciation_reason'];

            $feedback->timecreated = $time;
            $feedback->timemodified = $time;

            $DB->insert_record('digitala_report_feedback', $feedback);
        }
    }

    /**
     * Adds freeform feedback to database
     *
     * @Given /^I add freeform feedback to database:$/
     *
     * @param TableNode $data
     */
    public function i_add_freeform_feedback_to_database(TableNode $data) {
        global $DB;

        foreach ($data->getHash() as $row) {
            $feedback = new \stdClass();

            $activity = $DB->get_record('digitala', array('name' => $row['name']), '*', MUST_EXIST);
            $user = $DB->get_record('user', ['username' => $row['username']], '*', MUST_EXIST);
            $attempt = $DB->get_record('digitala_attempts',
                                       array('digitala' => $activity->id, 'userid' => $user->id), '*', MUST_EXIST);

            $time = time();

            $feedback->digitala = $activity->id;
            $feedback->attempt = $user->id;

            $feedback->old_fluency = $row['old_fluency'];
            $feedback->fluency = $row['fluency'];
            $feedback->fluency_reason = $row['fluency_reason'];

            $feedback->old_pronunciation = $row['old_pronunciation'];
            $feedback->pronunciation = $row['pronunciation'];
            $feedback->pronunciation_reason = $row['pronunciation_reason'];

            $feedback->old_taskcompletion = $row['old_taskcompletion'];
            $feedback->taskcompletion = $row['taskcompletion'];
            $feedback->taskcompletion_reason = $row['taskcompletion_reason'];

            $feedback->old_lexicogrammatical = $row['old_lexicogrammatical'];
            $feedback->lexicogrammatical = $row['lexicogrammatical'];
            $feedback->lexicogrammatical_reason = $row['lexicogrammatical_reason'];

            $feedback->old_holistic = $row['old_holistic'];
            $feedback->holistic = $row['holistic'];
            $feedback->holistic_reason = $row['holistic_reason'];

            $feedback->timecreated = $time;
            $feedback->timemodified = $time;

            $DB->insert_record('digitala_report_feedback', $feedback);
        }
    }

    /**
     * Sets evaluation status in attempt
     *
     * @Given /^I set evaluation status to:$/
     *
     * @param TableNode $data
     */
    public function i_set_evaluation_status(TableNode $data) {
        global $DB;

        foreach ($data->getHash() as $row) {
            $activity = $DB->get_record('digitala', array('name' => $row['name']), '*', MUST_EXIST);
            $user = $DB->get_record('user', ['username' => $row['username']], '*', MUST_EXIST);

            $attempt = $DB->get_record('digitala_attempts', array('userid' => $user->id), '*', MUST_EXIST);
            $attempt->status = $row['status'];
            $attempt->timemodified = time();

            $DB->update_record('digitala_attempts', $attempt);
        }
    }

    /**
     * Sets evaluation status in attempt
     *
     * @Given /^I set attempts creation time to:$/
     *
     * @param TableNode $data
     */
    public function i_set_attempts_creation_time_to(TableNode $data) {
        global $DB;

        foreach ($data->getHash() as $row) {
            $activity = $DB->get_record('digitala', array('name' => $row['name']), '*', MUST_EXIST);
            $user = $DB->get_record('user', ['username' => $row['username']], '*', MUST_EXIST);

            $attempt = $DB->get_record('digitala_attempts', array('userid' => $user->id), '*', MUST_EXIST);
            $attempt->timecreated = $row['time'] == 'now' ? time() : $row['time'];
            $attempt->timemodified = $row['time'] == 'now' ? time() : $row['time'];

            $DB->update_record('digitala_attempts', $attempt);
        }
    }

    /**
     * Checks if given feedback is found from database.
     *
     * @Then /^the following feedback is found:$/
     *
     * @param TableNode $data
     */
    public function the_following_feedback_is_found(TableNode $data) {
        global $DB;

        foreach ($data->getHash() as $row) {
            $attempt = new \stdClass();

            $activity = $DB->get_record('digitala', array('name' => $row['name']), '*', MUST_EXIST);
            $user = $DB->get_record('user', ['username' => $row['username']], '*', MUST_EXIST);
            $attempt = $DB->get_record('digitala_attempts', array('userid' => $user->id,
                                       'digitala' => $activity->id), '*', MUST_EXIST);

            if (!$DB->record_exists('digitala_report_feedback', array('attempt' => $attempt->id))) {
                throw new Exception('Record not found');
            }
        }
    }

    /**
     * Resolves activitys phases in step 'When I am on the "[id]" "[phase]" page'
     *
     * Recognised phase names are:
     * | phase                    | id                                | description                                          |
     * | Invalid                  | Activity name                     | Invalid view page number                             |
     * | Info                     | Activity name                     | Microphone testing phase                             |
     * | Assignment               | Activity name                     | Assignment phase                                     |
     * | Report                   | Activity name                     | Students report phase                                |
     * | Teacher Reports Overview | Activity name                     | Teacher's list of all attempts in activity           |
     * | Teacher Report Details   | Activity name > Students username | Teacher's view of student's attempt in details       |
     * | Teacher Report Feedback  | Activity name > Students username | Teacher's ability to give feedback on ASR Evaluation |
     * | Export                   | Activity name > mode              | Export as CSV or all recordings                      |
     *
     * @param string $phase Name of the phase.
     * @param string $id Activity name and student username if needed
     * @return moodle_url URL where we want to be at
     * @throws Exception If phase not found or incorrect amount of id params
     */
    protected function resolve_page_instance_url(string $phase, string $id): moodle_url {
        global $DB;

        switch (strtolower($phase)) {
            case 'invalid':
                $activity = $DB->get_record('digitala', array('name' => $id), '*', MUST_EXIST);
                $cm = get_coursemodule_from_instance('digitala', $activity->id, $activity->course, false, MUST_EXIST);
                return new moodle_url('/mod/digitala/view.php',
                                      array('id' => $cm->id, 'page' => 4));

            case 'info':
                $activity = $DB->get_record('digitala', array('name' => $id), '*', MUST_EXIST);
                $cm = get_coursemodule_from_instance('digitala', $activity->id, $activity->course, false, MUST_EXIST);
                return new moodle_url('/mod/digitala/view.php',
                                      array('id' => $cm->id, 'page' => 0));

            case 'assignment':
                $activity = $DB->get_record('digitala', array('name' => $id), '*', MUST_EXIST);
                $cm = get_coursemodule_from_instance('digitala', $activity->id, $activity->course, false, MUST_EXIST);
                return new moodle_url('/mod/digitala/view.php',
                                      array('id' => $cm->id, 'page' => 1));

            case 'report':
                $activity = $DB->get_record('digitala', array('name' => $id), '*', MUST_EXIST);
                $cm = get_coursemodule_from_instance('digitala', $activity->id, $activity->course, false, MUST_EXIST);
                return new moodle_url('/mod/digitala/view.php',
                                      array('id' => $cm->id, 'page' => 2));

            case 'teacher reports overview':
                $activity = $DB->get_record('digitala', array('name' => $id), '*', MUST_EXIST);
                $cm = get_coursemodule_from_instance('digitala', $activity->id, $activity->course, false, MUST_EXIST);
                return new moodle_url('/mod/digitala/report.php',
                                      array('id' => $cm->id, 'mode' => 'overview'));

            case 'teacher report details':
                if (substr_count($id, ' > ') !== 1) {
                    throw new Exception('Check that you have provided every needed parameter in id');
                }
                list($activityname, $username) = explode(' > ', $id);

                $activity = $DB->get_record('digitala', array('name' => $activityname), '*', MUST_EXIST);
                $cm = get_coursemodule_from_instance('digitala', $activity->id, $activity->course, false, MUST_EXIST);
                $user = $DB->get_record('user', array('username' => $username), '*', MUST_EXIST);

                return new moodle_url('/mod/digitala/report.php',
                                      array('id' => $cm->id, 'mode' => 'detail', 'student' => $user->id));

            case 'teacher report feedback':
                if (substr_count($id, ' > ') !== 1) {
                    throw new Exception('Check that you have provided every needed parameter in id');
                }
                list($activityname, $username) = explode(' > ', $id);

                $activity = $DB->get_record('digitala', array('name' => $activityname), '*', MUST_EXIST);
                $cm = get_coursemodule_from_instance('digitala', $activity->id, $activity->course, false, MUST_EXIST);
                $user = $DB->get_record('user', array('username' => $username), '*', MUST_EXIST);

                return new moodle_url('/mod/digitala/reporteditor.php',
                                      array('id' => $cm->id, 'student' => $user->id));

            case 'export':
                if (substr_count($id, ' > ') !== 1) {
                    throw new Exception('Check that you have provided every needed parameter in id');
                }
                list($activityname, $mode) = explode(' > ', $id);

                $activity = $DB->get_record('digitala', array('name' => $activityname), '*', MUST_EXIST);
                $cm = get_coursemodule_from_instance('digitala', $activity->id, $activity->course, false, MUST_EXIST);

                return new moodle_url('/mod/digitala/export.php',
                                      array('id' => $cm->id, 'mode' => $mode));

            default:
                throw new Exception('Given phase is unknown: ' . $phase);
        }
    }
}
