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
$string['digitala:addinstance'] = 'Lägg till en ny Digitala-aktivitet';
$string['digitala:viewdetailreport'] = 'Se inlärarnas ansvar i detalj';
$string['modulenameplural'] = 'Digitalar';
$string['pluginadministration'] = 'Administration';

$string['assignmentname'] = 'Namn på uppgiftet';
$string['assignmentname_help'] = 'Lägg till ett namn på uppgiften.';
$string['attemptlang'] = 'Språk';
$string['attemptlang_help'] = 'Välj vilken språkuppgift som skapas.';
$string['fi'] = 'Finska';
$string['sv'] = 'Svenska';
$string['attempttype'] = 'Uppgiftstyp';
$string['attempttype_help'] = 'I uppgiften "Högläsning" måste man läsa texten så noggrant och tydligt som man kan. I uppgiften "Fri produktion" kan man tala friare om temat.';
$string['readaloud'] = 'Högläsning';
$string['freeform'] = 'Fri produktion';
$string['timelimit'] = 'Maxtid';
$string['unlimited'] = 'Ingen gräns';
$string['attemptlimit'] = 'Antalet svarsförsök';
$string['attemptlimit_help'] = 'Det antal svarsförsök som användaren har.';
$string['assignment'] = 'Uppgift';
$string['assignmenttext'] = 'Uppgift';
$string['assignmenttext_help'] = 'En instruktionstext om vad och hur man ska tala i uppgiften';
$string['assignmentresource'] = 'Material';
$string['assignmentresource_help'] = 'Material placeras här. I uppgiften "Högläsning" placeras texten här. I uppgiften "Fri produktion" kan man placera här t.ex. text, bilder och figurer som utnyttjas i uppgiften.';
$string['maxlength'] = 'Maxlängd';
$string['maxlength_error'] = 'Inspelningen får inte överstiga 5 minuter';
$string['maxlength_help'] = 'Inspelningen måste vara kortare än 5 minuter eller 300 sekunder';

$string['navnext'] = 'Nästa >';
$string['navprevious'] = '< Föregående';
$string['navstartagain'] = 'Se uppgiften';
$string['navtryagain'] = 'Försök igen';
$string['feedback'] = 'Ge feedback';
$string['info'] = 'Början';
$string['infotext'] = 'Testa mikrofonen innan du gör uppgiften.';
$string['startbutton'] = 'Start';
$string['startbutton-again'] = 'Spela in på nytt';
$string['startbutton-loading'] = 'Väntas pä mikrofonen.';
$string['startbutton-error'] = 'Fel på mikrofonen. Kontrollera mikrofoninställningarna. Uppdatera sidan.';
$string['startbutton-no_permissions'] = 'Klicka på nytt för att spela in.';
$string['stopbutton'] = 'Stopp';
$string['microphone'] = 'Testa mikrofonen här';
$string['attemptsunlimited'] = 'Här finns ingen övre gräns för svarsförsöken.';
$string['attemptsremaining'] = 'Du kan försöka {$a} gånger till.';
$string['listenbutton'] = 'Lyssna';
$string['assignmentrecord'] = 'Spela in svaret';
$string['submit'] = 'Lämna in svaret';
$string['submitclose'] = 'Stäng av';
$string['submittitle'] = 'Är du säker att du vill lämna in svaret?';
$string['submitbody'] = 'Du har {$a} svarsförsök kvar i den här uppgiften';
$string['alreadysubmitted'] = 'Du har redan lämnat in svaret. Gå till nästa sida för att se rapporten';

$string['report'] = 'Bedömningsrapporten';
$string['report-title'] = 'Bedömningsrapporten';
$string['report-title-feedback'] = 'Bedömningsrapporten - innehåller lärarfeedback';
$string['report-timestamp'] = 'Lämnat in: ';
$string['reportnotavailable'] = 'Bedömningsrapporten är ännu inte tillgänglig.';
$string['reportinformation'] = 'Den här feedbacken gäller endast den uppgift som du har spelat in, inte muntlig färdighet generellt. Den automatiska bedömningen har gjorts av datorn. Datorn har lärts att bedöma tal med hjälp av andra språkinlärares tal och andra taluppgifter.';
$string['transcription'] = 'Ditt tal som text';
$string['server-feedback'] = 'Feedback på högläsningen';
$string['teacher-feedback'] = 'Föreslå förändringar I bedömningsrapporten';
$string['transcription_tab-plain'] = 'Ditt tal som text';
$string['transcription_tab-corrected'] = 'Visa korrigeringar';

$string['task_grades'] = 'Analytisk bedömning';
$string['task_grades_preamble'] = 'Automatisk bedömning tyder på att ';

