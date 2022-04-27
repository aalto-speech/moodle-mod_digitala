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
 * This file contains renderables for the digitala class
 *
 * @package   mod_digitala
 * @copyright 2022 Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once(__DIR__.'/answerrecording_form.php');

/**
 * A custom renderable class that implements the renderable and is used by the digitala module with the progress bar.
 *
 * @package mod_digitala
 * @copyright 2022 Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class digitala_progress_bar implements renderable {

    /**
     * Constructor
     * @param int $currpage - Current page number
     */
    public function __construct($currpage = 0) {
        $this->currpage = $currpage;
    }
}

/**
 * Implements a renderable info panel used on the first page of the activity.
 *
 * @package mod_digitala
 * @copyright 2022 Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class digitala_info implements renderable {
    /**
     * Constructor
     */
    public function __construct() {
    }
}

/**
 * Implements a renderable assignment panel used on the second page of the activity.
 *
 * @package mod_digitala
 * @copyright 2022 Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class digitala_assignment implements renderable {
    /**
     * Constructor
     * @param int $instanceid - Instance id of the activity
     * @param int $contextid - Context id of the activity
     * @param int $userid - Id of the current active user
     * @param int $id - Id of the activity
     * @param string $assignmenttext - Assignment text for the assignment
     * @param string $resourcetext - Resource text for the assignment
     * @param string $attempttype - Choice if the assignment is a readaloud or freeform type
     * @param string $attemptlang - Choice if the assignment is for fi (Finnish) or sv (Swedish) performance
     * @param int $maxlength - Maximum length of the recording in seconds, 0 = no limit
     * @param int $attemptlimit - Number of attempts that a person can submit
     */
    public function __construct($instanceid, $contextid, $userid, $id, $assignmenttext = '', $resourcetext = '',
                                $attempttype = '', $attemptlang = '', $maxlength = 0, $attemptlimit = 1) {
        $this->instanceid = $instanceid;
        $this->contextid = $contextid;
        $this->id = $id;
        $this->userid = $userid;
        $this->assignmenttext = $assignmenttext;
        $this->resourcetext = $resourcetext;
        $this->attempttype = $attempttype;
        $this->attemptlang = $attemptlang;
        $this->maxlength = $maxlength;
        $this->attemptlimit = $attemptlimit;
        $this->form = new answerrecording_form();
        if ($attempttype == 'readaloud') {
            $this->servertext = format_string($resourcetext);
        } else {
            $this->servertext = format_string($assignmenttext);
        }
    }
}


/**
 * Implements a renderable report panel used on the last page of the activity.
 *
 * @package mod_digitala
 * @copyright 2022 Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class digitala_report implements renderable {
    /**
     * Constructor
     * @param int $instanceid - Instance id of the activity
     * @param int $contextid - Context id of the activity
     * @param int $id - Id of the activity
     * @param string $attempttype - Choice if the assignment is a readaloud or freeform type
     * @param string $attemptlang - Choice if the assignment is for fi (Finnish) or sv (Swedish) performance
     * @param int $attemptlimit - Number of attempts that a person can submit
     * @param int $student - User id of student
     */
    public function __construct($instanceid, $contextid, $id, $attempttype = '', $attemptlang = '',
                                $attemptlimit = 1, $student = null) {
        $this->instanceid = $instanceid;
        $this->contextid = $contextid;
        $this->id = $id;
        $this->attempttype = $attempttype;
        $this->attemptlang = $attemptlang;
        $this->attemptlimit = $attemptlimit;
        $this->student = $student;
    }
}

/**
 * Implements a renderable short version of assignment panel used on the teacher detail report page.
 *
 * @package mod_digitala
 * @copyright 2022 Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class digitala_short_assignment implements renderable {
    /**
     * Constructor
     * @param int $contextid - Context id of the activity
     * @param string $assignmenttext - Assignment text for the assignment
     * @param string $resourcetext - Resource text for the assignment
     * @param string $attempttype - Choice if the assignment is a readaloud or freeform type
     * @param string $attemptlang - Choice if the assignment is for fi (Finnish) or sv (Swedish) performance
     */
    public function __construct($contextid = 0, $assignmenttext = '', $resourcetext = '', $attempttype = '', $attemptlang = '') {
        $this->contextid = $contextid;
        $this->assignmenttext = $assignmenttext;
        $this->resourcetext = $resourcetext;
        $this->attempttype = $attempttype;
        $this->attemptlang = $attemptlang;
    }
}

/**
 * Implements a renderable report panel used on the last page of the activity.
 *
 * @package mod_digitala
 * @copyright 2022 Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class digitala_report_editor implements renderable {
    /**
     * Constructor
     * @param int $instanceid - Instance id of the activity
     * @param int $id - Id of the activity
     * @param string $attempttype - Choice if the assignment is a readaloud or freeform type
     * @param int $student - User id of student
     */
    public function __construct($instanceid, $id, $attempttype = '', $student = null) {
        $this->instanceid = $instanceid;
        $this->id = $id;
        $this->attempttype = $attempttype;
        $this->student = $student;
    }
}

/**
 * Implements a renderable report panel used on the last page of the activity.
 *
 * @package mod_digitala
 * @copyright 2022 Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */
class digitala_results implements renderable {
    /**
     * Constructor
     * @param int $instanceid - Instance id of the activity
     * @param int $id - Id of the activity
     */
    public function __construct($instanceid, $id) {
        $this->instanceid = $instanceid;
        $this->id = $id;
    }
}

/**
 * Implements a renderable report panel used on the last page of the activity.
 *
 * @package mod_digitala
 * @copyright 2022 Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */
class digitala_delete implements renderable {
    /**
     * Constructor
     * @param int $instanceid - Instance id of the activity
     * @param int $contextid - Context id of the activity
     * @param int $id - Id of the activity
     * @param int $studentid - id of student
     */
    public function __construct($instanceid, $contextid, $id, $studentid) {
        $this->instanceid = $instanceid;
        $this->contextid = $contextid;
        $this->id = $id;
        $this->studentid = $studentid;
    }
}
