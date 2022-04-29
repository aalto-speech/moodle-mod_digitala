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

    if ($oldversion < 2022041003) {

        // Define table digitala_report_feedback to be created.
        $table = new xmldb_table('digitala_report_feedback');

        // Adding fields to table digitala_report_feedback.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('attempt', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('old_fluency', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('fluency', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('fluency_reason', XMLDB_TYPE_TEXT, null, null, null, null, null, null);
        $table->add_field('old_taskachievement', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('taskachievement', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('taskachievement_reason', XMLDB_TYPE_TEXT, null, null, null, null, null, null);
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
        upgrade_mod_savepoint(true, 2022041003, 'digitala');
    }

    if ($oldversion < 2022041401) {
        $table = new xmldb_table('digitala_attempts');
        // Rename field lexicalprofile on table digitala_attempts to lexicogrammatical.
        $field = new xmldb_field('lexicalprofile', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null, 'accuracy');
        $dbman->rename_field($table, $field, 'lexicogrammatical');

        // Rename field accuracy on table digitala_attempts to pronunciation.
        $field = new xmldb_field('accuracy', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null, 'taskachievement');
        $dbman->rename_field($table, $field, 'pronunciation');

        // Rename field taskachievement on table digitala_attempts to taskcompletion.
        $field = new xmldb_field('taskachievement', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null, 'speechrate');
        $dbman->rename_field($table, $field, 'taskcompletion');

        // Remove field fluencymean on table digitala_attempts.
        $field = new xmldb_field('fluencymean');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        // Remove field speechrate on table digitala_attempts.
        $field = new xmldb_field('speechrate');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        // Remove field nativeity on table digitala_attempts.
        $field = new xmldb_field('nativeity');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        // Add field feedback to table digitala_attempts.
        $field = new xmldb_field('feedback', XMLDB_TYPE_TEXT, null, null, null, null, null, 'transcript');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Add field fluency_features to table digitala_attempts.
        $field = new xmldb_field('fluency_features', XMLDB_TYPE_TEXT, null, null, null, null, null, 'fluency');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Add field pronunciation_features to table digitala_attempts.
        $field = new xmldb_field('pronunciation_features', XMLDB_TYPE_TEXT, null, null, null, null, null, 'pronunciation');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Add field lexicogrammatical_features to table digitala_attemptnativeity_reasons.
        $field = new xmldb_field('lexicogrammatical_features', XMLDB_TYPE_TEXT, null, null, null, null, null, 'lexicogrammatical');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $table = new xmldb_table('digitala_report_feedback');
        // Rename field nativeity_reason on table digitala_report_feedback to pronunciation_reason.
        $field = new xmldb_field('nativeity_reason', XMLDB_TYPE_TEXT, null, null, null, null, null, 'nativeity');
        $dbman->rename_field($table, $field, 'pronunciation_reason');

        // Rename field nativeity on table digitala_report_feedback to pronunciation.
        $field = new xmldb_field('nativeity', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null, 'old_nativeity');
        $dbman->rename_field($table, $field, 'pronunciation');

        // Rename field old_nativeity on table digitala_report_feedback to old_pronunciation.
        $field = new xmldb_field('old_nativeity', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null, 'lexicalprofile_reason');
        $dbman->rename_field($table, $field, 'old_pronunciation');

        // Rename field lexicalprofile_reason on table digitala_report_feedback to lexicogrammatical_reason.
        $field = new xmldb_field('lexicalprofile_reason', XMLDB_TYPE_TEXT, null, null, null, null, null, 'lexicalprofile');
        $dbman->rename_field($table, $field, 'lexicogrammatical_reason');

        // Rename field lexicalprofile on table digitala_report_feedback to lexicogrammatical.
        $field = new xmldb_field('lexicalprofile', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null, 'old_lexicalprofile');
        $dbman->rename_field($table, $field, 'lexicogrammatical');

        // Rename field old_lexicalprofile on table digitala_report_feedback to old_lexicogrammatical.
        $field = new xmldb_field('old_lexicalprofile', XMLDB_TYPE_NUMBER, '10, 2',
                                 null, null, null, null, 'taskachievement_reason');
        $dbman->rename_field($table, $field, 'old_lexicogrammatical');

        // Rename field lexicalprofile on table digitala_report_feedback to lexicogrammatical.
        $field = new xmldb_field('taskachievement_reason', XMLDB_TYPE_TEXT, null, null, null, null, null, 'taskachievement');
        $dbman->rename_field($table, $field, 'taskcompletion_reason');

        // Rename field lexicalprofile on table digitala_report_feedback to lexicogrammatical.
        $field = new xmldb_field('taskachievement', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null, 'old_taskachievement');
        $dbman->rename_field($table, $field, 'taskcompletion');

        // Rename field lexicalprofile on table digitala_report_feedback to lexicogrammatical.
        $field = new xmldb_field('old_taskachievement', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null, 'fluency_reason');
        $dbman->rename_field($table, $field, 'old_taskcompletion');

        // Digitala savepoint reached.
        upgrade_mod_savepoint(true, 2022041401, 'digitala');
    }

    // Conditionally launch add field status.
    if ($oldversion < 2022042302) {

        // Define field status to be added to digitala_attempts.
        $table = new xmldb_table('digitala_attempts');
        $field = new xmldb_field('status', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, 'waiting', 'attemptnumber');

        // Conditionally launch add field status.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        upgrade_mod_savepoint(true, 2022042302, 'digitala');
    }

    // Conditionally launch add field digitala.
    if ($oldversion < 2022042402) {

        // Define field digitala to be added to digitala_report_feedback.
        $table = new xmldb_table('digitala_report_feedback');
        $field = new xmldb_field('digitala', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'id');

        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        upgrade_mod_savepoint(true, 2022042402, 'digitala');
    }

    if ($oldversion < 2022042702) {

        // Define field information to be added to digitala.
        $table = new xmldb_table('digitala');
        $field = new xmldb_field('information', XMLDB_TYPE_TEXT, null, null, null, null, null, 'attemptlimit');

        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $field = new xmldb_field('informationformat', XMLDB_TYPE_INTEGER, '4', null, null, null, '0', 'information');

        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        upgrade_mod_savepoint(true, 2022042702, 'digitala');
    }

    if ($oldversion < 2022042906) {

        $table = new xmldb_table('digitala_attempts');
        $field = new xmldb_field('gop_score');
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        $table = new xmldb_table('digitala_report_feedback');
        $field = new xmldb_field('gop_score');
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        $field = new xmldb_field('old_gop_score');
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        $field = new xmldb_field('gop_score_reason');
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }
        upgrade_mod_savepoint(true, 2022042906, 'digitala');
    }

    return true;
}