$string['holistic'] = 'Bedömning av färdighetsnivån';
$string['holistic_description'] = 'Automatisk bedömning visar att din färdighetsnivå verkar vara ';
$string['holistic_level-0'] = 'Under A1';
$string['holistic_level-1'] = 'A1';
$string['holistic_level-2'] = 'A2';
$string['holistic_level-3'] = 'B1';
$string['holistic_level-4'] = 'B2';
$string['holistic_level-5'] = 'C1';
$string['holistic_level-6'] = 'C2';
$string['holistic_score-0'] = 'Du kan säga några ord på målspråket.';
$string['holistic_score-1'] = 'Du kan säga några meningar på målspråket (t.ex. hälsa på människor och berätta lite om dig själv).';
$string['holistic_score-2'] = 'Du behärskar vanliga ord och kan skapa meningar av dem på målspråket (t.ex. börja och avsluta ett kortare replikskifte).';
$string['holistic_score-3'] = 'Du klarar av vardagliga situationer på målspråket. Ditt uttal är begripligt, du har ett ganska omfattande ordförråd och du använder olika typer av meningar.';
$string['holistic_score-4'] = 'Du kan uttrycka dig på målspråket i olika situationer utan längre pauser och tvekanden. Du har ett ganska omfattande ordförråd och använder mångsidiga strukturer. Uttal och intonation är tydligt och naturligt.';
$string['holistic_score-5'] = 'Ditt tal är flytande, spontant och till stora delar ledigt. Du kan vid behov uttrycka dig detaljerat om situationen kräver det.';
$string['holistic_score-6'] = 'Du talar flytande, naturligt och utan att tveka också i längre talsituationer. Ditt tal är precist och passar bra för situationen. Du har varierande intonation och du behärskar satsbetoningen.';

$string['taskcompletion'] = 'Att svara på uppgiften';
$string['taskcompletion_description'] = 'Den här mätaren grundar sig på de svar med vilka datorn har lärts att bedöma uppgiften.';
$string['taskcompletion_score-0'] = 'Datorn inte har bedömt tidigare just den typ av tal du presterat och datorn kan därför inte bedöma det du säger.';
$string['taskcompletion_score-1'] = 'Du endast delvis svarar på uppgiften.';
$string['taskcompletion_score-2'] = 'Du svarar bra på uppgiften.';
$string['taskcompletion_score-3'] = 'Du svarar utmärkt på uppgiften.';

$string['fluency'] = 'Flyt';
$string['fluency_description'] = 'Den här mätaren berättar om taltempo, antalet pauser och tvekanden.';
$string['fluency_score-0'] = $string['taskcompletion_score-0'];
$string['fluency_score-1'] = 'Du har många pauser, avbrott och tvekanden.';
$string['fluency_score-2'] = 'Du talar ganska flytande med en del pauser, avbrott och tvekanden.';
$string['fluency_score-3'] = 'Du talar flytande och ledigt; pauser, avbrott och tvekanden är inte störande.';
$string['fluency_score-4'] = 'Du talar mycket flytande och ledigt; pauser, avbrott och tvekanden är inte störande.';

$string['pronunciation'] = 'Uttal';
$string['pronunciation_description'] = 'Du ser ovan att datorn förändrade ditt tal till en text. Du kan se i texten, huruvida du uttalade alla ord rätt. Den här mätaren berättar om hur väl och säkert datorn identifierade det du sade. Detta påverkas av det talmaterial som datorn har lärts att bedöma tal med.';
$string['pronunciation_score-0'] = $string['taskcompletion_score-0'];
$string['pronunciation_score-1'] = 'Datorn har ganska svårt att förstå ditt tal.';
$string['pronunciation_score-2'] = 'Datorn har ganska lätt att förstå ditt tal, men du tycks ha en del problem med uttalet.';
$string['pronunciation_score-3'] = 'Datorn förstår ditt tal och du tycks inte ha några större problem med uttalet.';
$string['pronunciation_score-4'] = 'Ditt uttal är begripligt och naturligt.';

$string['lexicogrammatical'] = 'Uttryckets omfång';
$string['lexicogrammatical_description'] = 'Den här mätaren berättar om hur mycket du talade samt hur varierat ordförråd och varierade meningar du använde.';
$string['lexicogrammatical_score-0'] = $string['taskcompletion_score-0'];
$string['lexicogrammatical_score-1'] = 'Ditt talprov är mycket kort eller består mestadels av enstaka ord.';
$string['lexicogrammatical_score-2'] = 'Du använder vanliga ord och du kan skapa meningar av dem.';
$string['lexicogrammatical_score-3'] = 'Du använder mångsidigt olika typer av ord och meningskonstruktioner.';

