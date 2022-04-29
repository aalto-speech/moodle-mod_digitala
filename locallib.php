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
 * Used to generate page urls for digitala module student views.
 *
 * @param number $page number of the step
 */
function switch_page($page) {
    $count = 0;
    $url = preg_replace('/&page=\d/i', '&page='.$page, $_SERVER['REQUEST_URI'], -1, $count);
    if ($count) {
        return $url;
    }
    return $url . '&page='.$page;
}

/**
 * Used to generate links in the steps of the progress bar.
 *
 * @param string $name name of the step
 * @param number $page number of the step
 */
function create_progress_bar_step_link($name, $page) {
    $title = html_writer::span($page + 1, 'pb-num').html_writer::span(get_string($name, 'digitala'), 'pb-phase-name');
    return html_writer::link(switch_page($page), $title, array('class' => 'display-6'));
}

/**
 * Used to begin creation of the progress bar.
 */
function start_progress_bar() {
    return html_writer::start_div('digitala-progress-bar');
}

/**
 * Used to end creation of the progress bar.
 */
function end_progress_bar() {
    return html_writer::end_div();
}

/**
 * Used to create one step of the progress bar.
 *
 * @param string $name name of the step as lang API compatible id
 * @param number $page number of the step
 * @param number $currentpage number of the active page
 */
function create_progress_bar_step($name, $page, $currentpage) {
    $classes = 'pb-step';
    if ($page == $currentpage) {
        $classes .= ' active';
    }
    if ($page == 0) {
        $classes .= ' first';
    } else if ($page == 2) {
        $classes .= ' last';
    }

    $out = html_writer::start_div($classes);
    $out .= create_progress_bar_step_link($name, $page);
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
    $out .= html_writer::start_tag('svg', array('class' => $class, 'viewBox' => '0 0 275 500', 'style' =>
        'fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5'));

    if ($mode == 'left-empty') {
        $out .= html_writer::empty_tag('path', array('d' => 'M275 0H20l235 250L20 500h255V0Z', 'fill' => '#d3d3d3'));
    } else if ($mode == 'right-empty') {
        $out .= html_writer::empty_tag('path', array('d' => 'M255 250 20 0H0v500h20l235-250Z', 'fill' => '#d3d3d3'));
    }
    $out .= html_writer::empty_tag('path', array('d' => 'm20 20 235 230L20 480',
                                                 'style' => 'fill:none;stroke:#d3d3d3;stroke-width:40px'));
    $out .= html_writer::end_tag('svg');
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
    return html_writer::start_div('col'.$size.' digitala-column');
}

/**
 * Used to close column
 */
function end_column() {
    return html_writer::end_div();
}

/**
 * Card template used for all card functions
 *
 * @param string $content html code to be added inside the card
 */
