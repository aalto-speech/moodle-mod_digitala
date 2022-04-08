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
$string['assignmentname_help'] = 'Give name for the assignment';
$string['attemptlang'] = 'Attempt language';
$string['attemptlang_help'] = 'The language that users will be attempting this assignment in.';
$string['fin'] = 'Finnish';
$string['sv'] = 'Swedish';
$string['attempttype'] = 'Attempt type';
$string['attempttype_help'] = 'In read aloud type the user will attempt to read the given resource text. In Freeform the user may speak about anything indicated on the assignment text.';
$string['readaloud'] = 'Read aloud';
$string['freeform'] = 'Freeform';
$string['timelimit'] = 'Timelimit';
$string['attemptlimit'] = 'Attempt limit';
$string['attemptlimit_help'] = 'The number of times a user can submit to this assignment.';
$string['unlimited'] = 'Unlimited';
$string['assignment'] = 'Assignment';
$string['assignment_help'] = 'The assignment that the user will need to complete.';
$string['assignmentresource'] = 'Resources';
$string['assignmentresource_help'] = 'Resources that the user can see before and while attempting this assignment. For the readaloud type place the text to be read here.';

$string['navnext'] = 'Next >';
$string['navprevious'] = '< Previous';
$string['navstartagain'] = 'See the assignment';
$string['navtryagain'] = 'Try again';
$string['feedback'] = 'Give feedback';
$string['info'] = 'Info';
$string['infotext'] = 'Try the microphone before moving on to the assignment';
$string['startbutton'] = 'Record';
$string['startbutton-again'] = 'Record again';
$string['startbutton-no_permissions'] = 'Press again to record';
$string['startbutton-error'] = 'Error while interacting with microphone. Please check your microphone settings.';
$string['stopbutton'] = 'Stop recording';
$string['microphone'] = 'Test your microphone here';
$string['attemptsunlimited'] = 'There is no limit set for the number of attempts on this assignment.';
$string['attemptsremaining'] = 'Number of attempts remaining: {$a}';
$string['listenbutton'] = 'Listen recording';
$string['assignmentrecord'] = 'Record your answer';
$string['submit'] = 'Submit answer';
$string['submitclose'] = 'Close';
$string['submittitle'] = 'Are you sure you want to submit this attempt?';
$string['submitbody'] = 'You still have {$a} attempts remaining on this assignment.';
$string['alreadysubmitted'] = 'Your answer has already been submitted. Move to next page to see the report.';
$string['report'] = 'Report';
$string['reportnotavailable'] = 'A report for this assignment is not available yet.';
$string['reportinformation'] = 'Tämä palaute koskee ainoastaan nauhoittamaasi puhenäytettä, eikä se kuvaa kaikkea suullista kielitaitoasi. Automaattinen arvio on koneen tekemä. Konetta on opetettu muiden kielen oppijoiden puheella ja muulla kieliaineistolla.';
$string['transcription'] = 'Transcription';

$string['task_grades'] = 'Task grades';

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

$string['holistic'] = 'Holistic';
$string['holistic_description'] = 'Automaattisen arvion mukaan vaikuttaa siltä, että taitotasosi on ';
$string['holistic_level-0'] = 'Below A1';
$string['holistic_level-1'] = 'A1';
$string['holistic_level-2'] = 'A2';
$string['holistic_level-3'] = 'B1';
$string['holistic_level-4'] = 'B2';
$string['holistic_level-5'] = 'C1';
$string['holistic_level-6'] = 'C2';
$string['holistic_score-0'] = 'Holistic score is 0, red score.';
$string['holistic_score-1'] = 'Holistic score is 1, light red score.';
$string['holistic_score-2'] = 'Holistic score is 2, brown score.';
$string['holistic_score-3'] = 'Holistic score is 3, yellow score.';
$string['holistic_score-4'] = 'Holistic score is 4, light yellow score.';
$string['holistic_score-5'] = 'Holistic score is 5, light green score.';
$string['holistic_score-6'] = 'Holistic score is 6, green score.';

