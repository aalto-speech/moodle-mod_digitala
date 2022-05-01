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
 * mod_digitala data generator
 *
 * @package     mod_digitala
 * @category    test
 * @author      Alanen, Tuomas; Erkkilä, Joona; Harjunpää, Topi; Heijala, Maikki.
 * @copyright   2022 Helsingin Yliopisto
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_digitala_generator extends testing_module_generator {
    /**
     * @var int keep track of how many Digitalas have been created.
     */
    protected $digitalacount = 0;


    /**
     * To be called from data reset code only,
     * do not use in tests.
     * @return void
     */
    public function reset() {
        $this->digitalacount = 0;
        parent::reset();
    }

    /**
     * Create Digitala instance
     * @param stdClass $record
     * @param array $options
     * @return stdClass
     */
    public function create_instance($record = null, array $options = null) {
        $record = (object)(array)$record;

        if (!isset($record->name)) {
            $record->name = 'digitala ' . $this->digitalacount;
        }

        if (!isset($record->resources['format'])) {
            $record->resources = array('text' => $record->resources, 'format' => $record->resourcesformat);
        }

        if (!isset($record->information['format'])) {
            $record->information = array('text' => $record->information, 'format' => $record->informationformat);
        }

        return parent::create_instance($record, (array)$options);
    }
}
