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
$string['digitala:addinstance'] = 'Lägger till en ny Digitala';
$string['digitala:viewdetailreport'] = 'Se detaljerad rapport över studentinlämningar';
$string['modulenameplural'] = 'Digitala';
$string['pluginadministration'] = 'Administation';

$string['assignmentname'] = 'Namn';
$string['assignmentname_help'] = 'Skriv namnet av Digitala.';
$string['attemptlang'] = 'Språk';
$string['attemptlang_help'] = 'Välja språket för Digitala';
$string['fin'] = 'finska';
$string['sv'] = 'svenska';
$string['attempttype'] = 'Uppgift typ';
$string['attempttype_help'] = 'I Läsa högt -typ måste man läsa texten i Resurser-lådan. I Fri tal -typ kan man tala friare om temat i .';
$string['readaloud'] = 'Läsa högt';
$string['freeform'] = 'Fri tal';
$string['timelimit'] = 'Maksimiaika';
$string['attemptlimit'] = 'Vastausyritysten määrä';
$string['attemptlimit_help'] = 'Käyttäjän vastausyritysten määrä.';
$string['unlimited'] = 'Ei rajaa';
$string['assignment'] = 'Uppgift';
$string['assignment_help'] = 'Uppgift texten som innehåller instruktioner om hur man borde prata';
$string['assignmentresource'] = 'Resurser';
$string['assignmentresource_help'] = 'Komplentterande materialer. I Läsa högt -typ finns texten för läsning här. I Fri tal kan lådan innehålla till exempel texter, bilder eller video.';

$string['navnext'] = 'Nästa >';
$string['navprevious'] = '< Förra';
$string['navstartagain'] = 'Se uppgiften';
$string['navtryagain'] = 'Try again';
$string['feedback'] = 'Ge respons';
$string['info'] = 'Info';
$string['infotext'] = 'Testa mikrofonen före uppgiften.';
$string['startbutton'] = 'Start';
$string['startbutton-again'] = 'Nauhoita uudelleen';
$string['startbutton-no_permissions'] = 'Paina uudelleen nauhoittaaksesi.';
$string['startbutton-error'] = 'Virhe mikrofoonin kanssa. Tarkasta mikrofoniasetukset.';
$string['stopbutton'] = 'Stop';
$string['microphone'] = 'Mikrofon';
$string['attemptsunlimited'] = 'Tässä tehtävässä ei ole yrityskertojen rajaa.';
$string['attemptsremaining'] = 'Sinä voit vielä {$a} kertaa yrittää tätä uudestaan.';
$string['listenbutton'] = 'Lyssna';
$string['assignmentrecord'] = 'Spela in svaret';
$string['submit'] = 'Skicka';
$string['submitclose'] = 'Sulje';
$string['submittitle'] = 'Oletko varma, että haluat palauttaa tämän vastauksen?';
$string['submitbody'] = 'Sinulla on vielä {$a} vastausyritystä tässä tehtävässä.';
$string['alreadysubmitted'] = 'Du har redan skickat din svar. Gå till nästa sidan för att se rapporten.';
$string['report'] = 'Rapport';
$string['reportnotavailable'] = 'Det finns ingen raporten ännu.';
$string['reportinformation'] = 'Tämä palaute koskee ainoastaan nauhoittamaasi puhenäytettä, eikä se kuvaa kaikkea suullista kielitaitoasi. Automaattinen arvio on koneen tekemä. Konetta on opetettu muiden kielen oppijoiden puheella ja muulla kieliaineistolla.';
$string['transcription'] = 'Transkription';

$string['task_grades'] = 'Delområden av talet';

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

$string['holistic'] = 'Helbetyg';
$string['holistic_description'] = 'Automaattisen arvion mukaan vaikuttaa siltä, että taitotasosi on ';
$string['holistic_level-0'] = 'Alle A1';
$string['holistic_level-1'] = 'A1';
$string['holistic_level-2'] = 'A2';
$string['holistic_level-3'] = 'B1';
$string['holistic_level-4'] = 'B2';
$string['holistic_level-5'] = 'C1';
$string['holistic_level-6'] = 'C2';
$string['holistic_score-0'] = 'Tuotat joitakin sanoja kohdekielellä.';
$string['holistic_score-1'] = 'Osaat joitakin lauseita kohdekielellä (esim. tervehtiä tai kertoa itsestäsi).';
$string['holistic_score-2'] = 'Hallitset tavallisia sanoja ja osaat tehdä niistä lauseita kohdekielellä (esim. aloittaa ja lopettaa lyhyen vuoropuhelun).';
$string['holistic_score-3'] = 'Selviydyt arkielämän tilanteista kohdekielellä. Ääntämisesi on ymmärrettävää, käytät melko laajaa sanastoa ja erilaisia lauseita.';
$string['holistic_score-4'] = 'Osaat ilmaista itseäsi kohdekielellä tilanteen vaatimalla tavalla ilman pidempiä taukoja tai epäröintiä. Käytät laajahkoa sanastoa ja monipuolisia rakenteita. Ääntäminen ja intonaatio selkeää ja luontevaa.';
$string['holistic_score-5'] = 'Puheesi on sujuvaa, spontaania ja lähes vaivatonta. Osaat halutessasi ilmaista asioita yksityiskohtaisesti tilanteen vaatimalla tavalla.';
$string['holistic_score-6'] = 'Puhut sujuvasti, luontevasti ja epäröimättä myös pitkäkestoisessa puhetilanteessa. Puheesi on täsmällistä ja asianmukaista, sopii tilanteeseen. Vaihtelet intonaatiota ja hallitset lausepainot.';

