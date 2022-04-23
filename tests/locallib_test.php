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
        $info = create_progress_bar_step_link('info', 0, 1, 1, false);
        $assignment = create_progress_bar_step_link('assignment', 1, 1, 1, false);
        $report = create_progress_bar_step_link('report', 2, 1, 1, false);
        // @codingStandardsIgnoreStart moodle.Files.LineLength.MaxExceeded
        $this->assertEquals($info, '<a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=0"><span class="pb-num">1</span><span class="pb-phase-name">Begin</span></a>');
        $this->assertEquals($assignment, '<a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=1"><span class="pb-num">2</span><span class="pb-phase-name">Assignment</span></a>');
        $this->assertEquals($report, '<a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=2"><span class="pb-num">3</span><span class="pb-phase-name">Evaluation</span></a>');

        $infoactive = create_progress_bar_step_link('info', 0, 1, 1, true);
        $assignmentactive = create_progress_bar_step_link('assignment', 1, 1, 1, true);
        $reportactive = create_progress_bar_step_link('report', 2, 1, 1, true);
        $this->assertEquals($infoactive, '<a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=0"><span class="pb-num active">1</span><span class="pb-phase-name">Begin</span></a>');
        $this->assertEquals($assignmentactive, '<a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=1"><span class="pb-num active">2</span><span class="pb-phase-name">Assignment</span></a>');
        $this->assertEquals($reportactive, '<a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=2"><span class="pb-num active">3</span><span class="pb-phase-name">Evaluation</span></a>');
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
        $info = create_progress_bar_step('info', 0, 1, 1, 1);
        $assignment = create_progress_bar_step('assignment', 1, 1, 1, 0);
        $report = create_progress_bar_step('report', 2, 1, 1, 0);
        $infoactive = create_progress_bar_step('info', 0, 1, 1, 0);
        $assignmentactive = create_progress_bar_step('assignment', 1, 1, 1, 1);
        $reportactive = create_progress_bar_step('report', 2, 1, 1, 2);
        // @codingStandardsIgnoreStart moodle.Files.LineLength.MaxExceeded
        $this->assertEquals($info, '<div class="pb-step first"><a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=0"><span class="pb-num">1</span><span class="pb-phase-name">Begin</span></a></div>');
        $this->assertEquals($assignment, '<div class="pb-step"><a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=1"><span class="pb-num">2</span><span class="pb-phase-name">Assignment</span></a></div>');
        $this->assertEquals($report, '<div class="pb-step last"><a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=2"><span class="pb-num">3</span><span class="pb-phase-name">Evaluation</span></a></div>');
        $this->assertEquals($infoactive, '<div class="pb-step active first"><a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=0"><span class="pb-num active">1</span><span class="pb-phase-name">Begin</span></a></div>');
        $this->assertEquals($assignmentactive, '<div class="pb-step active"><a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=1"><span class="pb-num active">2</span><span class="pb-phase-name">Assignment</span></a></div>');
        $this->assertEquals($reportactive, '<div class="pb-step active last"><a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=2"><span class="pb-num active">3</span><span class="pb-phase-name">Evaluation</span></a></div>');
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
        $this->assertEquals($rightempty, '<div class="pb-spacer pb-spacer-right"><svg class="pb-svg-front" viewBox="0 0 275 500"
    style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><path d="M255,250L20,0L0,0L0,500L20,500L255,250Z" style="fill:rgb(211,211,211);"/><path d="M20,20L255,250L20,480" style="fill:none;stroke:rgb(211,211,211);stroke-width:40px;"/></svg></div>');
        $this->assertEquals($leftempty, '<div class="pb-spacer pb-spacer-left"><svg class="pb-svg-back" viewBox="0 0 275 500"
    style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><path d="M275,0L20,0L255,250L20,500L275,500L275,0Z" style="fill:rgb(211,211,211);"/><path d="M20,20L255,250L20,480" style="fill:none;stroke:rgb(211,211,211);stroke-width:40px;"/></svg></div>');
        $this->assertEquals($nothing, '<div class="pb-spacer"><svg class="pb-svg-front" viewBox="0 0 275 500"
    style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><path d="M20,20L255,250L20,480" style="fill:none;stroke:rgb(211,211,211);stroke-width:40px;"/></svg></div>');
        // @codingStandardsIgnoreEnd moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test creating navigation buttons for view
     */
    public function test_navbuttons_html_output() {
        $result = create_nav_buttons('info', 1, 2);
        // @codingStandardsIgnoreStart moodle.Files.LineLength.MaxExceeded
        $this->assertEquals('<div class="navbuttons"><a href=https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=2&amp;page=1 id="nextButton" class="btn btn-primary">Next ></a href=https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=2&amp;page=1></div>',
            $result);
        $result = create_nav_buttons('assignmentprev', 1, 2);
        $this->assertEquals('<div class="navbuttons"><a href=https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=2&amp;page=0 id="prevButton" class="btn btn-primary">< Previous</a href=https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=2&amp;page=0></div>',
            $result);
        $result = create_nav_buttons('assignmentnext', 1, 2);
        $this->assertEquals('<div class="navbuttons"><a href=https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=2&amp;page=2 id="nextButton" class="btn btn-primary">Next ></a href=https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=2&amp;page=2></div>',
            $result);
        $result = create_nav_buttons('report', 1, 2);
        $this->assertEquals('<div class="navbuttons"><a href=https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=2&amp;page=1 id="tryAgainButton" class="btn btn-primary">See the assignment</a href=https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=2&amp;page=1></div>',
            $result);
        $result = create_nav_buttons('report', 1, 2, 1);
        $this->assertEquals('<div class="navbuttons"><a href=https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=2&amp;page=1 id="tryAgainButton" class="btn btn-primary">Try again</a href=https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=2&amp;page=1></div>',
            $result);
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
     * Test creating report view grading helper object.
     */
    public function test_grading_html_output() {
        $result = create_report_grading('fluency', 0, 0);
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Fluency</h5>'.
            '<canvas id="fluency" data-eval-name="fluency" data-eval-grade="0" data-eval-maxgrade="0" class="report-chart" height="40px"></canvas>'. // phpcs:ignore moodle.Files.LineLength.MaxExceeded
            '<h6 class="grade-number">0/0</h6>'.
            '<div class="card-text">This measure reflects the speed, pauses, and hesitations in your speech. Based on the automatic grading, it seems that unfortunately, the machine has not heard this type of performance before and therefore failed to grade your speech. However, do not be discouraged: try again!</div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test creating report view holistic helper object.
     */
    public function test_holistic_html_output() {
        $result = create_report_holistic(3);
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Proficiency level</h5><canvas id="holistic" data-eval-name="holistic" data-eval-grade="3" data-eval-maxgrade="6" class="report-chart" height="40px"></canvas><h6 class="grade-number">B1</h6><div class="card-text">Based on the automatic grading, it seems that your proficiency level is B1:<br>You manage everyday situations in the target language. Your pronunciation is intelligible, your vocabulary is fairly large, and you use different kinds of sentences.</div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test creating report view information helper object.
     */
    public function test_information_html_output() {
        $result = create_report_information('text');
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">More information</h5><div class="card-text">text</div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test creating report view GOP helper object.
     */
    public function test_gop_html_output() {
        $result = create_report_gop(0.72);
        $this->assertEquals('<div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Goodness of pronunciation</h5><h6 class="grade-number">72%</h6><div class="card-text">Pronunciation score is 7, big pink score.</div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Test creating report view tab creation helper.
     */
    public function test_tabs_html_output() {
        $result = create_report_tabs('', '', '');
        $this->assertEquals('<nav><div class="nav nav-tabs" id="nav-tab" role="tablist"><button class="nav-link active ml-2" id="report-grades-tab" data-toggle="tab" href="#report-grades" role="tab" aria-controls="report-grades" aria-selected="true">Analytic grading</button><button class="nav-link ml-2" id="report-holistic-tab" data-toggle="tab" href="#report-holistic" role="tab" aria-controls="report-holistic" aria-selected="false">Proficiency level</button><button class="nav-link ml-2" id="report-information-tab" data-toggle="tab" href="#report-information" role="tab" aria-controls="report-information" aria-selected="false">More information</button></div></nav><div class="tab-content" id="nav-tabContent"><div class="tab-pane fade show active" id="report-grades" role="tabpanel" aria-labelledby="report-grades-tab"></div><div class="tab-pane fade" id="report-holistic" role="tabpanel" aria-labelledby="report-holistic-tab"></div><div class="tab-pane fade" id="report-information" role="tabpanel" aria-labelledby="report-information-tab"></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
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

        $context = \context_module::instance($this->digitala->cmid);
        $assignment = new \digitala_assignment($this->digitala->id, $context->id, $USER->id, $USER->username, 4, 5, $this->digitala->assignment, 'testresource', $this->digitala->attempttype, $this->digitala->attemptlang); // phpcs:ignore moodle.Files.LineLength.MaxExceeded

        $result = create_resource($assignment);
        $this->assertEquals('<div class="card-text scrollbox400">testresource</div>', $result);
    }

    /**
     * Test saving answer recording.
     */
    public function test_save_answerrecording() {
        global $USER;

        $context = \context_module::instance($this->digitala->cmid);
        $assignment = new \digitala_assignment($this->digitala->id, $context->id, $USER->id, $USER->username, 1, 1, $this->digitala->assignment, $this->digitala->resources, $this->digitala->attempttype, $this->digitala->attemptlang);  // phpcs:ignore moodle.Files.LineLength.MaxExceeded

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

        $context = \context_module::instance($this->digitala->cmid);
        $assignment = new \digitala_assignment($this->digitala->id, $context->id, $USER->id, $USER->username, 4, 5, $this->digitala->assignment, $this->digitala->resources, $this->digitala->attempttype, $this->digitala->attemptlang); // phpcs:ignore moodle.Files.LineLength.MaxExceeded

        $result = create_answerrecording_form($assignment);
        if (PHPUnitVersion::series() < 9) {
            $this->assertRegExp('/form id="answerrecording"/', $result);
            $this->assertRegExp('/id=4/', $result);
            $this->assertRegExp('/d=5/', $result);
            $this->assertRegExp('/page=1/', $result);
            $this->assertRegExp('/input name="audiostring" type="hidden" value="answerrecording_form"/', $result);
        } else {
            $this->assertMatchesRegularExpression('/form id="answerrecording"/', $result);
            $this->assertMatchesRegularExpression('/id=4/', $result);
            $this->assertMatchesRegularExpression('/d=5/', $result);
            $this->assertMatchesRegularExpression('/page=1/', $result);
            $this->assertMatchesRegularExpression('/input name="audiostring" type="hidden" value="answerrecording_form"/', $result);
        }

    }

    /**
     * Test saving answerrecording form with form data.
     */
    public function test_save_answerrecording_form_with_data() {
        global $USER;
        \answerrecording_form::mock_submit(array('audiostring' => '{"url":"http:\/\/localhost:8000\/draftfile.php\/5\/user\/draft\/0\/testing.wav","id": 0,"file":"testing.wav"}', 'recordinglength' => 10), null, 'post', 'answerrecording_form'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
        $context = \context_module::instance($this->digitala->cmid);
        $assignment = new \digitala_assignment($this->digitala->id, $context->id, $USER->id, $USER->username, 1, 1, $this->digitala->assignment, $this->digitala->resources, $this->digitala->attempttype, $this->digitala->attemptlang); // phpcs:ignore moodle.Files.LineLength.MaxExceeded

        $result = save_answerrecording_form($assignment);
        $this->assertEquals('<p id="submitErrors"></p><br>No evaluation was found. Check your connection with server.', $result);
    }

    /**
     * Test saving answerrecording form without form data.
     */
    public function test_save_answerrecording_form_wo_data() {
        global $USER;
        $context = \context_module::instance($this->digitala->cmid);
        $assignment = new \digitala_assignment($this->digitala->id, $context->id, $USER->id, $USER->username, 1, 1, $this->digitala->assignment, $this->digitala->resources, $this->digitala->attempttype, $this->digitala->attemptlang); // phpcs:ignore moodle.Files.LineLength.MaxExceeded

        $result = save_answerrecording_form($assignment);
        $this->assertEquals('<p id="submitErrors"></p>', $result);
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

        save_attempt($assignment, 'filename', $evaluation, 60);

        $result = $DB->record_exists('digitala_attempts',
                                     array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals(true, $result);
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals($evaluation->transcript, $record->transcript);
        $this->assertEquals($evaluation->holistic, $record->holistic);
        $this->assertEquals('{"invalid":1}', $record->fluency_features);

        save_attempt($assignment, 'filename', $evaluation, 60);
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals(2, $record->attemptnumber);

        $evaluation->task_completion = -1.1;
        $evaluation->fluency->score = -1.1;
        $evaluation->pronunciation->score = -1.1;
        $evaluation->lexicogrammatical->score = -1.1;
        $evaluation->holistic = -1.1;

        save_attempt($assignment, 'filename', $evaluation, 60);
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

        save_attempt($assignment, 'filename', $evaluation, 60);
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
        $evaluation->feedback = '';
        $evaluation->GOP_score = 4;

        save_attempt($assignment, 'filename', $evaluation, 60);

        $result = $DB->record_exists('digitala_attempts',
                                     array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals(true, $result);
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals(0.00, $record->gop_score);

        $evaluation->GOP_score = 0.69;
        save_attempt($assignment, 'filename', $evaluation, 60);
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals(0.69, $record->gop_score);

        save_attempt($assignment, 'filename', $evaluation, 60);
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals(3, $record->attemptnumber);

        $evaluation->GOP_score = -1.3;

        save_attempt($assignment, 'filename', $evaluation, 60);
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));
        $this->assertEquals(0, $record->gop_score);
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
        $attempt->gop_score = 1.00;
        $attempt->timecreated = $timenow;
        $attempt->timemodified = $timenow;
        $DB->insert_record('digitala_attempts', $attempt);

        $result = get_attempt(2, $USER->id);
        $this->assertEquals($attempt->gop_score, $result->gop_score);
    }

// @codingStandardsIgnoreStart moodle.Files.LineLength.MaxExceeded
    public function test_create_microphone() {
        $result = create_microphone();
        $this->assertEquals('<div id="startIcon" style="display: none;"><svg width="16" height="16" fill="currentColor"class="bi bi-play-fill" viewBox="0 0 16 16"><path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/></svg></div><div id="stopIcon" style="display: none;"><svg width="16" height="16" fill="currentColor"class="bi bi-stop-fill" viewBox="0 0 16 16"><path d="M5 3.5h6A1.5 1.5 0 0 1 12.5 5v6a1.5 1.5 0 0 1-1.5 1.5H5A1.5 1.5 0 0 1 3.5 11V5A1.5 1.5 0 0 1 5 3.5z"/></svg></div><p id="recordTimer"><span id="recordingLength">00:00</span><span></span></p><button id="record" class="btn btn-primary record-btn">Record <svg width="16" height="16" fill="currentColor"class="bi bi-play-fill" viewBox="0 0 16 16"><path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/></svg></button><button id="listen" class="btn btn-primary listen-btn" disabled="true">Listen to your recording <svg width="16" height="16" fill="currentColor"class="bi bi-volume-down-fill" viewBox="0 0 16 16"><path d="M9 4a.5.5 0 0 0-.812-.39L5.825 5.5H3.5A.5.5 0 0 0 3 6v4a.5.5 0 0 0 .5.5h2.325l2.363 1.89A.5.5 0 0 0 9 12V4zm3.025 4a4.486 4.486 0 0 1-1.318 3.182L10 10.475A3.489 3.489 0 0 0 11.025 8 3.49 3.49 0 0 0 10 5.525l.707-.707A4.486 4.486 0 0 1 12.025 8z"/></svg></button>', $result);
    }

    /**
     * Test creating microphone icon.
     */
    public function test_create_microphone_icon() {
        $result = create_microphone_icon();
        $this->assertEquals('<div id="microphoneIconBox"></div><svg width="150" height="150" viewBox="0 0 150 150" version="1.1" id="svg5" inkscape:version="0.92.5 (2060ec1f9f, 2020-04-08)" inkscape:export-xdpi="96" inkscape:export-ydpi="96"> <sodipodi:namedview id="namedview7" pagecolor="#ffffff" bordercolor="#000000" borderopacity="1" inkscape:pageshadow="0" inkscape:pageopacity="0" inkscape:pagecheckerboard="false" inkscape:document-units="px" showgrid="false" units="px" inkscape:zoom="5.9223905" inkscape:cx="62.947139" inkscape:cy="78.863467" inkscape:window-width="1848" inkscape:window-height="1016" inkscape:window-x="72" inkscape:window-y="27" inkscape:window-maximized="1" inkscape:current-layer="layer1" viewbox-width="24" scale-x="1" showguides="true" /> <defs id="defs2"> <linearGradient inkscape:collect="always" id="linearGradient8239"> <stop style="stop-color:#ffffff;stop-opacity:1" offset="0" id="stop8278" /> <stop style="stop-color:#ffffff;stop-opacity:0" offset="1" id="stop8280" /> </linearGradient> <linearGradient id="linearGradient8197" inkscape:swatch="solid"> <stop style="stop-color:#c04b0d;stop-opacity:1;" offset="0" id="stop8195" /> </linearGradient> <linearGradient id="linearGradient6947" inkscape:swatch="solid"> <stop style="stop-color:#323232;stop-opacity:1;" offset="0" id="stop6945" /> </linearGradient> <linearGradient inkscape:collect="always" xlink:href="#linearGradient7609" id="linearGradient14811" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1.7019434,0,0,1.3429862,-166.17392,-206.17779)" x1="119.37104" y1="133.03964" x2="164.0202" y2="133.03964" /> <linearGradient id="linearGradient7609" inkscape:swatch="solid"> <stop style="stop-color:#000000;stop-opacity:1;" offset="0" id="stop7607" /> </linearGradient> <linearGradient inkscape:collect="always" xlink:href="#linearGradient8239" id="linearGradient8241" x1="12.490475" y1="20.807896" x2="12.282459" y2="-3.5488219" gradientUnits="userSpaceOnUse" gradientTransform="matrix(2.25,0,0,2.25,47.322403,-77.306788)" /> </defs> <g inkscape:label="Taso 1" inkscape:groupmode="layer" id="layer1" transform="translate(0,126)"> <ellipse style="fill:url(#linearGradient8241);fill-opacity:1;stroke:#d9f991;stroke-width:0; stroke-linecap:round;stroke-miterlimit:4;stroke-dasharray:none; stroke-dashoffset:0;stroke-opacity:1" id="path4797" cx="74.337151" cy="-50.244549" rx="26.929842" ry="26.977333" inkscape:export-filename="C:\Users\Joona\Desktop\icon.png" inkscape:export-xdpi="96" inkscape:export-ydpi="96" /> <rect style="fill:#000000;fill-opacity:1;stroke-width:0.47406167" id="rect1812-5-3-8" width="57.838097" height="83.551956" x="45.952644" y="-108.73703" ry="23.275175" rx="27.54195" /> <path style="fill:none;fill-opacity:1;stroke:url(#linearGradient14811);stroke-width :7.06218767;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:4; stroke-dasharray:none;stroke-opacity:1" d="m 40.246073,-38.828328 c 10.851217,28.219916 60.610707,28.8520856 69.419357,-0.73962" id="path401-9-7" sodipodi:nodetypes="cc" inkscape:connector-curvature="0" /> <path style="fill:none;stroke:#000000;stroke-width:9.99843788;stroke-linecap: butt;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1" d="M 75.90223,-19.843168 76.12741,0.59611765" id="path3077-8-4" inkscape:connector-curvature="0" /> <path style="fill:none;stroke:#000000;stroke-width:8.46515751;stroke-linecap: butt;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1" d="m 54.13793,2.5386476 c 13.84293,-1.83226995 28.51102,-2.01710995 44.282025,0" id="path574" sodipodi:nodetypes="cc" inkscape:connector-curvature="0" /> <path style="fill:none;stroke:#ffffff;stroke-width:5.0625px;stroke-linecap: round;stroke-linejoin:miter;stroke-opacity:1" d="m 45.849173,-83.263866 c 26.926417,-0.21371 26.926417,-0.21371 26.926417,-0.21371" id="path4391" inkscape:connector-curvature="0" /> <path style="fill:none;stroke:#ffffff;stroke-width:5.0625px;stroke-linecap: round;stroke-linejoin:miter;stroke-opacity:1" d="M 45.635473,-69.907508 C 72.5619,-70.121218 72.5619,-70.121218 72.5619,-70.121218" id="path4391-9" inkscape:connector-curvature="0" /> <path style="fill:none;stroke:#ffffff;stroke-width:5.0625;stroke-linecap: round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:30.375, 5.0625; stroke-dashoffset:0;stroke-opacity:1" d="M 45.635473,-56.230598 C 72.5619,-56.444308 72.5619,-56.444308 72.5619,-56.444308" id="path4391-9-2" inkscape:connector-curvature="0" /> </g> </svg id="microphoneIcon"></svg width="150" height="150" viewBox="0 0 150 150" version="1.1" id="svg5" inkscape:version="0.92.5 (2060ec1f9f, 2020-04-08)" inkscape:export-xdpi="96" inkscape:export-ydpi="96"> <sodipodi:namedview id="namedview7" pagecolor="#ffffff" bordercolor="#000000" borderopacity="1" inkscape:pageshadow="0" inkscape:pageopacity="0" inkscape:pagecheckerboard="false" inkscape:document-units="px" showgrid="false" units="px" inkscape:zoom="5.9223905" inkscape:cx="62.947139" inkscape:cy="78.863467" inkscape:window-width="1848" inkscape:window-height="1016" inkscape:window-x="72" inkscape:window-y="27" inkscape:window-maximized="1" inkscape:current-layer="layer1" viewbox-width="24" scale-x="1" showguides="true" /> <defs id="defs2"> <linearGradient inkscape:collect="always" id="linearGradient8239"> <stop style="stop-color:#ffffff;stop-opacity:1" offset="0" id="stop8278" /> <stop style="stop-color:#ffffff;stop-opacity:0" offset="1" id="stop8280" /> </linearGradient> <linearGradient id="linearGradient8197" inkscape:swatch="solid"> <stop style="stop-color:#c04b0d;stop-opacity:1;" offset="0" id="stop8195" /> </linearGradient> <linearGradient id="linearGradient6947" inkscape:swatch="solid"> <stop style="stop-color:#323232;stop-opacity:1;" offset="0" id="stop6945" /> </linearGradient> <linearGradient inkscape:collect="always" xlink:href="#linearGradient7609" id="linearGradient14811" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1.7019434,0,0,1.3429862,-166.17392,-206.17779)" x1="119.37104" y1="133.03964" x2="164.0202" y2="133.03964" /> <linearGradient id="linearGradient7609" inkscape:swatch="solid"> <stop style="stop-color:#000000;stop-opacity:1;" offset="0" id="stop7607" /> </linearGradient> <linearGradient inkscape:collect="always" xlink:href="#linearGradient8239" id="linearGradient8241" x1="12.490475" y1="20.807896" x2="12.282459" y2="-3.5488219" gradientUnits="userSpaceOnUse" gradientTransform="matrix(2.25,0,0,2.25,47.322403,-77.306788)" /> </defs> <g inkscape:label="Taso 1" inkscape:groupmode="layer" id="layer1" transform="translate(0,126)"> <ellipse style="fill:url(#linearGradient8241);fill-opacity:1;stroke:#d9f991;stroke-width:0; stroke-linecap:round;stroke-miterlimit:4;stroke-dasharray:none; stroke-dashoffset:0;stroke-opacity:1" id="path4797" cx="74.337151" cy="-50.244549" rx="26.929842" ry="26.977333" inkscape:export-filename="C:\Users\Joona\Desktop\icon.png" inkscape:export-xdpi="96" inkscape:export-ydpi="96" /> <rect style="fill:#000000;fill-opacity:1;stroke-width:0.47406167" id="rect1812-5-3-8" width="57.838097" height="83.551956" x="45.952644" y="-108.73703" ry="23.275175" rx="27.54195" /> <path style="fill:none;fill-opacity:1;stroke:url(#linearGradient14811);stroke-width :7.06218767;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:4; stroke-dasharray:none;stroke-opacity:1" d="m 40.246073,-38.828328 c 10.851217,28.219916 60.610707,28.8520856 69.419357,-0.73962" id="path401-9-7" sodipodi:nodetypes="cc" inkscape:connector-curvature="0" /> <path style="fill:none;stroke:#000000;stroke-width:9.99843788;stroke-linecap: butt;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1" d="M 75.90223,-19.843168 76.12741,0.59611765" id="path3077-8-4" inkscape:connector-curvature="0" /> <path style="fill:none;stroke:#000000;stroke-width:8.46515751;stroke-linecap: butt;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1" d="m 54.13793,2.5386476 c 13.84293,-1.83226995 28.51102,-2.01710995 44.282025,0" id="path574" sodipodi:nodetypes="cc" inkscape:connector-curvature="0" /> <path style="fill:none;stroke:#ffffff;stroke-width:5.0625px;stroke-linecap: round;stroke-linejoin:miter;stroke-opacity:1" d="m 45.849173,-83.263866 c 26.926417,-0.21371 26.926417,-0.21371 26.926417,-0.21371" id="path4391" inkscape:connector-curvature="0" /> <path style="fill:none;stroke:#ffffff;stroke-width:5.0625px;stroke-linecap: round;stroke-linejoin:miter;stroke-opacity:1" d="M 45.635473,-69.907508 C 72.5619,-70.121218 72.5619,-70.121218 72.5619,-70.121218" id="path4391-9" inkscape:connector-curvature="0" /> <path style="fill:none;stroke:#ffffff;stroke-width:5.0625;stroke-linecap: round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:30.375, 5.0625; stroke-dashoffset:0;stroke-opacity:1" d="M 45.635473,-56.230598 C 72.5619,-56.444308 72.5619,-56.444308 72.5619,-56.444308" id="path4391-9-2" inkscape:connector-curvature="0" /> </g> </svg>', $result);
    }


    /**
     * Test creating a fixed box for feedback.
     */
    public function test_create_fixed_box() {
        $result = create_fixed_box();
        $this->assertEquals('<div class="feedbackcontainer" data-toggle="collapse" data-target="#feedbacksite">Give feedback</div><button type="button" class="btn btn-primary"data-toggle="collapse" data-target="#feedbacksite" id="collapser"><svg id="feedback" width="16" height="16" fill="currentColor"class="bi bi-chat-text-fill" viewBox="0 0 16 16"><path d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM4.5 5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4z"/></svg></button type="button" class="btn btn-primary"data-toggle="collapse" data-target="#feedbacksite" id="collapser"><div class="collapse" id="feedbacksite"></div><iframe src=https://link.webropolsurveys.com/Participation/Public/2c1ccd52-6e23-436e-af51-f8f8c259ffbb?displayId=Fin2500048 id="feedbacksite" class="collapse"></iframe src=https://link.webropolsurveys.com/Participation/Public/2c1ccd52-6e23-436e-af51-f8f8c259ffbb?displayId=Fin2500048>', $result);

    }

    /**
     * Tests creating chart canvas.
     */
    public function test_create_chart() {
        $result = create_chart('nimi', '2.00', '4');
        $this->assertEquals('<canvas id="nimi" data-eval-name="nimi" data-eval-grade="2.00" data-eval-maxgrade="4" class="report-chart" height="40px"></canvas>',
                            $result);
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
        $evaluation->feedback = '';
        $evaluation->GOP_score = 1;

        save_attempt($assignment, 'filename', $evaluation, 60);
        $assignment->attemptlimit = 3;
        $result = create_attempt_number($assignment, $assignment->userid);
        $this->assertEquals('Number of attempts remaining: 2', $result);
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
        $evaluation->feedback = '';
        $evaluation->GOP_score = 1;

        save_attempt($assignment, 'filename', $evaluation, 60);

        \answerrecording_form::mock_submit(array('audiostring' => '{"url":"http:\/\/localhost:8000\/draftfile.php\/5\/user\/draft\/0\/testing.wav","id": 0,"file":"testing.wav"}'), null, 'post', 'answerrecording_form');
        $context = \context_module::instance($this->digitala->cmid);
        $assignment = new \digitala_assignment($this->digitala->id, $context->id, $USER->id, $USER->username, 1, 1, $this->digitala->assignment, $this->digitala->resources, $this->digitala->attempttype, $this->digitala->attemptlang);

        $result = create_attempt_modal($assignment);
        $this->assertStringStartsWith('<button id="submitModalButton" type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#attemptModal" style="display: none">Submit answer</button><div class="modal" id="attemptModal" tabindex="-1" role="dialog" aria-labelledby="submitModal" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Are you sure you want to submit this attempt?</h5><button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><p>You still have 1 attempts remaining on this assignment.</p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>', $result);
        $this->assertStringEndsWith('</form></div></div></div></div>', $result);

        $assignment->attemptlimit = 0;

        $result = create_attempt_modal($assignment);
        $this->assertStringStartsWith('<button id="submitModalButton" type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#attemptModal" style="display: none">Submit answer</button><div class="modal" id="attemptModal" tabindex="-1" role="dialog" aria-labelledby="submitModal" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Are you sure you want to submit this attempt?</h5><button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><p>There is no limit set for the number of attempts on this assignment.</p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>', $result);
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
        $evaluation->feedback = '';
        $evaluation->GOP_score = 4;
        $recordinglength = 5;

        save_attempt($assignment, 'filename1', $evaluation, $recordinglength);

        $assignment->instanceid = 1;
        $assignment->userid = 2;
        $evaluation->GOP_score = 3;
        $recordinglength = 5;

        save_attempt($assignment, 'filename2', $evaluation, $recordinglength);

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
        $evaluation->feedback = '';
        $evaluation->GOP_score = 1.00;
        $recordinglength = 5;

        save_attempt($assignment, 'filename', $evaluation, $recordinglength);
        $record = $DB->get_record('digitala_attempts',
                                  array('digitala' => $assignment->instanceid, 'userid' => $assignment->userid));

        $result = create_result_row($record, $this->digitala->id, $USER);
        $this->assertEquals('Admin User', $result[0]);
        $this->assertEquals(1.00, $result[1]);
        $this->assertEquals('00:05', $result[2]);
        $this->assertEquals(1, $result[3]);
        $this->assertStringContainsString('>See report</a>', $result[4]);
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
        $fromform->gop = 1;
        $fromform->gopreason = "I'm a reason, did you know!?";

        $oldattempt = new \stdClass();
        $oldattempt->id = 5;
        $oldattempt->gop_score = 4;
        $oldattempt->digitala = 2;

        save_report_feedback('readaloud', $fromform, $oldattempt);

        $result = $DB->record_exists('digitala_report_feedback',
                                     array('attempt' => 5));
        $this->assertEquals(true, $result);

        $feedback = $DB->get_record('digitala_report_feedback',
                                    array('attempt' => 5));
        $this->assertEquals(4, $feedback->old_gop_score);
        $this->assertEquals(1, $feedback->gop_score);
        $this->assertEquals("I'm a reason, did you know!?", $feedback->gop_score_reason);
        $this->assertEquals(false, isset($feedback->old_fluency));
        $this->assertEquals(false, isset($feedback->taskcompletion));
        $this->assertEquals(false, isset($feedback->pronunciation_reason));

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
        $this->assertEquals(false, isset($feedback->gop_score));
    }

    public function test_create_short_assignment_tabs() {
        $result = create_short_assignment_tabs('', '');
        $this->assertEquals('<nav><div class="nav nav-tabs" id="nav-tab" role="tablist"><button class="nav-link active ml-2" id="assignment-assignment-tab" data-toggle="tab" href="#assignment-assignment" role="tab" aria-controls="assignment-assignment" aria-selected="true">Assignment</button><button class="nav-link ml-2" id="assignment-resources-tab" data-toggle="tab" href="#assignment-resources" role="tab" aria-controls="assignment-resources" aria-selected="false">Material</button></div></nav><div class="tab-content" id="nav-tabContent"><div class="tab-pane fade show active" id="assignment-assignment" role="tabpanel" aria-labelledby="assignment-assignment-tab"></div><div class="tab-pane fade" id="assignment-resources" role="tabpanel" aria-labelledby="assignment-resources-tab"></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    public function test_create_transcript_toggle() {
        $result = create_transcript_toggle('transcript', 'feedback');
        $this->assertEquals('<nav><div class="nav nav-pills" id="nav-pills" role="tablist"><button class="nav-link active ml-1" id="readaloud-feedback-tab" data-toggle="tab" href="#readaloud-feedback" role="tab" aria-controls="readaloud-feedback" aria-selected="true">Show corrections</button><button class="nav-link ml-1" id="readaloud-transcript-tab" data-toggle="tab" href="#readaloud-transcript" role="tab" aria-controls="readaloud-transcript" aria-selected="false">Plain text</button></div></nav><div class="tab-content" id="nav-tabContent"><div class="tab-pane fade show active" id="readaloud-feedback" role="tabpanel" aria-labelledby="readaloud-feedback-tab"><div class="card row digitala-card"><div class="card-body"><h5 class="card-title">Give feedback</h5><div class="card-text scrollbox200">feedback</div></div></div></div><div class="tab-pane fade" id="readaloud-transcript" role="tabpanel" aria-labelledby="readaloud-transcript-tab"><div class="card row digitala-card"><div class="card-body"><h5 class="card-title">A transcript of your speech sample</h5><div class="card-text scrollbox200">transcript</div></div></div></div></div>', $result); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
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
        $evaluation->GOP_score = 4;
        $recordinglength = 5;

        save_attempt($assignment, 'filename1', $evaluation, $recordinglength);
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
        $evaluation->GOP_score = 4;
        $recordinglength = 5;

        save_attempt($assignment, 'filename1', $evaluation, $recordinglength);

        $assignment = new \stdClass();
        $assignment->instanceid = 1;
        $assignment->userid = 2;
        $evaluation = new \stdClass();
        $evaluation->GOP_score = 3;
        $recordinglength = 5;

        save_attempt($assignment, 'filename2', $evaluation, $recordinglength);

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
        $this->assertEquals($result, '<a href=https://www.example.com/moodle/mod/digitala/report.php?id=1&amp;mode=delete&amp;student=2 id="deleteRedirectButtonadmin" class="btn btn-warning">Confirm delete</a href=https://www.example.com/moodle/mod/digitala/report.php?id=1&amp;mode=delete&amp;student=2>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    }

    /**
     * Tests adding delete all redirect button.
     */
    public function test_add_delete_all_redirect_button() {
        $result = add_delete_all_redirect_button(2);
        $this->assertEquals($result, '<a href=https://www.example.com/moodle/mod/digitala/report.php?id=2&amp;mode=delete&amp;student id="deleteAllRedirectButton" class="btn btn-danger">Confirm delete</a href=https://www.example.com/moodle/mod/digitala/report.php?id=2&amp;mode=delete&amp;student>'); // phpcs:ignore moodle.Files.LineLength.MaxExceeded
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
        $this->assertEquals($result, '<div class="modal" id="deleteModal2" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Warning</h5><button class="close" data-dismiss="modal" aria-label="close-cross"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><p>Are you sure you want to delete and reset attempts from user Admin User?</p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><a href=https://www.example.com/moodle/mod/digitala/report.php?id=1&amp;mode=delete&amp;student=2 id="deleteRedirectButtonadmin" class="btn btn-warning">Confirm delete</a href=https://www.example.com/moodle/mod/digitala/report.php?id=1&amp;mode=delete&amp;student=2></div></div></div></div>');
    }

    // @codingStandardsIgnoreEnd moodle.Files.LineLength.MaxExceeded
}
