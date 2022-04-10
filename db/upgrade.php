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

    if ($oldversion < 2022030702) {

        // Define field attemptlang to be added to digitala.
        $table = new xmldb_table('digitala');
        $field = new xmldb_field('attemptlang', XMLDB_TYPE_TEXT, null, null, null, null, null, 'introformat');

        // Conditionally launch add field attemptlang.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $field = new xmldb_field('attempttype', XMLDB_TYPE_TEXT, null, null, null, null, null, 'attemptlang');

        // Conditionally launch add field attemptlang.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $field = new xmldb_field('assignment', XMLDB_TYPE_TEXT, null, null, null, null, null, 'attempttype');

        // Conditionally launch add field attemptlang.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $field = new xmldb_field('resources', XMLDB_TYPE_TEXT, null, null, null, null, null, 'assignment');

        // Conditionally launch add field attemptlang.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Digitala savepoint reached.
        upgrade_mod_savepoint(true, 2022030702, 'digitala');
    }

    if ($oldversion < 2022030703) {

        // Define field assignmentformat to be added to digitala.
        $table = new xmldb_table('digitala');
        $field = new xmldb_field('assignmentformat', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '0', 'assignment');

        // Conditionally launch add field attemptlang.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field assignmentformat to be added to digitala.
        $table = new xmldb_table('digitala');
        $field = new xmldb_field('resourcesformat', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '0', 'resources');

        // Conditionally launch add field attemptlang.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Digitala savepoint reached.
        upgrade_mod_savepoint(true, 2022030703, 'digitala');
    }

    if ($oldversion < 2022031601) {

        // Define field gop_score to be added to digitala_attempts.
        $table = new xmldb_table('digitala_attempts');
        $field = new xmldb_field('gop_score', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null, 'holistic');

        // Conditionally launch add field gop_score.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Digitala savepoint reached.
        upgrade_mod_savepoint(true, 2022031601, 'digitala');
    }

    if ($oldversion < 2022040102) {

        // Define field attemptlimit to be added to digitala.
        $table = new xmldb_table('digitala');
        $field = new xmldb_field('attemptlimit', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'resources');

        // Conditionally launch add field attemptlimit.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $table = new xmldb_table('digitala_attempts');
        $field = new xmldb_field('attemptnumber', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '1', 'userid');

        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Digitala savepoint reached.
        upgrade_mod_savepoint(true, 2022040102, 'digitala');
    }

    if ($oldversion < 2022040103) {

        // Define field maxlength to be added to digitala.
        $table = new xmldb_table('digitala');
        $field = new xmldb_field('maxlength', XMLDB_TYPE_INTEGER, '10', null, null, null, '0', 'resourcesformat');

        // Conditionally launch add field maxlength.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field maxlength to be added to digitala_attempts.
        $table = new xmldb_table('digitala_attempts');
        $field = new xmldb_field('recordinglength', XMLDB_TYPE_INTEGER, '10', null, null, null, '0', 'timemodified');

        // Conditionally launch add field maxlength.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Digitala savepoint reached.
        upgrade_mod_savepoint(true, 2022040103, 'digitala');
    }

    if ($oldversion < 2022041001) {

        // Define table digitala_report_feedback to be created.
        $table = new xmldb_table('digitala_report_feedback');

        // Adding fields to table digitala_report_feedback.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('attempt', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('old_fluency', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('fluency', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('fluency_reason', XMLDB_TYPE_TEXT, null, null, null, null, null, null);
        $table->add_field('old_accuracy', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('accuracy', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('accuracy_reason', XMLDB_TYPE_TEXT, null, null, null, null, null, null);
        $table->add_field('old_lexicalprofile', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('lexicalprofile', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('lexicalprofile_reason', XMLDB_TYPE_TEXT, null, null, null, null, null, null);
        $table->add_field('old_nativeity', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('nativeity', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('nativeity_reason', XMLDB_TYPE_TEXT, null, null, null, null, null, null);
        $table->add_field('old_holistic', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('holistic', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('holistic_reason', XMLDB_TYPE_TEXT, null, null, null, null, null, null);
        $table->add_field('old_gop_score', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('gop_score', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('gop_score_reason', XMLDB_TYPE_TEXT, null, null, null, null, null, null);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table digitala_report_feedback.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('attempt', XMLDB_KEY_FOREIGN, ['attempt'], 'digitala_attempt', ['id']);

        // Conditionally launch create table for digitala_report_feedback.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Digitala savepoint reached.
        upgrade_mod_savepoint(true, 2022041001, 'digitala');
    }

    if ($oldversion < 2022041002) {

        // Rename field accuracy_reason on table digitala_report_feedbak to taskachievement_reason.
        $table = new xmldb_table('digitala_report_feedback');
        $field = new xmldb_field('accuracy_reason', XMLDB_TYPE_TEXT, null, null, null, null, null, 'accuracy');

        // Launch rename field accuracy_reason.
        $dbman->rename_field($table, $field, 'taskachievement_reason');

        // Rename field accuracy on table digitala_report_feedbak to taskachievement.
        $field = new xmldb_field('accuracy', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null, 'old_accuracy');

        // Launch rename field accuracy.
        $dbman->rename_field($table, $field, 'taskachievement');

        // Rename field old_accuracy on table digitala_report_feedbak to old_taskachievement.
        $field = new xmldb_field('old_accuracy', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null, 'fluency_reason');

        // Launch rename field old_accuracy.
        $dbman->rename_field($table, $field, 'old_taskachievement');

        // Digitala savepoint reached.
        upgrade_mod_savepoint(true, 2022041002, 'digitala');
    }

    return true;
}
