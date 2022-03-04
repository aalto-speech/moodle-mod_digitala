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

namespace mod_digitala;

defined('MOODLE_INTERNAL') || die('Direct Access is forbidden!');

global $CFG;
require_once($CFG->dirroot . '/mod/digitala/locallib.php');

/**
 * Unit tests for view creation helpers: container, card and column.
 *
 * @group mod_digitala
 * @package     mod_digitala
 * @category    test
 * @copyright   2022 Name
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class view_helper_functions_test extends \advanced_testcase {

    /**
     * Test creating new container object.
     */
    public function test_container_html_output_right() {
        $result = start_container('some_step_of_digitala');
        $result .= end_container();
        $this->assertEquals('<div class="some_step_of_digitala"><div class="container-fluid">'.
            '<div class="row"></div></div></div>', $result);
    }

    /**
     * Test creating new column object.
     */
    public function test_column_html_output_right() {
        $result = start_column();
        $result .= end_column();
        $this->assertEquals('<div class="col digitala-column"></div>', $result);
    }

    /**
     * Test creating new card object.
     */
    public function test_card_html_output_right() {
        $result = create_card('pluginname', 'Some text here');
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Digitala</h5>'.
            '<div class="card-text">Some text here</div></div></div>', $result);
    }

    /**
     * Test drawing stars for the report view.
     */
    public function test_report_stars_output() {
        $result = create_report_stars(1, 3);
        $this->assertEquals('★☆☆', $result);
    }

    /**
     * Test creating report view specific helper object.
     */
    public function test_grading_html_output() {
        $report = new \stdClass();
        $report->name = "Grading";
        $report->grade = 0;
        $report->maxgrade = 0;
        $report->reporttext = "Test report";
        $result = create_report_grading($report);
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Grading</h5>'.
            '<h5 class="grade-stars"></h5><h6 class="grade-number">0/0</h6>'.
            '<div class="card-text">Test report</div></div></div>', $result);
    }

    /**
     * Test creating report view specific transcription object.
     */
    public function test_transcription_html_output() {
        $testtranscription = new \stdClass();
        $testtranscription->transtext = "Lorem ipsum test text";
        $result = create_report_transcription($testtranscription);
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Transcription</h5>'.
            '<div class="card-text scrollbox200">Lorem ipsum test text</div></div></div>', $result);
    }

    /**
     * Test creating navigation buttons for view
     */
    public function test_navbuttons_html_output() {
        $result = create_nav_buttons('info');
        $this->assertEquals('<div class="navbuttons"><button id="nextButton" class="nextButton">Next ></button></div>', $result);
        $result = create_nav_buttons('assignment');
        $this->assertEquals('<div class="navbuttons"><button id="prevButton" class="prevButton">< Previous</button></div>', $result);
        $result = create_nav_buttons('report');
        $this->assertEquals('<div class="navbuttons"><button id="tryAgainButton" class="tryAgainButton">Try again from start</button>' .
            '<button id="feedbackButton" class="feedbackButton">End and give feedback</button></div>', $result);
    }
}