$string['moreinformation'] = 'Mer information';
$string['moreinformation_help'] = 'Ytterligare information att ge studenten om uppgiftet eller bedömningen.';

$string['api'] = 'Adressen till API-servern.';
$string['api_help'] = 'Ge adressen till API-servern';
$string['key'] = 'Nyckeln till API-servern.';
$string['key_help'] = 'Ge nyckeln till API-servern för identifiering.';
$string['feedbacklink'] = 'Ge adress till feedbackwebbplatsen';
$string['feedbacklink_help'] = 'Ange adressen till webbplatsen som visas som ett feedbackformulär på bedömningssidan.';

$string['edit_report'] = 'Bearbeta bedömningsrapporten';
$string['holistic-reason'] = 'Feedback på Färdighetsnivå';
$string['taskcompletion-reason'] = 'Feedback på Att svara på uppgiften';
$string['fluency-reason'] = 'Feedback på Flyt';
$string['lexicogrammatical-reason'] = 'Feedback på Uttryckets omfång';
$string['pronunciation-reason'] = 'Feedback på Uttal';
$string['holistic-scale_error'] = 'Färdighetsnivån måste vara mellan 0 och 7';
$string['fluency-scale_error'] = 'Flytet måste vara mellan 0 och 4';
$string['taskcompletion-scale_error'] = 'Att svara på uppgiften måste vara mellan 0 och 3';
$string['lexicogrammatical-scale_error'] = 'Uttryckets omfång måste vara mellan 0 och 3';
$string['pronunciation-scale_error'] = 'Uttalet måste vara mellan 0 och 4';

$string['error_url-not-set'] = 'url-adressen saknas';
$string['error_no-evaluation'] = 'Det finns ingen bedömning. Kolla förbindelsen till API-servern.';
$string['error-save-recording'] = 'Det gick inte att spara inspelningen. Var god försök igen.';

$string['results_link'] = 'Visa rapporten';
$string['results_student'] = 'Studerande';
$string['results_text'] = 'Typ';
$string['results_score_proficiency'] = 'Färdighetsnivån';
$string['results_time'] = 'Tid';
$string['results_tries'] = 'Försök';
$string['results_report'] = 'Bedömningsrapporten';
$string['results_denied'] = 'Tillträde förbjudet';
$string['results_return'] = 'Gå tillbaka till DigiTalas huvudsida';
$string['results_view'] = 'Se inlärarnas resultat';
$string['results_timestamp'] = 'Tidsstämpel';

$string['results_status'] = 'Status';
$string['results_status-evaluated'] = 'Bedömningen färdig';
$string['results_status-waiting'] = 'Väntar på bedömningsrapporten';
$string['results_status-retry'] = 'Nytt försök att bedöma';
$string['results_status-failed'] = 'Bedömningen misslyckades';

$string['results_delete'] = 'Radera försöket';
$string['results_delete-confirm'] = 'Bekräfta raderingen';
$string['results_delete-all'] = 'Radera alla försök';
$string['results_delete-one-text'] = 'Är du säker att du vill radera och nollställa försök från {$a}?';
$string['results_delete-all-text'] = 'Är du säker att du vill radera och nollställa försök från alla användare?';
$string['results_no-show'] = 'Inga resultat ännu.';
$string['results_title'] = 'Användarnas resultat';
$string['results_delete-title'] = 'Obs!';
$string['results_waiting-title'] = 'Bedömning pågår';
$string['results_waiting-info'] = 'Bedömning pågår. Var god vänta, bedömningen kan ta en stund.';
$string['results_waiting-refresh'] = 'Kolla här om bedömningen är färdig.';
$string['results_waiting-loading'] = 'Laddar upp bedömningsrapporten...';
$string['results_retry-title'] = 'Bedömningen misslyckades';
$string['results_retry-info'] = 'Bedömningen misslyckades och ett nytt försök görs om en timme. Den nya bedömningen kan ta lite tid.';

$string['export_attempts'] = 'Ladda ner alla försök i CSV-format';
$string['export_attempts_feedback'] = 'Ladda ner lärarens feedback för alla försök i CSV-format';
$string['export_recordings'] = 'Exportera alla inspelningar';
$string['export_success'] = 'CSV-filen har skapats';

$string['teachergrade'] = 'Lärarens betygsförslag: ';
$string['teacherreason'] = 'Kommentar om betygsändringen: ';
$string['feedback_success'] = 'Kommentaren har sparats i studentrapporten.';
$string['feedback_not-found'] = 'Ingen rapport hittades för den här studenten.';

$string['task-send_to_evaluations'] = 'Skicka in för bedömning';
$string['task-check_failed_evaluation'] = 'Se om bedömningen har misslyckats';
