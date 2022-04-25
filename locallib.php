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
 * Library of functions used by the digitala module.
 *
 * @package     mod_digitala
 * @copyright   2022 Name
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/csvlib.class.php');

/**
 * Used to generate page urls for digitala module student views.
 *
 * @param number $page number of the step
 * @param number $id id of the course module
 * @param number $d id of the activity instance
 */
function page_url($page, $id, $d) {
    return new moodle_url('/mod/digitala/view.php', array('id' => $id, 'd' => $d, 'page' => $page));
}

/**
 * Used to generate page urls for digitala module teacher results views.
 *
 * @param number $id id of the activity instance
 * @param string $mode value to render all results on table or one spesific report
 * @param number $studentid id of the student whose results tescher wants to see
 */
function results_url($id, $mode, $studentid=null) {
    return new moodle_url('/mod/digitala/report.php', array('id' => $id, 'mode' => $mode, 'student' => $studentid));
}

/**
 * Used to generate page urls for deleting attempts.
 *
 * @param number $id id of the activity instance
 * @param number $studentid id of the student whose results tescher wants to see
 */
function delete_url($id, $studentid=null) {
    return new moodle_url('/mod/digitala/report.php', array('id' => $id, 'mode' => 'delete', 'student' => $studentid));
}

/**
 * Used to generate page urls for exporting attempts.
 *
 * @param number $id id of the activity instance
 * @param number $mode mode of export
 */
function export_url($id, $mode) {
    return new moodle_url('/mod/digitala/export.php', array('id' => $id, 'mode' => $mode));
}

/**
 * Used to generate links in the steps of the progress bar.
 *
 * @param string $name name of the step
 * @param number $page number of the step
 * @param number $id id of the course module
 * @param number $d id of the activity instance
 * @param bool $iscurrent true if page is currently active
 */
function create_progress_bar_step_link($name, $page, $id, $d, $iscurrent) {
    $url = page_url($page, $id, $d);
    $pageout = $page + 1;
    $name = get_string($name, 'digitala');
    if ($iscurrent) {
        $title = '<span class="pb-num active">'.$pageout.'</span>'.
                 '<span class="pb-phase-name">'.$name.'</span>';
    } else {
        $title = '<span class="pb-num">'.$pageout.'</span>'.
                 '<span class="pb-phase-name">'.$name.'</span>';
    }
    $out = html_writer::link($url, $title, array('class' => 'display-6'));
    return $out;
}

/**
 * Used to begin creation of the progress bar.
 */
function start_progress_bar() {
    $out = html_writer::start_div('digitala-progress-bar');
    return $out;
}

/**
 * Used to end creation of the progress bar.
 */
function end_progress_bar() {
    $out = html_writer::end_div();
    return $out;
}

/**
 * Used to create one step of the progress bar.
 *
 * @param string $name name of the step as lang API compatible id
 * @param number $page number of the step
 * @param number $id id of the course module
 * @param number $d id of the activity instance
 * @param number $currentpage number of the active page
 */
function create_progress_bar_step($name, $page, $id, $d, $currentpage) {
    $classes = 'pb-step';
    $iscurrent = $page == $currentpage;
    if ($iscurrent) {
        $classes .= ' active';
    }
    if ($page == 0) {
        $classes .= ' first';
    }
    if ($page == 2) {
        $classes .= ' last';
    }

    $out = html_writer::start_div($classes);
    $out .= create_progress_bar_step_link($name, $page, $id, $d, $iscurrent);
    $out .= html_writer::end_div();
    return $out;
}

/**
 * Helper function that is used to calculate if highlight color is needed in the spacer.
 *
 * @param number $page number of the page
 */
function calculate_progress_bar_spacers($page) {
    if ($page == 0) {
        return array('left' => 'right-empty', 'right' => 'nothing');
    } else if ($page == 1) {
        return array('left' => 'left-empty', 'right' => 'right-empty');
    } else {
        return array('left' => 'nothing', 'right' => 'left-empty');
    }
}

/**
 * Used to create spacer between steps in the progress bar.
 *
 * @param string $mode defines if extra filling needed in the spacer.
 * Knows values 'right-empty' and 'left-empty'. Other strings gives no extra filling.
 */
function create_progress_bar_spacer($mode) {
    if ($mode == 'left-empty') {
        $out = html_writer::start_div('pb-spacer pb-spacer-left');
        $class = "pb-svg-back";
    } else if ($mode == 'right-empty') {
        $out = html_writer::start_div('pb-spacer pb-spacer-right');
        $class = "pb-svg-front";
    } else {
        $out = html_writer::start_div('pb-spacer');
        $class = "pb-svg-front";
    }
    $out .= '<svg class="'.$class.'" viewBox="0 0 275 500"
    style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;">';

    if ($mode == 'left-empty') {
        $out .= '<path d="M275,0L20,0L255,250L20,500L275,500L275,0Z" style="fill:rgb(211,211,211);"/>';
    }

    if ($mode == 'right-empty') {
        $out .= '<path d="M255,250L20,0L0,0L0,500L20,500L255,250Z" style="fill:rgb(211,211,211);"/>';
    }
    $out .= '<path d="M20,20L255,250L20,480" style="fill:none;stroke:rgb(211,211,211);stroke-width:40px;"/>';
    $out .= '</svg>';
    $out .= html_writer::end_div();
    return $out;
}

/**
 * Used to create step content container.
 *
 * @param string $classname steps classname for css styling
 */
function start_container($classname) {
    $out = html_writer::start_div($classname . ' digitala-container');
    $out .= html_writer::start_div('container');
    $out .= html_writer::start_div('row');
    return $out;
}

/**
 * Used to close step content container
 */
function end_container() {
    $out = html_writer::end_div();
    $out .= html_writer::end_div();
    $out .= html_writer::end_div();
    return $out;
}

/**
 * Used to create column inside content container
 * @param string $size - width of the container, defaults to auto
 */
function start_column($size='') {
    $out = html_writer::start_div('col'.$size.' digitala-column');
    return $out;
}

/**
 * Used to close column
 */
function end_column() {
    $out = html_writer::end_div();
    return $out;
}

/**
 * Used to create content card inside content container column
 *
 * @param string $header text for card's header as lang file string name
 * @param string $text content for the card as html
 */
