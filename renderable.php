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
     * @param int $id - Id of the activity
     * @param int $d - Id of the course
     * @param int $currpage - Current page number
     */
    public function __construct($id = 0, $d = 0, $currpage = 0) {
        $this->id = $id;
        $this->d = $d;
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
     * @param int $id - Id of the activity
     * @param int $d - Id of the course
     */
    public function __construct($id = 0, $d = 0, $assignmenttext = '', $resourcetext = '') {
        $this->id = $id;
        $this->d = $d;
        $this->assignmenttext = $assignmenttext;
        $this->resourcetext = $resourcetext;
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

}
