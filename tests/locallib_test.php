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

use PHPUnit\Runner\Version as PHPUnitVersion;

global $CFG;
require_once($CFG->dirroot . '/mod/digitala/locallib.php');
require_once($CFG->dirroot . '/mod/digitala/renderable.php');
require_once($CFG->dirroot . '/mod/digitala/answerrecording_form.php');

/**
 * Unit tests for view creation helpers: container, card and column.
 *
 * @group       mod_digitala
 * @covers      \mod_digitala
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
            'attemptlang' => 'fi',
            'attempttype' => 'freeform',
            'assignment' => 'Assignment text',
            'resources' => array('text' => 'Resource text', 'format' => 1),
            'maxlength' => 120,
            'information' => array('text' => 'Information text', 'format' => 1),
        ]);
    }

    /**
     * Test generating switch_page
     */
    public function test_switch_page() {
        $_SERVER['REQUEST_URI'] = '/mod/digitala/view.php?id=1&d=1';
        $url = switch_page(1);
        $this->assertEquals('/mod/digitala/view.php?id=1&d=1&page=1', $url);
        $_SERVER['REQUEST_URI'] = '/mod/digitala/view.php?id=1&d=1&page=0';
        $url = switch_page(0);
        $this->assertEquals('/mod/digitala/view.php?id=1&d=1&page=0', $url);
        $url = switch_page(1);
        $this->assertEquals('/mod/digitala/view.php?id=1&d=1&page=1', $url);
        $url = switch_page(2);
        $this->assertEquals('/mod/digitala/view.php?id=1&d=1&page=2', $url);
    }

    /**
     * Test generating progress bar step link as non active and active
     */
    public function test_create_progress_bar_step_link() {
        $_SERVER['REQUEST_URI'] = '/mod/digitala/view.php?id=1&d=1&page=0';
        $info = create_progress_bar_step_link('info', 0, false);
        $assignment = create_progress_bar_step_link('assignment', 1, false);
        $report = create_progress_bar_step_link('report', 2, false);
        // @codingStandardsIgnoreStart moodle.Files.LineLength.MaxExceeded
        $this->assertEquals($info, '<a class="display-6" href="/mod/digitala/view.php?id=1&amp;d=1&amp;page=0"><span class="pb-num">1</span><span class="pb-phase-name">Begin</span></a>');
        $this->assertEquals($assignment, '<a class="display-6" href="/mod/digitala/view.php?id=1&amp;d=1&amp;page=1"><span class="pb-num">2</span><span class="pb-phase-name">Assignment</span></a>');
        $this->assertEquals($report, '<a class="display-6" href="/mod/digitala/view.php?id=1&amp;d=1&amp;page=2"><span class="pb-num">3</span><span class="pb-phase-name">Evaluation</span></a>');
        // @codingStandardsIgnoreEnd moodle.Files.LineLength.MaxExceeded
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
        $_SERVER['REQUEST_URI'] = '/mod/digitala/view.php?id=1&d=1&page=0';
        $info = create_progress_bar_step('info', 0, 1);
        $assignment = create_progress_bar_step('assignment', 1, 0);
        $report = create_progress_bar_step('report', 2, 0);
        $infoactive = create_progress_bar_step('info', 0, 0);
        $assignmentactive = create_progress_bar_step('assignment', 1, 1);
        $reportactive = create_progress_bar_step('report', 2, 2);
        // @codingStandardsIgnoreStart moodle.Files.LineLength.MaxExceeded
        $this->assertEquals($info, '<div class="pb-step first"><a class="display-6" href="/mod/digitala/view.php?id=1&amp;d=1&amp;page=0"><span class="pb-num">1</span><span class="pb-phase-name">Begin</span></a></div>');
        $this->assertEquals($assignment, '<div class="pb-step"><a class="display-6" href="/mod/digitala/view.php?id=1&amp;d=1&amp;page=1"><span class="pb-num">2</span><span class="pb-phase-name">Assignment</span></a></div>');
        $this->assertEquals($report, '<div class="pb-step last"><a class="display-6" href="/mod/digitala/view.php?id=1&amp;d=1&amp;page=2"><span class="pb-num">3</span><span class="pb-phase-name">Evaluation</span></a></div>');
        $this->assertEquals($infoactive, '<div class="pb-step active first"><a class="display-6" href="/mod/digitala/view.php?id=1&amp;d=1&amp;page=0"><span class="pb-num">1</span><span class="pb-phase-name">Begin</span></a></div>');
        $this->assertEquals($assignmentactive, '<div class="pb-step active"><a class="display-6" href="/mod/digitala/view.php?id=1&amp;d=1&amp;page=1"><span class="pb-num">2</span><span class="pb-phase-name">Assignment</span></a></div>');
        $this->assertEquals($reportactive, '<div class="pb-step active last"><a class="display-6" href="/mod/digitala/view.php?id=1&amp;d=1&amp;page=2"><span class="pb-num">3</span><span class="pb-phase-name">Evaluation</span></a></div>');
        // @codingStandardsIgnoreEnd moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test calculating progress bar spacers
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
     * Test creating progressbar spacer
     */
    public function test_create_progress_bar_spacer() {
        $rightempty = create_progress_bar_spacer('right-empty');
        $leftempty = create_progress_bar_spacer('left-empty');
        $nothing = create_progress_bar_spacer('nothing');
        // @codingStandardsIgnoreStart moodle.Files.LineLength.MaxExceeded
        $this->assertEquals($rightempty, '<div class="pb-spacer pb-spacer-right"><svg class="pb-svg-front" viewBox="0 0 275 500" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5"><path d="M255 250 20 0H0v500h20l235-250Z" fill="#d3d3d3" /><path d="m20 20 235 230L20 480" style="fill:none;stroke:#d3d3d3;stroke-width:40px" /></svg></div>');
        $this->assertEquals($leftempty, '<div class="pb-spacer pb-spacer-left"><svg class="pb-svg-back" viewBox="0 0 275 500" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5"><path d="M275 0H20l235 250L20 500h255V0Z" fill="#d3d3d3" /><path d="m20 20 235 230L20 480" style="fill:none;stroke:#d3d3d3;stroke-width:40px" /></svg></div>');
        $this->assertEquals($nothing, '<div class="pb-spacer"><svg class="pb-svg-front" viewBox="0 0 275 500" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5"><path d="m20 20 235 230L20 480" style="fill:none;stroke:#d3d3d3;stroke-width:40px" /></svg></div>');
        // @codingStandardsIgnoreEnd moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test creating navigation buttons for view
     */
    public function test_navbuttons_html_output() {
        $_SERVER['REQUEST_URI'] = '/mod/digitala/view.php?id=1&d=2&page=0';
        $result = create_nav_buttons('info');
        // @codingStandardsIgnoreStart moodle.Files.LineLength.MaxExceeded
        $this->assertEquals('<div class="navbuttons"><a id="nextButton" class="btn btn-primary" href="/mod/digitala/view.php?id=1&amp;d=2&amp;page=1">Next ></a></div>',
            $result);
        $result = create_nav_buttons('assignmentprev');
        $this->assertEquals('<div class="navbuttons"><a id="prevButton" class="btn btn-primary" href="/mod/digitala/view.php?id=1&amp;d=2&amp;page=0">< Previous</a></div>',
            $result);
        $result = create_nav_buttons('assignmentnext');
        $this->assertEquals('<div class="navbuttons"><a id="nextButton" class="btn btn-primary" href="/mod/digitala/view.php?id=1&amp;d=2&amp;page=2">Next ></a></div>',
            $result);
        $result = create_nav_buttons('report');
        $this->assertEquals('<div class="navbuttons"><a id="tryAgainButton" class="btn btn-primary" href="/mod/digitala/view.php?id=1&amp;d=2&amp;page=1">See the assignment</a></div>',
            $result);
        $result = create_nav_buttons('report', 1);
        $this->assertEquals('<div class="navbuttons"><a id="tryAgainButton" class="btn btn-primary" href="/mod/digitala/view.php?id=1&amp;d=2&amp;page=1">Try again</a></div>',
            $result);
        // @codingStandardsIgnoreEnd moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test creating new container object.
     */
    public function test_container_html_output_right() {
        $result = start_container('some_step_of_digitala');
        $result .= end_container();
        $this->assertEquals('<div class="some_step_of_digitala digitala-container"><div class="container"><div class="row"></div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
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
     * Test creating new card object.
     */
    public function test_card_template() {
        $result = create_card_template('text');
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body">text</div></div>', $result);
    }

    /**
     * Test creating report view grading helper object.
     */
    public function test_grading_html_output() {
        $result = create_report_grading('fluency', 0, 0);
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Fluency</h5><div class="digitala-chart-container"><canvas id="fluency" data-eval-name="fluency" data-eval-grade="0" data-eval-maxgrade="0" class="report-chart"></canvas></div><h6 class="grade-number">0/0</h6><div class="card-text"><p>This measure reflects the speed, pauses, and hesitations in your speech. Based on the automatic grading, it seems that unfortunately, the machine has not heard this type of performance before and therefore failed to grade your speech. However, do not be discouraged: try again!</p></div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $result = create_report_grading('fluency', 0, 0, 1, 'bad');
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Fluency</h5><div class="digitala-chart-container"><canvas id="fluency" data-eval-name="fluency" data-eval-grade="0" data-eval-maxgrade="0" class="report-chart"></canvas></div><h6 class="grade-number">0/0</h6><div class="card-text"><p>This measure reflects the speed, pauses, and hesitations in your speech. Based on the automatic grading, it seems that unfortunately, the machine has not heard this type of performance before and therefore failed to grade your speech. However, do not be discouraged: try again!</p><p>Teacher\'s grade suggestion: 1</p><p>Comments about grade suggestion: bad</p></div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $result = create_report_grading('fluency', 0, 0, 1, '');
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Fluency</h5><div class="digitala-chart-container"><canvas id="fluency" data-eval-name="fluency" data-eval-grade="0" data-eval-maxgrade="0" class="report-chart"></canvas></div><h6 class="grade-number">0/0</h6><div class="card-text"><p>This measure reflects the speed, pauses, and hesitations in your speech. Based on the automatic grading, it seems that unfortunately, the machine has not heard this type of performance before and therefore failed to grade your speech. However, do not be discouraged: try again!</p><p>Teacher\'s grade suggestion: 1</p></div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $result = create_report_grading('fluency', 0, 0, 0, 'bad');
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Fluency</h5><div class="digitala-chart-container"><canvas id="fluency" data-eval-name="fluency" data-eval-grade="0" data-eval-maxgrade="0" class="report-chart"></canvas></div><h6 class="grade-number">0/0</h6><div class="card-text"><p>This measure reflects the speed, pauses, and hesitations in your speech. Based on the automatic grading, it seems that unfortunately, the machine has not heard this type of performance before and therefore failed to grade your speech. However, do not be discouraged: try again!</p><p>Comments about grade suggestion: bad</p></div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test creating report view holistic helper object.
     */
    public function test_holistic_html_output() {
        $result = create_report_holistic(3);
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Proficiency level</h5><div class="digitala-chart-container"><canvas id="holistic" data-eval-name="holistic" data-eval-grade="3" data-eval-maxgrade="6" class="report-chart"></canvas></div><h6 class="grade-number">B1</h6><div class="card-text"><p>Based on the automatic grading, it seems that your proficiency level is B1.</p><p>You manage everyday situations in the target language. Your pronunciation is intelligible, your vocabulary is fairly large, and you use different kinds of sentences.</p></div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $feedback = new \stdClass();
        $feedback->holistic = 1;
        $feedback->holistic_reason = 'bad';
        $result = create_report_holistic(3, $feedback);
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Proficiency level</h5><div class="digitala-chart-container"><canvas id="holistic" data-eval-name="holistic" data-eval-grade="3" data-eval-maxgrade="6" class="report-chart"></canvas></div><h6 class="grade-number">B1</h6><div class="card-text"><p>Based on the automatic grading, it seems that your proficiency level is B1.</p><p>You manage everyday situations in the target language. Your pronunciation is intelligible, your vocabulary is fairly large, and you use different kinds of sentences.</p><p>Teacher\'s grade suggestion: 1</p><p>Comments about grade suggestion: bad</p></div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $feedback->holistic_reason = '';
        $result = create_report_holistic(3, $feedback);
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Proficiency level</h5><div class="digitala-chart-container"><canvas id="holistic" data-eval-name="holistic" data-eval-grade="3" data-eval-maxgrade="6" class="report-chart"></canvas></div><h6 class="grade-number">B1</h6><div class="card-text"><p>Based on the automatic grading, it seems that your proficiency level is B1.</p><p>You manage everyday situations in the target language. Your pronunciation is intelligible, your vocabulary is fairly large, and you use different kinds of sentences.</p><p>Teacher\'s grade suggestion: 1</p></div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $feedback->holistic = 3;
        $feedback->holistic_reason = 'bad';
        $result = create_report_holistic(3, $feedback);
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Proficiency level</h5><div class="digitala-chart-container"><canvas id="holistic" data-eval-name="holistic" data-eval-grade="3" data-eval-maxgrade="6" class="report-chart"></canvas></div><h6 class="grade-number">B1</h6><div class="card-text"><p>Based on the automatic grading, it seems that your proficiency level is B1.</p><p>You manage everyday situations in the target language. Your pronunciation is intelligible, your vocabulary is fairly large, and you use different kinds of sentences.</p><p>Comments about grade suggestion: bad</p></div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test creating report view information helper object.
     */
    public function test_create_report_waiting() {
        $_SERVER['REQUEST_URI'] = 'toot';
        $result = create_report_waiting();
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Evaluation in progress</h5><div class="card-text"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div><p>Evaluation is in progress, please hold. This could take up to few eternities.</p><a id="nextButton" class="btn btn-primary" href="toot">Press here to check if evaluation is completed.</a></div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test creating report view information helper object.
     */
    public function test_create_report_retry() {
        $result = create_report_retry();
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Evaluation failed</h5><div class="card-text"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div><p>Automated evaluation failed. Evaluation will be runned again in a hour. This could take up to few eternities.</p></div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test creating report view information helper object.
     */
    public function test_information_html_output() {
        global $USER;

        $context = \context_module::instance($this->digitala->cmid);
        $report = new \digitala_report($this->digitala->id, $context->id, 5, $this->digitala->attempttype, $this->digitala->attemptlang, $this->digitala->attemptlimit, 'testinformation', $USER->id); // phpcs:ignore moodle.Files.LineLength.MaxExceeded

        $result = create_report_information($report);
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">More information</h5><div class="card-text">testinformation</div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test creating tab creation helper.
     */
    public function test_create_tabs() {
        $result = create_tabs(array());
        $this->assertEquals('<nav><div class="nav nav-tabs digitala-tabs" id="nav-tab" role="tablist"></div></nav><div class="tab-content" id="nav-tabContent"></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test creating report view tab creation helper.
     */
    public function test_tabs_html_output() {
        $result = create_report_tabs('', '', '');
        $this->assertEquals('<nav><div class="nav nav-tabs digitala-tabs" id="nav-tab" role="tablist"><button class="nav-link ml-2 active" id="report-grades-tab" data-toggle="tab" href="#report-grades" role="tab" aria-controls="report-grades" aria-selected="true">Analytic grading</button><button class="nav-link ml-2" id="report-holistic-tab" data-toggle="tab" href="#report-holistic" role="tab" aria-controls="report-holistic" aria-selected="false">Proficiency level</button><button class="nav-link ml-2" id="report-information-tab" data-toggle="tab" href="#report-information" role="tab" aria-controls="report-information" aria-selected="false">More information</button></div></nav><div class="tab-content" id="nav-tabContent"><div class="tab-pane fade show active" id="report-grades" role="tabpanel" aria-labelledby="report-grades-tab"></div><div class="tab-pane fade" id="report-holistic" role="tabpanel" aria-labelledby="report-holistic-tab"></div><div class="tab-pane fade" id="report-information" role="tabpanel" aria-labelledby="report-information-tab"></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test creating report view specific transcription object.
     */
    public function test_transcription_html_output() {
        $testtranscription = 'Lorem ipsum test text';
        $result = create_report_transcription($testtranscription);
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">A transcript of your speech sample</h5><div class="card-text scrollbox200">Lorem ipsum test text</div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test creating new assignment object.
     */
    public function test_create_button() {
        $result = create_button('buttonId', 'buttonClass', 'buttonText');
        $this->assertEquals('<button id="buttonId" class="buttonClass">buttonText</button>', $result);
    }

    /**
     * Test creating create assignment.
     */
    public function test_create_assignment() {
        $result = create_assignment('testassignment');
        $this->assertEquals('<div class="card-text scrollbox200">testassignment</div>', $result);
    }

    /**
     * Test creating create resource.
     */
    public function test_create_resource() {
        global $USER;

        $_SERVER['REQUEST_URI'] = '';
        $context = \context_module::instance($this->digitala->cmid);
        $assignment = new \digitala_assignment($this->digitala->id, $context->id, $USER->id, 1, $this->digitala->assignment, 'testresource', $this->digitala->attempttype, $this->digitala->attemptlang); // phpcs:ignore moodle.Files.LineLength.MaxExceeded

        $result = create_resource($assignment);
        $this->assertEquals('<div class="card-text scrollbox400">testresource</div>', $result);
    }

    /**
     * Test saving answer recording.
     */
    public function test_save_answerrecording() {
        global $USER;

        $_SERVER['REQUEST_URI'] = '';
        $context = \context_module::instance($this->digitala->cmid);
        $assignment = new \digitala_assignment($this->digitala->id, $context->id, $USER->id, 1, $this->digitala->assignment, $this->digitala->resources, $this->digitala->attempttype, $this->digitala->attemptlang);  // phpcs:ignore moodle.Files.LineLength.MaxExceeded

        $fileinfo = array(
            'contextid' => \context_user::instance($USER->id)->id,
            'component' => 'user',
            'filearea' => 'draft',
            'itemid' => 0,
            'filepath' => '/',
            'filename' => 'testing.wav',
            'userid' => $USER->id,
        );
        $fs = get_file_storage();
        $fs->create_file_from_string($fileinfo, 'I\'m an audio file, cool right!?');
        $file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],
                          $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']);

        $formdata = new \stdClass();
        $formdata->audiostring = '{"url":"http:\/\/localhost:8000\/draftfile.php\/5\/user\/draft\/0\/testing.wav","id": 0,"file":"testing.wav"}'; // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $formdata->recordinglength = 60;
        $result = save_answerrecording($formdata, $assignment);
        $this->assertEquals('url address not set', $result);
    }

    /**
     * Test creating answerrecording form without form data.
     */
    public function test_create_answerrecording_form() {
        global $USER;

        $_SERVER['REQUEST_URI'] = '/mod/digitala/view.php?id=4&d=5&page=1';
        $context = \context_module::instance($this->digitala->cmid);
        $assignment = new \digitala_assignment($this->digitala->id, $context->id, $USER->id, 4, $this->digitala->assignment, $this->digitala->resources, $this->digitala->attempttype, $this->digitala->attemptlang); // phpcs:ignore moodle.Files.LineLength.MaxExceeded

        $result = create_answerrecording_form($assignment);
        if (PHPUnitVersion::series() < 9) {
            $assertregexp = function($a, $b) {
                return $this->assertRegExp($a, $b);
            };
        } else {
            $assertregexp = function($a, $b) {
                return $this->assertMatchesRegularExpression($a, $b);
            };
        }
        $assertregexp('/form id="answerrecording"/', $result);
        $assertregexp('/id=4/', $result);
        $assertregexp('/d=5/', $result);
        $assertregexp('/page=1/', $result);
        $assertregexp('/input name="audiostring" type="hidden" value="answerrecording_form"/', $result);
    }

    /**
     * Test saving answerrecording form with form data.
     */
    public function test_save_answerrecording_form_with_data() {
        global $USER;
        \answerrecording_form::mock_submit(array('audiostring' => '{"url":"http:\/\/localhost:8000\/draftfile.php\/5\/user\/draft\/0\/testing.wav","id": 0,"file":"testing.wav"}', 'recordinglength' => 10), null, 'post', 'answerrecording_form'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $_SERVER['REQUEST_URI'] = '';
        $context = \context_module::instance($this->digitala->cmid);
        $assignment = new \digitala_assignment($this->digitala->id, $context->id, $USER->id, 1, $this->digitala->assignment, $this->digitala->resources, $this->digitala->attempttype, $this->digitala->attemptlang); // phpcs:ignore moodle.Files.LineLength.MaxExceeded

        $result = save_answerrecording_form($assignment);
        $this->assertEquals('<p id="submitErrors"></p>', $result);
    }

    /**
     * Test saving answerrecording form without form data.
     */
    public function test_save_answerrecording_form_wo_data() {
        global $USER;
        $_SERVER['REQUEST_URI'] = '/mod/digitala/view.php?id=1&page=1';
        $context = \context_module::instance($this->digitala->cmid);
        $assignment = new \digitala_assignment($this->digitala->id, $context->id, $USER->id, 1, $this->digitala->assignment, $this->digitala->resources, $this->digitala->attempttype, $this->digitala->attemptlang); // phpcs:ignore moodle.Files.LineLength.MaxExceeded

        $result = save_answerrecording_form($assignment);
        $this->assertEquals('<p id="submitErrors"></p>', $result);
    }

    /**
     * Test validating grading number.
     */
    public function test_validate_grading() {
        $this->assertEquals(1, validate_grading(1));
        $this->assertEquals(1, validate_grading(1, 4));
        $this->assertEquals(0, validate_grading(-1, 1));
        $this->assertEquals(0, validate_grading(5, 4));
        $this->assertEquals(0.57, validate_grading(0.57, 1));
        $this->assertEquals(0.58, validate_grading(0.576, 1));
    }

    /**
     * Test creating an attempt to database.
     */
    public function test_create_waiting_attempt() {
        global $DB;

        $assignment = new \stdClass();
        $assignment->instanceid = 1;
        $assignment->userid = 1;

        create_waiting_attempt($assignment, 'filename', 60);

        $result = $DB->record_exists('digitala_attempts',
                                     array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals(true, $result);
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals('waiting', $record->status);
        $this->assertEquals('filename', $record->file);
        $this->assertEquals(60, $record->recordinglength);

        create_waiting_attempt($assignment, 'filename', 60);
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals(2, $record->attemptnumber);
    }

    /**
     * Test saving attempt status to database.
     */
    public function test_set_attempt_status() {
        global $DB;

        $assignment = new \stdClass();
        $assignment->instanceid = 1;
        $assignment->userid = 1;

        create_waiting_attempt($assignment, 'filename', 60);
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));

        set_attempt_status($record, 'retry');
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals('retry', $record->status);
    }

    /**
     * Test saving failed attempt to database.
     */
    public function test_save_failed_attempt() {
        global $DB;

        $assignment = new \stdClass();
        $assignment->instanceid = 1;
        $assignment->userid = 1;
        $assignment->attempttype = 'freeform';

        create_waiting_attempt($assignment, 'filename', 60);
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));

        save_failed_attempt($record, $assignment);
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals('failed', $record->status);
        $this->assertEquals(0, $record->taskcompletion);
        $this->assertEquals(0, $record->fluency);
        $this->assertEquals(0, $record->pronunciation);
        $this->assertEquals(0, $record->lexicogrammatical);
        $this->assertEquals(0, $record->holistic);

        $assignment->instanceid = 2;
        $assignment->userid = 2;
        $assignment->attempttype = 'readaloud';
        create_waiting_attempt($assignment, 'filename', 60);
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals('waiting', $record->status);

        save_failed_attempt($record, $assignment);
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals('failed', $record->status);
        $this->assertEquals(0, $record->fluency);
        $this->assertEquals(0, $record->pronunciation);
    }

    /**
     * Test saving a readaloud attempt to database.
     */
    public function test_save_attempt_freeform() {
        global $DB;

        $assignment = new \stdClass();
        $assignment->instanceid = 1;
        $assignment->userid = 0;
        $assignment->attempttype = 'freeform';
        $evaluation = new \stdClass();
        $evaluation->transcript = 'transcript';
        $evaluation->task_completion = 2;
        $evaluation->fluency = new \stdClass();
        $evaluation->fluency->score = 1;
        $evaluation->fluency->flu_features = array('invalid' => 1);
        $evaluation->pronunciation = new \stdClass();
        $evaluation->pronunciation->score = 1;
        $evaluation->pronunciation->pron_features = array('invalid' => 1);
        $evaluation->lexicogrammatical = new \stdClass();
        $evaluation->lexicogrammatical->score = 3;
        $evaluation->lexicogrammatical->lexgram_features = array('invalid' => 1);
        $evaluation->holistic = 4;

        create_waiting_attempt($assignment, 'filename', 60);
        save_attempt($assignment, $evaluation);

        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals($evaluation->transcript, $record->transcript);
        $this->assertEquals('evaluated', $record->status);
        $this->assertEquals($evaluation->holistic, $record->holistic);
        $this->assertEquals('{"invalid":1}', $record->fluency_features);

        $evaluation->task_completion = -1.1;
        $evaluation->fluency->score = -1.1;
        $evaluation->pronunciation->score = -1.1;
        $evaluation->lexicogrammatical->score = -1.1;
        $evaluation->holistic = -1.1;

        save_attempt($assignment, $evaluation);
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals(0, $record->taskcompletion);
        $this->assertEquals(0, $record->fluency);
        $this->assertEquals(0, $record->pronunciation);
        $this->assertEquals(0, $record->lexicogrammatical);
        $this->assertEquals(0, $record->holistic);

        $evaluation->task_completion = 10.666;
        $evaluation->fluency->score = 10.666;
        $evaluation->pronunciation->score = 10.666;
        $evaluation->lexicogrammatical->score = 10.666;
        $evaluation->holistic = 10.666;

        save_attempt($assignment, $evaluation);
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals(0, $record->taskcompletion);
        $this->assertEquals(0, $record->fluency);
        $this->assertEquals(0, $record->pronunciation);
        $this->assertEquals(0, $record->lexicogrammatical);
        $this->assertEquals(0, $record->holistic);
    }

    /**
     * Test saving a freeform attempt to database.
     */
    public function test_save_attempt_readaloud() {
        global $DB;

        $assignment = new \stdClass();
        $assignment->instanceid = 1;
        $assignment->userid = 1;
        $assignment->attempttype = 'readaloud';
        $evaluation = new \stdClass();
        $evaluation->transcript = '';
        $evaluation->annotated_response = '';
        $evaluation->fluency = new \stdClass();
        $evaluation->fluency->score = 2;
        $evaluation->fluency->flu_features = array('invalid' => 1);
        $evaluation->pronunciation = new \stdClass();
        $evaluation->pronunciation->score = 1;
        $evaluation->pronunciation->pron_features = array('invalid' => 1);

        create_waiting_attempt($assignment, 'filename', 60);
        save_attempt($assignment, $evaluation);

        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals(2, $record->fluency);
        $this->assertEquals(1, $record->pronunciation);

        $evaluation->pronunciation->score = 5;
        save_attempt($assignment, $evaluation);
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals(0, $record->pronunciation);

        $evaluation->pronunciation->score = -1;
        save_attempt($assignment, $evaluation);
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals(0, $record->pronunciation);
    }

    /**
     * Test reading an attempt from database.
     */
    public function test_get_attempt() {
        global $DB, $USER;

        $result = get_attempt(2, $USER->id);
        $this->assertEquals(null, $result);

        $timenow = time();
        $attempt = new \stdClass();
        $attempt->digitala = 2;
        $attempt->userid = $USER->id;
        $attempt->file = 'filename';
        $attempt->fluency = 1;
        $attempt->pronunciation = 1;
        $attempt->timecreated = $timenow;
        $attempt->timemodified = $timenow;
        $DB->insert_record('digitala_attempts', $attempt);

        $result = get_attempt(2, $USER->id);
        $this->assertEquals($attempt->fluency, $result->fluency);
    }

// @codingStandardsIgnoreStart moodle.Files.LineLength.MaxExceeded
    public function test_create_microphone() {
        $result = create_microphone();
        $this->assertEquals('<p id="recordTimer"><span id="recordingLength">00:00</span></p><span id="startIcon" style="display: none;"><svg width="16" height="16" fill="currentColor" class="bi bi-play-fill"><path d="m12 9-7 3H4V4h1l7 3a1 1 0 0 1 0 2z" /></svg></span><span id="stopIcon" style="display: none;"><svg width="16" height="16" fill="currentColor" class="bi bi-stop-fill"><path d="M5 4h6a2 2 0 0 1 2 1v6a2 2 0 0 1-2 2H5a2 2 0 0 1-1-2V5a2 2 0 0 1 1-1z" /></svg></span><button id="record" class="btn btn-primary record-btn">Record <svg width="16" height="16" fill="currentColor" class="bi bi-play-fill"><path d="m12 9-7 3H4V4h1l7 3a1 1 0 0 1 0 2z" /></svg></button><button id="listen" class="btn btn-primary listen-btn" disabled="true">Listen to your recording <svg width="16" height="16" fill="currentColor" class="bi bi-volume-down-fill"><path d="M9 4a.5.5 0 0 0-.8-.4L5.8 5.5H3.5A.5.5 0 0 0 3 6v4a.5.5 0 0 0 .5.5h2.3l2.4 1.9A.5.5 0 0 0 9 12V4zm3 4a4.5 4.5 0 0 1-1.3 3.2l-.7-.7A3.5 3.5 0 0 0 11 8a3.5 3.5 0 0 0-1-2.5l.7-.7A4.5 4.5 0 0 1 12 8z" /></svg></button>', $result);
    }

    /**
     * Test creating microphone icon.
     */
    public function test_create_microphone_icon() {
        $result = create_microphone_icon();
        $this->assertEquals('<div id="microphoneIconBox"></div><svg width="150" height="150" id="microphoneIcon"><defs><linearGradient id="b"><stop offset="0" stop-color="#fff" /><stop offset="1" stop-color="#fff" stop-opacity="0" /></linearGradient><linearGradient xlink:href="#a" id="d" x1="119.4" x2="164" y1="133" y2="133" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1.70194 0 0 1.34299 -166.2 -206.2)" /><linearGradient id="a"><stop offset="0" /></linearGradient><linearGradient xlink:href="#b" id="c" x1="12.5" x2="12.3" y1="20.8" y2="-3.5" gradientUnits="userSpaceOnUse" gradientTransform="matrix(2.25 0 0 2.25 47.3 -77.3)" /></defs><g transform="translate(0 126)"><eclipse cx="74.3" cy="-50.2" fill="url(#c)" rx="26.9" ry="27" /><rect width="57.8" height="83.6" x="46" y="-108.7" rx="27.5" ry="23.3" /><path fill="none" stroke="url(#d)" stroke-width="7.1" d="M40.2-38.8c10.9 28.2 60.7 28.8 69.5-.8" /><path fill="none" stroke="#000" stroke-width="10" d="M75.9-19.8 76.1.6" /><path fill="none" stroke="#000" stroke-width="8.5" d="M54.1 2.5C68 .7 82.6.5 98.4 2.5" /><path fill="none" stroke="#fff" stroke-linecap="round" stroke-width="5.1" d="m45.8-83.3 27-.2M45.6-70l27-.1" /><path fill="none" stroke="#fff" stroke-dasharray="30.4 5.1" stroke-linecap="round" stroke-width="5.1" d="m45.6-56.2 27-.2" /></g></svg>', $result);
    }


    /**
     * Test creating a fixed box for feedback.
     */
    public function test_create_fixed_box() {
        $result = create_fixed_box();
        $this->assertEquals('<div class="feedbackcontainer" data-toggle="collapse" data-target="#feedbacksite">Give feedback</div><button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#feedbacksite" id="collapser"><svg width="16" height="16" fill="currentColor" id="feedback" class="bi bi-chat-text-fill"><path d="M16 8c0 3.9-3.6 7-8 7a9 9 0 0 1-2.3-.3c-.6.3-2 .9-4.2 1.2-.2 0-.4-.1-.3-.3.4-.9.7-2 .8-3A6.5 6.5 0 0 1 0 8c0-3.9 3.6-7 8-7s8 3.1 8 7zM4.5 5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4z" /></svg></button><div class="collapse" id="feedbacksite"></div><iframe id="feedbacksite" class="collapse" src="https://link.webropolsurveys.com/Participation/Public/2c1ccd52-6e23-436e-af51-f8f8c259ffbb?displayId=Fin2500048"></iframe>', $result);

    }

    /**
     * Tests creating chart canvas.
     */
    public function test_create_chart() {
        $result = create_chart('nimi', '2.00', '4');
        $this->assertEquals('<div class="digitala-chart-container"><canvas id="nimi" data-eval-name="nimi" data-eval-grade="2.00" data-eval-maxgrade="4" class="report-chart"></canvas></div>',$result);
    }

    /**
     * Tests getting remaining number of attempts.
     */
    public function test_get_remaining_number() {
        $assignment = new \stdClass();
        $assignment->instanceid = 1;
        $assignment->userid = 1;
        $assignment->attemptlimit = 0;
        $assignment->attempttype = 'readaloud';

        $result = get_remaining_number($assignment, $assignment->userid);
        $this->assertEquals(null, $result);

        $assignment->attemptlimit = 1;
        $result = get_remaining_number($assignment, $assignment->userid);
        $this->assertEquals(1, $result);

        $evaluation = new \stdClass();
        $evaluation->transcript = '';
        $evaluation->annotated_response = '';
        $evaluation->fluency = new \stdClass();
        $evaluation->fluency->score = 1;
        $evaluation->fluency->flu_features = array('invalid' => 1);
        $evaluation->pronunciation = new \stdClass();
        $evaluation->pronunciation->score = 1;
        $evaluation->pronunciation->pron_features = array('invalid' => 1);

        create_waiting_attempt($assignment, 'filename', 60);
        save_attempt($assignment, $evaluation);
        $assignment->attemptlimit = 3;
        $result = get_remaining_number($assignment, $assignment->userid);
        $this->assertEquals(2, $result);
    }

    /**
     * Tests creating attempt number.
     */
    public function test_create_attempt_number() {
        $assignment = new \stdClass();
        $assignment->instanceid = 1;
        $assignment->userid = 1;
        $assignment->attemptlimit = 0;
        $assignment->attempttype = 'readaloud';

        $result = create_attempt_number($assignment, $assignment->userid);
        $this->assertEquals('There is no limit set for the number of attempts on this assignment.', $result);

        $assignment->attemptlimit = 1;
        $result = create_attempt_number($assignment, $assignment->userid);
        $this->assertEquals('Number of attempts remaining: 1', $result);

        $evaluation = new \stdClass();
        $evaluation->transcript = '';
        $evaluation->annotated_response = '';
        $evaluation->fluency = new \stdClass();
        $evaluation->fluency->score = 1;
        $evaluation->fluency->flu_features = array('invalid' => 1);
        $evaluation->pronunciation = new \stdClass();
        $evaluation->pronunciation->score = 1;
        $evaluation->pronunciation->pron_features = array('invalid' => 1);

        create_waiting_attempt($assignment, 'filename', 60);
        save_attempt($assignment, $evaluation);
        $assignment->attemptlimit = 3;
        $result = create_attempt_number($assignment, $assignment->userid);
        $this->assertEquals('Number of attempts remaining: 2', $result);
    }

    /**
     * Tests creating modal template.
     */
    public function test_create_modal() {
        $result = create_modal('newModal', 'Title', 'Body',
            '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>');
        $this->assertEquals('<div class="modal" id="newModal" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Title</h5><button class="close" data-dismiss="modal" aria-label="close-cross"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><p>Body</p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div></div></div></div>', $result);
    }

    /**
     * Tests creating attempt modal.
     */
    public function test_create_attempt_modal() {
        global $USER;

        $assignment = new \stdClass();
        $assignment->instanceid = 1;
        $assignment->userid = 1;
        $assignment->attemptlimit = 2;
        $assignment->attempttype = 'readaloud';

        $evaluation = new \stdClass();
        $evaluation->transcript = '';
        $evaluation->annotated_response = '';
        $evaluation->fluency = new \stdClass();
        $evaluation->fluency->score = 1;
        $evaluation->fluency->flu_features = array('invalid' => 1);
        $evaluation->pronunciation = new \stdClass();
        $evaluation->pronunciation->score = 1;
        $evaluation->pronunciation->pron_features = array('invalid' => 1);

        create_waiting_attempt($assignment, 'filename', 60);
        save_attempt($assignment, $evaluation);

        \answerrecording_form::mock_submit(array('audiostring' => '{"url":"http:\/\/localhost:8000\/draftfile.php\/5\/user\/draft\/0\/testing.wav","id": 0,"file":"testing.wav"}'), null, 'post', 'answerrecording_form');
        $_SERVER['REQUEST_URI'] = '/mod/digitala/view.php?id=1&page=1';
        $context = \context_module::instance($this->digitala->cmid);
        $assignment = new \digitala_assignment($this->digitala->id, $context->id, $USER->id, 1, $this->digitala->assignment, $this->digitala->resources, $this->digitala->attempttype, $this->digitala->attemptlang);

        $result = create_attempt_modal($assignment);
        $this->assertStringStartsWith('<button id="submitModalButton" type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#attemptModal" style="display: none">Submit answer</button><div class="modal" id="attemptModal" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Are you sure you want to submit this attempt?</h5><button class="close" data-dismiss="modal" aria-label="close-cross"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><p>You still have 1 attempts remaining on this assignment.</p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>', $result);
        $this->assertStringEndsWith('</form></div></div></div></div>', $result);

        $assignment->attemptlimit = 0;

        $result = create_attempt_modal($assignment);
        $this->assertStringStartsWith('<button id="submitModalButton" type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#attemptModal" style="display: none">Submit answer</button><div class="modal" id="attemptModal" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Are you sure you want to submit this attempt?</h5><button class="close" data-dismiss="modal" aria-label="close-cross"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><p>There is no limit set for the number of attempts on this assignment.</p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>', $result);
        $this->assertStringEndsWith('</form></div></div></div></div>', $result);
    }
// @codingStandardsIgnoreEnd moodle.Files.LineLength.MaxExceeded

    /**
     * Tests creating the results url.
     */
    public function test_results_url() {
        $generatedurl = results_url(1, 1, 1);
        $this->assertEquals($generatedurl, 'https://www.example.com/moodle/mod/digitala/report.php?id=1&amp;mode=1&amp;student=1');
    }

    /**
     * Tests getting all attempts.
     */
    public function test_get_all_attempts() {
        global $DB;

        $assignment = new \stdClass();
        $assignment->instanceid = 1;
        $assignment->userid = 1;
        $assignment->attempttype = 'readaloud';
        $evaluation = new \stdClass();
        $evaluation->transcript = '';
        $evaluation->annotated_response = '';
        $evaluation->fluency = new \stdClass();
        $evaluation->fluency->score = 1;
        $evaluation->fluency->flu_features = array('invalid' => 1);
        $evaluation->pronunciation = new \stdClass();
        $evaluation->pronunciation->score = 1;
        $evaluation->pronunciation->pron_features = array('invalid' => 1);
        $recordinglength = 5;

        create_waiting_attempt($assignment, 'filename1', $recordinglength);
        save_attempt($assignment, $evaluation);

        $assignment->instanceid = 1;
        $assignment->userid = 2;
        $evaluation->fluency = new \stdClass();
        $evaluation->fluency->score = 2;
        $evaluation->fluency->flu_features = array('invalid' => 1);
        $evaluation->pronunciation = new \stdClass();
        $evaluation->pronunciation->score = 2;
        $evaluation->pronunciation->pron_features = array('invalid' => 1);
        $recordinglength = 5;

        create_waiting_attempt($assignment, 'filename2', $recordinglength);
        save_attempt($assignment, $evaluation);

        $records = $DB->get_records('digitala_attempts',
                                  array('digitala' => $assignment->instanceid));
        $this->assertEquals(2, count($records));
    }

    /**
     * Tests getting user and compares their ids.
     */
    public function test_get_user() {
        global $USER;
        $result = get_user(2);
        $this->assertEquals($USER->id, $result->id);
    }

    /**
     * Tests creating result row.
     */
    public function test_create_result_row() {
        global $DB, $USER;

        $assignment = new \stdClass();
        $assignment->instanceid = 1;
        $assignment->userid = 2;
        $assignment->attempttype = 'readaloud';
        $evaluation = new \stdClass();
        $evaluation->transcript = '';
        $evaluation->annotated_response = '';
        $evaluation->fluency = new \stdClass();
        $evaluation->fluency->score = 1;
        $evaluation->fluency->flu_features = array('invalid' => 1);
        $evaluation->pronunciation = new \stdClass();
        $evaluation->pronunciation->score = 1;
        $evaluation->pronunciation->pron_features = array('invalid' => 1);
        $recordinglength = 5;

        create_waiting_attempt($assignment, 'filename', $recordinglength);
        save_attempt($assignment, $evaluation);
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));

        $result = create_result_row($record, $this->digitala->id, $USER);
        $this->assertEquals('Admin User', $result[0]);
        $this->assertEquals(1, $result[1]);
        $this->assertEquals('00:05', $result[2]);
        $this->assertEquals(1, $result[3]);
        $this->assertEquals('Evaluated', $result[4]);
        $this->assertStringContainsString('>See report</a>', $result[5]);
    }

    /**
     * Tests convertsecondstostring for making time strings from seconds
     */
    public function test_convertsecondstostring() {
        $result = convertsecondstostring(5);
        $this->assertEquals('00:05', $result);
        $result = convertsecondstostring(10);
        $this->assertEquals('00:10', $result);
        $result = convertsecondstostring(59);
        $this->assertEquals('00:59', $result);
        $result = convertsecondstostring(60);
        $this->assertEquals('01:00', $result);
        $result = convertsecondstostring(70);
        $this->assertEquals('01:10', $result);
        $result = convertsecondstostring(119);
        $this->assertEquals('01:59', $result);
        $result = convertsecondstostring(120);
        $this->assertEquals('02:00', $result);
        $result = convertsecondstostring(599);
        $this->assertEquals('09:59', $result);
        $result = convertsecondstostring(600);
        $this->assertEquals('10:00', $result);
        $result = convertsecondstostring(3599);
        $this->assertEquals('59:59', $result);
        $result = convertsecondstostring(3600);
        $this->assertEquals('01:00:00', $result);
        $result = convertsecondstostring(3610);
        $this->assertEquals('01:00:10', $result);
        $result = convertsecondstostring(3670);
        $this->assertEquals('01:01:10', $result);
        $result = convertsecondstostring(4270);
        $this->assertEquals('01:11:10', $result);
        $result = convertsecondstostring(35999);
        $this->assertEquals('09:59:59', $result);
        $result = convertsecondstostring(36000);
        $this->assertEquals('10:00:00', $result);
    }

    public function test_save_report_feedback_readaloud() {
        global $DB;

        $fromform = new \stdClass();
        $fromform->fluency = 1;
        $fromform->fluencyreason = "I'm a fluency reason, did you know!?";
        $fromform->pronunciation = 2;
        $fromform->pronunciationreason = "I'm a pronunciation reason, did you know!?";

        $oldattempt = new \stdClass();
        $oldattempt->id = 5;
        $oldattempt->fluency = 3;
        $oldattempt->pronunciation = 0;
        $oldattempt->digitala = 2;

        save_report_feedback('readaloud', $fromform, $oldattempt);

        $result = $DB->record_exists('digitala_report_feedback',
                                     array('attempt' => 5));
        $this->assertEquals(true, $result);

        $feedback = $DB->get_record('digitala_report_feedback',
                                    array('attempt' => 5));
        $this->assertEquals(3, $feedback->old_fluency);
        $this->assertEquals(0, $feedback->old_pronunciation);
        $this->assertEquals(1, $feedback->fluency);
        $this->assertEquals(2, $feedback->pronunciation);
        $this->assertEquals("I'm a fluency reason, did you know!?", $feedback->fluency_reason);
        $this->assertEquals("I'm a pronunciation reason, did you know!?", $feedback->pronunciation_reason);
        $this->assertEquals(false, isset($feedback->old_holistic));
        $this->assertEquals(false, isset($feedback->taskcompletion));
        $this->assertEquals(false, isset($feedback->lexicogrammatical_reason));

    }

    public function test_save_report_feedback_freeform() {
        global $DB;

        $fromform = new \stdClass();
        $fromform->taskcompletion = 2;
        $fromform->taskcompletionreason = "I'm a taskcompletion reason, did you know!?";
        $fromform->fluency = 1;
        $fromform->fluencyreason = "I'm a fluency reason, did you know!?";
        $fromform->pronunciation = 2;
        $fromform->pronunciationreason = "I'm a pronunciation reason, did you know!?";
        $fromform->lexicogrammatical = 3;
        $fromform->lexicogrammaticalreason = "I'm a lexicogrammatical reason, did you know!?";
        $fromform->holistic = 1;
        $fromform->holisticreason = "I'm a holistic reason, did you know!?";

        $oldattempt = new \stdClass();
        $oldattempt->id = 6;
        $oldattempt->taskcompletion = 1;
        $oldattempt->fluency = 3;
        $oldattempt->pronunciation = 0;
        $oldattempt->lexicogrammatical = 2;
        $oldattempt->holistic = 3;
        $oldattempt->digitala = 2;

        save_report_feedback('freeform', $fromform, $oldattempt);

        $result = $DB->record_exists('digitala_report_feedback',
                                     array('attempt' => 6));
        $this->assertEquals(true, $result);

        $feedback = $DB->get_record('digitala_report_feedback',
                                    array('attempt' => 6));
        $this->assertEquals(1, $feedback->old_taskcompletion);
        $this->assertEquals(3, $feedback->old_fluency);
        $this->assertEquals(0, $feedback->old_pronunciation);
        $this->assertEquals(2, $feedback->old_lexicogrammatical);
        $this->assertEquals(3, $feedback->old_holistic);
        $this->assertEquals(2, $feedback->taskcompletion);
        $this->assertEquals(1, $feedback->fluency);
        $this->assertEquals(2, $feedback->pronunciation);
        $this->assertEquals(3, $feedback->lexicogrammatical);
        $this->assertEquals(1, $feedback->holistic);
        $this->assertEquals("I'm a taskcompletion reason, did you know!?", $feedback->taskcompletion_reason);
        $this->assertEquals("I'm a fluency reason, did you know!?", $feedback->fluency_reason);
        $this->assertEquals("I'm a pronunciation reason, did you know!?", $feedback->pronunciation_reason);
        $this->assertEquals("I'm a lexicogrammatical reason, did you know!?", $feedback->lexicogrammatical_reason);
        $this->assertEquals("I'm a holistic reason, did you know!?", $feedback->holistic_reason);
    }

    /**
     * Tests fetching latest teacher feedback from batabase.
     */
    public function test_get_feedback() {
        global $DB;

        $fromform = new \stdClass();
        $fromform->taskcompletion = 2;
        $fromform->taskcompletionreason = "I'm a taskcompletion reason, did you know!?";
        $fromform->fluency = 1;
        $fromform->fluencyreason = "I'm a fluency reason, did you know!?";
        $fromform->pronunciation = 2;
        $fromform->pronunciationreason = "I'm a pronunciation reason, did you know!?";
        $fromform->lexicogrammatical = 3;
        $fromform->lexicogrammaticalreason = "I'm a lexicogrammatical reason, did you know!?";
        $fromform->holistic = 1;
        $fromform->holisticreason = "I'm a holistic reason, did you know!?";

        $oldattempt = new \stdClass();
        $oldattempt->id = 6;
        $oldattempt->taskcompletion = 1;
        $oldattempt->fluency = 3;
        $oldattempt->pronunciation = 0;
        $oldattempt->lexicogrammatical = 2;
        $oldattempt->holistic = 3;
        $oldattempt->digitala = 2;

        $fromform2 = new \stdClass();
        $fromform2->taskcompletion = 3;
        $fromform2->taskcompletionreason = "I should be found in test";
        $fromform2->fluency = 2;
        $fromform2->fluencyreason = "I should be found in test";
        $fromform2->pronunciation = 3;
        $fromform2->pronunciationreason = "I should be found in test";
        $fromform2->lexicogrammatical = 2;
        $fromform2->lexicogrammaticalreason = "I should be found in test";
        $fromform2->holistic = 6;
        $fromform2->holisticreason = "I should be found in test";

        $result = get_feedback($oldattempt);
        $this->assertEquals(null, $result);

        save_report_feedback('freeform', $fromform, $oldattempt);
        save_report_feedback('freeform', $fromform, $oldattempt);
        save_report_feedback('freeform', $fromform2, $oldattempt);

        $result = get_feedback($oldattempt);
        $this->assertEquals(1, $result->old_taskcompletion);
        $this->assertEquals(3, $result->old_fluency);
        $this->assertEquals(0, $result->old_pronunciation);
        $this->assertEquals(2, $result->old_lexicogrammatical);
        $this->assertEquals(3, $result->old_holistic);
        $this->assertEquals(3, $result->taskcompletion);
        $this->assertEquals(2, $result->fluency);
        $this->assertEquals(3, $result->pronunciation);
        $this->assertEquals(2, $result->lexicogrammatical);
        $this->assertEquals(6, $result->holistic);
        $this->assertEquals("I should be found in test", $result->taskcompletion_reason);
    }

    public function test_create_short_assignment_tabs() {
        $result = create_short_assignment_tabs('', '');
        $this->assertEquals('<nav><div class="nav nav-tabs digitala-tabs" id="nav-tab" role="tablist"><button class="nav-link ml-2 active" id="assignment-assignment-tab" data-toggle="tab" href="#assignment-assignment" role="tab" aria-controls="assignment-assignment" aria-selected="true">Assignment</button><button class="nav-link ml-2" id="assignment-resources-tab" data-toggle="tab" href="#assignment-resources" role="tab" aria-controls="assignment-resources" aria-selected="false">Material</button></div></nav><div class="tab-content" id="nav-tabContent"><div class="tab-pane fade show active" id="assignment-assignment" role="tabpanel" aria-labelledby="assignment-assignment-tab"></div><div class="tab-pane fade" id="assignment-resources" role="tabpanel" aria-labelledby="assignment-resources-tab"></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    public function test_create_transcript_toggle() {
        $result = create_transcript_toggle('transcript', 'feedback');
        $this->assertEquals('<nav><div class="nav nav-tabs digitala-tabs" id="nav-tab" role="tablist"><button class="nav-link ml-2 active" id="readaloud-transcript-tab" data-toggle="tab" href="#readaloud-transcript" role="tab" aria-controls="readaloud-transcript" aria-selected="true">Plain text</button><button class="nav-link ml-2" id="readaloud-feedback-tab" data-toggle="tab" href="#readaloud-feedback" role="tab" aria-controls="readaloud-feedback" aria-selected="false">Show corrections</button></div></nav><div class="tab-content" id="nav-tabContent"><div class="tab-pane fade show active" id="readaloud-transcript" role="tabpanel" aria-labelledby="readaloud-transcript-tab"><div class="card row digitala-card"><div class="card-body"><h5 class="card-title">A transcript of your speech sample</h5><div class="card-text scrollbox200">transcript</div></div></div></div><div class="tab-pane fade" id="readaloud-feedback" role="tabpanel" aria-labelledby="readaloud-feedback-tab"><div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Transcript feedback</h5><div class="card-text scrollbox200">feedback</div></div></div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Tests creating delete attempt.
     */
    public function delete_attempt() {
        global $DB;

        $assignment = new \stdClass();
        $assignment->instanceid = 1;
        $assignment->userid = 1;
        $evaluation = new \stdClass();
        $evaluation->annotated_response = '';
        $evaluation->fluency = 1;
        $evaluation->pronunciation = 1;
        $recordinglength = 5;

        create_waiting_attempt($assignment, 'filename1', $recordinglength);
        delete_attempt($assignment->instanceid, $assignment->userid);

        $records = $DB->get_records('digitala_attempts',
                        array('digitala' => $assignment->instanceid));
        $this->assertEquals(0, count($records));
    }

    /**
     * Tests creating delete all attempts.
     */
    public function delete_all_attempts() {
        global $DB;

        $assignment = new \stdClass();
        $assignment->instanceid = 1;
        $assignment->userid = 1;
        $evaluation = new \stdClass();
        $evaluation->annotated_response = '';
        $evaluation->fluency = 1;
        $evaluation->pronunciation = 1;
        $recordinglength = 5;

        create_waiting_attempt($assignment, 'filename1', $recordinglength);
        save_attempt($assignment, $evaluation);

        $assignment = new \stdClass();
        $assignment->instanceid = 1;
        $assignment->userid = 2;
        $evaluation = new \stdClass();
        $evaluation->annotated_response = '';
        $evaluation->fluency = 2;
        $evaluation->pronunciation = 2;
        $recordinglength = 5;

        create_waiting_attempt($assignment, 'filename2', $recordinglength);
        save_attempt($assignment, $evaluation);

        delete_all_attempts($assignment->instanceid);

        $records = $DB->get_records('digitala_attempts',
                        array('digitala' => $assignment->instanceid));
        $this->assertEquals(0, count($records));
    }

    /**
     * Tests adding delete attempt button.
     */
    public function test_add_delete_attempt_button() {
        global $USER;
        $result = add_delete_attempt_button($USER);
        $this->assertEquals($result, '<button id="deleteButtonadmin" class="btn btn-warning" data-toggle="modal" data-target="#deleteModal2">Delete attempt</button>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Tests adding delete redirect button.
     */
    public function test_add_delete_redirect_button() {
        global $USER;
        $result = add_delete_redirect_button(1, $USER);
        $this->assertEquals($result, '<a id="deleteRedirectButtonadmin" class="btn btn-warning" href="https://www.example.com/moodle/mod/digitala/report.php?id=1&amp;mode=delete&amp;student=2">Confirm delete</a>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Tests adding delete all redirect button.
     */
    public function test_add_delete_all_redirect_button() {
        $result = add_delete_all_redirect_button(2);
        $this->assertEquals($result, '<a id="deleteAllRedirectButton" class="btn btn-danger" href="https://www.example.com/moodle/mod/digitala/report.php?id=2&amp;mode=delete&amp;student">Confirm delete</a>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Tests adding delete all attempts button.
     */
    public function test_add_delete_all_attempts_button() {
        $result = add_delete_all_attempts_button();
        $this->assertEquals($result, '<button id="deleteAllButton" class="btn btn-danger" data-toggle="modal" data-target="#deleteAllModal">Delete all</button>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }
    // @codingStandardsIgnoreStart moodle.Files.LineLength.MaxExceeded

    /**
     * Tests creating delete modal.
     */
    public function test_create_delete_modal() {
        global $USER;

        $result = create_delete_modal(1, $USER);
        $this->assertEquals($result, '<div class="modal" id="deleteModal2" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Warning</h5><button class="close" data-dismiss="modal" aria-label="close-cross"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><p>Are you sure you want to delete and reset attempts from user Admin User?</p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><a id="deleteRedirectButtonadmin" class="btn btn-warning" href="https://www.example.com/moodle/mod/digitala/report.php?id=1&amp;mode=delete&amp;student=2">Confirm delete</a></div></div></div></div>');
    }

    // @codingStandardsIgnoreEnd moodle.Files.LineLength.MaxExceeded

    // @codingStandardsIgnoreStart moodle.Files.LineLength.MaxExceeded
    public function test_generate_attempts_csv() {
        global $CFG, $DB;

        $assignment = new \stdClass();
        $assignment->instanceid = 500;
        $assignment->userid = 501;
        $assignment->attempttype = 'freeform';
        $evaluation = new \stdClass();
        $evaluation->transcript = 'transcript';
        $evaluation->task_completion = 2;
        $evaluation->fluency = new \stdClass();
        $evaluation->fluency->score = 1;
        $evaluation->fluency->flu_features = array('invalid' => 1);
        $evaluation->pronunciation = new \stdClass();
        $evaluation->pronunciation->score = 1;
        $evaluation->pronunciation->pron_features = array('invalid' => 1);
        $evaluation->lexicogrammatical = new \stdClass();
        $evaluation->lexicogrammatical->score = 3;
        $evaluation->lexicogrammatical->lexgram_features = array('invalid' => 1);
        $evaluation->holistic = 4;

        create_waiting_attempt($assignment, 'filename', 60);
        save_attempt($assignment, $evaluation);

        $result = generate_attempts_csv($assignment->instanceid, 'moodi');

        $this->assertEquals(str_contains($result, 'filename'), true);
        $this->assertEquals(str_contains($result, 500), true);
        $this->assertEquals(str_contains($result, 501), true);
    }

    public function test_get_all_feedbacks() {
        global $DB;

        $fromform = new \stdClass();
        $fromform->fluency = 1;
        $fromform->fluencyreason = 'Fluencyness';
        $fromform->pronunciation = 1;
        $fromform->pronunciationreason = 'Pronounciationess';

        $oldattempt = new \stdClass();
        $oldattempt->id = 1;
        $oldattempt->digitala = 2;
        $oldattempt->fluency = 1;
        $oldattempt->pronunciation = 1;

        save_report_feedback('readaloud', $fromform, $oldattempt);

        $fromform = new \stdClass();
        $fromform->taskcompletion = 1;
        $fromform->taskcompletionreason = "Taskcompletioness";
        $fromform->fluency = 1;
        $fromform->fluencyreason = "Fluencyness";
        $fromform->pronunciation = 1;
        $fromform->pronunciationreason = "Pronounciationess";
        $fromform->lexicogrammatical = 1;
        $fromform->lexicogrammaticalreason = "Lexicogrammaticalness";
        $fromform->holistic = 1;
        $fromform->holisticreason = "Holisticness";

        $oldattempt = new \stdClass();
        $oldattempt->id = 2;
        $oldattempt->taskcompletion = 1;
        $oldattempt->fluency = 1;
        $oldattempt->pronunciation = 1;
        $oldattempt->lexicogrammatical = 1;
        $oldattempt->holistic = 1;
        $oldattempt->digitala = 2;

        save_report_feedback('freeform', $fromform, $oldattempt);

        $result = get_all_feedbacks(2);
        $this->assertEquals(count($result), 2);
    }

    public function test_generate_report_feedback_csv() {
        global $DB;

        $assignment = new \stdClass();
        $assignment->instanceid = 808;
        $assignment->userid = 809;
        $assignment->attempttype = 'freeform';
        $evaluation = new \stdClass();
        $evaluation->transcript = 'transcript';
        $evaluation->task_completion = 2;
        $evaluation->fluency = new \stdClass();
        $evaluation->fluency->score = 1;
        $evaluation->fluency->flu_features = array('invalid' => 1);
        $evaluation->pronunciation = new \stdClass();
        $evaluation->pronunciation->score = 1;
        $evaluation->pronunciation->pron_features = array('invalid' => 1);
        $evaluation->lexicogrammatical = new \stdClass();
        $evaluation->lexicogrammatical->score = 3;
        $evaluation->lexicogrammatical->lexgram_features = array('invalid' => 1);
        $evaluation->holistic = 4;

        create_waiting_attempt($assignment, 'filename', 60);
        save_attempt($assignment, $evaluation);

        $result = generate_attempts_csv($assignment->instanceid, 'moodi');

        $this->assertEquals(str_contains($result, 'filename'), true);
        $this->assertEquals(str_contains($result, 808), true);
        $this->assertEquals(str_contains($result, 809), true);
    }

    public function test_create_export_buttons() {
        $result = create_export_buttons(2);
        $this->assertEquals($result, '<a href="https://www.example.com/moodle/mod/digitala/export.php?id=2&amp;mode=attempts" id="export_attempts" class="btn btn-primary">Export all attempts as CSV</a><a href="https://www.example.com/moodle/mod/digitala/export.php?id=2&amp;mode=feedback" id="export_attempts_feedback" class="btn btn-primary">Export all feedbacks for attempts as CSV</a>');
    }
    // @codingStandardsIgnoreEnd moodle.Files.LineLength.MaxExceeded
}
