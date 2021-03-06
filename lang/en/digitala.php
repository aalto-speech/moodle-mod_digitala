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
 * Plugin strings are defined here.
 *
 * @package     mod_digitala
 * @category    string
 * @author      Alanen, Tuomas; Erkkilä, Joona; Harjunpää, Topi; Heijala, Maikki.
 * @copyright   2022 Helsingin Yliopisto
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Digitala';
$string['modulename'] = 'Digitala';
$string['digitala:addinstance'] = 'Add new Digitala activity';
$string['digitala:viewdetailreport'] = 'View detailed report of student submissions';
$string['modulenameplural'] = 'Digitalas';
$string['pluginadministration'] = 'Plugin Administration';

$string['assignmentname'] = 'Assignment name';
$string['assignmentname_help'] = 'Give a name for the assignment';
$string['attemptlang'] = 'Language';
$string['attemptlang_help'] = 'The language that users will be attempting this assignment in.';
$string['fi'] = 'Finnish';
$string['sv'] = 'Swedish';
$string['attempttype'] = 'Assignment type';
$string['attempttype_help'] = 'In "Read-aloud" type, the user will attempt to read aloud the given text material. In "Freeform", the user can speak more freely about the topic indicated on the assignment.';
$string['readaloud'] = 'Read-aloud';
$string['freeform'] = 'Freeform';
$string['timelimit'] = 'Time limit';
$string['unlimited'] = 'Unlimited';
$string['attemptlimit'] = 'Attempt limit';
$string['attemptlimit_help'] = 'The number of times a user can submit to this assignment.';
$string['assignment'] = 'Assignment';
$string['assignmenttext'] = 'Assignment text';
$string['assignmenttext_help'] = 'The assignment that the user will need to complete.';
$string['assignmentresource'] = 'Material';
$string['assignmentresource_help'] = 'The material can be added here. In "Read-aloud" type, place the text to be read here. In "Freeform" type, you can add text, images, charts, and videos, which the user should utilize in their response.';
$string['maxlength'] = 'Maximum duration';
$string['maxlength_error'] = 'The recording can be at most 5 minutes long';
$string['maxlength_help'] = 'The recording must be shorter than 5 minutes or 300 seconds';

$string['navnext'] = 'Next >';
$string['navprevious'] = '< Previous';
$string['navstartagain'] = 'See the assignment';
$string['navtryagain'] = 'Try again';
$string['feedback'] = 'Give feedback';
$string['info'] = 'Begin';
$string['infotext'] = 'Try out the microphone before moving on to the assignment';
$string['startbutton'] = 'Record';
$string['startbutton-again'] = 'Record again';
$string['startbutton-loading'] = 'Waiting for microphone';
$string['startbutton-error'] = 'Error while interacting with microphone. Please check your microphone settings and refresh the page.';
$string['startbutton-no_permissions'] = 'Press again to record';
$string['stopbutton'] = 'Stop recording';
$string['microphone'] = 'Test your microphone here';
$string['attemptsunlimited'] = 'There is no limit set for the number of attempts on this assignment.';
$string['attemptsremaining'] = 'Number of attempts remaining: {$a}';
$string['listenbutton'] = 'Listen to your recording';
$string['assignmentrecord'] = 'Record your answer';
$string['submit'] = 'Submit answer';
$string['submitclose'] = 'Close';
$string['submittitle'] = 'Are you sure you want to submit this attempt?';
$string['submitbody'] = 'You still have {$a} attempts remaining on this assignment.';
$string['alreadysubmitted'] = 'Your answer has already been submitted. Move to the next page to see the report.';

$string['report'] = 'Evaluation';
$string['report-title'] = 'Evaluation report';
$string['report-title-feedback'] = 'Evaluation report - includes teacher feedback';
$string['report-timestamp'] = 'Submitted: ';
$string['reportnotavailable'] = 'The evaluation report for this assignment is not available yet.';
$string['reportinformation'] = 'This feedback concerns only the speech sample you produced and it does not cover all aspects of your oral language skills. A machine produces your grades automatically. We have taught the machine with speech from other language learners together with other language-specific data.';
$string['transcription'] = 'A transcript of your speech sample';
$string['server-feedback'] = 'Read-aloud feedback';
$string['teacher-feedback'] = 'Suggest changes to automatic evaluation report';
$string['transcription_tab-plain'] = 'A transcript of your speech sample';
$string['transcription_tab-corrected'] = 'Show corrections';

