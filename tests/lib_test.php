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

/**
 * Unit tests for adding a digitala plugin
 *
 * @group       mod_digitala
 * @covers      \mod_digitala
 * @package     mod_digitala
 * @category    test
 * @copyright   2022 Name
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class lib_test extends \advanced_testcase {

    /**
     * A test to test testing.
     */
    public function test_dummy() {
        $this->assertEquals(2, 1 + 1);
    }

    /**
     * Setup for unit test.
     */
    protected function setUp(): void {
        $this->setAdminUser();
        $this->resetAfterTest();
        $this->course = $this->getDataGenerator()->create_course();
    }

    /**
     * Create new digitala activity.
     */
    private function create_digitala() {
        return $this->getDataGenerator()->create_module('digitala', [
                'course' => $this->course->id,
                'name' => 'new_digitala',
                'attemptlang' => 'fi',
                'attempttype' => 'freeform',
                'assignment' => 'Assignment text',
                'resources' => array('text' => 'Resource text', 'format' => 1),
                'information' => array('text' => 'Information text', 'format' => 1),
            ]);
    }

    /**
     * Test creating a digitala instance.
     */
    public function test_digitala_add_instance() {
        $digitala = $this->create_digitala();
        $this->assertEquals('new_digitala', $digitala->name);

        $digitala = $this->getDataGenerator()->create_module('digitala', [
                'course' => $this->course->id,
                'name' => 'new_digitala',
                'attemptlang' => 'fi',
                'attempttype' => 'freeform',
                'assignment' => 'Assignment text',
                'resources' => array('text' => 'Resource text', 'format' => 1),
                'information' => array('text' => 'Information text', 'format' => 1),
                'resources_editor' => array('text' => 'New resource text', 'format' => 1),
            ]);
        $this->assertEquals($digitala->resources, 'New resource text');
        $this->assertEquals($digitala->information, 'Information text');
        $digitala = $this->getDataGenerator()->create_module('digitala', [
                'course' => $this->course->id,
                'name' => 'new_digitala',
                'attemptlang' => 'fi',
                'attempttype' => 'freeform',
                'assignment' => 'Assignment text',
                'resources' => array('text' => 'Resource text', 'format' => 1),
                'information' => array('text' => 'Information text', 'format' => 1),
                'information_editor' => array('text' => 'New information text', 'format' => 1),
            ]);
        $this->assertEquals($digitala->resources, 'Resource text');
        $this->assertEquals($digitala->information, 'New information text');
        $digitala = $this->getDataGenerator()->create_module('digitala', [
                'course' => $this->course->id,
                'name' => 'new_digitala',
                'attemptlang' => 'fi',
                'attempttype' => 'freeform',
                'assignment' => 'Assignment text',
                'resources' => array('text' => 'Resource text', 'format' => 1),
                'information' => array('text' => 'Information text', 'format' => 1),
                'resources_editor' => array('text' => 'New resource text', 'format' => 1),
                'information_editor' => array('text' => 'New information text', 'format' => 1),
            ]);
        $this->assertEquals($digitala->resources, 'New resource text');
        $this->assertEquals($digitala->information, 'New information text');
    }

    /**
     * Test deleting a digitala instance.
     */
    public function test_digitala_delete_instance() {
        $result = digitala_delete_instance(0);
        $this->assertEquals($result, false);

        // Get the created digitala course.
        $digitala = $this->create_digitala();

        $result = digitala_delete_instance($digitala->id);

        // Check that the digitala course instance was removed.
        $this->assertEquals($result, true);
    }

    /**
     * Test updating a digitala instance.
     */
    public function test_digitala_update_instance() {
        // Get the created digitala course.
        $digitala = $this->create_digitala();
        $digitala->instance = 2;
        $digitala->resources = array('text' => 'Resource text', 'format' => 1);

        $passed = digitala_update_instance($digitala);

        // Check that the digitala instance update returned true.
        $this->assertEquals(true, $passed);
        $this->assertEquals('Resource text', $digitala->resources);
        $this->assertEquals('Information text', $digitala->information);

        $digitala = $this->create_digitala();
        $digitala->instance = 2;
        $digitala->coursemodule = $digitala->cmid;
        $digitala->resources_editor = array('text' => 'New resource text', 'format' => 1);

        digitala_update_instance($digitala);

        $this->assertEquals('New resource text', $digitala->resources);
        $this->assertEquals('Information text', $digitala->information);

        $digitala = $this->create_digitala();
        $digitala->instance = 2;
        $digitala->coursemodule = $digitala->cmid;
        $digitala->information_editor = array('text' => 'New information text', 'format' => 1);

        digitala_update_instance($digitala);

        $this->assertEquals('Resource text', $digitala->resources);
        $this->assertEquals('New information text', $digitala->information);

        $digitala = $this->create_digitala();
        $digitala->instance = 2;
        $digitala->coursemodule = $digitala->cmid;
        $digitala->resources_editor = array('text' => 'New resource text', 'format' => 1);
        $digitala->information_editor = array('text' => 'New information text', 'format' => 1);

        digitala_update_instance($digitala);

        $this->assertEquals('New resource text', $digitala->resources);
        $this->assertEquals('New information text', $digitala->information);
    }

    /**
     * Test digitala grade item delete dummy function.
     */
    public function test_digitala_grade_item_delete() {
        $digitala = $this->create_digitala();
        $this->assertEquals(null, digitala_grade_item_delete($digitala));
    }

    /**
     * Test digitala update grades dummy function.
     */
    public function test_digitala_update_grades() {
        $digitala = $this->create_digitala();
        $this->assertEquals(null, digitala_update_grades($digitala));
    }

    /**
     * Test digitala file areas dummy function.
     */
    public function test_digitala_get_file_areas() {
        $this->assertEquals(array(), digitala_get_file_areas(null, null, null));
    }

    /**
     * Test digitala get file info dummy function.
     */
    public function test_digitala_get_file_info() {
        $this->assertEquals(null, digitala_get_file_info(null, null, null, null, null, null, null, null, null));
    }

    /**
     * Test digitala get editor options function.
     */
    public function test_digitala_get_editor_options() {
        $result = digitala_get_editor_options(null);

        $this->assertEquals(false, $result['trusttext']);
        $this->assertEquals(true, $result['subdirs']);
        $this->assertEquals(-1, $result['maxfiles']);
        $this->assertEquals(null, $result['context']);
    }
}
