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
 * @group       mod_digitala
 * @package     mod_digitala
 * @category    test
 * @copyright   2022 Name
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class microphone_test extends \advanced_testcase {

    /**
     * Test creating new assignment object.
     */
    public function test_create_button() {
        $result = create_button('buttonId', 'buttonClass', 'buttonText');
        $this->assertEquals('<button id="buttonId" class="buttonClass">buttonText</button>', $result);
    }

    public function test_create_microphone() {
        $result = create_microphone('testmic');
        $this->assertEquals('<br></br><button id="record" class="btn btn-primary record-btn">Start</button>'.
            '<button id="stopRecord" class="btn btn-primary stopRecord-btn">Stop</button><button id="listenButton" '.
            'class="btn btn-primary listen-btn">Listen recording</button>', $result);
    }

}
