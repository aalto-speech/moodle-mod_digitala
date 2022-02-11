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

// Temporary text fields for assignment waiting for teacher edit capability!
$assignmenttext = "<p>Tell me about Rick's lyfe.</p>";
$resourcetext = '<iframe width="100%" src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
    title="YouTube video player" frameborder="0" allow="accelerometer; 
    autoplay; clipboard-write; encrypted-media; gyroscope; 
    picture-in-picture" allowfullscreen></iframe>
    <p>Lyrics should be here?!<br><img width="100%" 
    src="https://images.pexels.com/photos/730896/pexels-photo-730896.jpeg
    ?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"></img></p>';

if ($pagenum == 0) {
    $content .= $OUTPUT->render(new digitala_info());
} else if ($pagenum == 1) {
    $content .= $OUTPUT->render(new digitala_assignment($id, $d, $assignmenttext, $resourcetext));
} else {
    $content .= $OUTPUT->render(new digitala_report());
}

echo $OUTPUT->header();

echo $content;

echo $OUTPUT->footer();
