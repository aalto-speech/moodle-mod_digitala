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

class send_to_evaluation extends \core\task\adhoc_task {
    public function execute() {
        // Get the custom data.
        $data = $this->get_custom_data();
        echo 'Evaluation in progress';
        $fs = get_file_storage();
        $fileinfo = $data->fileinfo;
        $file = $fs->get_file($fileinfo->contextid, $fileinfo->component, $fileinfo->filearea,
                          $fileinfo->itemid, $fileinfo->filepath, $fileinfo->filename);
        $url = get_config('digitala', 'api');
        $key = get_config('digitala', 'key');
        $add = '?prompt=' . rawurlencode($data->assignment->servertext) . '&lang=' .
               $data->assignment->attemptlang . '&task=' . $data->assignment->attempttype . '&key=' . $key;
        $params = array('file' => $file);

        $c = new \curl(array('ignoresecurity' => true));

        $evaluation = $c->post($url . $add, $params);
        save_attempt($data->assignment, $file->get_filename(), json_decode($evaluation), $data->length);
    }
}
