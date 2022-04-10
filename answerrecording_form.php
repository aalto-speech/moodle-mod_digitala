<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * This file contains a custom form for sending a recorded audiofile to Moodle database
 *
 * @package     mod_digitala
 * @copyright   2022 Name
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once("$CFG->libdir/formslib.php");

/**
 * A custom form class for saving an audiofile that extends the moodleform and is used by the digitala module.
 *
 * @package mod_digitala
 * @copyright 2022 Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class answerrecording_form extends moodleform {

    /**
     * Custom constructor for audioform that also renders the file's post url address.
     *
     * @param int $id - activity id
     * @param int $d - course id
     * @param int $pagenum - page number of the activity
     */
    public function __construct($id, $d, $pagenum) {
        $url = '?id=' . $id . '&d=' . $d . '&page=' . $pagenum;
        parent::__construct($url, null, 'post', '', 'id="answerrecording"');
    }

    /**
     * Definition of audioform fields, types and buttons.
     *
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('hidden', 'audiostring', $this->_formname);
        $mform->setType('audiostring', PARAM_RAW);
        $mform->addElement('hidden', 'recordinglength', $this->_formname);
        $mform->setType('recordinglength', PARAM_RAW);

        $mform->addElement('submit', 'submitbutton', get_string('submit', 'digitala'), 'style="display: block;"');
    }
}