function create_card_template($content) {
    $out = html_writer::start_div('card row digitala-card');
    $out .= html_writer::start_div('card-body');

    $out .= $content;

    $out .= html_writer::end_div();
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Used to create content card inside content container column
 *
 * @param string $header text for card's header as lang file string name
 * @param string $text content for the card as html
 */
function create_card($header, $text) {
    $out = html_writer::tag('h5', get_string($header, 'digitala'), array('class' => 'card-title'));
    $out .= html_writer::div($text, 'card-text');

    return create_card_template($out);
}

/**
 * Used to create text inside assignment card - helper function for box sizing
 *
 * @param string $content text inside assignment text card
 */
function create_assignment($content) {
    return html_writer::div($content, 'card-text scrollbox200');
}

/**
 * Used to create text inside resource card - helper function for box sizing
 *
 * @param digitala_assignment $assignment - assignment includes resource text
 */
function create_resource($assignment) {
    $resources = file_rewrite_pluginfile_urls($assignment->resourcetext, 'pluginfile.php', $assignment->contextid,
                                              'mod_digitala', 'files', 0);

    return html_writer::div($resources, 'card-text scrollbox400');
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
    $out = html_writer::tag('h5', get_string($name, 'digitala'), array('class' => 'card-title'));
    $out .= html_writer::tag('p', get_string($name.'_description', 'digitala'));

    $out .= create_chart($name, $grade, $maxgrade);
    $out .= html_writer::tag('h6', floor($grade) . '/' . $maxgrade, array('class' => 'grade-number'));

    $out .= html_writer::start_div('card-text');
    $out .= html_writer::tag('p', get_string('task_grades_preamble', 'digitala').
                                  lcfirst(get_string($name.'_score-' . floor($grade), 'digitala')));

    if (isset($feedbackgrade) && $grade != $feedbackgrade) {
        $out .= html_writer::tag('p', get_string('teachergrade', 'digitala').$feedbackgrade);
    }
    if (isset($feedbackreason) && !empty($feedbackreason)) {
        $out .= html_writer::tag('p', get_string('teacherreason', 'digitala').$feedbackreason);
    }
    $out .= html_writer::end_div();

    return create_card_template($out);
}

/**
 * Creates holistic information container from report
 *
 * @param int $grade grading number given by the server
 * @param mixed $feedback information given by the teacher
 */
function create_report_holistic($grade, $feedback = null) {
    $out = html_writer::tag('h5', get_string('holistic', 'digitala'), array('class' => 'card-title'));

    $out .= create_chart('holistic', $grade, 6);
    $out .= html_writer::tag('h6', get_string('holistic_level-'.$grade, 'digitala'), array('class' => 'grade-number'));

    $out .= html_writer::start_div('card-text');
    $out .= html_writer::tag('p', get_string('holistic_description', 'digitala').
                                  get_string('holistic_level-'.$grade, 'digitala').'.');
    $out .= html_writer::tag('p', get_string('holistic_score-'.$grade, 'digitala'));

    if (isset($feedback)) {
        if ($grade != $feedback->holistic) {
            $out .= html_writer::tag('p', get_string('teachergrade', 'digitala').$feedback->holistic);
        }
        if (!empty($feedback->holistic_reason)) {
            $out .= html_writer::tag('p', get_string('teacherreason', 'digitala').$feedback->holistic_reason);
        }
    }
    $out .= html_writer::end_div();

    return create_card_template($out);
}

/**
 * Creates report waiting container
 */
function create_report_waiting() {
    $out = html_writer::tag('h5', get_string('results_waiting-title', 'digitala'), array('class' => 'card-title'));

    $out .= html_writer::start_div('card-text');

    $out .= html_writer::start_div('spinner-border text-primary', array('role' => 'status'));
    $out .= html_writer::tag('span', get_string('results_waiting-loading', 'digitala'), array('class' => 'sr-only'));
    $out .= html_writer::end_div();

    $out .= html_writer::tag('p', get_string('results_waiting-info', 'digitala'));
    $out .= html_writer::tag('a', get_string('results_waiting-refresh', 'digitala'),
                             array('id' => 'nextButton', 'class' => 'btn btn-primary', 'href' => $_SERVER['REQUEST_URI']));
    $out .= html_writer::end_div();

    return create_card_template($out);
}

/**
 * Creates report retry container
 */
function create_report_retry() {
    $out = html_writer::tag('h5', get_string('results_retry-title', 'digitala'), array('class' => 'card-title'));

    $out .= html_writer::start_div('card-text');

    $out .= html_writer::start_div('spinner-border text-primary', array('role' => 'status'));
    $out .= html_writer::tag('span', get_string('results_waiting-loading', 'digitala'), array('class' => 'sr-only'));
    $out .= html_writer::end_div();

    $out .= html_writer::tag('p', get_string('results_retry-info', 'digitala'));
    $out .= html_writer::end_div();

    return create_card_template($out);
}

/**
 * Creates more information container from report
 *
 * @param digitala_report $report report object containing information
 */
function create_report_information($report) {
    if (empty($report->informationtext)) {
        return '';
    }

    $out = html_writer::tag('h5', get_string('moreinformation', 'digitala'), array('class' => 'card-title'));

    $text = file_rewrite_pluginfile_urls($report->informationtext, 'pluginfile.php', $report->contextid,
                                         'mod_digitala', 'info', 0);
    $out .= html_writer::div($text, 'card-text');

    return create_card_template($out);
}

/**
 * Creates transcription container from report
 *
 * @param mixed $transcription object containing the transcription part of report
 */
function create_report_transcription($transcription) {
    $out = html_writer::tag('h5', get_string('transcription', 'digitala'), array('class' => 'card-title'));

    $out .= html_writer::div($transcription, 'card-text scrollbox200');

    return create_card_template($out);
}

/**
 * Creates feedback container from report
 *
 * @param mixed $feedback object containing the feedback part of report
 */
function create_report_feedback($feedback) {
    $out = html_writer::tag('h5', get_string('server-feedback', 'digitala'), array('class' => 'card-title'));

    $out .= html_writer::div($feedback, 'card-text scrollbox200');

    return create_card_template($out);
}

/**
 * Creates tab navigation and contents for report view
 *
 * @param array $tabs array containing tab information. key must be id, values must include name and content
 */
function create_tabs($tabs) {
    $first = true;
    $buttons = '';
    $divs = '';
    foreach ($tabs as $name => $contents) {
        $buttonclasses = 'nav-link ml-2';
        $divclasses = 'tab-pane fade';
        if ($first) {
            $buttonclasses .= ' active';
            $divclasses .= ' show active';
        }
        $buttons .= html_writer::tag('button', $contents['name'], array('class' => $buttonclasses, 'id' => $name.'-tab',
                                     'data-toggle' => 'tab', 'href' => '#'.$name, 'role' => 'tab', 'aria-controls' => $name,
                                     'aria-selected' => $first ? 'true' : 'false'));
        $divs .= html_writer::div($contents['content'], $divclasses,
                                  array('id' => $name, 'role' => 'tabpanel', 'aria-labelledby' => $name.'-tab'));
        if ($first) {
            $first = false;
        }
    }
    $out = html_writer::start_tag('nav');
    $out .= html_writer::start_div('nav nav-tabs digitala-tabs', array('id' => 'nav-tab', 'role' => 'tablist'));
    $out .= $buttons;
    $out .= html_writer::end_div();
    $out .= html_writer::end_tag('nav');

    $out .= html_writer::start_div('tab-content', array('id' => 'nav-tabContent'));
    $out .= $divs;
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
    $tabs = array('report-grades' => array('name' => get_string('task_grades', 'digitala'), 'content' => $gradings),
                  'report-holistic' => array('name' => get_string('holistic', 'digitala'), 'content' => $holistic));
    if (!empty($information)) {
        $tabs['report-information'] = array('name' => get_string('moreinformation', 'digitala'), 'content' => $information);
    }

    return create_tabs($tabs);
}

/**
 * Creates tab navigation and contents for short assignment
 *
 * @param string $assignment html content of assignment shown
 * @param string $resources html content of resources shown
 */
function create_short_assignment_tabs($assignment, $resources) {
    $tabs = array('assignment-assignment' => array('name' => get_string('assignment', 'digitala'), 'content' => $assignment),
                  'assignment-resources' => array('name' => get_string('assignmentresource', 'digitala'),
                                                  'content' => $resources));

    return create_tabs($tabs);
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

    $tabs = array('readaloud-transcript' => array('name' => get_string('transcription_tab-plain', 'digitala'),
                                                  'content' => $transcript),
                  'readaloud-feedback' => array('name' => get_string('transcription_tab-corrected', 'digitala'),
                                                  'content' => $feedback));

    return create_tabs($tabs);
}

/**
 * Creates a button with identical id and
 * Send user audio file to Aalto ASR for evaluation.
 *
 * @param string $id of the button
 * @param string $class of the button
 * @param string $text of the button
 * @param bool $disabled value of the button
 *
 */
function create_button($id, $class, $text, $disabled = false) {
    $options = array('id' => $id, 'class' => $class);
    if ($disabled) {
        $options['disabled'] = 'true';
    }
    $out = html_writer::tag('button', $text, $options);

    return $out;
}

/**
 * Creates navigation buttons with identical id and class
 *
 * @param string $buttonlocation location (info, assignmentprev, assignmentnext report) of the step
 * @param number $remaining remaining number of attempts used in report page
 */
function create_nav_buttons($buttonlocation, $remaining = 0) {
    if ($buttonlocation == 'info') {
        $newurl = switch_page(1);
        $string = 'navnext';
        $id = 'nextButton';
    } else if ($buttonlocation == 'assignmentprev') {
        $newurl = switch_page(0);
        $string = 'navprevious';
        $id = 'prevButton';
    } else if ($buttonlocation == 'assignmentnext') {
        $newurl = switch_page(2);
        $string = 'navnext';
        $id = 'nextButton';
    } else if ($buttonlocation == 'report') {
        $newurl = switch_page(1);
        if ($remaining == 0) {
            $string = 'navstartagain';
        } else {
            $string = 'navtryagain';
        }
        $id = 'tryAgainButton';
    }
    $out = html_writer::start_div('navbuttons');
    $out .= html_writer::link($newurl, get_string($string, 'digitala'),
                              array('id' => $id, 'class' => 'btn btn-primary'));
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Creates an instance of microphone with start and stop button
 *
 * @param number $maxlength maximum length of recording in seconds
 */
function create_microphone($maxlength = 0) {
    $starticon = html_writer::start_tag('svg', array('width' => 16, 'height' => 16, 'fill' => 'currentColor',
                                                     'class' => 'bi bi-play-fill'));
    $starticon .= html_writer::empty_tag('path', array('d' => 'm12 9-7 3H4V4h1l7 3a1 1 0 0 1 0 2z'));
    $starticon .= html_writer::end_tag('svg');
    $stopicon = html_writer::start_tag('svg', array('width' => 16, 'height' => 16, 'fill' => 'currentColor',
                                                     'class' => 'bi bi-stop-fill'));
    $stopicon .= html_writer::empty_tag('path', array('d' => 'M5 4h6a2 2 0 0 1 2 1v6a2 2 0 0 1-2 2H5a2 2 0 0 1-1-2V5a2 '.
                                                             '2 0 0 1 1-1z'));
    $stopicon .= html_writer::end_tag('svg');
    $listenicon = html_writer::start_tag('svg', array('width' => 16, 'height' => 16, 'fill' => 'currentColor',
                                                     'class' => 'bi bi-volume-down-fill'));
    $listenicon .= html_writer::empty_tag('path', array('d' => 'M9 4a.5.5 0 0 0-.8-.4L5.8 5.5H3.5A.5.5 0 0 0 3 6v4a.5.5 0 0 0 '.
                                                               '.5.5h2.3l2.4 1.9A.5.5 0 0 0 9 12V4zm3 4a4.5 4.5 0 0 1-1.3 3.2l-'.
                                                               '.7-.7A3.5 3.5 0 0 0 11 8a3.5 3.5 0 0 0-1-2.5l.7-.7A4.5 4.5 0 0 1 '.
                                                               '12 8z'));
    $listenicon .= html_writer::end_tag('svg');

    if ($maxlength == 0) {
        $limit = '';
    } else {
        $limit = ' / '.convertsecondstostring($maxlength);
    }

    $out = html_writer::start_tag('p', array('id' => 'recordTimer'));
    $out .= html_writer::span('00:00', '', array('id' => 'recordingLength'));
    $out .= html_writer::nonempty_tag('span', $limit);
    $out .= html_writer::end_tag('p');
    $out .= html_writer::span($starticon, '', array('id' => 'startIcon', 'style' => 'display: none;'));
    $out .= html_writer::span($stopicon, '', array('id' => 'stopIcon', 'style' => 'display: none;'));
    $out .= create_button('record', 'btn btn-primary record-btn', get_string('startbutton', 'digitala') . ' ' . $starticon);
    $out .= create_button('listen', 'btn btn-primary listen-btn', get_string('listenbutton', 'digitala') . ' ' . $listenicon, true);

    return $out;
}

/**
 * Creates the microphone icon for the microphone view
 */
function create_microphone_icon() {
    $out = html_writer::div('', '', array('id' => 'microphoneIconBox'));
    $out .= html_writer::start_tag('svg', array('width' => '150', 'height' => '150',
                                                'id' => 'microphoneIcon'));
    $out .= html_writer::start_tag('defs');
    $out .= html_writer::start_tag('linearGradient', array('id' => 'b'));
    $out .= html_writer::empty_tag('stop', array('offset' => 0, 'stop-color' => '#fff'));
    $out .= html_writer::empty_tag('stop', array('offset' => 1, 'stop-color' => '#fff', 'stop-opacity' => 0));
    $out .= html_writer::end_tag('linearGradient');
    $out .= html_writer::empty_tag('linearGradient', array('xlink:href' => '#a', 'id' => 'd', 'x1' => 119.4, 'x2' => 164,
                                                           'y1' => 133, 'y2' => '133', 'gradientUnits' => 'userSpaceOnUse',
                                                           'gradientTransform' => 'matrix(1.70194 0 0 1.34299 -166.2 -206.2)'));
    $out .= html_writer::start_tag('linearGradient', array('id' => 'a'));
    $out .= html_writer::empty_tag('stop', array('offset' => 0));
    $out .= html_writer::end_tag('linearGradient');
    $out .= html_writer::empty_tag('linearGradient', array('xlink:href' => '#b', 'id' => 'c', 'x1' => 12.5, 'x2' => 12.3,
                                                           'y1' => 20.8, 'y2' => '-3.5', 'gradientUnits' => 'userSpaceOnUse',
                                                           'gradientTransform' => 'matrix(2.25 0 0 2.25 47.3 -77.3)'));
    $out .= html_writer::end_tag('defs');
    $out .= html_writer::start_tag('g', array('transform' => 'translate(0 126)'));
    $out .= html_writer::empty_tag('eclipse', array('cx' => 74.3, 'cy' => -50.2, 'fill' => 'url(#c)', 'rx' => 26.9, 'ry' => 27));
    $out .= html_writer::empty_tag('rect', array('width' => 57.8, 'height' => 83.6, 'x' => 46, 'y' => -108.7,
                                                 'rx' => 27.5, 'ry' => 23.3));
    $out .= html_writer::empty_tag('path', array('fill' => "none", 'stroke' => 'url(#d)', 'stroke-width' => 7.1,
                                                 'd' => 'M40.2-38.8c10.9 28.2 60.7 28.8 69.5-.8'));
    $out .= html_writer::empty_tag('path', array('fill' => "none", 'stroke' => '#000', 'stroke-width' => 10,
                                                 'd' => 'M75.9-19.8 76.1.6'));
    $out .= html_writer::empty_tag('path', array('fill' => "none", 'stroke' => '#000', 'stroke-width' => 8.5,
                                                 'd' => 'M54.1 2.5C68 .7 82.6.5 98.4 2.5'));
    $out .= html_writer::empty_tag('path', array('fill' => "none", 'stroke' => '#fff', 'stroke-linecap' => 'round',
                                                 'stroke-width' => 5.1, 'd' => 'm45.8-83.3 27-.2M45.6-70l27-.1'));
    $out .= html_writer::empty_tag('path', array('fill' => "none", 'stroke' => '#fff', 'stroke-dasharray' => '30.4 5.1',
                                                 'stroke-linecap' => 'round', 'stroke-width' => 5.1, 'd' => 'm45.6-56.2 27-.2'));
    $out .= html_writer::end_tag('g');
    $out .= html_writer::end_tag('svg');
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

    if (!empty($_SERVER['REQUEST_URI'])) {
        redirect(switch_page(2));
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
 * Validate grading before we save it to the database.
 *
 * @param int $grading - grading to be validated
 * @param int $max - maximum value for this grading
 */
function validate_grading($grading, $max = 3) {
    $grading = $grading > $max ? 0 : $grading;
    $grading = $grading < 0 ? 0 : $grading;
    return round ($grading, 2);
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
    $attempt->fluency = validate_grading($evaluation->fluency->score, 4);
    $attempt->fluency_features = json_encode($evaluation->fluency->flu_features);
    $attempt->pronunciation = validate_grading($evaluation->pronunciation->score, 4);
    $attempt->pronunciation_features = json_encode($evaluation->pronunciation->pron_features);
    if ($assignment->attempttype == 'freeform') {
        $attempt->taskcompletion = validate_grading($evaluation->task_completion);
        $attempt->lexicogrammatical = validate_grading($evaluation->lexicogrammatical->score);
        $attempt->lexicogrammatical_features = json_encode($evaluation->lexicogrammatical->lexgram_features);
        $attempt->holistic = validate_grading($evaluation->holistic, 6);
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
    return html_writer::tag('button', get_string('results_delete-all', 'digitala'),
        array('id' => 'deleteAllButton', 'class' => 'btn btn-danger',
              'data-toggle' => 'modal', 'data-target' => '#deleteAllModal'));
}

/**
 * Add delete button to redirect and delete all attempts from the database.
 *
 * @param int $id - id of digitala instance
 * @return $button - button containing delete url
 */
function add_delete_all_redirect_button($id) {
    $deleteurl = delete_url($id);
    return html_writer::link($deleteurl, get_string('results_delete-confirm', 'digitala'),
        array('id' => 'deleteAllRedirectButton', 'class' => 'btn btn-danger'));
}

/**
 * Add button to open deletion modal for deleting single attempt.
 *
 * @param mixed $user - user object
 * @return $button - button that opens deletion modal
 */
function add_delete_attempt_button($user) {
    return html_writer::tag('button', get_string('results_delete', 'digitala'),
        array('id' => 'deleteButton'.$user->username, 'class' => 'btn btn-warning',
              'data-toggle' => 'modal', 'data-target' => '#deleteModal'.$user->id));
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
    return html_writer::link($deleteurl, get_string('results_delete-confirm', 'digitala'),
        array('id' => 'deleteRedirectButton'.$user->username, 'class' => 'btn btn-warning'));
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

    $timestamp = timestampformatter($attempt->timecreated);

    $cells = array($username, $score, $time, $tries, $status, $timestamp, $urllink, $deletebutton);
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
    $out = html_writer::div(get_string('feedback', 'digitala'), 'feedbackcontainer',
                            array('data-toggle' => 'collapse', 'data-target' => '#feedbacksite'));
    $out .= html_writer::start_tag('button', array('type' => 'button', 'class' => 'btn btn-primary', 'data-toggle' => 'collapse',
                                                   'data-target' => '#feedbacksite', 'id' => 'collapser'));
    $out .= html_writer::start_tag('svg', array('width' => 16, 'height' => 16, 'fill' => 'currentColor', 'id' => 'feedback',
                                                'class' => 'bi bi-chat-text-fill'));
    $out .= html_writer::empty_tag('path', array('d' => 'M16 8c0 3.9-3.6 7-8 7a9 9 0 0 1-2.3-.3c-.6.3-2 .9-4.2 1.2-.2 0-.4-.1-.'.
                                                        '3-.3.4-.9.7-2 .8-3A6.5 6.5 0 0 1 0 8c0-3.9 3.6-7 8-7s8 3.1 8 7zM4.5 5a.'.
                                                        '5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-'.
                                                        '1h-7zm0 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4z'));
    $out .= html_writer::end_tag('svg');
    $out .= html_writer::end_tag('button');
    $out .= html_writer::div('', 'collapse', array('id' => 'feedbacksite'));
    $out .= html_writer::tag('iframe', '', array('id' => 'feedbacksite', 'class' => 'collapse',
    'src' => get_config('digitala', 'feedback')));
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
 * Gets number of attempts remaining for the user.
 *
 * @param int $time timestamp in Unix epoch time
 * @return string $timestamp timestamp in format dd.mm.yyyy hh.mm:ss
 */
function timestampformatter($time) {
    $timestamp = date("d.m.Y H.i:s", $time);
    return $timestamp;
}


/**
 * Gets number of attempts remaining for the user.
 *
 * @param digitala_assignment $assignment - assignment containing id information
 * @param int $userid - id of the user
 */
function get_remaining_number($assignment, $userid) {
    $remaining = $assignment->attemptlimit;
    if ($remaining == 0) {
        return null;
    } else {
        $attempt = get_attempt($assignment->instanceid, $userid);
        if (isset($attempt)) {
            $remaining -= $attempt->attemptnumber;
        }
        return $remaining;
    }
}

/**
 * Creates attempt number visualization for assignment view.
 *
 * @param digitala_assignment $assignment - assignment containing id information
 * @param int $userid - id of the user
 */
function create_attempt_number($assignment, $userid) {
    $remaining = get_remaining_number($assignment, $userid);
    if (is_null($remaining)) {
        $out = get_string('attemptsunlimited', 'mod_digitala');
    } else {
        $out = get_string('attemptsremaining', 'mod_digitala', $remaining);
    }

    return $out;
}

/**
 * Creates html audio controls.
 *
 * @param string $url - url of the audio source
 */
function create_audio_controls($url) {
    $out = html_writer::start_tag('audio controls', array('title' => 'attempt_recording'));
    $out .= html_writer::empty_tag('source', array('src' => $url));
    $out .= html_writer::end_tag('audio');

    return $out;
}

/**
 * Creates modal with content
 *
 * @param string $id id of the modal
 * @param string $title title to be added to the modal
 * @param string $body text to be added to the body of the modal
 * @param string $buttons html objects to be added to the buttons section of the modal
 */
function create_modal($id, $title, $body, $buttons) {
    $out = html_writer::start_div('modal', array('id' => $id, 'tabindex' => '-1', 'role' => 'dialog'));
    $out .= html_writer::start_div('modal-dialog', array('role' => 'document'));
    $out .= html_writer::start_div('modal-content');
    $out .= html_writer::start_div('modal-header');
    $out .= html_writer::tag('h5', $title, array('class' => 'modal-title'));
    $out .= html_writer::start_tag('button', array('class' => 'close', 'data-dismiss' => 'modal',
                                                   'aria-label' => 'close-cross'));
    $out .= html_writer::span('&times;', '', array('aria-hidden' => 'true'));
    $out .= html_writer::end_tag('button');
    $out .= html_writer::end_div();
    $out .= html_writer::start_div('modal-body');
    $out .= html_writer::tag('p', $body);
    $out .= html_writer::end_div();
    $out .= html_writer::start_div('modal-footer');
    $out .= $buttons;
    $out .= html_writer::end_div();
    $out .= html_writer::end_div();
    $out .= html_writer::end_div();
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Creates attempt modal.
 *
 * @param digitala_assignment $assignment - assignment that this object is created for
 */
function create_attempt_modal($assignment) {
    $out = html_writer::tag('button', get_string('submit', 'mod_digitala'),
                            array('id' => 'submitModalButton', 'type' => 'button', 'class' => 'btn btn-primary ml-2',
                                  'data-toggle' => 'modal',  'data-target' => '#attemptModal', 'style' => 'display: none'));
    $id = 'attemptModal';
    $title = get_string('submittitle', 'digitala');
    $remaining = get_remaining_number($assignment, $assignment->userid);
    if (is_null($remaining)) {
        $body = get_string('attemptsunlimited', 'mod_digitala');
    } else {
        $body = get_string('submitbody', 'mod_digitala', $remaining);
    }
    $buttons = html_writer::tag('button', get_string('submitclose', 'mod_digitala'),
                                array('type' => 'button', 'class' => 'btn btn-secondary', 'data-dismiss' => 'modal'));
    $buttons .= create_answerrecording_form($assignment);
    $out .= create_modal($id, $title, $body, $buttons);

    return $out;
}

/**
 * Creates attempt modal.
 *
 * @param int $id - id of the activity
 * @param mixed $user - the user whose attempt ought to be deleted or null if deleting all attempts
 */
function create_delete_modal($id, $user = null) {
    if (isset($user)) {
        $modalid = 'deleteModal'.$user->id;
    } else {
        $modalid = 'deleteAllModal';
    }
    $title = get_string('results_delete-title', 'digitala');
    if (isset($user)) {
        $username = $user->firstname . ' ' . $user->lastname;
        $body = get_string('results_delete-one-text', 'digitala', $username);
    } else {
        $body = get_string('results_delete-all-text', 'digitala');
    }
    $buttons = html_writer::tag('button', get_string('submitclose', 'mod_digitala'),
                                array('type' => 'button', 'class' => 'btn btn-secondary', 'data-dismiss' => 'modal'));
    if (isset($user)) {
        $buttons .= add_delete_redirect_button($id, $user);
    } else {
        $buttons .= add_delete_all_redirect_button($id);
    }

    return create_modal($modalid, $title, $body, $buttons);
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
