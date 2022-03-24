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
     * Test creating report view grading helper object.
     */
    public function test_grading_html_output() {
        $result = create_report_grading("fluency", 0, 0);
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Fluency</h5>'.
            '<h5 class="grade-stars"></h5><h6 class="grade-number">0/0</h6>'.
            '<div class="card-text">Fluency score is 0, red score.</div></div></div>', $result);
    }

    /**
     * Test creating report view holistic helper object.
     */
    public function test_holistic_html_output() {
        $result = create_report_holistic(3);
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Holistic</h5>'.
            '<h6 class="grade-number">B1</h6><div class="card-text">Holistic score is 3, yellow score.</div></div></div>', $result);
    }

    /**
     * Test creating report view GOP helper object.
     */
    public function test_gop_html_output() {
        $result = create_report_gop(0.72);
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Goodness of pronunciation</h5><h6 class="grade-number">72/100</h6><div class="card-text">Pronunciation score is 7, big pink score.</div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test creating report view tab creation helper.
     */
    public function test_tabs_html_output() {
        $result = create_report_tabs('', '');
        $this->assertEquals('<nav><div class="nav nav-tabs" id="nav-tab" role="tablist">'.
            '<button class="nav-link active ml-2" id="report-grades-tab" data-toggle="tab" href="#report-grades" role="tab" '.
            'aria-controls="report-grades" aria-selected="true">Task grades</button>'.
            '<button class="nav-link ml-2" id="report-holistic-tab" data-toggle="tab" href="#report-holistic" role="tab" '.
            'aria-controls="report-holistic" aria-selected="false">Holistic</button>'.
            '</div></nav><div class="tab-content" id="nav-tabContent">'.
            '<div class="tab-pane fade show active" id="report-grades" role="tabpanel" aria-labelledby="report-grades-tab"></div>'.
            '<div class="tab-pane fade" id="report-holistic" role="tabpanel" aria-labelledby="report-holistic-tab">'.
            '</div></div>', $result);
    }

    /**
     * Test creating report view specific transcription object.
     */
    public function test_transcription_html_output() {
        $testtranscription = "Lorem ipsum test text";
        $result = create_report_transcription($testtranscription);
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Transcription</h5>'.
            '<div class="card-text scrollbox200">Lorem ipsum test text</div></div></div>', $result);
    }

    /**
     * Test creating navigation buttons for view
     */
    public function test_navbuttons_html_output() {
        $result = create_nav_buttons('info', 1, 2);
        $this->assertEquals('<div class="navbuttons"><a href=https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=2&amp;page=1 id="nextButton" class="btn btn-primary">Next ></a href=https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=2&amp;page=1></div>', // phpcs:ignore moodle.Files.LineLength.MaxExceeded
            $result);
        $result = create_nav_buttons('assignmentprev', 1, 2);
        $this->assertEquals('<div class="navbuttons"><a href=https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=2&amp;page=0 id="prevButton" class="btn btn-primary">< Previous</a href=https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=2&amp;page=0></div>', // phpcs:ignore moodle.Files.LineLength.MaxExceeded
            $result);
        $result = create_nav_buttons('assignmentnext', 1, 2);
        $this->assertEquals('<div class="navbuttons"><a href=https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=2&amp;page=2 id="nextButton" class="btn btn-primary">Next ></a href=https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=2&amp;page=2></div>', // phpcs:ignore moodle.Files.LineLength.MaxExceeded
            $result);
        $result = create_nav_buttons('report', 1, 2);
        $this->assertEquals('<div class="navbuttons"><a href=https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=2&amp;page=1 id="tryAgainButton" class="btn btn-primary">See the assignment</a href=https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=2&amp;page=1></div>', // phpcs:ignore moodle.Files.LineLength.MaxExceeded
            $result);
    }
}
