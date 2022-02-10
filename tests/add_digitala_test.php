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
 * @package     mod_digitala
 * @category    test
 * @copyright   2022 Name
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class add_digitala_test extends \advanced_testcase {

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
     * Test adding digitala plugin.
     */
    public function test_add_digitala() {
        $digitala = $this->create_digitala();
        $this->assertEquals('new_digitala', $digitala->name);
    }

    /**
     * Create new digitala activity.
     */
    private function create_digitala() {
        $course = $this->course;
        return $this->getDataGenerator()->create_module('digitala', [
                'course' => $course->id,
                'name' => 'new_digitala'
        ]);
    }
}
