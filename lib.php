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
 * Library of interface functions and constants.
 *
 * @package     mod_digitala
 * @author      Alanen, Tuomas; Erkkilä, Joona; Harjunpää, Topi; Heijala, Maikki.
 * @copyright   2022 Helsingin Yliopisto
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Return if the plugin supports $feature.
 *
 * @param string $feature Constant representing the feature.
 * @return mixed - True if the feature is supported, null otherwise.
 */
function digitala_supports($feature) {
    switch ($feature) {
        case FEATURE_GRADE_HAS_GRADE:
            return true;
        case FEATURE_MOD_INTRO:
            return true;
        default:
            return null;
    }
}

/**
 * Saves a new instance of the mod_digitala into the database.
 *
 * Given an object containing all the necessary data, (defined by the form
 * in mod_form.php) this function will create a new instance and return the id
 * number of the instance.
 *
 * @param object $moduleinstance An object from the form.
 * @param mod_digitala_mod_form $mform The form.
 * @return int The id of the newly inserted record.
 */
function digitala_add_instance($moduleinstance, $mform = null) {
    global $DB;

    $moduleinstance->timecreated = time();

    if (!empty($moduleinstance->resources_editor)) {
        $context = context_module::instance($moduleinstance->coursemodule);
        $moduleinstance = file_postupdate_standard_editor($moduleinstance, 'resources', digitala_get_editor_options($context),
                                                          $context, 'mod_digitala', 'files', 0);
    } else if (gettype($moduleinstance->resources) == 'array') {
        $moduleinstance->resourcesformat = $moduleinstance->resources['format'];
        $moduleinstance->resources = $moduleinstance->resources['text'];
    }

    if (!empty($moduleinstance->information_editor)) {
        if (!isset($context)) {
            $context = context_module::instance($moduleinstance->coursemodule);
        }
        $moduleinstance = file_postupdate_standard_editor($moduleinstance, 'information', digitala_get_editor_options($context),
                                                          $context, 'mod_digitala', 'info', 0);
    } else if (gettype($moduleinstance->information) == 'array') {
        $moduleinstance->informationformat = $moduleinstance->information['format'];
        $moduleinstance->information = $moduleinstance->information['text'];
    }

    $id = $DB->insert_record('digitala', $moduleinstance);

    return $id;
}

/**
 * Updates an instance of the mod_digitala in the database.
 *
 * Given an object containing all the necessary data (defined in mod_form.php),
 * this function will update an existing instance with new data.
 *
 * @param object $moduleinstance An object from the form in mod_form.php.
 * @param mod_digitala_mod_form $mform The form.
 * @return bool True if successful, false otherwise.
 */
function digitala_update_instance($moduleinstance, $mform = null) {
    global $DB;

    $moduleinstance->id = $moduleinstance->instance;
    $moduleinstance->timemodified = time();

    if (!empty($moduleinstance->resources_editor)) {
        $context = context_module::instance($moduleinstance->coursemodule);
        $moduleinstance = file_postupdate_standard_editor($moduleinstance, 'resources', digitala_get_editor_options($context),
                                                          $context, 'mod_digitala', 'files', 0);
    } else if (gettype($moduleinstance->resources) == 'array') {
        $moduleinstance->resourcesformat = $moduleinstance->resources['format'];
        $moduleinstance->resources = $moduleinstance->resources['text'];
    }

    if (!empty($moduleinstance->information_editor)) {
        if (!isset($context)) {
            $context = context_module::instance($moduleinstance->coursemodule);
        }
        $moduleinstance = file_postupdate_standard_editor($moduleinstance, 'information', digitala_get_editor_options($context),
                                                          $context, 'mod_digitala', 'info', 0);
    } else if (gettype($moduleinstance->information) == 'array') {
        $moduleinstance->informationformat = $moduleinstance->information['format'];
        $moduleinstance->information = $moduleinstance->information['text'];
    }

    return $DB->update_record('digitala', $moduleinstance);
}

/**
 * Removes an instance of the mod_digitala from the database.
 *
 * @param int $id Id of the module instance.
 * @return bool True if successful, false on failure.
 */