$string['taskachievement'] = 'Tehtävänantoon vastaaminen';
$string['taskachievement_description'] = 'Tämä mittari perustuu vastauksiin, joilla kone on opetettu arvioimaan tätä tehtävää. Automaattisen arvion mukaan vaikuttaa siltä, että ';
$string['taskachievement_score-0'] = 'Valitettavasti kone ei ole kuullut tämänkaltaista suoritusta aiemmin, eikä siksi osaa arvioida puhettasi. Älä lannistu, yritä uudelleen!';
$string['taskachievement_score-1'] = 'Vastasit tehtävänantoon vain osittain.';
$string['taskachievement_score-2'] = 'Vastaat tehtävänantoon hyvin.';
$string['taskachievement_score-3'] = 'Vastaat tehtävänantoon erinomaisesti.';

$string['fluency'] = 'Sujuvuus';
$string['fluency_description'] = 'Tämä mittari kertoo puhenäytteesi nopeudesta, taukojen määrästä ja empimisestä. Automaattisen arvion mukaan vaikuttaa siltä, että ';
$string['fluency_score-0'] = 'Valitettavasti kone ei ole kuullut tämänkaltaista suoritusta aiemmin, eikä siksi osaa arvioida puhettasi. Älä lannistu, yritä uudelleen!';
$string['fluency_score-1'] = 'Puheessasi on paljon taukoja, katkoksia tai empimistä.';
$string['fluency_score-2'] = 'Puheesi on kohtalaisen sujuvaa, joitakin taukoja, katkoksia tai empimistä.';
$string['fluency_score-3'] = 'Puheesi on sujuvaa ja vaivatonta, ei häiritseviä taukoja, katkoksia tai empimistä.';

$string['nativeity'] = 'Ääntäminen';
$string['nativeity_description'] = 'Näet yllä, että kone muunsi puheesi tekstiksi. Voit tarkistaa tekstistä, lausuitko kaikki sanat oikein. Tämä mittari kertoo, kuinka hyvin ja varmasti kone tunnistaa puheesi. Tunnistamistarkkuuteen vaikuttavat puhenäytteet, joita kone on aiemmin opetusvaiheessa saanut. Automaattisen arvion mukaan vaikuttaa siltä, että ';
$string['nativeity_score-0'] = 'Valitettavasti kone ei ole kuullut tämänkaltaista suoritusta aiemmin, eikä siksi osaa arvioida puhettasi. Älä lannistu, yritä uudelleen!';
$string['nativeity_score-1'] = 'Koneen on vaikea ymmärtää puhettasi.';
$string['nativeity_score-2'] = 'Koneen on melko helppo ymmärtää puhettasi, mutta näytteessä voi olla joitakin ääntämisongelmia.';
$string['nativeity_score-3'] = 'Kone ymmärtää puhettasi, ääntämisessäsi ei vaikuta olevan suurempia ongelmia.';

$string['lexicalprofile'] = 'Laajuus';
$string['lexicalprofile_description'] = 'Tämä mittari kertoo, kuinka paljon olet puhunut sekä käyttämiesi sanojen ja lauseiden monipuolisuudesta. Automaattisen arvion mukaan vaikuttaa siltä, että ';
$string['lexicalprofile_score-0'] = 'Valitettavasti kone ei ole kuullut tämänkaltaista suoritusta aiemmin, eikä siksi osaa arvioida puhettasi. Älä lannistu, yritä uudelleen!';
$string['lexicalprofile_score-1'] = 'Puhenäytteesi on hyvin lyhyt tai sisältää lähinnä yksittäisiä sanoja.';
$string['lexicalprofile_score-2'] = 'Käytät tavallisia sanoja ja osaat tehdä niistä lauseita.';
$string['lexicalprofile_score-3'] = 'Käytät monipuolisesti eri sanoja ja lauserakenteita.';

$string['moreinformation'] = 'Mer information';

$string['api'] = 'API-server adress';
$string['api_help'] = 'Ge API-server adress.';
$string['key'] = 'API-server nyckel';
$string['key_help'] = 'Ge API-server nyckel för identifiering.';

$string['edit_report'] = 'Edit report';
$string['holistic-reason'] = 'Feedback on holistic';
$string['taskachievement-reason'] = 'Feedback on task achievement';
$string['fluency-reason'] = 'Feedback on fluency';
$string['nativeity-reason'] = 'Feedback on nativeity';
$string['lexicalprofile-reason'] = 'Feedback on lexical profile';
$string['gop-reason'] = 'Feedback on goodness of pronunciation';
$string['holistic-scale_error'] = 'Holistic needs to be between 0 and 7';
$string['fluency-scale_error'] = 'Fluency needs to be between 0 and 3';
$string['taskachievement-scale_error'] = 'Task achievement needs to be between 0 and 3';
$string['nativeity-scale_error'] = 'Nativeity needs to be between 0 and 3';
$string['lexicalprofile-scale_error'] = 'Lexical profile needs to be between 0 and 3';
$string['gop-scale_error'] = 'Godness of pronunciation needs to be between 0 and 1';

$string['error_url-not-set'] = 'url-adress har inte bestämt';
$string['error_no-evaluation'] = 'Det finns ingen bedömning. Kolla kopplingen med API-server.';

$string['results_link'] = 'Visa rapport';
$string['results_student'] = 'Student';
$string['results_text'] = 'Typ';
$string['results_score'] = 'Betyg/GOP';
$string['results_time'] = 'Tid';
$string['results_tries'] = 'Försök';
$string['results_report'] = 'Rapport';
$string['results_denied'] = 'Tillträde förbjudet';
$string['results_return'] = 'Returnera';
$string['results_view'] = 'Titta studenters resultat';
