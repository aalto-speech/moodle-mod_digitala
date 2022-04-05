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
            $attempt->fluency = $row['fluency'];
            $attempt->fluencymean = $row['fluencymean'];
            $attempt->speechrate = $row['speechrate'];
            $attempt->taskachievement = $row['taskachievement'];
            $attempt->accuracy = $row['accuracy'];
            $attempt->lexicalprofile = $row['lexicalprofile'];
            $attempt->nativeity = $row['nativeity'];
            $attempt->holistic = $row['holistic'];
            $attempt->timecreated = $time;
            $attempt->timemodified = $time;
            $attempt->recordinglength = $row['recordinglength'];

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
            $attempt->gop_score = $row['gop_score'];
            $attempt->timecreated = $time;
            $attempt->timemodified = $time;
            $attempt->recordinglength = $row['recordinglength'];

            $DB->insert_record('digitala_attempts', $attempt);
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

}
