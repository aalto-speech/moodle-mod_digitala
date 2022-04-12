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
$string['digitala:addinstance'] = 'Lägger till en ny Digitala-aktivitet';
$string['digitala:viewdetailreport'] = 'Se inlärarnas ansvar i detalj';
$string['modulenameplural'] = 'Digitalar';
$string['pluginadministration'] = 'Administation';

$string['assignmentname'] = 'Namn på uppgiftet';
$string['assignmentname_help'] = 'Lägg till ett namn på uppgiften.';
$string['attemptlang'] = 'Språk';
$string['attemptlang_help'] = 'Välja vilken språkuppgift som skapas';
$string['fin'] = 'finska';
$string['sv'] = 'svenska';
$string['attempttype'] = 'Uppgiftstyp';
$string['attempttype_help'] = 'I uppgiften "Läs högt" måste man läsa texten så noggrant och tydligt som man kan. I uppgiften "Fritt tal" kan man tala friare om temat.';
$string['readaloud'] = 'Läs högt';
$string['freeform'] = 'Fritt tal';
$string['timelimit'] = 'Maxtid';
$string['attemptlimit'] = 'Antalet svarsförsök';
$string['attemptlimit_help'] = 'Det antal svarsförsök som användaren har.';
$string['unlimited'] = 'Ingen gräns';
$string['assignment'] = 'Uppgift';
$string['assignment_help'] = 'En instruktionstext om vad och hur man ska tala i uppgiften';
$string['assignmentresource'] = 'Material';
$string['assignmentresource_help'] = 'Material placeras här. I uppgiften "Läs högt" placeras texten här. I uppgiften "Fritt tal" kan man placera här t.ex. text, bilder och figurer som utnyttjas i uppgiften.';

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
$string['startbutton-error'] = 'Fel på mikrofonen. Kontrollera mikrofoninställningarna.';
$string['startbutton-no_permissions'] = 'Klicka på nytt för att spela in.';
$string['stopbutton'] = 'Stopp';
$string['microphone'] = 'Testa mikrofonen här';
$string['attemptsunlimited'] = 'Här finns inge övre gräns för svarsförsöken.';
$string['attemptsremaining'] = 'Du kan försöka {$a} gånger till.';
$string['listenbutton'] = 'Lyssna';
$string['assignmentrecord'] = 'Spela in svaret';
$string['submit'] = 'Lämna in svaret';
$string['submitclose'] = 'Stäng av';
$string['submittitle'] = 'Är du säker att du vill lämna in svaret?';
$string['submitbody'] = 'Du har {$a} svarsförsök kvar i den här uppgiften';
$string['alreadysubmitted'] = 'Du har redan lämnat in svaret. Gå till nästa sida för att se rapporten';
$string['report'] = 'Bedömning';
$string['report-title'] = 'Bedömningsrapporten';
$string['reportnotavailable'] = 'Bedömningsrapporten är ännu inte tillgänglig.';
$string['reportinformation'] = 'Den här feedbacken gäller endast den uppgift som du har spelat in, inte muntlig färdighet generellt. Den automatiska bedömningen har gjorts av datorn. Datorn har lärts att bedöma tal med hjälp av andra språkinlärares tal och andra taluppgifter.';
$string['transcription'] = 'Ditt tal som text';

$string['task_grades'] = 'Analytisk bedömning';

$string['gop'] = 'Goodness of Pronunciation';
$string['gop_score-0'] = 'Ääntämisen taso on 0.';
$string['gop_score-1'] = 'Ääntämisen taso on 1.';
$string['gop_score-2'] = 'Ääntämisen taso on 2.';
$string['gop_score-3'] = 'Ääntämisen taso on 3.';
$string['gop_score-4'] = 'Ääntämisen taso on 4.';
$string['gop_score-5'] = 'Ääntämisen taso on 5.';
$string['gop_score-6'] = 'Ääntämisen taso on 6.';
$string['gop_score-7'] = 'Ääntämisen taso on 7.';
$string['gop_score-8'] = 'Ääntämisen taso on 8.';
$string['gop_score-9'] = 'Ääntämisen taso on 9.';
$string['gop_score-10'] = 'Ääntämisen taso on 10.';

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

$string['taskachievement'] = 'Att svara på uppgiften';
$string['taskachievement_description'] = 'Den här mätaren grundar sig på de svar med vilka datorn har lärts att bedöma uppgiften. Automatisk bedömning tyder på att ';
$string['taskachievement_score-0'] = 'datorn inte har bedömt tidigare just den typ av tal du presterat och datorn kan därför inte bedöma det du säger. Ge inte upp utan försök igen!';
$string['taskachievement_score-1'] = 'du endast delvis svarar på uppgiften.';
$string['taskachievement_score-2'] = 'du svarar bra på uppgiften.';
$string['taskachievement_score-3'] = 'du svarar utmärkt på uppgiften.';

