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
 * Unit tests for adding a digitala plugin
 *
 * @package     mod_digitala
 * @category    test
 * @copyright   2022 Name
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../lib/behat/behat_base.php');

class behat_mod_digitala extends behat_base {
    
    /**
     * Convert page names to URLs for steps like 'When I am on the "[page name]" page'.
     *
     * Recognised page names are:
     * | None so far!      |                                                              |
     *
     * @param string $page name of the page, with the component name removed e.g. 'Admin notification'.
     * @return moodle_url the corresponding URL.
     * @throws Exception with a meaningful error message if the specified page cannot be found.
     */
    protected function resolve_page_url(string $page): moodle_url {
        switch (strtolower($page)) {
            default:
                throw new Exception('Unrecognised digitala page type "' . $page . '."');
        }
    }

    /**
     * Convert page names to URLs for steps like 'When I am on the "[identifier]" "[page type]" page'.
     *
     * Recognised page names are:
     * | pagetype          | name meaning                                | description                                  |
     * | View              | Digitala name                               | The digitala info page (view.php)                |
     *
     * @param string $type identifies which type of page this is, e.g. 'Attempt review'.
     * @param string $identifier identifies the particular page, e.g. 'Test quiz > student > Attempt 1'.
     * @return moodle_url the corresponding URL.
     * @throws Exception with a meaningful error message if the specified page cannot be found.
     */
    protected function resolve_page_instance_url(string $type, string $identifier): moodle_url {
        global $DB;

        switch (strtolower($type)) {
            case 'view':
                return new moodle_url('/mod/digitala/view.php',
                        ['id' => $this->get_cm_by_digitala_name($identifier)->id]);
        }
    }

    /**
     * Get a digitala by name.
     *
     * @param string $name digitala name.
     * @return stdClass the corresponding DB row.
     */
    protected function get_digitala_by_name(string $name): stdClass {
        global $DB;
        return $DB->get_record('digitala', array('name' => $name), '*', MUST_EXIST);
    }

    /**
     * Get a digitala cmid from the digitala name.
     *
     * @param string $name digitala name.
     * @return stdClass cm from get_coursemodule_from_instance.
     */
    protected function get_cm_by_digitala_name(string $name): stdClass {
        $quiz = $this->get_digitala_by_name($name);
        return get_coursemodule_from_instance('digitala', $digitala->id, $digitala->course);
    }
}