function digitala_delete_instance($id) {
    require_once(__DIR__ . '/locallib.php');
    global $DB;

    $moduleinstance = $DB->get_record('digitala', array('id' => $id));
    if (!$moduleinstance) {
        return false;
    }

    $course = $DB->get_record('course', array('id' => $moduleinstance->course), '*', MUST_EXIST);
    $cm = get_coursemodule_from_instance('digitala', $moduleinstance->id, $course->id, false, MUST_EXIST);
    $context = context_module::instance($cm->id);
    delete_all_attempts($id, $context->id);

    $DB->delete_records('digitala', array('id' => $id));

    return true;
}

/**
 * Is a given scale used by the instance of mod_digitala?
 *
 * This function returns if a scale is being used by one mod_digitala
 * if it has support for grading and scales.
 *
 * @param int $moduleinstanceid ID of an instance of this module.
 * @param int $scaleid ID of the scale.
 * @return bool True if the scale is used by the given mod_digitala instance.
 */
function digitala_scale_used($moduleinstanceid, $scaleid) {
    global $DB;

    if ($scaleid && $DB->record_exists('digitala', array('id' => $moduleinstanceid, 'grade' => -$scaleid))) {
        return true;
    } else {
        return false;
    }
}

/**
 * Checks if scale is being used by any instance of mod_digitala.
 *
 * This is used to find out if scale used anywhere.
 *
 * @param int $scaleid ID of the scale.
 * @return bool True if the scale is used by any mod_digitala instance.
 */
function digitala_scale_used_anywhere($scaleid) {
    global $DB;

    if ($scaleid and $DB->record_exists('digitala', array('grade' => -$scaleid))) {
        return true;
    } else {
        return false;
    }
}

/**
 * Creates or updates grade item for the given mod_digitala instance.
 *
 * Needed by {@see grade_update_mod_grades()}.
 *
 * @param stdClass $moduleinstance Instance object with extra cmidnumber and modname property.
 * @param bool $reset Reset grades in the gradebook.
 * @return void.
 */
function digitala_grade_item_update($moduleinstance, $reset=false) {
    global $CFG;
    require_once($CFG->libdir.'/gradelib.php');

    $item = array();
    $item['itemname'] = clean_param($moduleinstance->name, PARAM_NOTAGS);
    $item['gradetype'] = GRADE_TYPE_VALUE;

    if ($moduleinstance->grade > 0) {
        $item['gradetype'] = GRADE_TYPE_VALUE;
        $item['grademax']  = $moduleinstance->grade;
        $item['grademin']  = 0;
    } else if ($moduleinstance->grade < 0) {
        $item['gradetype'] = GRADE_TYPE_SCALE;
        $item['scaleid']   = -$moduleinstance->grade;
    } else {
        $item['gradetype'] = GRADE_TYPE_NONE;
    }
    if ($reset) {
        $item['reset'] = true;
    }

    grade_update('/mod/digitala', $moduleinstance->course, 'mod', 'mod_digitala', $moduleinstance->id, 0, null, $item);
}

/**
 * Delete grade item for given mod_digitala instance.
 *
 * @param stdClass $moduleinstance Instance object.
 * @return grade_item.
 */
function digitala_grade_item_delete($moduleinstance) {
    global $CFG;
    require_once($CFG->libdir.'/gradelib.php');

    return grade_update('/mod/digitala', $moduleinstance->course, 'mod', 'digitala',
                        $moduleinstance->id, 0, null, array('deleted' => 1));
}

/**
 * Update mod_digitala grades in the gradebook.
 *
 * Needed by {@see grade_update_mod_grades()}.
 *
 * @param stdClass $moduleinstance Instance object with extra cmidnumber and modname property.
 * @param int $userid Update grade of specific user only, 0 means all participants.
 */
function digitala_update_grades($moduleinstance, $userid = 0) {
    global $CFG, $DB;
    require_once($CFG->libdir.'/gradelib.php');

    // Populate array of grade objects indexed by userid.
    $grades = array();
    grade_update('/mod/digitala', $moduleinstance->course, 'mod', 'mod_digitala', $moduleinstance->id, 0, $grades);
}

