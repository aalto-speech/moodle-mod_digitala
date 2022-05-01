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
 * Prints the appropriate view related page to the user.
 *
 * @package     mod_digitala
 * @author      Alanen, Tuomas; Erkkilä, Joona; Harjunpää, Topi; Heijala, Maikki.
 * @copyright   2022 Helsingin Yliopisto
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__.'/../../config.php');
require_once(__DIR__.'/lib.php');
require_once(__DIR__.'/renderable.php');
require_once(__DIR__.'/answerrecording_form.php');

global $USER;

// Course module id.
$id = optional_param('id', 0, PARAM_INT);

// Activity instance id.
$d = optional_param('d', 0, PARAM_INT);

if ($id) {
    $cm = get_coursemodule_from_id('digitala', $id, 0, false, MUST_EXIST);
    $course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $moduleinstance = $DB->get_record('digitala', array('id' => $cm->instance), '*', MUST_EXIST);
} else {
    $moduleinstance = $DB->get_record('digitala', array('id' => $d), '*', MUST_EXIST);
    $course = $DB->get_record('course', array('id' => $moduleinstance->course), '*', MUST_EXIST);
    $cm = get_coursemodule_from_instance('digitala', $moduleinstance->id, $course->id, false, MUST_EXIST);
}

require_login($course, true, $cm);

$modulecontext = context_module::instance($cm->id);

$event = \mod_digitala\event\course_module_viewed::create(array(
    'objectid' => $moduleinstance->id,
    'context' => $modulecontext
));
$event->add_record_snapshot('course', $course);
$event->add_record_snapshot('digitala', $moduleinstance);
$event->trigger();

$PAGE->set_url('/mod/digitala/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($moduleinstance->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($modulecontext);

$OUTPUT = $PAGE->get_renderer('mod_digitala');

$pagenum = optional_param('page', 0, PARAM_INT);

$content = $OUTPUT->render(new digitala_progress_bar($pagenum));

$config = ['waitSeconds' => 40, 'enforceDefine' => false];
if ($pagenum == 0 || $pagenum == 1) {
    $config['paths'] = ['RecordRTC' => '//cdn.jsdelivr.net/npm/recordrtc@5.6.2/RecordRTC'];
} else if ($pagenum == 2) {
    $config['paths'] = ['chart' => '//cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart'];
}
$requirejs = 'require.config(' . json_encode($config) . ')';
$PAGE->requires->js_amd_inline($requirejs);

if ($pagenum == 0) {
    $PAGE->requires->js_call_amd('mod_digitala/mic', 'initializeMicrophone',
                                array($pagenum, $id, $USER->id, $USER->username, $moduleinstance->maxlength));
    $content .= $OUTPUT->render(new digitala_info());
} else if ($pagenum == 1) {
    $PAGE->requires->js_call_amd('mod_digitala/mic', 'initializeMicrophone',
                                array($pagenum, $id, $USER->id, $USER->username, $moduleinstance->maxlength));
    $content .= $OUTPUT->render(new digitala_assignment($moduleinstance->id, $modulecontext->id, $USER->id, $id,
                                $moduleinstance->assignment, $moduleinstance->resources, $moduleinstance->attempttype,
                                $moduleinstance->attemptlang, $moduleinstance->maxlength, $moduleinstance->attemptlimit));
} else if ($pagenum == 2) {
    $PAGE->requires->js_call_amd('mod_digitala/chart', 'init');
    $content .= $OUTPUT->render(new digitala_report($moduleinstance->id, $modulecontext->id, $id, $moduleinstance->attempttype,
                                $moduleinstance->attemptlang, $moduleinstance->attemptlimit,
                                $moduleinstance->information, $USER->id));
} else {
    $content = get_string('results_denied', 'digitala');
}

echo $OUTPUT->header();

echo $content;

echo $OUTPUT->footer();
