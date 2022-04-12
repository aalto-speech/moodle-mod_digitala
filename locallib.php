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
    $out = html_writer::start_div($classname);
    $out .= html_writer::start_div('container-fluid');
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
 */
function start_column() {
    $out = html_writer::start_div('col digitala-column');
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
 * @param string $content text inside resource text card
 */
function create_resource($content) {
    $out = html_writer::div($content, 'card-text scrollbox400');

    return $out;
}

/**
 * Creates grading information container from report
 *
 * @param string $name name of the grading
 * @param int $grade grading number given by the server
 * @param int $maxgrade maximum number of this grade
 */
function create_report_grading($name, $grade, $maxgrade) {
    $out = html_writer::start_div('card row digitala-card');
    $out .= html_writer::start_div('card-body');

    $out .= html_writer::tag('h5', get_string($name, 'digitala'), array('class' => 'card-title'));

    $out .= create_chart($name, $grade, $maxgrade);
    $out .= html_writer::tag('h6', floor($grade) . '/' . $maxgrade, array('class' => 'grade-number'));

    $out .= html_writer::div(get_string($name.'_description', 'digitala').
                             lcfirst(get_string($name.'_score-' . floor($grade), 'digitala')), 'card-text');

    $out .= html_writer::end_div();
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Creates holistic information container from report
 *
 * @param int $grade grading number given by the server
 */
function create_report_holistic($grade) {
    $out = html_writer::start_div('card row digitala-card');
    $out .= html_writer::start_div('card-body');

    $out .= html_writer::tag('h5', get_string('holistic', 'digitala'), array('class' => 'card-title'));

    $out .= create_chart('holistic', $grade, 6);
    $out .= html_writer::tag('h6', get_string('holistic_level-'.$grade, 'digitala'), array('class' => 'grade-number'));

    $out .= html_writer::div(get_string('holistic_description', 'digitala').get_string('holistic_level-'.$grade, 'digitala').
                             ':<br>'.get_string('holistic_score-'.$grade, 'digitala'), 'card-text');

    $out .= html_writer::end_div();
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Creates more information container from report
 *
 * @param string $text information to show on report page given by the server
 */
function create_report_information($text) {
    $out = html_writer::start_div('card row digitala-card');
    $out .= html_writer::start_div('card-body');

    $out .= html_writer::tag('h5', get_string('moreinformation', 'digitala'), array('class' => 'card-title'));

    $out .= html_writer::div($text, 'card-text');

    $out .= html_writer::end_div();
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Creates grading information container from report
 *
 * @param int $grade grading number given by the server
 */
function create_report_gop($grade) {
    $out = html_writer::start_div('card row digitala-card');
    $out .= html_writer::start_div('card-body');

    $out .= html_writer::tag('h5', get_string('gop', 'digitala'), array('class' => 'card-title'));

    $out .= html_writer::tag('h6', $grade * 100 . '%', array('class' => 'grade-number'));

    $out .= html_writer::div(get_string('gop_score-'.floor($grade * 10), 'digitala'), 'card-text');

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
 * Creates tab navigation and contents for report view
 *
 * @param string $gradings html content of gradings shown
 * @param string $holistic html content of holistic shown
 * @param string $information html content of more information shown
 */
function create_report_tabs($gradings, $holistic, $information) {
    $out = html_writer::start_tag('nav');
    $out .= html_writer::start_div('nav nav-tabs', array('id' => 'nav-tab', 'role' => 'tablist'));
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
    $out .= html_writer::start_div('nav nav-tabs', array('id' => 'nav-tab', 'role' => 'tablist'));
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

    $out = html_writer::tag('br', '');
    $out .= html_writer::div($starticon, '', array('id' => 'startIcon', 'style' => 'display: none;'));
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
 * Send user audio file to Aalto ASR for evaluation.
 *
 * @param stored_file $file - audio file to be sent for evaluation
 * @param string $assignmenttext - assignment text given for students
 * @param string $lang - language (fin or sve) chosen for the assignment
 * @param string $type - type of assignment (readaloud or freeform)
 * @param string $key - keystring for server communication
 */
function send_answerrecording_for_evaluation($file, $assignmenttext, $lang, $type, $key) {
    $assignmenttextraw = format_string($assignmenttext);
    $c = new curl(array('ignoresecurity' => true));
    $curlurl = get_config('digitala', 'api');
    $key = get_config('digitala', 'key');
    $curladd = '?prompt=' . rawurlencode($assignmenttextraw) . '&lang='. $lang . '&task=' . $type . '&key=' . $key;
    $curlparams = array('file' => $file);
    $json = $c->post($curlurl . $curladd, $curlparams);
    return $json;
}

/**
 * Save the attempt to the database.
 *
 * @param digitala_assignment $assignment - assignment includes needed identifications
 * @param string $filename - file name of the recording
 * @param mixed $evaluation - mixed object containing evaluation info
 * @param mixed $recordinglength - length of recording in seconds
 */
function save_attempt($assignment, $filename, $evaluation, $recordinglength) {
    global $DB;

    $attempt = get_attempt($assignment->instanceid, $assignment->userid);

    if (isset($attempt)) {
        $attempt->attemptnumber++;
    } else {
        $attempt = new stdClass();
    }

    $timenow = time();

    $attempt->digitala = $assignment->instanceid;
    $attempt->userid = $assignment->userid;
    $attempt->file = $filename;
    if (isset($evaluation->Transcript)) {
        $attempt->transcript = $evaluation->Transcript;
    }
    if (isset($evaluation->Fluency)) {
        $attempt->fluency = $evaluation->Fluency->score;
        $attempt->fluencymean = $evaluation->Fluency->mean_f1;
        $attempt->speechrate = $evaluation->Fluency->speech_rate;
        $attempt->taskachievement = $evaluation->TaskAchievement;
        $attempt->accuracy = $evaluation->Accuracy->score;
        $attempt->lexicalprofile = $evaluation->Accuracy->lexical_profile;
        $attempt->nativeity = $evaluation->Accuracy->nativeity;
        $attempt->holistic = $evaluation->Holistic;
    } else {
        $attempt->gop_score = $evaluation->GOP_score;
    }
    $attempt->timemodified = $timenow;
    $attempt->recordinglength = $recordinglength;

    if (isset($attempt->attemptnumber)) {
        $DB->update_record('digitala_attempts', $attempt);
    } else {
        $attempt->timecreated = $timenow;
        $DB->insert_record('digitala_attempts', $attempt);
    }

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

    if ($attempttype == 'freeform') {

        $feedback->old_taskachievement = $oldattempt->taskachievement;
        $feedback->taskachievement = $fromform->taskachievement;
        $feedback->taskachievement_reason = $fromform->taskachievementreason;

        $feedback->old_fluency = $oldattempt->fluency;
        $feedback->fluency = $fromform->fluency;
        $feedback->fluency_reason = $fromform->fluencyreason;

        $feedback->old_nativeity = $oldattempt->nativeity;
        $feedback->nativeity = $fromform->nativeity;
        $feedback->nativeity_reason = $fromform->nativeityreason;

        $feedback->old_lexicalprofile = $oldattempt->lexicalprofile;
        $feedback->lexicalprofile = $fromform->lexicalprofile;
        $feedback->lexicalprofile_reason = $fromform->lexicalprofilereason;

        $feedback->old_holistic = $oldattempt->holistic;
        $feedback->holistic = $fromform->holistic;
        $feedback->holistic_reason = $fromform->holisticreason;

    } else if ($attempttype == 'readaloud') {
        $feedback->old_gop_score = $oldattempt->gop_score;
        $feedback->gop_score = $fromform->gop;
        $feedback->gop_score_reason = $fromform->gopreason;
    }

    $timenow = time();

    $feedback->timecreated = $timenow;

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

    $attempts = $DB->get_records('digitala_attempts', array('digitala'  => $instanceid));
    return $attempts;
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
 * @return $cells - cells containing table data
 */
function create_result_row($attempt, $id) {
    $user = get_user($attempt->userid);

    $username = $user->firstname . ' ' . $user->lastname;
    if ($attempt->holistic) {
        $score = $attempt->holistic;
    } else {
        $score = $attempt->gop_score;
    }
    $time = convertsecondstostring($attempt->recordinglength);
    $tries = ($attempt->attemptnumber);

    $urltext = results_url($id, 'detail', $attempt->userid);
    $urllink = html_writer::link($urltext, get_string('results_link', 'digitala'));

    $cells = array($username, $score, $time, $tries, $urllink);
    return $cells;
}

/**
 * Save user recored audio to server and send it to Aalto ASR for evaluation.
 *
 * @param array $formdata - form data includes audio as base64 encoded string
 * @param digitala_assignment $assignment - assignment includes needed identifications
 */
function save_answerrecording($formdata, $assignment) {
    $fs = get_file_storage();

    $audiofile = json_decode($formdata->audiostring);
    $recordinglength = $formdata->recordinglength;

    $fileinfo = array(
        'contextid' => $assignment->contextid,
        'component' => 'mod_digitala',
        'filearea' => 'recordings',
        'itemid' => 0,
        'filepath' => '/',
        'filename' => $audiofile->file
    );

    file_save_draft_area_files($audiofile->id, $fileinfo['contextid'], $fileinfo['component'],
                                $fileinfo['filearea'], $fileinfo['itemid']);

    $file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],
                          $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']);

    // Change key to a hidden value later on.
    $key = 'aalto';
    $texttoaalto = $assignment->assignmenttext;
    if ($assignment->attempttype == 'readaloud') {
        $texttoaalto = $assignment->resourcetext;
    }

    $evaluation = send_answerrecording_for_evaluation(
            $file,
            $texttoaalto,
            $assignment->attemptlang,
            $assignment->attempttype, $key
        );

    if (!isset(json_decode($evaluation)->prompt)) {
        $out = get_string('error_no-evaluation', 'digitala');
    } else {
        save_attempt($assignment, $file->get_filename(), json_decode($evaluation), $recordinglength);
        if (isset($_SERVER['REQUEST_URI'])) {
            $url = $_SERVER['REQUEST_URI'];
            $newurl = str_replace('page=1', 'page=2', $url);
            redirect($newurl);
        } else {
            $out = get_string('error_url-not-set', 'digitala');
        }
    }

    return $out;
}

/**
 * Handles answer recording form's actions
 *
 * @param digitala_assignment $assignment - assignment includes needed identifications
 */
function create_answerrecording_form($assignment) {
    if ($formdata = $assignment->form->get_data()) {
        $out = save_answerrecording($formdata, $assignment);
    } else {
        $out = $assignment->form->render();
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
    $out = html_writer::tag('canvas', '', array('id' => $name, 'data-eval-name' => $name, 'data-eval-grade' => $grade,
                                                'data-eval-maxgrade' => $maxgrade, 'class' => 'report-chart', 'height' => '40px'));
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