$string['task_grades'] = 'Analytic grading';
$string['task_grades_preamble'] = 'Based on the automatic grading, it seems that ';

$string['holistic'] = 'Proficiency level';
$string['holistic_description'] = 'Based on the automatic grading, it seems that your proficiency level is ';
$string['holistic_level-0'] = 'Below A1';
$string['holistic_level-1'] = 'A1';
$string['holistic_level-2'] = 'A2';
$string['holistic_level-3'] = 'B1';
$string['holistic_level-4'] = 'B2';
$string['holistic_level-5'] = 'C1';
$string['holistic_level-6'] = 'C2';
$string['holistic_score-0'] = 'You are able to produce some words in the target language.';
$string['holistic_score-1'] = 'You are able to produce some sentences in the target language (for example, greet somebody or tell about yourself).';
$string['holistic_score-2'] = 'You know basic words and are able to form sentences in the target language (for example, start and end a short conversation).';
$string['holistic_score-3'] = 'You manage everyday situations in the target language. Your pronunciation is intelligible, your vocabulary is fairly large, and you use different kinds of sentences.';
$string['holistic_score-4'] = 'You are able to express yourself as required by the situation, without long pauses or hesitations. You use a fairly large vocabulary and versatile structures. Your pronunciation and intonation are clear and natural.';
$string['holistic_score-5'] = 'Your speech is fluent, spontaneous, and almost effortless. You are able to express yourself in detail and as required by the situation.';
$string['holistic_score-6'] = 'You are able to speak fluently, naturally, and without hesitations also in long-lasting speech situations. Your speech is accurate and situationally appropriate. You vary your intonation and master sentence stress in the target language.';

$string['taskcompletion'] = 'Task completion';
$string['taskcompletion_description'] = 'This measure is based on the previous responses that have been used in teaching the machine to grade this task.';
$string['taskcompletion_score-0'] = 'Unfortunately, the machine has not heard this type of performance before and therefore failed to grade your speech.';
$string['taskcompletion_score-1'] = 'You only partially responded to the assignment.';
$string['taskcompletion_score-2'] = 'You responded well to the assignment.';
$string['taskcompletion_score-3'] = 'You respond excellently to the assignment.';

$string['fluency'] = 'Fluency';
$string['fluency_description'] = 'This measure reflects the speed, pauses, and hesitations in your speech.';
$string['fluency_score-0'] = $string['taskcompletion_score-0'];
$string['fluency_score-1'] = 'Your speech has many pauses, breaks, or hesitations.';
$string['fluency_score-2'] = 'Your speech is fairly fluent, but some pauses, breaks, and hesitations occur.';
$string['fluency_score-3'] = 'Your speech is fluent and no disturbing pauses, breaks, or hesitations occur.';
$string['fluency_score-4'] = 'Your speech is very fluent and no disturbing pauses, breaks, or hesitations occur.';

$string['pronunciation'] = 'Pronunciation';
$string['pronunciation_description'] = 'Above you can see that the machine transformed your speech into text. There you can check whether you pronounced all the words right. This measure reflects how well the machine understands your speech. The speech samples that the machine has heard before affect its ability to understand you.';
$string['pronunciation_score-0'] = $string['taskcompletion_score-0'];
$string['pronunciation_score-1'] = 'The machine struggles to understand you.';
$string['pronunciation_score-2'] = 'The machine understands your speech quite well, but there might be some pronunciation problems in the speech sample.';
$string['pronunciation_score-3'] = 'The machine understands you and there seems to be no major issues in your pronunciation.';
$string['pronunciation_score-4'] = 'Your pronunciation is clear and natural.';

$string['lexicogrammatical'] = 'Range';
$string['lexicogrammatical_description'] = 'This measure reflects how much you have spoken and how comprehensive your vocabulary and sentence structures are.';
$string['lexicogrammatical_score-0'] = $string['taskcompletion_score-0'];
$string['lexicogrammatical_score-1'] = 'Your speech sample is very short or contains mainly individual words.';
$string['lexicogrammatical_score-2'] = 'You use basic words and are able to form sentences.';
$string['lexicogrammatical_score-3'] = 'You have comprehensive vocabulary and use a variety of sentence structures.';

