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
 * @package    mod_digitala
 * @copyright  2020 Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../lib/behat/behat_base.php');

use Behat\Gherkin\Node\TableNode as TableNode;
/**
 * Digitala-related steps definitions.
 *
 * @package    mod_digitala
 * @copyright  2020 Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
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

            $DB->insert_record('digitala_attempts', $attempt);
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

            $DB->insert_record('digitala_attempts', $attempt);
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

            default:
                throw new Exception('Given phase is unknown: ' . $phase);
        }
    }
}
