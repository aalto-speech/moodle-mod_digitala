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

defined('MOODLE_INTERNAL') || die('');

global $CFG;
require_once(__DIR__.'/../locallib.php');

/**
 * Unit tests for adding a digitala plugin
 *
 * @group mod_digitala
 * @package     mod_digitala
 * @category    test
 * @copyright   2022 Name
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class digitala_progress_bar_test extends \advanced_testcase {

    /**
     * Setup for unit test.
     */
    protected function setUp(): void {
        $this->setAdminUser();
        $this->resetAfterTest();
        $this->course = $this->getDataGenerator()->create_course();
        $this->digitala = $this->getDataGenerator()->create_module('digitala', [
            'course' => $this->course->id,
            'name' => 'new_digitala'
        ]);
    }
    /**
     * Test generating page_url
     */
    public function test_page_url() {
        for ($i = 0; $i <= 2; $i++) {
            $generated_url = (page_url($i,1,1))->out();
            $this->assertEquals($generated_url,'https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page='.$i);
        }
        
    }

    /**
     * Test generating progress bar step link as non active and active
     */
    public function test_create_progress_bar_step_link() {
        $info = create_progress_bar_step_link('digitalainfo', 0, 1, 1, false);
        $assignment = create_progress_bar_step_link('digitalaassignment', 1, 1, 1, false);
        $report = create_progress_bar_step_link('digitalareport', 2, 1, 1, false);
        $this->assertEquals($info, '<a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=0"><span class="pb-num">1</span>Info</a>');
        $this->assertEquals($assignment, '<a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=1"><span class="pb-num">2</span>Assignment</a>');
        $this->assertEquals($report, '<a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=2"><span class="pb-num">3</span>Report</a>');
    
        $infoactive = create_progress_bar_step_link('digitalainfo', 0, 1, 1, true);
        $assignmentactive = create_progress_bar_step_link('digitalaassignment', 1, 1, 1, true);
        $reportactive = create_progress_bar_step_link('digitalareport', 2, 1, 1, true);
        $this->assertEquals($infoactive, '<a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=0"><span class="pb-num active">1</span>Info</a>');
        $this->assertEquals($assignmentactive, '<a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=1"><span class="pb-num active">2</span>Assignment</a>');
        $this->assertEquals($reportactive, '<a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=2"><span class="pb-num active">3</span>Report</a>');
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
        $this->assertEquals($info, '<div class="pb-step first"><a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=0"><span class="pb-num">1</span>Info</a></div>');
        $this->assertEquals($assignment, '<div class="pb-step"><a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=1"><span class="pb-num">2</span>Assignment</a></div>');
        $this->assertEquals($report, '<div class="pb-step last"><a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=2"><span class="pb-num">3</span>Report</a></div>');
        $this->assertEquals($infoactive, '<div class="pb-step active first"><a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=0"><span class="pb-num active">1</span>Info</a></div>');
        $this->assertEquals($assignmentactive, '<div class="pb-step active"><a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=1"><span class="pb-num active">2</span>Assignment</a></div>');
        $this->assertEquals($reportactive, '<div class="pb-step active last"><a class="display-6" href="https://www.example.com/moodle/mod/digitala/view.php?id=1&amp;d=1&amp;page=2"><span class="pb-num active">3</span>Report</a></div>');
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
        $this->assertEquals($rightempty, '<div class="pb-spacer"><svg width="100%" height="100%" viewBox="0 0 275 500"
    style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><path d="M255,250L20,0L0,0L0,500L20,500L255,250Z" style="fill:rgb(211,211,211);"/><path d="M20,20L255,250L20,480" style="fill:none;stroke:rgb(211,211,211);stroke-width:40px;"/></svg></div>');
        $this->assertEquals($leftempty, '<div class="pb-spacer"><svg width="100%" height="100%" viewBox="0 0 275 500"
    style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><path d="M275,0L20,0L255,250L20,500L275,500L275,0Z" style="fill:rgb(211,211,211);"/><path d="M20,20L255,250L20,480" style="fill:none;stroke:rgb(211,211,211);stroke-width:40px;"/></svg></div>');
        $this->assertEquals($nothing, '<div class="pb-spacer"><svg width="100%" height="100%" viewBox="0 0 275 500"
    style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><path d="M20,20L255,250L20,480" style="fill:none;stroke:rgb(211,211,211);stroke-width:40px;"/></svg></div>');
    }

}
