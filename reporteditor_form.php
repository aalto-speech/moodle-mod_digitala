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
 * This file contains a custom form for editing report in teacher view
 *
 * @package     mod_digitala
 * @copyright   2022 Name
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once("$CFG->libdir/formslib.php");

/**
 * A custom form class for editing report in teacher view that extends the moodleform and is used by the digitala module.
 *
 * @package mod_digitala
 * @copyright 2022 Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class reporteditor_form extends moodleform {

    /**
     * Custom constructor for reporteditor_form.
     *
     * @param int $id - id of this activity
     * @param string $attempttype - type of this attempt
     * @param mixed $attempt - attempt that is being given feedback to
     */
    public function __construct($id, $attempttype, $attempt) {
        $this->attempttype = $attempttype;
        $this->attempt = $attempt;
        $this->id = $id;
        $url = '?id=' . $id . '&student=' . $attempt->userid;
        parent::__construct($url, null, 'post', '', 'id="reporteditor"');
    }

    /**
     * Definition of report_editor form fields, types and buttons.
     *
     */
    public function definition() {
        $mform = $this->_form;
        $attempt = $this->attempt;
        $attempttype = $this->attempttype;

        if ($attempttype == 'freeform') {
            $mform->addElement('float', 'taskachievement', get_string('taskachievement', 'mod_digitala'));
            $mform->addElement('textarea', 'taskachievementreason', get_string('taskachievement-reason', 'digitala'),
                               'rows="5" cols="50"');
            $mform->addElement('float', 'fluency', get_string('fluency', 'mod_digitala'));
            $mform->addElement('textarea', 'fluencyreason', get_string('fluency-reason', 'digitala'), 'rows="5" cols="50"');
            $mform->addElement('float', 'nativeity', get_string('pronunciation', 'mod_digitala'));
            $mform->addElement('textarea', 'nativeityreason', get_string('pronunciation-reason', 'digitala'), 'rows="5" cols="50"');
            $mform->addElement('float', 'lexicalprofile', get_string('range', 'mod_digitala'));
            $mform->addElement('textarea', 'lexicalprofilereason',
                               get_string('range-reason', 'digitala'), 'rows="5" cols="50"');
            $mform->addElement('float', 'holistic', get_string('holistic', 'mod_digitala'));
            $mform->addElement('textarea', 'holisticreason', get_string('holistic-reason', 'digitala'), 'rows="5" cols="50"');

            $mform->getElement('taskachievement')->setValue($attempt->taskachievement);
            $mform->getElement('fluency')->setValue($attempt->fluency);
            $mform->getElement('nativeity')->setValue($attempt->nativeity);
            $mform->getElement('lexicalprofile')->setValue($attempt->lexicalprofile);
            $mform->getElement('holistic')->setValue($attempt->holistic);
        } else if ($attempttype == 'readaloud') {
            $mform->addElement('float', 'gop', get_string('gop', 'mod_digitala'));
            $mform->addElement('textarea', 'gopreason', get_string('gop-reason', 'digitala'), 'rows="5" cols="50"');

            $mform->getElement('gop')->setValue($attempt->gop_score);
        }
        $this->add_action_buttons();
    }

    /**
     * Validates all evaluation fields are in correct scale
     *
     * @param mixed $fromform - Values coming from form
     * @param mixed $files - Files (are there any coming?!) coming from form
     */
    public function validation($fromform, $files) {
        $errors = parent::validation($fromform, $files);

        $attempttype = $this->attempttype;

        if ($attempttype == 'freeform') {
            if ($fromform['holistic'] < 0 || $fromform['holistic'] > 7) {
                $errors['holistic'] = get_string('holistic-scale_error', 'digitala');
            }
            if ($fromform['taskachievement'] < 0 || $fromform['taskachievement'] > 3) {
                $errors['taskachievement'] = get_string('taskachievement-scale_error', 'digitala');
            }
            if ($fromform['fluency'] < 0 || $fromform['fluency'] > 3) {
                $errors['fluency'] = get_string('fluency-scale_error', 'digitala');
            }
            if ($fromform['nativeity'] < 0 || $fromform['nativeity'] > 3) {
                $errors['nativeity'] = get_string('nativeity-scale_error', 'digitala');
            }
            if ($fromform['lexicalprofile'] < 0 || $fromform['lexicalprofile'] > 3) {
                $errors['lexicalprofile'] = get_string('lexicalprofile-scale_error', 'digitala');
            }
        } else if ($attempttype == 'readaloud') {
            if ($fromform['gop'] < 0 || $fromform['gop'] > 1) {
                $errors['gop'] = get_string('gop-scale_error', 'digitala');
            }
        }

        return $errors;
    }
}
