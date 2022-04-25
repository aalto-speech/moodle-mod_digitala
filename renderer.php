<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This file contains a renderer for the digitala class
 *
 * @package   mod_digitala
 * @copyright 2022 Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once(__DIR__.'/locallib.php');
require_once(__DIR__.'/reporteditor_form.php');

/**
 * A custom renderer class that extends the plugin_renderer_base and is used by the digitala module.
 *
 * @package mod_digitala
 * @copyright 2022 Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_digitala_renderer extends plugin_renderer_base {

    /**
     * Renders the progress bar.
     *
     * @param digitala_progress_bar $progressbar - An instance of digitala_progress_bar to render.
     * @return $out - HTML string to output.
     */
    protected function render_digitala_progress_bar(digitala_progress_bar $progressbar) {
        $spacers = calculate_progress_bar_spacers($progressbar->currpage);
        $out = start_progress_bar();
        $out .= create_progress_bar_step('info', 0, $progressbar->id, $progressbar->d, $progressbar->currpage);
        $out .= create_progress_bar_spacer($spacers['left']);
        $out .= create_progress_bar_step('assignment', 1, $progressbar->id, $progressbar->d, $progressbar->currpage);
        $out .= create_progress_bar_spacer($spacers['right']);
        $out .= create_progress_bar_step('report', 2, $progressbar->id, $progressbar->d, $progressbar->currpage);
        $out .= end_progress_bar();
        return $out;
    }

    /**
     * Renders the info panel.
     *
     * @param digitala_info $info - An instance of digitala_info to render.
     * @return $out - HTML string to output.
     */
    protected function render_digitala_info(digitala_info $info) {
        $out = start_container('digitala-info');

        // For the info text and microphone.
        $out .= start_column();
        $out .= create_card('microphone', create_microphone_icon());
        $out .= create_card('info', get_string('infotext', 'digitala') . create_microphone());
        $out .= create_nav_buttons('info', $info->id, $info->d);
        $out .= end_column();

        $out .= end_container();
        return $out;
    }

    /**
     * Renders the assignment panel.
     *
     * @param digitala_assignment $assignment - An instance of digitala_assignment to render.
     * @return $out - HTML string to output.
     */
    protected function render_digitala_assignment(digitala_assignment $assignment) {
        $out = start_container('digitala-assignment');

        $out .= start_column('-4');
        $out .= create_card('assignment', create_assignment($assignment->assignmenttext));

        $attempt = get_attempt($assignment->instanceid, $assignment->userid);
        if (isset($attempt) && ($attempt->status == 'waiting' || $attempt->status == 'retry')) {
            $url = str_replace('page=1', 'page=2', $_SERVER['REQUEST_URI']);
            $out .= create_card('assignmentrecord', get_string('results_waiting-info', 'digitala'));
            $out .= html_writer::tag('a', get_string('results_waiting-refresh', 'digitala'),
                array('id' => 'nextButton', 'class' => 'btn btn-primary', 'href' => $url));
        } else if ($assignment->attemptlimit != 0 && isset($attempt) && $attempt->attemptnumber >= $assignment->attemptlimit) {
            $out .= create_card('assignmentrecord', get_string('alreadysubmitted', 'digitala'));
            $out .= create_nav_buttons('assignmentnext', $assignment->id, $assignment->d);
        } else {
            $out .= create_card('assignmentrecord', create_attempt_number($assignment, $assignment->userid).
                                                    save_answerrecording_form($assignment).
                                                    create_microphone($assignment->maxlength).
                                                    create_attempt_modal($assignment));
            $out .= create_nav_buttons('assignmentprev', $assignment->id, $assignment->d);
        }
        $out .= end_column();

        $out .= start_column();
        $out .= create_card('assignmentresource', create_resource($assignment));
        $out .= end_column();

        $out .= end_container();
        return $out;
    }

    /**
     * Renders the report panel.
     *
     * @param digitala_report $report - An instance of digitala_report to render.
     * @return $out - HTML string to output.
     */
    protected function render_digitala_report(digitala_report $report) {
        global $USER, $CFG;

        $out = start_container('digitala-report');

        $out .= start_column();

        $attempt = get_attempt($report->instanceid, $report->student);
        $remaining = $report->attemptlimit;

        if (is_null($attempt)) {
            $out .= create_card('report-title', get_string('reportnotavailable', 'digitala'));
        } else if ($attempt->status == 'waiting') {
            $remaining -= $attempt->attemptnumber;
            $out .= create_report_waiting();
        } else if ($attempt->status == 'retry') {
            $remaining -= $attempt->attemptnumber;
            $out .= create_report_retry();
        } else if ($attempt->status == 'evaluated' || $attempt->status == 'failed') {
            $remaining -= $attempt->attemptnumber;
            $feedback = get_feedback($attempt);
            $audiourl = moodle_url::make_pluginfile_url($report->contextid, 'mod_digitala', 'recordings', 0, '/',
                                                        $attempt->file, false);
            if (isset($feedback)) {
                $reporttitle = 'report-title-feedback';
            } else {
                $reporttitle = 'report-title';
            }
            $out .= create_card($reporttitle, get_string('reportinformation', 'digitala').
                                          '<br><br>'.create_attempt_number($report, $report->student).
                                          '<br><br><audio title="attempt_recording" controls><source src='.$audiourl.'></audio>');

            $information = create_report_information($report);

            if (isset($feedback)) {
                $gradings = create_report_grading('fluency', $attempt->fluency, 4,
                                                  $feedback->fluency, $feedback->fluency_reason);
                $gradings .= create_report_grading('pronunciation', $attempt->pronunciation, 4,
                                                   $feedback->pronunciation, $feedback->pronunciation_reason);
            } else {
                $gradings = create_report_grading('fluency', $attempt->fluency, 4);
                $gradings .= create_report_grading('pronunciation', $attempt->pronunciation, 4);
            }
            if ($report->attempttype == 'freeform') {
                if (isset($feedback)) {
                    $gradings .= create_report_grading('taskcompletion', $attempt->taskcompletion, 3,
                                                       $feedback->taskcompletion, $feedback->taskcompletion_reason);
                    $gradings .= create_report_grading('lexicogrammatical', $attempt->lexicogrammatical, 3,
                                                       $feedback->lexicogrammatical, $feedback->lexicogrammatical_reason);
                } else {
                    $gradings .= create_report_grading('taskcompletion', $attempt->taskcompletion, 3);
                    $gradings .= create_report_grading('lexicogrammatical', $attempt->lexicogrammatical, 3);
                }

                $holistic = create_report_holistic(floor($attempt->holistic), $feedback);

                $out .= create_report_transcription($attempt->transcript);
                $out .= create_report_tabs($gradings, $holistic, $information);
            } else {
                $out .= create_transcript_toggle($attempt->transcript, $attempt->feedback);
                $out .= $gradings;
                $out .= $information;
            }
            if ($report->student != $USER->id && $attempt->status == 'evaluated') {
                $out .= '<a class="btn btn-primary" href="'.$CFG->wwwroot.
                        '/mod/digitala/reporteditor.php?id='.$report->id.'&student='.$report->student.'">'.
                        get_string('teacher-feedback', 'digitala').'</a>';
            }
        } else {
            $out .= create_card('report-title', get_string('reportnotavailable', 'digitala'));
        }

        $out .= create_nav_buttons('report', $report->id, $report->d, $remaining);
        $out .= create_fixed_box();
        $out .= end_column();

        $out .= end_container();
        return $out;
    }

    /**
     * Renders the results panel for teacher.
     *
     * @param digitala_results $result - An instance of digitala_results to render.
     * @return $out - HTML string to output.
     */
    protected function render_digitala_results(digitala_results $result) {
        $out = html_writer::tag('h5', get_string('results_title', 'digitala'));
        $attempts = get_all_attempts($result->instanceid);

        if (count($attempts) > 0) {
            $table = new html_table();

            $headers = array(
                new html_table_cell(get_string('results_student', 'digitala')),
                new html_table_cell(get_string('results_score', 'digitala')),
                new html_table_cell(get_string('results_time', 'digitala')),
                new html_table_cell(get_string('results_tries', 'digitala')),
                new html_table_cell(get_string('results_status', 'digitala')),
                new html_table_cell(get_string('results_report', 'digitala')),
                new html_table_cell(add_delete_all_attempts_button()));
            foreach ($headers as $value) {
                $value->header = true;
            }
            $out .= create_delete_modal($result->id);

            $table->data[] = $headers;

            foreach ($attempts as $attempt) {
                $user = get_user($attempt->userid);
                $row = create_result_row($attempt, $result->id, $user);
                $out .= create_delete_modal($result->id, $user);
                foreach ($row as $cell) {
                    $cell = new html_table_cell($cell);
                }
                $table->data[] = $row;
            }

            $out .= html_writer::table($table);

            $out .= create_export_buttons($result->id);

        } else {
            $out .= get_string('results_no-show', 'digitala');
        }

        return $out;
    }

    /**
     * Renders the assignment panel.
     *
     * @param digitala_short_assignment $assignment - An instance of digitala_short_assignment to render.
     * @return $out - HTML string to output.
     */
    protected function render_digitala_short_assignment(digitala_short_assignment $assignment) {
        $attemptinfo = get_string('attemptlang', 'digitala').': '.get_string($assignment->attemptlang, 'digitala').
                                  ' | '.get_string('attempttype', 'digitala').': '.
                                  get_string($assignment->attempttype, 'digitala').'<br>';
        $assignmentcard = create_card('assignment', $attemptinfo.$assignment->assignmenttext);
        $resources = file_rewrite_pluginfile_urls($assignment->resourcetext, 'pluginfile.php', $assignment->contextid,
                                                  'mod_digitala', 'files', 0);
        $resourcescard = create_card('assignmentresource', $resources);

        $out = start_container('digitala-short_assignment');
        $out .= start_column();
        $out .= create_short_assignment_tabs($assignmentcard, $resourcescard);
        $out .= end_column();
        $out .= end_container();

        return $out;
    }

    /**
     * Renders the report editor panel.
     *
     * @param digitala_report_editor $reporteditor - An instance of digitala_report_editor to render.
     * @return $out - HTML string to output.
     */
    protected function render_digitala_report_editor(digitala_report_editor $reporteditor) {
        global $CFG;

        $attempt = get_attempt($reporteditor->instanceid, $reporteditor->student);
        if (!isset($attempt->id)) {
            redirect($CFG->wwwroot.'/mod/digitala/report.php?id='.$reporteditor->id.'&mode=overview',
                     get_string('feedback_not-found', 'digitala'),
                     null, \core\output\notification::NOTIFY_ERROR);
        }
        $form = new \reporteditor_form($reporteditor->id, $reporteditor->attempttype, $attempt);

        $out = '';

        if ($form->is_cancelled()) {
            redirect($CFG->wwwroot.'/mod/digitala/report.php?id='.$reporteditor->id.'&mode=detail&student='
                     .$reporteditor->student);
        } else if ($fromform = $form->get_data()) {
            // In the future third phase, update evaluation in digitala_attempt here...
            save_report_feedback($reporteditor->attempttype, $fromform, $attempt);
            redirect($CFG->wwwroot.'/mod/digitala/report.php?id='.$reporteditor->id.'&mode=detail&student='
                     .$reporteditor->student, get_string('feedback_success', 'digitala'),
                     null, \core\output\notification::NOTIFY_SUCCESS);
        } else {
            $out = start_container('digitala-report_editor');
            $out .= start_column();
            $out .= create_card('edit_report', $form->render());
            $out .= end_column();
            $out .= end_container();
        }

        return $out;
    }
    /**
     * Renders digitala attempt deletion.
     *
     * @param digitala_delete $delete - An instance of digitala_delete to render.
     */
    protected function render_digitala_delete(digitala_delete $delete) {
        global $CFG;
        if ($delete->studentid) {
            delete_attempt($delete->instanceid, $delete->studentid);
        } else {
            delete_all_attempts($delete->instanceid);
        }

        redirect($CFG->wwwroot.'/mod/digitala/report.php?id='.$delete->id.'&mode=overview');
    }
}
