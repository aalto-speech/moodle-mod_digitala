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
 * Prints an instance of mod_digitala.
 *
 * @package     mod_digitala
 * @copyright   2022 Name
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
$content = $OUTPUT->render(new digitala_progress_bar($id, $d, $pagenum));

$config = ['paths' => ['RecordRTC' => '//cdn.jsdelivr.net/npm/recordrtc@5.6.2/RecordRTC',
], 'waitSeconds' => 40, 'enforceDefine' => false];
$requirejs = 'require.config(' . json_encode($config) . ')';
$PAGE->requires->js_amd_inline($requirejs);

$PAGE->requires->js_call_amd('mod_digitala/mic', 'initializeMicrophone', array($pagenum, $id, $USER->id, $USER->username));

// Temporary output of the report we receive. Format could/will change as we do not yet have access to the server.
// @codingStandardsIgnoreStart moodle.Files.LineLength.MaxExceeded
$reportoutput = '{
    "transcription": [
        {"transtext": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."}
    ],
    "grades": [
        {"name": "Completing the task", "grade": 3, "maxgrade": 3, "reporttext": "No significant shortcomings."},
        {"name": "Fluency", "grade": 2, "maxgrade": 4, "reporttext": "Moderately smooth; some breaks, repetitions, and hesitations."},
        {"name": "Pronounciation", "grade": 1, "maxgrade": 4, "reporttext": "Weak, difficult to understand."},
        {"name": "Scope of expression", "grade": 3, "maxgrade": 3, "reporttext": "Narrow."},
        {"name": "Vocabulary and grammar accuracy ", "grade": 4, "maxgrade": 4, "reporttext": "No vocabulary or grammar errors."}
    ]
}';
// @codingStandardsIgnoreEnd moodle.Files.LineLength.MaxExceeded

if ($pagenum == 0) {
    $content .= $OUTPUT->render(new digitala_info($id, $d));
} else if ($pagenum == 1) {
    $content .= $OUTPUT->render(new digitala_assignment($moduleinstance->id, $modulecontext->id, $id, $d,
                                $USER->id, $USER->username, $moduleinstance->assignment, $moduleinstance->resources));
} else {
    $content .= $OUTPUT->render(new digitala_report($id, $d, $reportoutput));
}

echo $OUTPUT->header();

echo $content;

echo $OUTPUT->footer();
