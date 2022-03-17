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
 * Used to generate page urls for digitala module.
 *
 * @param number $page number of the step
 * @param number $id id of the course module
 * @param number $d id of the activity instance
 */
function page_url($page, $id, $d) {
    return new moodle_url('/mod/digitala/view.php', array('id' => $id, 'd' => $d, 'page' => $page));
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
        $title = '<span class="pb-num active">'.$pageout.'</span>'.$name;
    } else {
        $title = '<span class="pb-num">'.$pageout.'</span>'.$name;
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
    } else if ($mode == 'right-empty') {
        $out = html_writer::start_div('pb-spacer pb-spacer-right');
    } else {
        $out = html_writer::start_div('pb-spacer');
    }
    $out .= '<svg width="100%" height="100%" viewBox="0 0 275 500"
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

    $out .= html_writer::tag('h5', get_string($header, 'digitala'), array("class" => 'card-title'));
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
    $out = html_writer::start_div('card-body');
    $out .= html_writer::tag('h5', '', array('class' => 'card-title'));
    $out .= html_writer::div($content, 'card-text scrollbox200');
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Used to create text inside resource card - helper function for box sizing
 *
 * @param string $content text inside resource text card
 */
function create_resource($content) {
    $out = html_writer::start_div('card-body');
    $out .= html_writer::tag('h5', '', array('class' => 'card-title'));
    $out .= html_writer::div($content, 'card-text scrollbox400');
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Draws star gradings
 *
 * @param int $filled number of filled stars to draw
 * @param int $total number of to draw in totaldraw_report
 */
function create_report_stars($filled, $total) {
    $out = '';

    for ($i = 1; $i <= $total; $i++) {
        if ($i <= $filled) {
            $out .= "\u{2605}";
        } else {
            $out .= "\u{2606}";
        }
    }

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

    $out .= html_writer::tag('h5', get_string($name, 'digitala'), array("class" => 'card-title'));

    $out .= html_writer::tag('h5', create_report_stars($grade, $maxgrade), array("class" => 'grade-stars'));
    $out .= html_writer::tag('h6', floor($grade) . '/' . $maxgrade, array("class" => 'grade-number'));

    $out .= html_writer::div(get_string($name.'_score-' . floor($grade), 'digitala'), 'card-text');

    $out .= html_writer::end_div();
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Creates grading information container from report
 *
 * @param int $grade grading number given by the server
 */
function create_report_holistic($grade) {
    $out = html_writer::start_div('card row digitala-card');
    $out .= html_writer::start_div('card-body');

    $out .= html_writer::tag('h5', get_string('holistic', 'digitala'), array("class" => 'card-title'));

    $out .= html_writer::tag('h6', get_string('holistic_level-'.$grade, 'digitala'), array("class" => 'grade-number'));

    $out .= html_writer::div(get_string('holistic_score-'.$grade, 'digitala'), 'card-text');

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

    $out .= html_writer::tag('h5', get_string('gop', 'digitala'), array("class" => 'card-title'));

    $out .= html_writer::tag('h6', $grade * 100 . '/100', array("class" => 'grade-number'));

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

    $out .= html_writer::tag('h5', get_string('digitalatranscription', 'digitala'), array('class' => 'card-title'));

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
 */
function create_report_tabs($gradings, $holistic) {
    $out = html_writer::start_tag('nav');
    $out .= html_writer::start_div('nav nav-tabs', array('id' => 'nav-tab', 'role' => 'tablist'));
    $out .= html_writer::tag('button', get_string('task_grades', 'digitala'),
                             array('class' => "nav-link active ml-2", 'id' => 'report-grades-tab', 'data-toggle' => 'tab',
                                   'href' => '#report-grades', 'role' => 'tab', 'aria-controls' => 'report-grades',
                                   'aria-selected' => 'true'));
    $out .= html_writer::tag('button', get_string('holistic', 'digitala'),
                             array('class' => "nav-link ml-2", 'id' => 'report-holistic-tab', 'data-toggle' => 'tab',
                                   'href' => '#report-holistic', 'role' => 'tab', 'aria-controls' => 'report-holistic',
                                   'aria-selected' => 'false'));
    $out .= html_writer::end_div();
    $out .= html_writer::end_tag('nav');

    $out .= html_writer::start_div('tab-content', array('id' => 'nav-tabContent'));
    $out .= html_writer::div($gradings, 'tab-pane fade show active',
                            array('id' => 'report-grades', 'role' => 'tabpanel', 'aria-labelledby' => 'report-grades-tab'));
    $out .= html_writer::div($holistic, 'tab-pane fade',
                            array('id' => 'report-holistic', 'role' => 'tabpanel', 'aria-labelledby' => 'report-holistic-tab'));
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
 *
 */
function create_button($id, $class, $text) {
    $out = html_writer::tag('button', $text, array('id' => $id, 'class' => $class));
    return $out;
}

/**
 * Creates navigation buttons with identical id and class
 *
 * @param number $page number of the step
 * @param number $id id of the course module
 * @param number $d id of the activity instance
 */
function create_nav_buttons($page, $id, $d) {
    $out = html_writer::start_div('navbuttons');
    if ($page == 0) {
        $newurl = page_url(1, $id, $d);
        $out .= html_writer::tag('a href=' . $newurl, get_string('digitalanavnext', 'digitala'),
                array('id' => 'nextButton', 'class' => 'btn btn-primary'));
    } else if ($page == 1) {
        $newurl = page_url(0, $id, $d);
        $out .= html_writer::tag('a href=' . $newurl, get_string('digitalanavprevious', 'digitala'),
                array('id' => 'prevButton', 'class' => 'btn btn-primary'));
    } else if ($page == 2) {
        $newurl = page_url(0, $id, $d);
        $out .= html_writer::tag('a href=' . $newurl, get_string('digitalanavstartagain', 'digitala'),
                array('id' => 'tryAgainButton', 'class' => 'btn btn-primary'));
        $out .= html_writer::tag('a href=' .
                'https://link.webropolsurveys.com/Participation/Public/2c1ccd52-6e23-436e-af51-f8f8c259ffbb?displayId=Fin2500048' .
                'target=_blank', get_string('digitalanavfeedback', 'digitala'),
                array('id' => 'feedbackButton', 'class' => 'btn btn-primary'));
    }
    $out .= html_writer::end_div();

    return $out;
}

/**
 * Creates an instance of microphone with start and stop button
 *
 * @param string $id
 */
function create_microphone($id) {
    $out = html_writer::tag('br', '');
    $out .= create_button('record', 'btn btn-primary record-btn', 'Start');
    $out .= create_button('stopRecord', 'btn btn-primary stopRecord-btn', 'Stop');
    $out .= create_button('listenButton', 'btn btn-primary listen-btn', 'Listen recording');

    return $out;
}

/**
 * Creates the microphone icon for the microphone view
 *
 * @param string $id
 */
function create_microphone_icon($id) {
    $out = html_writer::start_div('', array('id' => 'microphoneIconBox'));
    $out .= html_writer::end_div();
    $out .= html_writer::tag('img src=' . 'pix/mic.svg', '', array('id' => 'microphoneIcon'));
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
    $curlurl = 'http://digitalamoodle.aalto.fi:5000';
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
 */
function save_attempt($assignment, $filename, $evaluation) {
    global $DB;

    if ($DB->record_exists('digitala_attempts', array('digitala' => $assignment->instanceid,
                                                      'userid' => $assignment->userid))) {
        return;
    }

    $attempt = new stdClass();
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

    $timenow = time();

    $attempt->timecreated = $timenow;
    $attempt->timemodified = $timenow;

    $DB->insert_record('digitala_attempts', $attempt);
}

/**
 * Load current users attempt from the database.
 *
 * @param int $instanceid - instance id of this digitala activity
 * @return mixed $attempt - object containing attempt information
 */
function get_attempt($instanceid) {
    global $DB, $USER;

    if (!$DB->record_exists('digitala_attempts', array('digitala' => $instanceid, 'userid' => $USER->id))) {
        return null;
    }

    $attempt = $DB->get_record('digitala_attempts', array('digitala' => $instanceid, 'userid' => $USER->id));

    return $attempt;
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

    $out = '<br> <b>File URL:</b> '.moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(),
                                                                    $file->get_filearea(), $file->get_itemid(),
                                                                    $file->get_filepath(), $file->get_filename(), true).'<br>';

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

    $out;

    if (!isset(json_decode($evaluation)->prompt)) {
        $out .= 'No evaluation was found. Please return to previous page.';
    } else {
        save_attempt($assignment, $file->get_filename(), json_decode($evaluation));
        $url = $_SERVER['REQUEST_URI'];
        $newurl = str_replace('page=1', 'page=2', $url);
        $out = header('Location: ' . $newurl);
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
 * Creates a canvas.
 */
function create_canvas() {
    $out = html_writer::tag('canvas', '', array('id' => 'kaavio', 'height' => '40px'));
    return $out;
}