function create_card($header, $text) {
    $out = html_writer::start_div('card row digitala-card');
    $out .= html_writer::start_div('card-body');

    $out .= html_writer::tag('h5', get_string($header, 'digitala'), array('class' => 'card-title'));
    $out .= html_writer::div($text, 'card-text');

    $out .= html_writer::end_div();
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Used to create text inside assignment card - helper function for box sizing
 *
 * @param string $content text inside assignment text card
 */
function create_assignment($content) {
    $out = html_writer::div($content, 'card-text scrollbox200');

    return $out;
}

/**
 * Used to create text inside resource card - helper function for box sizing
 *
 * @param digitala_assignment $assignment - assignment includes resource text
 */
function create_resource($assignment) {
    $resources = file_rewrite_pluginfile_urls($assignment->resourcetext, 'pluginfile.php', $assignment->contextid,
                                              'mod_digitala', 'files', 0);
    $out = html_writer::div($resources, 'card-text scrollbox400');

    return $out;
}

/**
 * Creates grading information container from report
 *
 * @param string $name name of the grading
 * @param int $grade grading number given by the server
 * @param int $maxgrade maximum number of this grade
 * @param int $feedbackgrade grade given manually by the teacher
 * @param string $feedbackreason reason for the grade change
 */
function create_report_grading($name, $grade, $maxgrade, $feedbackgrade = null, $feedbackreason = null) {
    $out = html_writer::start_div('card row digitala-card');
    $out .= html_writer::start_div('card-body');

    $out .= html_writer::tag('h5', get_string($name, 'digitala'), array('class' => 'card-title'));

    $out .= create_chart($name, $grade, $maxgrade);
    $out .= html_writer::tag('h6', floor($grade) . '/' . $maxgrade, array('class' => 'grade-number'));

    $out .= html_writer::start_div('card-text');
    $out .= html_writer::tag('p', get_string($name.'_description', 'digitala').
                                  lcfirst(get_string($name.'_score-' . floor($grade), 'digitala')));

    if (isset($feedbackgrade) && $grade != $feedbackgrade) {
        $out .= html_writer::tag('p', get_string('teachergrade', 'digitala').$feedbackgrade);
    }
    if (isset($feedbackreason) && !empty($feedbackreason)) {
        $out .= html_writer::tag('p', get_string('teacherreason', 'digitala').$feedbackreason);
    }

    $out .= html_writer::end_div();
    $out .= html_writer::end_div();
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Creates holistic information container from report
 *
 * @param int $grade grading number given by the server
 * @param mixed $feedback information given by the teacher
 */
function create_report_holistic($grade, $feedback = null) {
    $out = html_writer::start_div('card row digitala-card');
    $out .= html_writer::start_div('card-body');

    $out .= html_writer::tag('h5', get_string('holistic', 'digitala'), array('class' => 'card-title'));

    $out .= create_chart('holistic', $grade, 6);
    $out .= html_writer::tag('h6', get_string('holistic_level-'.$grade, 'digitala'), array('class' => 'grade-number'));

    $out .= html_writer::start_div('card-text');
    $out .= html_writer::tag('p', get_string('holistic_description', 'digitala').
                                  get_string('holistic_level-'.$grade, 'digitala').
                                  ':<br>'.get_string('holistic_score-'.$grade, 'digitala'));

    if (isset($feedback)) {
        if ($grade != $feedback->holistic) {
            $out .= html_writer::tag('p', get_string('teachergrade', 'digitala').$feedback->holistic);
        }
        if (!empty($feedback->holistic_reason)) {
            $out .= html_writer::tag('p', get_string('teacherreason', 'digitala').$feedback->holistic_reason);
        }
    }

    $out .= html_writer::end_div();
    $out .= html_writer::end_div();
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Creates more information container from report
 */
function create_report_waiting() {
    $out = html_writer::start_div('card row digitala-card');
    $out .= html_writer::start_div('card-body');

    $out .= html_writer::tag('h5', get_string('results_waiting-title', 'digitala'), array('class' => 'card-title'));

    $out .= html_writer::start_div('card-text');

    $out .= html_writer::start_div('spinner-border text-primary', array('role' => 'status'));
    $out .= html_writer::tag('span', get_string('results_waiting-loading', 'digitala'), array('class' => 'sr-only'));
    $out .= html_writer::end_div();

    $out .= html_writer::tag('p', get_string('results_waiting-info', 'digitala'));
    $out .= html_writer::tag('a', get_string('results_waiting-refresh', 'digitala'),
                             array('id' => 'nextButton', 'class' => 'btn btn-primary', 'href' => $_SERVER['REQUEST_URI']));
    $out .= html_writer::end_div();

    $out .= html_writer::end_div();
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Creates more information container from report
 */
function create_report_retry() {
    $out = html_writer::start_div('card row digitala-card');
    $out .= html_writer::start_div('card-body');

    $out .= html_writer::tag('h5', get_string('results_retry-title', 'digitala'), array('class' => 'card-title'));

    $out .= html_writer::start_div('card-text');

    $out .= html_writer::start_div('spinner-border text-primary', array('role' => 'status'));
    $out .= html_writer::tag('span', get_string('results_waiting-loading', 'digitala'), array('class' => 'sr-only'));
    $out .= html_writer::end_div();

    $out .= html_writer::tag('p', get_string('results_retry-info', 'digitala'));
    $out .= html_writer::end_div();

    $out .= html_writer::end_div();
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Creates more information container from report
 *
 * @param digitala_report $report report object containing information
 */
function create_report_information($report) {
    $out = html_writer::start_div('card row digitala-card');
    $out .= html_writer::start_div('card-body');

    $out .= html_writer::tag('h5', get_string('moreinformation', 'digitala'), array('class' => 'card-title'));

    $text = file_rewrite_pluginfile_urls($report->informationtext, 'pluginfile.php', $report->contextid,
                                         'mod_digitala', 'info', 0);
    $out .= html_writer::div($text, 'card-text');

    $out .= html_writer::end_div();
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Creates transcription container from report
 *
 * @param mixed $transcription object containing the transcription part of report
 */
function create_report_transcription($transcription) {
    $out = html_writer::start_div('card row digitala-card');
    $out .= html_writer::start_div('card-body');

    $out .= html_writer::tag('h5', get_string('transcription', 'digitala'), array('class' => 'card-title'));

    $out .= html_writer::div($transcription, 'card-text scrollbox200');

    $out .= html_writer::end_div();
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Creates feedback container from report
 *
 * @param mixed $feedback object containing the feedback part of report
 */
function create_report_feedback($feedback) {
    $out = html_writer::start_div('card row digitala-card');
    $out .= html_writer::start_div('card-body');

    $out .= html_writer::tag('h5', get_string('server-feedback', 'digitala'), array('class' => 'card-title'));

    $out .= html_writer::div($feedback, 'card-text scrollbox200');

    $out .= html_writer::end_div();
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Creates tab navigation and contents for report view
 *
 * @param string $gradings html content of gradings shown
 * @param string $holistic html content of holistic shown
 * @param string $information html content of more information shown
 */
function create_report_tabs($gradings, $holistic, $information) {
    $out = html_writer::start_tag('nav');
    $out .= html_writer::start_div('nav nav-tabs digitala-tabs', array('id' => 'nav-tab', 'role' => 'tablist'));
    $out .= html_writer::tag('button', get_string('task_grades', 'digitala'),
                             array('class' => 'nav-link active ml-2', 'id' => 'report-grades-tab', 'data-toggle' => 'tab',
                                   'href' => '#report-grades', 'role' => 'tab', 'aria-controls' => 'report-grades',
                                   'aria-selected' => 'true'));
    $out .= html_writer::tag('button', get_string('holistic', 'digitala'),
                             array('class' => 'nav-link ml-2', 'id' => 'report-holistic-tab', 'data-toggle' => 'tab',
                                   'href' => '#report-holistic', 'role' => 'tab', 'aria-controls' => 'report-holistic',
                                   'aria-selected' => 'false'));
    $out .= html_writer::tag('button', get_string('moreinformation', 'digitala'),
                             array('class' => 'nav-link ml-2', 'id' => 'report-information-tab', 'data-toggle' => 'tab',
                                   'href' => '#report-information', 'role' => 'tab', 'aria-controls' => 'report-information',
                                   'aria-selected' => 'false'));
    $out .= html_writer::end_div();
    $out .= html_writer::end_tag('nav');

    $out .= html_writer::start_div('tab-content', array('id' => 'nav-tabContent'));
    $out .= html_writer::div($gradings, 'tab-pane fade show active',
                            array('id' => 'report-grades', 'role' => 'tabpanel', 'aria-labelledby' => 'report-grades-tab'));
    $out .= html_writer::div($holistic, 'tab-pane fade',
                            array('id' => 'report-holistic', 'role' => 'tabpanel', 'aria-labelledby' => 'report-holistic-tab'));
    $out .= html_writer::div($information, 'tab-pane fade',
                             array('id' => 'report-information', 'role' => 'tabpanel',
                             'aria-labelledby' => 'report-information-tab'));
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Creates tab navigation and contents for short assignment
 *
 * @param string $assignment html content of assignment shown
 * @param string $resources html content of resources shown
 */
function create_short_assignment_tabs($assignment, $resources) {
    $out = html_writer::start_tag('nav');
    $out .= html_writer::start_div('nav nav-tabs digitala-tabs', array('id' => 'nav-tab', 'role' => 'tablist'));
    $out .= html_writer::tag('button', get_string('assignment', 'digitala'),
                             array('class' => 'nav-link active ml-2', 'id' => 'assignment-assignment-tab', 'data-toggle' => 'tab',
                                   'href' => '#assignment-assignment', 'role' => 'tab', 'aria-controls' => 'assignment-assignment',
                                   'aria-selected' => 'true'));
    $out .= html_writer::tag('button', get_string('assignmentresource', 'digitala'),
                             array('class' => 'nav-link ml-2', 'id' => 'assignment-resources-tab', 'data-toggle' => 'tab',
                                   'href' => '#assignment-resources', 'role' => 'tab', 'aria-controls' => 'assignment-resources',
                                   'aria-selected' => 'false'));
    $out .= html_writer::end_div();
    $out .= html_writer::end_tag('nav');

    $out .= html_writer::start_div('tab-content', array('id' => 'nav-tabContent'));
    $out .= html_writer::div($assignment, 'tab-pane fade show active',
                            array('id' => 'assignment-assignment', 'role' => 'tabpanel',
                                  'aria-labelledby' => 'assignment-assignment-tab'));
    $out .= html_writer::div($resources, 'tab-pane fade',
                            array('id' => 'assignment-resources', 'role' => 'tabpanel',
                                  'aria-labelledby' => 'assignment-resources-tab'));
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Creates pills navigation between plain and corrected transcription
 *
 * @param string $transcript content of transcript shown
 * @param string $feedback content of corrected transcription shown
 */
function create_transcript_toggle($transcript, $feedback) {
    $transcript = create_report_transcription($transcript);
    $feedback = create_report_feedback($feedback);
    $out = html_writer::start_tag('nav');
    $out .= html_writer::start_div('nav nav-pills digitala-tabs', array('id' => 'nav-pills', 'role' => 'tablist'));
    $out .= html_writer::tag('a', get_string('transcription_tab-corrected', 'digitala'),
                             array('class' => 'nav-link active ml-1', 'id' => 'readaloud-feedback-tab', 'data-toggle' => 'tab',
                                   'href' => '#readaloud-feedback', 'role' => 'tab', 'aria-controls' => 'readaloud-feedback',
                                   'aria-selected' => 'true'));
    $out .= html_writer::tag('a', get_string('transcription_tab-plain', 'digitala'),
                             array('class' => 'nav-link ml-1', 'id' => 'readaloud-transcript-tab', 'data-toggle' => 'tab',
                                   'href' => '#readaloud-transcript', 'role' => 'tab', 'aria-controls' => 'readaloud-transcript',
                                   'aria-selected' => 'false'));
    $out .= html_writer::end_div();
    $out .= html_writer::end_tag('nav');

    $out .= html_writer::start_div('tab-content', array('id' => 'nav-tabContent'));
    $out .= html_writer::div($feedback, 'tab-pane fade show active',
                            array('id' => 'readaloud-feedback', 'role' => 'tabpanel',
                                  'aria-labelledby' => 'readaloud-feedback-tab'));
    $out .= html_writer::div($transcript, 'tab-pane fade',
                            array('id' => 'readaloud-transcript', 'role' => 'tabpanel',
                                  'aria-labelledby' => 'readaloud-transcript-tab'));
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Creates a button with identical id and
 * Send user audio file to Aalto ASR for evaluation.
 * class
 *
 * @param string $id of the button
 * @param string $class of the button
 * @param string $text of the button
 * @param bool $disabled value of the button
 *
 */
function create_button($id, $class, $text, $disabled = false) {
    if ($disabled) {
        $out = html_writer::tag('button', $text, array('id' => $id, 'class' => $class, 'disabled' => 'true'));
    } else {
        $out = html_writer::tag('button', $text, array('id' => $id, 'class' => $class));
    }

    return $out;
}

/**
 * Creates navigation buttons with identical id and class
 *
 * @param string $buttonlocation location (info, assignmentprev, assignmentnext report) of the step
 * @param number $id id of the course module
 * @param number $d id of the activity instance
 * @param number $remaining remaining number of attempts used in report page
 */
function create_nav_buttons($buttonlocation, $id, $d, $remaining = 0) {
    $out = html_writer::start_div('navbuttons');
    if ($buttonlocation == 'info') {
        $newurl = page_url(1, $id, $d);
        $out .= html_writer::tag('a href=' . $newurl, get_string('navnext', 'digitala'),
                array('id' => 'nextButton', 'class' => 'btn btn-primary'));
    } else if ($buttonlocation == 'assignmentprev') {
        $newurl = page_url(0, $id, $d);
        $out .= html_writer::tag('a href=' . $newurl, get_string('navprevious', 'digitala'),
                array('id' => 'prevButton', 'class' => 'btn btn-primary'));
    } else if ($buttonlocation == 'assignmentnext') {
        $newurl = page_url(2, $id, $d);
        $out .= html_writer::tag('a href=' . $newurl, get_string('navnext', 'digitala'),
                array('id' => 'nextButton', 'class' => 'btn btn-primary'));
    } else if ($buttonlocation == 'report') {
        $newurl = page_url(1, $id, $d);
        if ($remaining == 0) {
            $string = 'navstartagain';
        } else {
            $string = 'navtryagain';
        }
        $out .= html_writer::tag('a href=' . $newurl, get_string($string, 'digitala'),
                array('id' => 'tryAgainButton', 'class' => 'btn btn-primary'));
    }
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Creates an instance of microphone with start and stop button
 *
 * @param number $maxlength maximum length of recording in seconds
 */
function create_microphone($maxlength = 0) {
    $starticon = '<svg width="16" height="16" fill="currentColor"' .
    'class="bi bi-play-fill" viewBox="0 0 16 16">' .
    '<path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.' .
    '697V4.308c0-.63.692-1.01 1.233-.696l6.363' .
    ' 3.692a.802.802 0 0 1 0 1.393z"/></svg>';
    $stopicon = '<svg width="16" height="16" fill="currentColor"' .
    'class="bi bi-stop-fill" viewBox="0 0 16 16">' .
    '<path d="M5 3.5h6A1.5 1.5 0 0 1 12.5 5v6a1.5 1.5 0 0 1-1.5' .
    ' 1.5H5A1.5 1.5 0 0 1 3.5 11V5A1.5 1.5 0 0 1 5 3.5z"/>' .
    '</svg>';
    $listenicon = '<svg width="16" height="16" fill="currentColor"' .
    'class="bi bi-volume-down-fill" viewBox="0 0 16 16">' .
    '<path d="M9 4a.5.5 0 0 0-.812-.39L5.825' .
    ' 5.5H3.5A.5.5 0 0 0 3 6v4a.5.5 0 0 0 .5.5h2.325l2.363' .
    ' 1.89A.5.5 0 0 0 9 12V4zm3.025 4a4.486 4.486 0 0 1-1.318 3.182L10' .
    ' 10.475A3.489 3.489 0 0 0 11.025 8 3.49 3.49 0 0 0 10 5.525l.707-.707A4.486' .
    ' 4.486 0 0 1 12.025 8z"/></svg>';

    if ($maxlength == 0) {
        $limit = '';
    } else {
        $limit = ' / '.convertsecondstostring($maxlength);
    }

    $out = html_writer::div($starticon, '', array('id' => 'startIcon', 'style' => 'display: none;'));
    $out .= html_writer::div($stopicon, '', array('id' => 'stopIcon', 'style' => 'display: none;'));
    $out .= html_writer::start_tag('p', array('id' => 'recordTimer'));
    $out .= html_writer::tag('span', '00:00', array('id' => 'recordingLength'));
    $out .= html_writer::tag('span', $limit);
    $out .= html_writer::end_tag('p');
    $out .= create_button('record', 'btn btn-primary record-btn', get_string('startbutton', 'digitala') . ' ' . $starticon);
    $out .= create_button('listen', 'btn btn-primary listen-btn', get_string('listenbutton', 'digitala') . ' ' . $listenicon, true);

    return $out;
}

/**
 * Creates the microphone icon for the microphone view
 */
function create_microphone_icon() {
    $microphoneicon = 'svg width="150" height="150" viewBox="0 0 150 150" version="1.1" id="svg5" inkscape:version="0.92.5 (2060ec1f9f, 2020-04-08)" inkscape:export-xdpi="96" inkscape:export-ydpi="96"> <sodipodi:namedview id="namedview7" pagecolor="#ffffff" bordercolor="#000000" borderopacity="1" inkscape:pageshadow="0" inkscape:pageopacity="0" inkscape:pagecheckerboard="false" inkscape:document-units="px" showgrid="false" units="px" inkscape:zoom="5.9223905" inkscape:cx="62.947139" inkscape:cy="78.863467" inkscape:window-width="1848" inkscape:window-height="1016" inkscape:window-x="72" inkscape:window-y="27" inkscape:window-maximized="1" inkscape:current-layer="layer1" viewbox-width="24" scale-x="1" showguides="true" /> <defs id="defs2"> <linearGradient inkscape:collect="always" id="linearGradient8239"> <stop style="stop-color:#ffffff;stop-opacity:1" offset="0" id="stop8278" /> <stop style="stop-color:#ffffff;stop-opacity:0" offset="1" id="stop8280" /> </linearGradient> <linearGradient id="linearGradient8197" inkscape:swatch="solid"> <stop style="stop-color:#c04b0d;stop-opacity:1;" offset="0" id="stop8195" /> </linearGradient> <linearGradient id="linearGradient6947" inkscape:swatch="solid"> <stop style="stop-color:#323232;stop-opacity:1;" offset="0" id="stop6945" /> </linearGradient> <linearGradient inkscape:collect="always" xlink:href="#linearGradient7609" id="linearGradient14811" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1.7019434,0,0,1.3429862,-166.17392,-206.17779)" x1="119.37104" y1="133.03964" x2="164.0202" y2="133.03964" /> <linearGradient id="linearGradient7609" inkscape:swatch="solid"> <stop style="stop-color:#000000;stop-opacity:1;" offset="0" id="stop7607" /> </linearGradient> <linearGradient inkscape:collect="always" xlink:href="#linearGradient8239" id="linearGradient8241" x1="12.490475" y1="20.807896" x2="12.282459" y2="-3.5488219" gradientUnits="userSpaceOnUse" gradientTransform="matrix(2.25,0,0,2.25,47.322403,-77.306788)" /> </defs> <g inkscape:label="Taso 1" inkscape:groupmode="layer" id="layer1" transform="translate(0,126)"> <ellipse style="fill:url(#linearGradient8241);fill-opacity:1;stroke:#d9f991;stroke-width:0; stroke-linecap:round;stroke-miterlimit:4;stroke-dasharray:none; stroke-dashoffset:0;stroke-opacity:1" id="path4797" cx="74.337151" cy="-50.244549" rx="26.929842" ry="26.977333" inkscape:export-filename="C:\Users\Joona\Desktop\icon.png" inkscape:export-xdpi="96" inkscape:export-ydpi="96" /> <rect style="fill:#000000;fill-opacity:1;stroke-width:0.47406167" id="rect1812-5-3-8" width="57.838097" height="83.551956" x="45.952644" y="-108.73703" ry="23.275175" rx="27.54195" /> <path style="fill:none;fill-opacity:1;stroke:url(#linearGradient14811);stroke-width :7.06218767;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:4; stroke-dasharray:none;stroke-opacity:1" d="m 40.246073,-38.828328 c 10.851217,28.219916 60.610707,28.8520856 69.419357,-0.73962" id="path401-9-7" sodipodi:nodetypes="cc" inkscape:connector-curvature="0" /> <path style="fill:none;stroke:#000000;stroke-width:9.99843788;stroke-linecap: butt;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1" d="M 75.90223,-19.843168 76.12741,0.59611765" id="path3077-8-4" inkscape:connector-curvature="0" /> <path style="fill:none;stroke:#000000;stroke-width:8.46515751;stroke-linecap: butt;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1" d="m 54.13793,2.5386476 c 13.84293,-1.83226995 28.51102,-2.01710995 44.282025,0" id="path574" sodipodi:nodetypes="cc" inkscape:connector-curvature="0" /> <path style="fill:none;stroke:#ffffff;stroke-width:5.0625px;stroke-linecap: round;stroke-linejoin:miter;stroke-opacity:1" d="m 45.849173,-83.263866 c 26.926417,-0.21371 26.926417,-0.21371 26.926417,-0.21371" id="path4391" inkscape:connector-curvature="0" /> <path style="fill:none;stroke:#ffffff;stroke-width:5.0625px;stroke-linecap: round;stroke-linejoin:miter;stroke-opacity:1" d="M 45.635473,-69.907508 C 72.5619,-70.121218 72.5619,-70.121218 72.5619,-70.121218" id="path4391-9" inkscape:connector-curvature="0" /> <path style="fill:none;stroke:#ffffff;stroke-width:5.0625;stroke-linecap: round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:30.375, 5.0625; stroke-dashoffset:0;stroke-opacity:1" d="M 45.635473,-56.230598 C 72.5619,-56.444308 72.5619,-56.444308 72.5619,-56.444308" id="path4391-9-2" inkscape:connector-curvature="0" /> </g> </svg'; // phpcs:ignore moodle.Files.LineLength.MaxExceeded
    $out = html_writer::start_div('', array('id' => 'microphoneIconBox'));
    $out .= html_writer::end_div();
    $out .= html_writer::tag($microphoneicon, '', array('id' => 'microphoneIcon'));
    return $out;
}

/**
 * Save user recored audio to server and send it to Aalto ASR for evaluation.
 *
 * @param array $formdata - form data includes file information
 * @param digitala_assignment $assignment - assignment includes needed identifications
 */
function save_answerrecording($formdata, $assignment) {
    $audiofile = json_decode($formdata->audiostring);
    $recordinglength = $formdata->recordinglength;

    $fileinfo = new stdClass();
    $fileinfo->contextid = $assignment->contextid;
    $fileinfo->component = 'mod_digitala';
    $fileinfo->filearea = 'recordings';
    $fileinfo->itemid = 0;
    $fileinfo->filepath = '/';
    $fileinfo->filename = $audiofile->file;

    file_save_draft_area_files($audiofile->id, $fileinfo->contextid, $fileinfo->component,
                                $fileinfo->filearea, $fileinfo->itemid);

    create_waiting_attempt($assignment, $fileinfo->filename, $recordinglength);
    send_answerrecording_for_evaluation($fileinfo, $assignment, $recordinglength);

    if (isset($_SERVER['REQUEST_URI'])) {
        $newurl = str_replace('page=1', 'page=2', $_SERVER['REQUEST_URI']);
        redirect($newurl);
    } else {
        return get_string('error_url-not-set', 'digitala');
    }
}

/**
 * Send user audio file to Aalto ASR for evaluation.
 *
 * @param any $fileinfo - audio file to be sent for evaluation
 * @param string $assignment - assignment which we get information from
 * @param string $length - length of the recording
 */
function send_answerrecording_for_evaluation($fileinfo, $assignment, $length) {
    $task = new \mod_digitala\task\send_to_evaluation();
    $task->set_custom_data(array(
        'assignment' => $assignment,
        'fileinfo' => $fileinfo,
        'length' => $length
    ));

    \core\task\manager::queue_adhoc_task($task, true);
}

/**
 * Save the attempt to the database.
 *
 * @param digitala_assignment $assignment - assignment includes needed identifications
 * @param string $filename - file name of the recording
 * @param mixed $recordinglength - length of recording in seconds
 */
function create_waiting_attempt($assignment, $filename, $recordinglength) {
    global $DB;

    $attempt = get_attempt($assignment->instanceid, $assignment->userid);

    if (isset($attempt)) {
        $attempt->attemptnumber++;
    } else {
        $attempt = new stdClass();
    }

    $attempt->digitala = $assignment->instanceid;
    $attempt->userid = $assignment->userid;
    $attempt->status = 'waiting';
    $attempt->file = $filename;
    $attempt->recordinglength = $recordinglength;

    $timenow = time();
    $attempt->timemodified = $timenow;

    if (isset($attempt->attemptnumber)) {
        $DB->update_record('digitala_attempts', $attempt);
    } else {
        $attempt->timecreated = $timenow;
        $DB->insert_record('digitala_attempts', $attempt);
    }
}

/**
 * Set attempt status in database.
 *
 * @param mixed $attempt - object containing attempt information
 * @param string $status - status of the attempt
 */
function set_attempt_status($attempt, $status) {
    global $DB;

    $attempt->status = $status;
    $attempt->timemodified = time();

    $DB->update_record('digitala_attempts', $attempt);
}

/**
 * Save attempt as failed in database.
 *
 * @param mixed $attempt - object containing attempt information
 * @param digitala_assignment $assignment - assignment includes needed identifications
 */
function save_failed_attempt($attempt, $assignment) {
    global $DB;

    $attempt->status = 'failed';
    $attempt->transcript = '';
    $attempt->attemptnumber--;
    $attempt->fluency = 0;
    $attempt->pronunciation = 0;
    if ($assignment->attempttype == 'freeform') {
        $attempt->taskcompletion = 0;
        $attempt->lexicogrammatical = 0;
        $attempt->holistic = 0;
    } else {
        $attempt->feedback = '';
    }
    $attempt->timemodified = time();

    $DB->update_record('digitala_attempts', $attempt);
}

/**
 * Save the attempt to the database.
 *
 * @param digitala_assignment $assignment - assignment includes needed identifications
 * @param mixed $evaluation - mixed object containing evaluation info
 */
function save_attempt($assignment, $evaluation) {
    global $DB;

    $attempt = get_attempt($assignment->instanceid, $assignment->userid);
    $attempt->status = 'evaluated';
    $attempt->transcript = $evaluation->transcript;
    $attempt->fluency = $evaluation->fluency->score > 4 ? 0 : $evaluation->fluency->score;
    $attempt->fluency = $attempt->fluency < 0 ? 0 : $attempt->fluency;
    $attempt->fluency = round($attempt->fluency, 2);
    $attempt->fluency_features = json_encode($evaluation->fluency->flu_features);
    $attempt->pronunciation = $evaluation->pronunciation->score > 4 ? 0 : $evaluation->pronunciation->score;
    $attempt->pronunciation = $attempt->pronunciation < 0 ? 0 : $attempt->pronunciation;
    $attempt->pronunciation = round($attempt->pronunciation, 2);
    $attempt->pronunciation_features = json_encode($evaluation->pronunciation->pron_features);
    if ($assignment->attempttype == 'freeform') {
        $attempt->taskcompletion = $evaluation->task_completion > 3 ? 0 : $evaluation->task_completion;
        $attempt->taskcompletion = $attempt->taskcompletion < 0 ? 0 : $attempt->taskcompletion;
        $attempt->taskcompletion = round($attempt->taskcompletion, 0, 2);
        $attempt->lexicogrammatical = $evaluation->lexicogrammatical->score > 3 ? 0 : $evaluation->lexicogrammatical->score;
        $attempt->lexicogrammatical = $attempt->lexicogrammatical < 0 ? 0 : $attempt->lexicogrammatical;
        $attempt->lexicogrammatical = round($attempt->lexicogrammatical, 2);
        $attempt->lexicogrammatical_features = json_encode($evaluation->lexicogrammatical->lexgram_features);
        $attempt->holistic = $evaluation->holistic > 6 ? 0 : $evaluation->holistic;
        $attempt->holistic = $attempt->holistic < 0 ? 0 : $attempt->holistic;
        $attempt->holistic = round($attempt->holistic, 2);
    } else {
        $attempt->feedback = $evaluation->annotated_response;
    }
    $attempt->timemodified = time();

    $DB->update_record('digitala_attempts', $attempt);
}

/**
 * Save the attempt to the database.
 *
 * @param string $attempttype - string containing attempt type
 * @param mixed $fromform - form which we get the data from
 * @param mixed $oldattempt - attempt that we're giving feedback to
 */
function save_report_feedback($attempttype, $fromform, $oldattempt) {
    global $DB;

    $feedback = new stdClass();
    $feedback->attempt = $oldattempt->id;
    $feedback->digitala = $oldattempt->digitala;

    $feedback->old_fluency = $oldattempt->fluency;
    $feedback->fluency = $fromform->fluency;
    $feedback->fluency_reason = $fromform->fluencyreason;

    $feedback->old_pronunciation = $oldattempt->pronunciation;
    $feedback->pronunciation = $fromform->pronunciation;
    $feedback->pronunciation_reason = $fromform->pronunciationreason;

    if ($attempttype == 'freeform') {
        $feedback->old_taskcompletion = $oldattempt->taskcompletion;
        $feedback->taskcompletion = $fromform->taskcompletion;
        $feedback->taskcompletion_reason = $fromform->taskcompletionreason;

        $feedback->old_lexicogrammatical = $oldattempt->lexicogrammatical;
        $feedback->lexicogrammatical = $fromform->lexicogrammatical;
        $feedback->lexicogrammatical_reason = $fromform->lexicogrammaticalreason;

        $feedback->old_holistic = $oldattempt->holistic;
        $feedback->holistic = $fromform->holistic;
        $feedback->holistic_reason = $fromform->holisticreason;
    }

    $feedback->timecreated = time();

    $DB->insert_record('digitala_report_feedback', $feedback);
}

/**
 * Load current users attempt from the database.
 *
 * @param int $instanceid - instance id of this digitala activity
 * @param int $userid - user id of this user or student
 * @return mixed $attempt - object containing attempt information
 */
function get_attempt($instanceid, $userid) {
    global $DB;

    if (!$DB->record_exists('digitala_attempts', array('digitala' => $instanceid, 'userid' => $userid))) {
        return null;
    }

    $attempt = $DB->get_record('digitala_attempts', array('digitala' => $instanceid, 'userid' => $userid));

    return $attempt;
}

/**
 * Load all attempts from the database.
 *
 * @param int $instanceid - instance id of this digitala activity
 * @return $attempts - object containing all attempt information
 */
function get_all_attempts($instanceid) {
    global $DB;

    $attempts = $DB->get_records('digitala_attempts', array('digitala' => $instanceid));
    return $attempts;
}

/**
 * Delete students attempt from the database.
 *
 * @param int $instanceid - instance id of this digitala activity
 * @param int $userid - id of the student
 */
function delete_attempt($instanceid, $userid) {
    global $DB;

    if ($DB->record_exists('digitala_attempts', array('digitala' => $instanceid, 'userid' => $userid))) {
        $DB->delete_records('digitala_attempts', array('digitala' => $instanceid, 'userid' => $userid));
    }
}

/**
 * Delete all attempts from the database.
 *
 * @param int $instanceid - instance id of this digitala activity
 */
function delete_all_attempts($instanceid) {
    global $DB;

    if ($DB->record_exists('digitala_attempts', array('digitala' => $instanceid))) {
        $DB->delete_records('digitala_attempts', array('digitala' => $instanceid));
    }
}

/**
 * Add button to open deletion modal for deleting all attempts.
 *
 * @return $button - button containing delete url
 */
function add_delete_all_attempts_button() {
    $button = html_writer::tag('button', get_string('results_delete-all', 'digitala'),
        array('id' => 'deleteAllButton', 'class' => 'btn btn-danger',
            'data-toggle' => 'modal', 'data-target' => '#deleteAllModal'));
    return $button;
}

/**
 * Add delete button to redirect and delete all attempts from the database.
 *
 * @param int $id - id of digitala instance
 * @return $button - button containing delete url
 */
function add_delete_all_redirect_button($id) {
    $deleteurl = delete_url($id);
    $button = html_writer::tag('a href=' . $deleteurl, get_string('results_delete-confirm', 'digitala'),
        array('id' => 'deleteAllRedirectButton', 'class' => 'btn btn-danger'));
    return $button;
}

/**
 * Add button to open deletion modal for deleting single attempt.
 *
 * @param mixed $user - user object
 * @return $button - button that opens deletion modal
 */
function add_delete_attempt_button($user) {
    $button = html_writer::tag('button', get_string('results_delete', 'digitala'),
        array('id' => 'deleteButton'.$user->username, 'class' => 'btn btn-warning',
            'data-toggle' => 'modal', 'data-target' => '#deleteModal'.$user->id));
    return $button;
}

/**
 * Add delete button to redirect and delete given attempt from the database.
 *
 * @param int $id - id of digitala instance
 * @param mixed $user - user object
 * @return $button - button containing delete url
 */
function add_delete_redirect_button($id, $user) {
    $deleteurl = delete_url($id, $user->id);
    $button = html_writer::tag('a href=' . $deleteurl, get_string('results_delete-confirm', 'digitala'),
        array('id' => 'deleteRedirectButton'.$user->username, 'class' => 'btn btn-warning'));
    return $button;
}

/**
 * Load current users latest feedback from the database.
 *
 * @param int $attempt - attempt object
 * @return mixed $feedback - object containing latest feedback information
 */
function get_feedback($attempt) {
    global $DB;

    if (!$DB->record_exists('digitala_report_feedback', array('attempt' => $attempt->id))) {
        return null;
    }

    $sql = 'SELECT * FROM {digitala_report_feedback} WHERE attempt = ? ORDER BY id DESC LIMIT 1';
    $feedback = $DB->get_record_sql($sql, array($attempt->id));

    return $feedback;
}

/**
 * Load users name based on their id.
 *
 * @param int $id - id of the user
 * @return $user - user object
 */
function get_user($id) {
    global $DB;

    $user = $DB->get_record('user', array('id' => $id));
    return $user;
}

/**
 * Load all attempts from the database.
 *
 * @param mixed $attempt - object containing attempt information
 * @param int $id - activity id
 * @param mixed $user - user info from database
 * @return $cells - cells containing table data
 */
function create_result_row($attempt, $id, $user) {
    $username = $user->firstname . ' ' . $user->lastname;
    if (isset($attempt->holistic)) {
        $score = $attempt->holistic;
    } else {
        $score = $attempt->fluency;
    }
    if ($attempt->status == 'waiting' || $attempt->status == "retry" || $attempt->status == "failed") {
        $score = "-";
    }
    $time = convertsecondstostring($attempt->recordinglength);
    $tries = ($attempt->attemptnumber);
    $status = get_string('results_status-'.$attempt->status, 'digitala');

    $urltext = results_url($id, 'detail', $attempt->userid);
    $urllink = html_writer::link($urltext, get_string('results_link', 'digitala'));

    $deletebutton = add_delete_attempt_button($user);

    $cells = array($username, $score, $time, $tries, $status, $urllink, $deletebutton);
    return $cells;
}

/**
 * Handles answer recording form's actions
 *
 * @param digitala_assignment $assignment - assignment includes needed identifications
 */
function create_answerrecording_form($assignment) {
    return $assignment->form->render();
}

/**
 * Handles saving answer recording form
 *
 * @param digitala_assignment $assignment - assignment includes needed identifications
 */
function save_answerrecording_form($assignment) {
    $out = html_writer::tag('p', '', array('id' => 'submitErrors'));
    if ($formdata = $assignment->form->get_data()) {
        save_answerrecording($formdata, $assignment);
    }
    return $out;
}

/**
 * Creates a chart.
 *
 * @param string $name of the chart
 * @param mixed $grade of the chart
 * @param mixed $maxgrade of the chart
 */
function create_chart($name, $grade, $maxgrade) {
    $out = html_writer::start_div('digitala-chart-container');
    $out .= html_writer::tag('canvas', '', array('id' => $name, 'data-eval-name' => $name, 'data-eval-grade' => $grade,
                                                'data-eval-maxgrade' => $maxgrade, 'class' => 'report-chart'));
    $out .= html_writer::end_div();
    return $out;
}

/**
 * Creates a fixed feedback box.
 */
function create_fixed_box() {
    $chaticon = '<svg id="feedback" width="16" height="16" fill="currentColor"' .
    'class="bi bi-chat-text-fill" viewBox="0 0 16 16">' .
    '<path d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.' .
    '584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.' .
    '836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8' .
    ' 3.134 8 7zM4.5 5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5' .
    ' 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4z"/></svg>';
    $out = html_writer::div(get_string('feedback', 'digitala'), 'feedbackcontainer',
    array('data-toggle' => 'collapse', 'data-target' => '#feedbacksite'));
    $out .= html_writer::tag('button type="button" class="btn btn-primary"' .
    'data-toggle="collapse" data-target="#feedbacksite" id="collapser"', $chaticon);
    $out .= html_writer::div('', 'collapse', array('id' => 'feedbacksite'));
    $out .= html_writer::tag('iframe src=' .
    'https://link.webropolsurveys.com/Participation/Public/2c1ccd52-6e23-436e-af51-f8f8c259ffbb?displayId=Fin2500048',
    '', array('id' => 'feedbacksite', 'class' => 'collapse'));
    return $out;
}

/**
 * Converts seconds to formatted time string
 * @param number $secs seconds set by teacher when creating activity
 */
function convertsecondstostring($secs) {
    $hours = floor($secs / 3600);
    $minutes = floor(($secs - ($hours * 3600)) / 60);
    $seconds = floor($secs - ($hours * 3600) - ($minutes * 60));

    if ($hours == 0) {
        $hours = '';
    } else {
        if ($hours < 10) {
            $hours = '0'.$hours.':';
        } else {
            $hours = $hours.':';
        }

    }

    if ($minutes < 10) {
        $minutes = '0'.$minutes;
    }

    if ($seconds < 10) {
        $seconds = '0'.$seconds;
    }

    return $hours.$minutes.':'.$seconds;
}

/**
 * Creates attempt number visualization for assignment view.
 *
 * @param digitala_assignment $assignment - assignment containing id information
 * @param int $userid - id of the user
 */
function create_attempt_number($assignment, $userid) {
    $remaining = $assignment->attemptlimit;
    if ($remaining == 0) {
        $out = get_string('attemptsunlimited', 'mod_digitala');
    } else {
        $attempt = get_attempt($assignment->instanceid, $userid);
        if (isset($attempt)) {
            $remaining -= $attempt->attemptnumber;
        }

        $out = get_string('attemptsremaining', 'mod_digitala', $remaining);
    }

    return $out;
}

/**
 * Creates attempt modal.
 *
 * @param digitala_assignment $assignment - assignment that this object is created for
 */
function create_attempt_modal($assignment) {
    $remaining = $assignment->attemptlimit;

    $out = html_writer::tag('button', get_string('submit', 'mod_digitala'),
                            array('id' => 'submitModalButton', 'type' => 'button', 'class' => 'btn btn-primary ml-2',
                                  'data-toggle' => 'modal',  'data-target' => '#attemptModal', 'style' => 'display: none'));
    $out .= html_writer::start_div('modal', array('id' => 'attemptModal', 'tabindex' => '-1', 'role' => 'dialog',
                                                  'aria-labelledby' => 'submitModal', 'aria-hidden' => 'true'));
    $out .= html_writer::start_div('modal-dialog', array('role' => 'document'));
    $out .= html_writer::start_div('modal-content');
    $out .= html_writer::start_div('modal-header');
    $out .= html_writer::tag('h5', get_string('submittitle', 'digitala'), array('class' => 'modal-title'));
    $out .= html_writer::start_tag('button', array('class' => 'close', 'data-dismiss' => 'modal',
                                                   'aria-label' => get_string('submitclose', 'mod_digitala')));
    $out .= html_writer::tag('span', '&times;', array('aria-hidden' => 'true'));
    $out .= html_writer::end_tag('button');
    $out .= html_writer::end_div();
    $out .= html_writer::start_div('modal-body');
    $out .= html_writer::start_tag('p');
    if ($remaining == 0) {
        $out .= get_string('attemptsunlimited', 'mod_digitala');
    } else {
        $attempt = get_attempt($assignment->instanceid, $assignment->userid);
        if (isset($attempt)) {
            $remaining -= $attempt->attemptnumber;
        }
        $out .= get_string('submitbody', 'digitala', $remaining);
    }
    $out .= html_writer::end_tag('p');
    $out .= html_writer::end_div();
    $out .= html_writer::start_div('modal-footer');
    $out .= html_writer::tag('button', get_string('submitclose', 'mod_digitala'),
                             array('type' => 'button', 'class' => 'btn btn-secondary', 'data-dismiss' => 'modal'));
    $out .= create_answerrecording_form($assignment);
    $out .= html_writer::end_div();
    $out .= html_writer::end_div();
    $out .= html_writer::end_div();
    $out .= html_writer::end_div();
    return $out;
}

/**
 * Creates attempt modal.
 *
 * @param int $id - id of the activity
 * @param mixed $user - the user whose attempt ought to be deleted or null if deleting all attempts
 */
function create_delete_modal($id, $user=null) {

    if (isset($user)) {
        $out = html_writer::start_div('modal', array('id' => 'deleteModal'.$user->id, 'tabindex' => '-1', 'role' => 'dialog'));
    } else {
        $out = html_writer::start_div('modal', array('id' => 'deleteAllModal', 'tabindex' => '-1', 'role' => 'dialog'));
    }
    $out .= html_writer::start_div('modal-dialog', array('role' => 'document'));
    $out .= html_writer::start_div('modal-content');
    $out .= html_writer::start_div('modal-header');
    $out .= html_writer::tag('h5', get_string('results_delete-title', 'digitala'), array('class' => 'modal-title'));
    $out .= html_writer::start_tag('button', array('class' => 'close', 'data-dismiss' => 'modal',
                                                   'aria-label' => 'close-cross'));
    $out .= html_writer::tag('span', '&times;', array('aria-hidden' => 'true'));
    $out .= html_writer::end_tag('button');
    $out .= html_writer::end_div();
    $out .= html_writer::start_div('modal-body');
    $out .= html_writer::start_tag('p');
    if (isset($user)) {
        $username = $user->firstname . ' ' . $user->lastname;
        $out .= get_string('results_delete-one-text', 'digitala', $username);
    } else {
        $out .= get_string('results_delete-all-text', 'digitala');
    }
    $out .= html_writer::end_tag('p');
    $out .= html_writer::end_div();
    $out .= html_writer::start_div('modal-footer');
    $out .= html_writer::tag('button', get_string('submitclose', 'mod_digitala'),
                             array('type' => 'button', 'class' => 'btn btn-secondary', 'data-dismiss' => 'modal'));
    if (isset($user)) {
        $out .= add_delete_redirect_button($id, $user);
    } else {
        $out .= add_delete_all_redirect_button($id);
    }

    $out .= html_writer::end_div();
    $out .= html_writer::end_div();
    $out .= html_writer::end_div();
    $out .= html_writer::end_div();
    return $out;
}

/**
 * Generates csv of activitys attempts
 *
 * @param int $id - id of the activity
 * @param string $mode - mode of the url
 * @return string $data - data of the array
 */
function generate_attempts_csv($id, $mode) {
    $attempts = get_all_attempts($id);

    $writer = new \csv_export_writer();

    $header = 'id;digitala;userid;attemptnumber;file;transcript;feedback;'
           .'fluency;fluency_features;taskcompletion;pronunciation;pronunciation_features;'
           .'lexicogrammatical;lexicogrammatical_features;holistic;gop_score;timecreated;'
           .'timemodified;recordinglength;status';
    $writer->add_data(explode(';', $header));
    foreach ($attempts as $attempt) {
        $arr = [
            $attempt->id,
            $attempt->digitala,
            $attempt->userid,
            $attempt->attemptnumber,
            $attempt->file,
            $attempt->transcript,
            $attempt->feedback,
            $attempt->fluency,
            $attempt->fluency_features,
            $attempt->taskcompletion,
            $attempt->pronunciation,
            $attempt->pronunciation_features,
            $attempt->lexicogrammatical,
            $attempt->lexicogrammatical_features,
            $attempt->holistic,
            $attempt->gop_score,
            $attempt->timecreated,
            $attempt->timemodified,
            $attempt->recordinglength,
            $attempt->status
        ];
        $writer->add_data($arr);
    }
    $writer->set_filename('digitala-attempts');
    if ($mode == 'attempts') {
        $writer->download_file();
    } else {
        $data = $writer->print_csv_data(true);
        return $data;
    }
}

/**
 * Load all feedbacks from the database.
 *
 * @param int $id - id of the activity
 * @return $feedbacks - object containing all feedback information
 */
function get_all_feedbacks($id) {
    global $DB;

    $feedbacks = $DB->get_records('digitala_report_feedback', array('digitala' => $id));
    return $feedbacks;
}

/**
 * Generates csv of activitys attempts
 *
 * @param int $id - id of the activity
 * @param string $mode - mode of the url
 * @return string $data - data of the array
 */
function generate_report_feedback_csv($id, $mode) {
    $feedbacks = get_all_feedbacks($id);
    $header = 'id;attempt;digitala;old_fluency;fluency;fluency_reason;old_taskcompletion;'
           .'taskcompletion;taskcompletion_reason;old_lexicogrammatical;lexicogrammatical;'
           .'lexicogrammatical_reason;old_pronunciation;pronunciation;pronunciation_reason;'
           .'old_holistic;holistic;holistic_reason;old_gop_score;gop_score;'
           .'gop_score_reason;timecreated';
    $writer = new \csv_export_writer();
    $writer->add_data(explode(';', $header));

    foreach ($feedbacks as $feedback) {
        $arr = [
            $feedback->id,
            $feedback->attempt,
            $feedback->digitala,
            $feedback->old_fluency,
            $feedback->fluency,
            $feedback->fluency_reason,
            $feedback->old_taskcompletion,
            $feedback->taskcompletion,
            $feedback->taskcompletion_reason,
            $feedback->old_lexicogrammatical,
            $feedback->lexicogrammatical,
            $feedback->lexicogrammatical_reason,
            $feedback->old_pronunciation,
            $feedback->pronunciation,
            $feedback->pronunciation_reason,
            $feedback->old_holistic,
            $feedback->holistic,
            $feedback->holistic_reason,
            $feedback->old_gop_score,
            $feedback->gop_score,
            $feedback->gop_score_reason,
            $feedback->timecreated
        ];
        $writer->add_data($arr);
    }
    $writer->set_filename('digitala-attempts-feedback');
    if ($mode == 'feedback') {
        $writer->download_file();
    } else {
        $data = $writer->print_csv_data(true);
        return $data;
    }
}

/**
 * Create export buttons
 *
 * @param int $id - id of the activity
 */
function create_export_buttons($id) {
    $out = html_writer::tag('a', get_string('export_attempts', 'digitala'),
                array('href' => export_url($id, 'attempts'), 'id' => 'export_attempts', 'class' => 'btn btn-primary'));
    $out .= html_writer::tag('a', get_string('export_attempts_feedback', 'digitala'),
                array('href' => export_url($id, 'feedback'), 'id' => 'export_attempts_feedback', 'class' => 'btn btn-primary'));
    return $out;
}