/**
 * Returns the lists of all browsable file areas within the given module context.
 *
 * The file area 'intro' for the activity introduction field is added automatically
 * by {@see file_browser::get_file_info_context_module()}.
 *
 * @package     mod_digitala
 * @category    files
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param stdClass $context
 * @return array
 */
function digitala_get_file_areas($course, $cm, $context) {
    return array('recordings', 'files', 'info');
}

/**
 * File browsing support for mod_digitala file areas.
 *
 * @package     mod_digitala
 * @category    files
 *
 * @param file_browser $browser
 * @param array $areas
 * @param stdClass $course
 * @param stdClass $cm
 * @param stdClass $context
 * @param string $filearea
 * @param int $itemid
 * @param string $filepath
 * @param string $filename
 * @return file_info Instance or null if not found.
 */
function digitala_get_file_info($browser, $areas, $course, $cm, $context, $filearea, $itemid, $filepath, $filename) {
    return null;
}

/**
 * Serves the files from the mod_digitala file areas.
 *
 * @package     mod_digitala
 * @category    files
 *
 * @param stdClass $course The course object.
 * @param stdClass $cm The course module object.
 * @param stdClass $context The mod_digitala's context.
 * @param string $filearea The name of the file area.
 * @param array $args Extra arguments (itemid, path).
 * @param bool $forcedownload Whether or not force download.
 * @param array $options Additional options affecting the file serving.
 */
function digitala_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, $options = array()) {
    global $USER;
    if ($context->contextlevel != CONTEXT_MODULE) {
        return false;
    }

    if (!in_array($filearea, digitala_get_file_areas($course, $cm, $context))) {
        return false;
    }

    require_login($course, true, $cm);

    $itemid = array_shift($args);

    $filename = array_pop($args);
    if (!$args) {
        $filepath = '/';
    } else {
        $filepath = '/'.implode('/', $args).'/';
    }

    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'mod_digitala', $filearea, $itemid, $filepath, $filename);
    if (!$file) {
        return false;
    }

    if ($filearea == 'recordings') {
        if (has_capability('mod/digitala:viewdetailreport', $context)) {
            send_stored_file($file, 86400, 0, $forcedownload, $options);
            return;
        } else if ($USER->id == $file->get_userid()) {
            send_stored_file($file, 86400, 0, $forcedownload, $options);
            return;
        } else {
            return false;
        }
    } else {
        send_stored_file($file, 86400, 0, $forcedownload, $options);
    }
}

/**
 * Extends the global navigation tree by adding mod_digitala nodes if there is a relevant content.
 *
 * This can be called by an AJAX request so do not rely on $PAGE as it might not be set up properly.
 *
 * @param navigation_node $digitalanode An object representing the navigation tree node.
 * @param stdClass $course
 * @param stdClass $module
 * @param cm_info $cm
 */
function digitala_extend_navigation($digitalanode, $course, $module, $cm) {
}

/**
 * Extends the settings navigation with the mod_digitala settings.
 *
 * This function is called when the context for the page is a mod_digitala module.
 * This is not called by AJAX so it is safe to rely on the $PAGE.
 *
 * @param settings_navigation $settingsnav {@see settings_navigation}
 * @param navigation_node $digitalanode {@see navigation_node}
 */
function digitala_extend_settings_navigation($settingsnav, $digitalanode) {
    global $PAGE;

    $context = $PAGE->cm->context;

    $id = $PAGE->cm->id;

    if (has_capability('mod/digitala:viewdetailreport', $context)) {
        $digitalanode->add(get_string('results_view', 'digitala'),
        new moodle_url('/mod/digitala/report.php', array('id' => $id, 'mode' => 'overview')),
        settings_navigation::TYPE_CUSTOM,
        null, null);
    }
}

/**
 * Returns editor options for resource field
 *
 * @param stdClass $context context object
 * @return array array containing editor options
 */
function digitala_get_editor_options($context) {
    global $CFG;

    return array('trusttext' => false, 'subdirs' => true, 'maxfiles' => -1, 'maxbytes' => $CFG->maxbytes,
                 'context' => $context, 'changeformat' => true, 'noclean' => true);
}