$string['taskachievement'] = 'Task achievement';
$string['taskachievement_description'] = 'Tämä mittari perustuu vastauksiin, joilla kone on opetettu arvioimaan tätä tehtävää. Automaattisen arvion mukaan vaikuttaa siltä, että ';
$string['taskachievement_score-0'] = 'Task achievement score is 0, red score.';
$string['taskachievement_score-1'] = 'Task achievement score is 1, light red score.';
$string['taskachievement_score-2'] = 'Task achievement score is 2, yellow score.';
$string['taskachievement_score-3'] = 'Task achievement score is 3, green score.';

$string['fluency'] = 'Fluency';
$string['fluency_description'] = 'Tämä mittari kertoo puhenäytteesi nopeudesta, taukojen määrästä ja empimisestä. Automaattisen arvion mukaan vaikuttaa siltä, että ';
$string['fluency_score-0'] = 'Fluency score is 0, red score.';
$string['fluency_score-1'] = 'Fluency score is 1, light red score.';
$string['fluency_score-2'] = 'Fluency score is 2, yellow score.';
$string['fluency_score-3'] = 'Fluency score is 3, green score.';

$string['nativeity'] = 'Nativeity';
$string['nativeity_description'] = 'Näet yllä, että kone muunsi puheesi tekstiksi. Voit tarkistaa tekstistä, lausuitko kaikki sanat oikein. Tämä mittari kertoo, kuinka hyvin ja varmasti kone tunnistaa puheesi. Tunnistamistarkkuuteen vaikuttavat puhenäytteet, joita kone on aiemmin opetusvaiheessa saanut. Automaattisen arvion mukaan vaikuttaa siltä, että ';
$string['nativeity_score-0'] = 'Nativeity score is 0, red score.';
$string['nativeity_score-1'] = 'Nativeity score is 1, light red score.';
$string['nativeity_score-2'] = 'Nativeity score is 2, yellow score.';
$string['nativeity_score-3'] = 'Nativeity score is 3, green score.';

$string['lexicalprofile'] = 'Lexical profile';
$string['lexicalprofile_description'] = 'Tämä mittari kertoo, kuinka paljon olet puhunut sekä käyttämiesi sanojen ja lauseiden monipuolisuudesta. Automaattisen arvion mukaan vaikuttaa siltä, että ';
$string['lexicalprofile_score-0'] = 'Lexical profile score is 0, red score.';
$string['lexicalprofile_score-1'] = 'Lexical profile is 1, light red score.';
$string['lexicalprofile_score-2'] = 'Lexical profile is 2, yellow score.';
$string['lexicalprofile_score-3'] = 'Lexical profile is 3, green score.';

$string['moreinformation'] = 'More information';

$string['api'] = 'Address for API-server';
$string['api_help'] = 'Give address to API-server.';
$string['key'] = 'Key for API-server';
$string['key_help'] = 'Give valid key for API-server authentication';

$string['edit_report'] = 'Give feedback on report';
$string['holistic-reason'] = 'Feedback on holistic';
$string['taskachievement-reason'] = 'Feedback on task achievement';
$string['fluency-reason'] = 'Feedback on fluency';
$string['nativeity-reason'] = 'Feedback on nativeity';
$string['lexicalprofile-reason'] = 'Feedback on lexical profile';
$string['gop-reason'] = 'Feedback on goodness of pronunciation';
$string['holistic-scale_error'] = 'Holistic needs to be between 0 and 7';
$string['taskachievement-scale_error'] = 'Task achievement needs to be between 0 and 3';
$string['fluency-scale_error'] = 'Fluency needs to be between 0 and 3';
$string['nativeity-scale_error'] = 'Nativeity needs to be between 0 and 3';
$string['lexicalprofile-scale_error'] = 'Lexical profile needs to be between 0 and 3';
$string['gop-scale_error'] = 'Godness of pronunciation needs to be between 0 and 1';

$string['error_url-not-set'] = 'accessed without internet successful';
$string['error_no-evaluation'] = 'No evaluation was found. Check your connection with server.';

$string['results_link'] = 'See report';
$string['results_student'] = 'Student';
$string['results_text'] = 'Type';
$string['results_score'] = 'Holistic/GOP';
$string['results_time'] = 'Time';
$string['results_tries'] = 'Tries';
$string['results_report'] = 'Report';
$string['results_denied'] = 'Access denied';
$string['results_return'] = 'Return to Digitala';
$string['results_view'] = 'View student results';