$string['moreinformation'] = 'More information';
$string['moreinformation_help'] = 'Additional information to provide to the student about the assignment or evaluation.';

$string['api'] = 'Address for API-server';
$string['api_help'] = 'Give address to the API-server.';
$string['key'] = 'Key for the API-server';
$string['key_help'] = 'Give a valid key for the API-server authentication';
$string['feedbacklink'] = 'Give address to feedback site';
$string['feedbacklink_help'] = 'Give the address of the site that shows as a feedback form on the evaluation page.';

$string['edit_report'] = 'Edit the evaluation report';
$string['holistic-reason'] = 'Feedback on Proficiency';
$string['taskcompletion-reason'] = 'Feedback on Task completion';
$string['fluency-reason'] = 'Feedback on Fluency';
$string['lexicogrammatical-reason'] = 'Feedback on Range';
$string['pronunciation-reason'] = 'Feedback on Pronunciation';
$string['holistic-scale_error'] = 'Proficiency needs to be between 0 and 7';
$string['taskcompletion-scale_error'] = 'Task achievement needs to be between 0 and 3';
$string['fluency-scale_error'] = 'Fluency needs to be between 0 and 4';
$string['lexicogrammatical-scale_error'] = 'Range needs to be between 0 and 3';
$string['pronunciation-scale_error'] = 'Pronunciation needs to be between 0 and 4';

$string['error_url-not-set'] = 'url address not set';
$string['error_no-evaluation'] = 'No evaluation was found. Check your connection with server.';
$string['error-save-recording'] = 'Unable to save the recording. Please try again.';

$string['results_link'] = 'See report';
$string['results_student'] = 'Student';
$string['results_text'] = 'Type';
$string['results_score_proficiency'] = 'Proficiency';
$string['results_time'] = 'Time';
$string['results_tries'] = 'Tries';
$string['results_report'] = 'Evaluation report';
$string['results_denied'] = 'Access denied';
$string['results_return'] = 'Return to Digitala front page';
$string['results_view'] = 'View student results';
$string['results_timestamp'] = 'Timestamp';

$string['results_status'] = 'Status';
$string['results_status-evaluated'] = 'Evaluated';
$string['results_status-waiting'] = 'Waiting for evaluation';
$string['results_status-retry'] = 'Retrying automatic evaluation';
$string['results_status-failed'] = 'Evaluation failed';

$string['results_delete'] = 'Delete attempt';
$string['results_delete-confirm'] = 'Confirm delete';
$string['results_delete-all'] = 'Delete all attempts';
$string['results_delete-one-text'] = 'Are you sure you want to delete and reset attempts from user {$a}?';
$string['results_delete-all-text'] = 'Are you sure you want to delete and reset attempts from all users?';
$string['results_no-show'] = 'No results to show yet.';
$string['results_title'] = 'User results';
$string['results_delete-title'] = 'Note!';
$string['results_waiting-title'] = 'Evaluation in progress';
$string['results_waiting-info'] = 'Evaluation is in progress. This may take some time.';
$string['results_waiting-refresh'] = 'Press here to check if evaluation is completed.';
$string['results_waiting-loading'] = 'Loading evaluation report...';
$string['results_retry-title'] = 'Evaluation failed';
$string['results_retry-info'] = 'Automated evaluation failed and will be run again in couple of hours. The new evaluation attempt can take some time.';

$string['export_attempts'] = 'Export all attempts as CSV';
$string['export_attempts_feedback'] = 'Export all teacher feedback for attempts as CSV';
$string['export_recordings'] = 'Export all recordings';
$string['export_success'] = 'Creation of CSV-file was successful.';

$string['teachergrade'] = 'Teacher\'s grade suggestion: ';
$string['teacherreason'] = 'Comments about grade suggestion: ';
$string['feedback_success'] = 'Comment added successfully to student\'s report.';
$string['feedback_not-found'] = 'No report found for this student';

$string['task-send_to_evaluations'] = 'Send to evaluation';
$string['task-check_failed_evaluation'] = 'Check for failed evaluations';
