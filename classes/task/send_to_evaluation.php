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
 * The mod_digitala task for sending attempt to evaluation.
 *
 * @package    mod_digitala
 * @copyright  2022 Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_digitala\task;
defined('MOODLE_INTERNAL') || die();
require_once(__DIR__.'/../../locallib.php');

/**
 * Sends attempt to evaluation
 *
 * @package     mod_digitala
 * @author      Alanen, Tuomas; Erkkilä, Joona; Harjunpää, Topi; Heijala, Maikki.
 * @copyright   2022 Helsingin Yliopisto
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class send_to_evaluation extends \core\task\adhoc_task {
    /**
     * Return the task's name as shown in admin screens.
     *
     * @return string - task's name
     */
    public function get_name() {
        return get_string('task-send_to_evaluations', 'digitala');
    }

    /**
     * Sends attempt to evaluation.
     */
    public function execute() {
        global $DB;
        \set_time_limit(0);
        // Get the custom data.
        $data = $this->get_custom_data();
        mtrace('Evaluation in progress');
        $fs = get_file_storage();
        $fileinfo = $data->fileinfo;
        $file = $fs->get_file($fileinfo->contextid, $fileinfo->component, $fileinfo->filearea,
                          $fileinfo->itemid, $fileinfo->filepath, $fileinfo->filename);

        mtrace('File in evaluation: '.$file->get_filename().' - '.$file->get_itemid());

        $url = get_config('digitala', 'api');
        $key = get_config('digitala', 'key');
        $add = '?prompt=' . rawurlencode($data->assignment->servertext) . '&lang=' .
               $data->assignment->attemptlang . '&task=' . $data->assignment->attempttype . '&key=' . $key;
        $params = array('file' => $file);

        $c = new \curl(array('ignoresecurity' => true));
        $c->setopt(array('CURLOPT_CONNECTTIMEOUT' => 0, 'CURLOPT_TIMEOUT' => 1800));

        $evaluation = json_decode($c->post($url . $add, $params));
        mtrace('Evaluation answer from Aalto:');
        if (isset($evaluation->transcript)) {
            mtrace(json_encode($evaluation));
            save_attempt($data->assignment, $evaluation);
            mtrace('Evaluation done');
        } else {
            mtrace($evaluation);
            $attempt = get_attempt($data->assignment->instanceid, $data->assignment->userid);
            if ($attempt->status == 'waiting') {
                set_attempt_status($attempt, 'retry');
                mtrace('Evaluation in will be tried again');
            } else if ($attempt->status == 'retry') {
                save_failed_attempt($attempt, $data->assignment);
                mtrace('Evaluation failed totally');
            }
        }
    }
}