$string['fluency'] = 'Flyt';
$string['fluency_description'] = 'Den här mätaren berättar om taltempo, antalet pauser och tvekanden. Automatisk bedömning tyder på att ';
$string['fluency_score-0'] = 'Om du får betyget 0, betyder det att datorn inte har bedömt tidigare just den typ av tal du presterat och datorn kan därför inte bedöma det du säger. Ge inte upp utan försök igen!';
$string['fluency_score-1'] = 'du har många pauser, avbrott och tvekanden.';
$string['fluency_score-2'] = 'du talar ganska flytande med en del pauser, avbrott och tvekanden.';
$string['fluency_score-3'] = 'du talar flytande och ledigt; pauser, avbrott och tvekanden är inte störande.';
$string['fluency_score-4'] = 'du talar mycket flytande och ledigt; pauser, avbrott och tvekanden är inte störande.';

$string['pronunciation'] = 'Uttal';
$string['pronunciation_description'] = 'Du ser ovan att datorn förändrade ditt tal till en text. Du kan se i texten, huruvida du uttalade alla ord rätt. Den här mätaren berättar om hur väl och säkert datorn identifierade det du sade. Detta påverkas av det talmaterial som datorn har lärts att bedöma tal med. Automatisk bedömning tyder på att ';
$string['pronunciation_score-0'] = 'datorn inte har bedömt tidigare just den typ av tal du presterat och datorn kan därför inte bedöma det du säger. Ge inte upp utan försök igen!';
$string['pronunciation_score-1'] = 'datorn har ganska svårt att förstå ditt tal.';
$string['pronunciation_score-2'] = 'datorn har ganska lätt att förstå ditt tal, men du tycks ha en del problem med uttalet.';
$string['pronunciation_score-3'] = 'datorn förstår ditt tal och du tycks inte ha några större problem med uttalet.';
$string['pronunciation_score-4'] = 'ditt uttal är begripligt och naturligt.';

$string['range'] = 'Uttryckets omfång';
$string['range_description'] = 'Den här mätaren berättar om hur mycket du talade samt hur varierat ordförråd och varierade meningar du använde. Automatisk bedömning tyder på att ';
$string['range_score-0'] = 'datorn inte har bedömt tidigare just den typ av tal du presterat och datorn kan därför inte bedöma det du säger. Ge inte upp utan försök igen!';
$string['range_score-1'] = 'ditt talprov är mycket kort eller består mestadels av enstaka ord.';
$string['range_score-2'] = 'du använder vanliga ord och du kan skapa meningar av dem.';
$string['range_score-3'] = 'du använder mångsidigt olika typer av ord och meningskonstruktioner.';

$string['moreinformation'] = 'Mer information';

$string['api'] = 'API-server adress';
$string['api_help'] = 'Ge API-server adress.';
$string['key'] = 'API-server nyckel';
$string['key_help'] = 'Ge API-server nyckel för identifiering.';

$string['edit_report'] = 'Bearbeta bedömningsrapporten';
$string['holistic-reason'] = 'Feedback på Färdighetsnivå';
$string['taskachievement-reason'] = 'Feedback på Att svara på uppgiften';
$string['fluency-reason'] = 'Feedback på Flyt';
$string['nativeity-reason'] = 'Feedback on nativeity';
$string['range-reason'] = 'Feedback på Uttryckets omfång';
$string['pronunciation-reason'] = 'Feedback på Uttal';
$string['gop-reason'] = 'CHANGE THIS TO pronunciation-reason';
$string['holistic-scale_error'] = 'Färdighetsnivån måste vara mellan 0 och 7';
$string['fluency-scale_error'] = 'Fluency needs to be between 0 and 3';
$string['taskachievement-scale_error'] = 'Task achievement needs to be between 0 and 3';
$string['nativeity-scale_error'] = 'Nativeity needs to be between 0 and 3';
$string['lexicalprofile-scale_error'] = 'Lexical profile needs to be between 0 and 3';
$string['gop-scale_error'] = 'CHANGE THIS TO pronunciation-scale_error';
$string['pronunciation-scale_error'] = 'Uttalet måste vara mellan 0 och 4';

$string['error_url-not-set'] = 'url-adress har inte bestämt';
$string['error_no-evaluation'] = 'Det finns ingen bedömning. Kolla kopplingen med API-server.';

$string['results_link'] = 'Visa rapporten';
$string['results_student'] = 'Inlärare';
$string['results_text'] = 'Typ';
$string['results_score'] = 'Färdighetsnivån/Analytisk bedömning';
$string['results_time'] = 'Tid';
$string['results_tries'] = 'Försök';
$string['results_report'] = 'Rapporten';
$string['results_denied'] = 'Tillträde förbjudet';
$string['results_return'] = 'Gå tillbaka till DigiTalas huvudsida';
$string['results_view'] = 'Se inlärarnas resultat';
