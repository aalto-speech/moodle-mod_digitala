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
 * The main mod_digitala configuration form.
 *
 * @package     mod_digitala
 * @copyright   2022 Name
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once('lib.php');

/**
 * Module instance settings form.
 *
 * @package     mod_digitala
 * @copyright   2022 Name
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_digitala_mod_form extends moodleform_mod {

    /**
     * Defines forms elements
     */
    public function definition() {
        global $CFG;

        $mform = $this->_form;
        $id = empty($this->current->id) ? null : 0;
        $this->current = file_prepare_standard_editor($this->current, 'resources', digitala_get_editor_options($this->context),
                                                      $this->context, 'mod_digitala', 'files', $id);

        // Adding the "general" fieldset, where all the common settings are shown.
        $mform->addElement('header', 'general', get_string('general', 'form'));

        // Adding the standard "name" field.
        $mform->addElement('text', 'name', get_string('assignmentname', 'mod_digitala'), array('size' => '64'));

        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }

        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'assignmentname', 'mod_digitala');

        // Adding the "attemptlang" field. Tells what language info we send with the audio file.
        $langoptions = array(
                'fi' => get_string('fi', 'mod_digitala'),
                'sv' => get_string('sv', 'mod_digitala'),
        );
        $mform->addElement('select', 'attemptlang', get_string('attemptlang', 'mod_digitala'), $langoptions);
        $mform->addHelpButton('attemptlang', 'attemptlang', 'mod_digitala');

        // Adding the "attempttype" field. Tells what task type we send with the audio file.
        $typeoptions = array(
                'readaloud' => get_string('readaloud', 'mod_digitala'),
                'freeform' => get_string('freeform', 'mod_digitala'),
        );
        $mform->addElement('select', 'attempttype', get_string('attempttype', 'mod_digitala'), $typeoptions);
        $mform->addHelpButton('attempttype', 'attempttype', 'mod_digitala');

        // Adding the "maxlength" field for assignment timelimit.
        $mform->addElement('duration', 'maxlength', get_string('timelimit', 'mod_digitala'),
                array('optional' => false, 'units' => array(1, MINSECS)));

        // Adding the "attemptnumber" field.
        $limitoptions = array(
            0 => get_string('unlimited', 'mod_digitala'),
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8,
            9 => 9,
            10 => 10
        );
        $mform->addElement('select', 'attemptlimit', get_string('attemptlimit', 'mod_digitala'), $limitoptions);

        $mform->addRule('attemptlimit', null, 'required', null, 'client');
        $mform->addHelpButton('attemptlimit', 'attemptlimit', 'mod_digitala');

        // Adding the "assignment" field.
        $mform->addElement('textarea', 'assignment', get_string('assignment', 'mod_digitala'),
                array('rows' => 10, 'cols' => '64'));

        $mform->setType('assignment', PARAM_TEXT);
        $mform->addRule('assignment', null, 'required', null, 'client');
        $mform->addHelpButton('assignment', 'assignment', 'mod_digitala');

        // Adding the "resources_editor" field.
        $mform->addElement('editor', 'resources_editor', get_string('assignmentresource', 'mod_digitala'),
                           array('rows' => 10), digitala_get_editor_options($this->context));

        $mform->setType('resources_editor', PARAM_RAW);
        $mform->addHelpButton('resources_editor', 'assignmentresource', 'mod_digitala');

        // Adding the standard "intro" and "introformat" fields.
        if ($CFG->branch >= 29) {
            $this->standard_intro_elements();
        } else {
            $this->add_intro_editor();
        }

        // Add standard grading elements.
        $this->standard_grading_coursemodule_elements();

        // Add standard elements.
        $this->standard_coursemodule_elements();

        // Add standard buttons.
        $this->add_action_buttons();
    }

    /**
     * Any data processing needed before the form is displayed
     * @param array $defaultvalues
     */
    public function data_preprocessing(&$defaultvalues) {
        if (isset($defaultvalues['resources']) && !empty($defaultvalues['resources'])) {
            $defaultvalues['resources'] = file_rewrite_pluginfile_urls($defaultvalues['resources'], 'pluginfile.php',
                                                                       $this->context->id, 'mod_digitala', 'files', 0);
        }
    }

    /**
     * Validates the data processed by the form.
     *
     * @param mixed $data
     * @param array $files
     * @return array
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        if (isset($data['maxlength'])) {
            if ($data['maxlength'] > 300) {
                $len = $data['maxlength'] / 60;
                if ($len > 300) {
                    $errors['maxlength'] = get_string('maxlength_error', 'digitala');
                }
                $errors['maxlength'] = get_string('maxlength_error', 'digitala');
            }
        }
        return $errors;
    }
}
