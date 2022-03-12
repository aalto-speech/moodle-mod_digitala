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
 * Unit tests for locallib.
 *
 * @group       mod_digitala
 * @package     mod_digitala
 * @category    test
 * @copyright   2022 Name
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class locallib_test extends \advanced_testcase {

    /**
     * Setup for unit test.
     */
    protected function setUp(): void {
        $this->setAdminUser();
        $this->resetAfterTest();
        $this->course = $this->getDataGenerator()->create_course();
        $this->digitala = $this->getDataGenerator()->create_module('digitala', [
            'course' => $this->course->id,
            'name' => 'new_digitala',
            'attemptlang' => 'fin',
            'attempttype' => 'freeform',
            'assignment' => array('text' => 'Assignment text', 'format' => 1),
            'resources' => array('text' => 'Resource text', 'format' => 1),
        ]);
    }
    /**
     * Test generating page_url
     */
    public function test_page_url() {
        for ($i = 0; $i <= 2; $i++) {
            $generatedurl = (page_url($i, 1, 1))->out();
            $this->assertEquals($generatedurl, 'https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page='.$i);
        }
    }

    /**
     * Test generating progress bar step link as non active and active
     */
    public function test_create_progress_bar_step_link() {
        $info = create_progress_bar_step_link('digitalainfo', 0, 1, 1, false);
        $assignment = create_progress_bar_step_link('digitalaassignment', 1, 1, 1, false);
        $report = create_progress_bar_step_link('digitalareport', 2, 1, 1, false);
        $this->assertEquals($info, '<a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=0"><span class="pb-num">1</span>Info</a>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $this->assertEquals($assignment, '<a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=1"><span class="pb-num">2</span>Assignment</a>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $this->assertEquals($report, '<a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=2"><span class="pb-num">3</span>Report</a>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded

        $infoactive = create_progress_bar_step_link('digitalainfo', 0, 1, 1, true);
        $assignmentactive = create_progress_bar_step_link('digitalaassignment', 1, 1, 1, true);
        $reportactive = create_progress_bar_step_link('digitalareport', 2, 1, 1, true);
        $this->assertEquals($infoactive, '<a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=0"><span class="pb-num active">1</span>Info</a>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $this->assertEquals($assignmentactive, '<a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=1"><span class="pb-num active">2</span>Assignment</a>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $this->assertEquals($reportactive, '<a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=2"><span class="pb-num active">3</span>Report</a>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test generating opening div for progress bar
     */
    public function test_start_progress_bar() {
        $start = start_progress_bar();
        $this->assertEquals($start, '<div class="digitala-progress-bar">');
    }

    /**
     * Test generating ending div for progress bar
     */
    public function test_end_progress_bar() {
        $end = end_progress_bar();
        $this->assertEquals($end, '</div>');
    }

    /**
     * Test generating whole step in the progress bar
     */
    public function test_create_progress_bar_step() {
        $info = create_progress_bar_step('digitalainfo', 0, 1, 1, 1);
        $assignment = create_progress_bar_step('digitalaassignment', 1, 1, 1, 0);
        $report = create_progress_bar_step('digitalareport', 2, 1, 1, 0);
        $infoactive = create_progress_bar_step('digitalainfo', 0, 1, 1, 0);
        $assignmentactive = create_progress_bar_step('digitalaassignment', 1, 1, 1, 1);
        $reportactive = create_progress_bar_step('digitalareport', 2, 1, 1, 2);
        $this->assertEquals($info, '<div class="pb-step first"><a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=0"><span class="pb-num">1</span>Info</a></div>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $this->assertEquals($assignment, '<div class="pb-step"><a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=1"><span class="pb-num">2</span>Assignment</a></div>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $this->assertEquals($report, '<div class="pb-step last"><a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=2"><span class="pb-num">3</span>Report</a></div>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $this->assertEquals($infoactive, '<div class="pb-step active first"><a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=0"><span class="pb-num active">1</span>Info</a></div>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $this->assertEquals($assignmentactive, '<div class="pb-step active"><a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=1"><span class="pb-num active">2</span>Assignment</a></div>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $this->assertEquals($reportactive, '<div class="pb-step active last"><a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=2"><span class="pb-num active">3</span>Report</a></div>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test generating page_url
     */
    public function test_calculate_progress_bar_spacers() {
        $info = calculate_progress_bar_spacers(0);
        $assignment = calculate_progress_bar_spacers(1);
        $report = calculate_progress_bar_spacers(2);
        $this->assertEquals($info, array('left' => 'right-empty', 'right' => 'nothing'));
        $this->assertEquals($assignment, array('left' => 'left-empty', 'right' => 'right-empty'));
        $this->assertEquals($report, array('left' => 'nothing', 'right' => 'left-empty'));
    }

    /**
     * Test generating page_url
     */
    public function test_create_progress_bar_spacer() {
        $rightempty = create_progress_bar_spacer('right-empty');
        $leftempty = create_progress_bar_spacer('left-empty');
        $nothing = create_progress_bar_spacer('nothing');
        // @codingStandardsIgnoreStart moodle.Files.LineLength.MaxExceeded
        $this->assertEquals($rightempty, '<div class="pb-spacer pb-spacer-right"><svg width="100%" height="100%" viewBox="0 0 275 500" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><path d="M255,250L20,0L0,0L0,500L20,500L255,250Z" style="fill:rgb(211,211,211);"/><path d="M20,20L255,250L20,480" style="fill:none;stroke:rgb(211,211,211);stroke-width:40px;"/></svg></div>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $this->assertEquals($leftempty, '<div class="pb-spacer pb-spacer-left"><svg width="100%" height="100%" viewBox="0 0 275 500" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><path d="M275,0L20,0L255,250L20,500L275,500L275,0Z" style="fill:rgb(211,211,211);"/><path d="M20,20L255,250L20,480" style="fill:none;stroke:rgb(211,211,211);stroke-width:40px;"/></svg></div>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $this->assertEquals($nothing, '<div class="pb-spacer"><svg width="100%" height="100%" viewBox="0 0 275 500" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><path d="M20,20L255,250L20,480" style="fill:none;stroke:rgb(211,211,211);stroke-width:40px;"/></svg></div>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        // @codingStandardsIgnoreEnd moodle.Files.LineLength.MaxExceeded
    }


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
     * Test creating new button.
     */
    public function test_create_button() {
        $result = create_button('buttonId', 'buttonText');
        $this->assertEquals('<button id="buttonId" class="buttonId">buttonText</button>', $result);
    }

    /**
     * Test creating create microphone.
     */
    public function test_create_microphone() {
        $result = create_microphone('testmic');
        $this->assertEquals('<br></br><button id="record" class="record">Start</button><button id="stopRecord" class="stopRecord">Stop</button><button id="listenButton" class="listenButton">Listen recording</button>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test creating create assignment.
     */
    public function test_create_assignment() {
        $result = create_assignment('testassignment');
        $this->assertEquals('<div class="card-body"><h5 class="card-title"></h5><div class="card-text scrollbox200">testassignment</div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test creating create resource.
     */
    public function test_create_resource() {
        $result = create_resource('testresource');
        $this->assertEquals('<div class="card-body"><h5 class="card-title"></h5><div class="card-text scrollbox400">testresource</div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test sending answerrecording for evaluation.
     */
    public function test_send_answerrecording_for_evaluation() {
        $file = new file('');
        $assignmenttextraw = 'abc';
        $result = send_answerrecording_for_evaluation($file, $assignmenttextraw);
        $this->assertEquals('', $result);
    }

    /**
     * Test saving attempt.
     */
    public function test_save_attempt() {
        global $DB;
        save_attempt();

    }
}
