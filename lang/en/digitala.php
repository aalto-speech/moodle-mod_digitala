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
 * @copyright   2022 Name
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Digitala';
$string['modulename'] = 'Digitala';
$string['digitala:addinstance'] = 'Add new Digitala activity';
$string['digitala:viewdetailreport'] = 'View detailed report of student submissions';
$string['modulenameplural'] = 'Digitalas';
$string['pluginadministration'] = 'Plugin Administration';

$string['assignmentname'] = 'Name';
$string['assignmentname_help'] = 'Give a name for the assignment';
$string['attemptlang'] = 'Language';
$string['attemptlang_help'] = 'The language that users will be attempting this assignment in.';
$string['fi'] = 'Finnish';
$string['sv'] = 'Swedish';
$string['attempttype'] = 'Type';
$string['attempttype_help'] = 'In "Read aloud" type, the user will attempt to read aloud the given text material. In "Freeform", the user can speak more freely about the topic indicated on the assignment.';
$string['readaloud'] = 'Read aloud';
$string['freeform'] = 'Freeform';
$string['timelimit'] = 'Time limit';
$string['attemptlimit'] = 'Attempt limit';
$string['attemptlimit_help'] = 'The number of times a user can submit to this assignment.';
$string['unlimited'] = 'Unlimited';
$string['assignment'] = 'Assignment';
$string['assignment_help'] = 'The assignment that the user will need to complete.';
$string['assignmentresource'] = 'Material';
$string['assignmentresource_help'] = 'The material can be added here. In "Read aloud" type, place the text to be read here. In "Freeform" type, you can add text, images, charts, and videos, which the user should utilize in their response.';
$string['maxlength_error'] = 'The recording can be at most 5 minutes long';

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
$string['startbutton-no_permissions'] = "Press again to record";
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
$string['alreadysubmitted'] = 'Your answer has already been submitted. Move to next page to see the report.';
$string['report'] = 'Evaluation';
$string['report-title'] = 'Evaluation report';
$string['report-title-feedback'] = 'Evaluation report - includes some teacher feedback';
$string['reportnotavailable'] = 'A report for this assignment is not available yet.';
$string['reportinformation'] = 'This feedback concerns only the speech sample you produced and it does not cover all aspects of your oral language skills. A machine produces your grades automatically. We have taught the machine with speech from other language learners together with other language-specific data.';
$string['transcription'] = 'A transcript of your speech sample';
$string['server-feedback'] = 'Transcript feedback';
$string['teacher-feedback'] = 'Suggest changes to grading';
$string['transcription_tab-plain'] = 'Plain text';
$string['transcription_tab-corrected'] = 'Show corrections';

$string['task_grades'] = 'Analytic grading';

$string['gop'] = 'Goodness of pronunciation';
$string['gop_score-0'] = 'Pronunciation score is 0, red score.';
$string['gop_score-1'] = 'Pronunciation score is 1, light red score.';
$string['gop_score-2'] = 'Pronunciation score is 2, pink score.';
$string['gop_score-3'] = 'Pronunciation score is 3, brown score.';
$string['gop_score-4'] = 'Pronunciation score is 4, light yellow score.';
$string['gop_score-5'] = 'Pronunciation score is 5, yellow score.';
$string['gop_score-6'] = 'Pronunciation score is 6, teal score.';
$string['gop_score-7'] = 'Pronunciation score is 7, big pink score.';
$string['gop_score-8'] = 'Pronunciation score is 8, cyan score.';
$string['gop_score-9'] = 'Pronunciation score is 9, light green score.';
$string['gop_score-10'] = 'Pronunciation score is 10, green score.';

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
$string['taskcompletion_description'] = 'This measure is based on the previous responses that have been used in teaching the machine to grade this task. Based on the automatic grading, it seems that ';
$string['taskcompletion_score-0'] = 'Unfortunately, the machine has not heard this type of performance before and therefore failed to grade your speech. However, do not be discouraged: try again!';
$string['taskcompletion_score-1'] = 'You only partially responded to the assignment.';
$string['taskcompletion_score-2'] = 'You responded well to the assignment.';
$string['taskcompletion_score-3'] = 'You respond excellently to the assignment.';

$string['fluency'] = 'Fluency';
$string['fluency_description'] = 'This measure reflects the speed, pauses, and hesitations in your speech. Based on the automatic grading, it seems that ';
$string['fluency_score-0'] = 'Unfortunately, the machine has not heard this type of performance before and therefore failed to grade your speech. However, do not be discouraged: try again!';
$string['fluency_score-1'] = 'Your speech has many pauses, breaks, or hesitations.';
$string['fluency_score-2'] = 'Your speech is fairly fluent, but some pauses, breaks, and hesitations occur.';
$string['fluency_score-3'] = 'Your speech is fluent and no disturbing pauses, breaks, or hesitations occur.';
$string['fluency_score-4'] = 'Your speech is very fluent and no disturbing pauses, breaks, or hesitations occur.';

