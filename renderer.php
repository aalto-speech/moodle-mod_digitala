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
        $out .= create_card('info', create_microphone_icon('info'));
        $out .= create_card('info', get_string('infotext', 'digitala') . create_microphone('info'));
        $out .= create_nav_buttons(0, $info->id, $info->d);
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

        $out .= start_column();
        $out .= create_card('assignment', create_assignment($assignment->assignmenttext));
        $out .= create_card('assignmentrecord', create_microphone('assignment').'<br>'.
                create_answerrecording_form($assignment));
        $out .= create_nav_buttons(1, $assignment->id, $assignment->d);
        $out .= end_column();

        $out .= start_column();
        $out .= create_card('assignmentresource', create_resource($assignment->resourcetext));
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
        $out = start_container('digitala-report');

        $out .= start_column();

        $attempt = get_attempt($report->instanceid);

        if (is_null($attempt)) {
            $out .= create_card('report', get_string('reportnotavailable', 'digitala'));
        } else {
            $out .= create_card('report', create_canvas());

            if ($report->attempttype == "freeform") {
                $gradings = create_report_grading('fluency', $attempt->fluency, 4);
                $gradings .= create_report_grading('accuracy', $attempt->accuracy, 4);
                $gradings .= create_report_grading('lexicalprofile', $attempt->lexicalprofile, 3);
                $gradings .= create_report_grading('nativeity', $attempt->nativeity, 4);

                $holistic = create_report_holistic(floor($attempt->holistic));

                $out .= create_report_transcription($attempt->transcript);
                $out .= create_report_tabs($gradings, $holistic);
            } else {
                $out .= create_report_gop($attempt->gop_score);
            }
        }
        $out .= create_nav_buttons(2, $report->id, $report->d);
        $out .= end_column();

        $out .= end_container();
        return $out;
    }
}
