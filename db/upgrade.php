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

/**
 * Digitala module upgrade function.
 * @param string $oldversion the version we are upgrading from.
 */
function xmldb_digitala_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2022022500) {

        // Define table digitala_attempts to be created.
        $table = new xmldb_table('digitala_attempts');

        // Adding fields to table digitala_attempts.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('digitala', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('file', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $table->add_field('transcript', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('fluency', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('fluencymean', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('speechrate', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('taskachievement', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('accuracy', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('lexicalprofile', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('nativeity', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('holistic', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table digitala_attempts.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('digitala', XMLDB_KEY_FOREIGN, ['digitala'], 'digitala', ['id']);
        $table->add_key('userid', XMLDB_KEY_FOREIGN, ['userid'], 'user', ['id']);

        // Conditionally launch create table for digitala_attempts.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Digitala savepoint reached.
        upgrade_mod_savepoint(true, 2022022500, 'digitala');
    }

    return true;
}