$string['pronunciation'] = 'Pronunciation';
$string['pronunciation_description'] = 'Above you can see that the machine transformed your speech into text. There you can check whether you pronounced all the words right. This measure reflects how well the machine understands your speech. The speech samples that the machine has heard before affect its ability to understand you. Based on the automatic grading, it seems that ';
$string['pronunciation_score-0'] = 'Unfortunately, the machine has not heard this type of performance before and therefore failed to grade your speech. However, do not be discouraged: try again!';
$string['pronunciation_score-1'] = 'The machine struggles to understand you.';
$string['pronunciation_score-2'] = 'The machine understands your speech quite well, but there might be some pronunciation problems in the speech sample.';
$string['pronunciation_score-3'] = 'The machine understands you and there seems to be no major issues in your pronunciation.';
$string['pronunciation_score-4'] = 'Your pronunciation is clear and natural.';

$string['lexicogrammatical'] = 'Range';
$string['lexicogrammatical_description'] = 'This measure reflects how much you have spoken and how comprehensive your vocabulary and sentence structures are. Based on the automatic grading, it seems that ';
$string['lexicogrammatical_score-0'] = 'Unfortunately, the machine has not heard this type of performance before and therefore failed to grade your speech. However, do not be discouraged: try again!';
$string['lexicogrammatical_score-1'] = 'Your speech sample is very short or contains mainly individual words.';
$string['lexicogrammatical_score-2'] = 'You use basic words and are able to form sentences.';
$string['lexicogrammatical_score-3'] = 'You have comprehensive vocabulary and use a variety of sentence structures.';

$string['moreinformation'] = 'More information';

$string['api'] = 'Address for API-server';
$string['api_help'] = 'Give address to the API-server.';
$string['key'] = 'Key for the API-server';
$string['key_help'] = 'Give valid key for the API-server authentication';

$string['edit_report'] = 'Edit the evaluation report';
$string['holistic-reason'] = 'Feedback on Proficiency';
$string['taskcompletion-reason'] = 'Feedback on Task completion';
$string['fluency-reason'] = 'Feedback on Fluency';
$string['lexicogrammatical-reason'] = 'Feedback on Range';
$string['gop-reason'] = 'Feedback on goodness of pronunciation';
$string['pronunciation-reason'] = 'Feedback on Pronunciation';
$string['holistic-scale_error'] = 'Proficiency needs to be between 0 and 7';
$string['taskcompletion-scale_error'] = 'Task achievement needs to be between 0 and 3';
$string['fluency-scale_error'] = 'Fluency needs to be between 0 and 4';
$string['pronunciation-scale_error'] = 'Nativeity needs to be between 0 and 3';
$string['lexicogrammatical-scale_error'] = 'Range needs to be between 0 and 3';
$string['gop-scale_error'] = 'CHANGE THIS TO pronunciation-scale_error';
$string['pronunciation-scale_error'] = 'Pronunciation needs to be between 0 and 4';


$string['error_url-not-set'] = 'url address not set';
$string['error_no-evaluation'] = 'No evaluation was found. Check your connection with server.';
$string['error-save-recording'] = 'Unable to save the recording. Please try again.';

$string['results_link'] = 'See report';
$string['results_student'] = 'Student';
$string['results_text'] = 'Type';
$string['results_score'] = 'Proficiency/Analytic grades';
$string['results_time'] = 'Time';
$string['results_tries'] = 'Tries';
$string['results_report'] = 'Evaluation report';
$string['results_denied'] = 'Access denied';
$string['results_return'] = 'Return to Digitala front page';
$string['results_view'] = 'View student results';

$string['results_delete'] = 'Delete attempt';
$string['results_delete-confirm'] = 'Confirm delete';
$string['results_delete-all'] = 'Delete all';
$string['results_delete-one-text'] = 'Are you sure you want to delete and reset attempts from user {$a}?';
$string['results_delete-all-text'] = 'Are you sure you want to delete and reset attempts from all users?';
$string['results_no-show'] = 'No results to show yet.';
$string['results_title'] = 'User results';
$string['results_delete-title'] = 'Warning';

$string['teachergrade'] = "Teacher's grade suggestion: ";
$string['teacherreason'] = "Comments about grade suggestion: ";
$string['feedback_success'] = 'Comment added successfully to students report.';
$string['feedback_not-found'] = 'Report for given student is not found';
