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
$string['digitala:addinstance'] = 'Lisää uusi Digitala-aktiviteetti';
$string['digitala:viewdetailreport'] = 'Tarkastele kaikkia suorituksia';
$string['modulenameplural'] = 'Digitalat';
$string['pluginadministration'] = 'Liitännäisen hallintatyökalut';

$string['assignmentname'] = 'Tehtävän nimi';
$string['assignmentname_help'] = 'Lisää tehtävän nimi.';
$string['attemptlang'] = 'Suorituskieli';
$string['attemptlang_help'] = 'Valitse, minkä kielen tehtävä luodaan.';
$string['fi'] = 'Suomi';
$string['sv'] = 'Ruotsi';
$string['attempttype'] = 'Tehtävätyyppi';
$string['attempttype_help'] = 'Lue ääneen -tehtävässä pitää lukea annettu teksti ääneen. Vapaa tuotto -tehtävässä voidaan puhua vapaammin tehtävänannon aiheesta.';
$string['readaloud'] = 'Lue ääneen';
$string['freeform'] = 'Vapaa tuotto';
$string['timelimit'] = 'Maksimiaika';
$string['attemptlimit'] = 'Vastausyritysten määrä';
$string['attemptlimit_help'] = 'Käyttäjän vastausyritysten määrä.';
$string['unlimited'] = 'Ei rajaa';
$string['assignment'] = 'Tehtävä';
$string['assignment_help'] = 'Tehtävänanto, jonka mukaan tulee tehdä puhesuoritus.';
$string['assignmentresource'] = 'Aineisto';
$string['assignmentresource_help'] = 'Tehtävän aineisto voidaan liittää tähän. Lue ääneen -tehtävän luettava teksti tulee tähän. Vapaa tuotto -tehtävässä tähän voidaan lisätä tekstiä, kuvia, kaavioita ja videoita, joita suorituksessa tulee hyödyntää.';
$string['maxlength_error'] = 'Nauhoite saa olla maksimissaan 5 minuuttia pitkä';

$string['navnext'] = 'Seuraava >';
$string['navprevious'] = '< Edellinen';
$string['navstartagain'] = 'Katso tehtävää';
$string['navtryagain'] = 'Yritä uudestaan';
$string['feedback'] = 'Anna palautetta';
$string['info'] = 'Aloitus';
$string['infotext'] = 'Kokeile mikrofonin toimintaa ennen tehtävän tekemistä.';
$string['startbutton'] = 'Nauhoita';
$string['startbutton-again'] = 'Nauhoita uudelleen';
$string['startbutton-loading'] = 'Odotetaan mikrofonia.';
$string['startbutton-error'] = 'Virhe mikrofonin kanssa. Tarkasta mikrofoniasetukset ja lataa sivu uudelleen.';
$string['startbutton-no_permissions'] = "Paina uudelleen nauhoittaaksesi.";
$string['stopbutton'] = 'Pysäytä';
$string['microphone'] = 'Testaa mikrofoniasi tässä';
$string['attemptsunlimited'] = 'Tässä tehtävässä ei ole yrityskertojen rajaa.';
$string['attemptsremaining'] = 'Voit yrittää tätä tehtävää uudestaan vielä {$a} kertaa.';
$string['listenbutton'] = 'Kuuntele nauhoitus';
$string['assignmentrecord'] = 'Vastauksen nauhoittaminen';
$string['submit'] = 'Palauta vastaus';
$string['submitclose'] = 'Sulje';
$string['submittitle'] = 'Oletko varma, että haluat palauttaa tämän vastauksen?';
$string['submitbody'] = 'Sinulla on vielä {$a} vastausyritystä tässä tehtävässä.';
$string['alreadysubmitted'] = 'Olet jo palauttanut vastauksen. Siirry seuraavalle sivulle nähdäksesi raportin.';
$string['report'] = 'Arviointi';
$string['report-title'] = 'Arviointiraportti';
$string['report-title-feedback'] = 'Arviointiraportti - sisältää opettajan arvosanaehdotuksia';
$string['reportnotavailable'] = 'Arviointiraportti ei ole vielä saatavilla.';
$string['reportinformation'] = 'Tämä palaute koskee ainoastaan nauhoittamaasi puhenäytettä, eikä se kuvaa kaikkea suullista kielitaitoasi. Automaattinen arvio on koneen tekemä. Konetta on opetettu muiden kielen oppijoiden puheella ja muulla kieliaineistolla.';
$string['transcription'] = 'Puhenäytteesi tekstinä';
$string['server-feedback'] = 'Puhenäytteesi palaute';
$string['teacher-feedback'] = 'Ehdota arvioinnin muutoksia';
$string['transcription_tab-plain'] = 'Pelkkä teksti';
$string['transcription_tab-corrected'] = 'Näytä korjaukset';

$string['task_grades'] = 'Analyyttinen arvio';

$string['holistic'] = 'Taitotasoarvio';
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

$string['taskcompletion'] = 'Tehtävänantoon vastaaminen';
$string['taskcompletion_description'] = 'Tämä mittari perustuu vastauksiin, joilla kone on opetettu arvioimaan tätä tehtävää. Automaattisen arvion mukaan vaikuttaa siltä, että ';
$string['taskcompletion_score-0'] = 'Valitettavasti kone ei ole kuullut tämänkaltaista suoritusta aiemmin, eikä siksi osaa arvioida puhettasi. Älä lannistu, yritä uudelleen!';
$string['taskcompletion_score-1'] = 'Vastasit tehtävänantoon vain osittain.';
$string['taskcompletion_score-2'] = 'Vastaat tehtävänantoon hyvin.';
$string['taskcompletion_score-3'] = 'Vastaat tehtävänantoon erinomaisesti.';

$string['fluency'] = 'Sujuvuus';
$string['fluency_description'] = 'Tämä mittari kertoo puhenäytteesi nopeudesta, taukojen määrästä ja empimisestä. Automaattisen arvion mukaan vaikuttaa siltä, että ';
$string['fluency_score-0'] = 'Valitettavasti kone ei ole kuullut tämänkaltaista suoritusta aiemmin, eikä siksi osaa arvioida puhettasi. Älä lannistu, yritä uudelleen!';
$string['fluency_score-1'] = 'Puheessasi on paljon taukoja, katkoksia tai empimistä.';
$string['fluency_score-2'] = 'Puheesi on kohtalaisen sujuvaa, joitakin taukoja, katkoksia tai empimistä.';
$string['fluency_score-3'] = 'Puheesi on sujuvaa ja vaivatonta, ei häiritseviä taukoja, katkoksia tai empimistä.';
$string['fluency_score-4'] = 'Puheesi on todella sujuvaa ja vaivatonta, ei häiritseviä taukoja, katkoksia tai empimistä.';

$string['pronunciation'] = 'Ääntäminen';
$string['pronunciation_description'] = 'Näet yllä, että kone muunsi puheesi tekstiksi. Voit tarkistaa tekstistä, lausuitko kaikki sanat oikein. Tämä mittari kertoo, kuinka hyvin ja varmasti kone tunnistaa puheesi. Tunnistamistarkkuuteen vaikuttavat puhenäytteet, joita kone on aiemmin opetusvaiheessa saanut. Automaattisen arvion mukaan vaikuttaa siltä, että ';
$string['pronunciation_score-0'] = 'Valitettavasti kone ei ole kuullut tämänkaltaista suoritusta aiemmin, eikä siksi osaa arvioida puhettasi. Älä lannistu, yritä uudelleen!';
$string['pronunciation_score-1'] = 'Koneen on vaikea ymmärtää puhettasi.';
$string['pronunciation_score-2'] = 'Koneen on melko helppo ymmärtää puhettasi, mutta näytteessä voi olla joitakin ääntämisongelmia.';
$string['pronunciation_score-3'] = 'Kone ymmärtää puhettasi, ääntämisessäsi ei vaikuta olevan suurempia ongelmia.';
$string['pronunciation_score-4'] = 'Ääntämisesi on selkeää ja luontevaa. ';

$string['lexicogrammatical'] = 'Laajuus';
$string['lexicogrammatical_description'] = 'Tämä mittari kertoo, kuinka paljon olet puhunut sekä käyttämiesi sanojen ja lauseiden monipuolisuudesta. Automaattisen arvion mukaan vaikuttaa siltä, että ';
$string['lexicogrammatical_score-0'] = 'Valitettavasti kone ei ole kuullut tämänkaltaista suoritusta aiemmin, eikä siksi osaa arvioida puhettasi. Älä lannistu, yritä uudelleen!';
$string['lexicogrammatical_score-1'] = 'Puhenäytteesi on hyvin lyhyt tai sisältää lähinnä yksittäisiä sanoja.';
$string['lexicogrammatical_score-2'] = 'Käytät tavallisia sanoja ja osaat tehdä niistä lauseita.';
$string['lexicogrammatical_score-3'] = 'Käytät monipuolisesti eri sanoja ja lauserakenteita.';

$string['moreinformation'] = 'Lisätietoja';
$string['moreinformation_help'] = 'Information to provide to the student after they have made an attempt.';

$string['api'] = 'API-palvelimen osoite';
$string['api_help'] = 'Anna API-palvelimen osoite.';
$string['key'] = 'API-palvelimen avain';
$string['key_help'] = 'Anna API-palvelimen tunnistautumiseen käytettävä avain.';

$string['edit_report'] = 'Muokkaa arviointiraporttia';
$string['holistic-reason'] = 'Palaute Taitotasosta';
$string['taskcompletion-reason'] = 'Palaute Tehtävänantoon vastaamisesta';
$string['fluency-reason'] = 'Palaute Sujuvuudesta';
$string['lexicogrammatical-reason'] = 'Palaute Laajuudesta';
$string['pronunciation-reason'] = 'Palaute Ääntämisestä';
$string['holistic-scale_error'] = 'Taitotaso tulee olla välillä 0 ja 7';
$string['fluency-scale_error'] = 'Sujuvuus tulee olla välillä 0 ja 4';
$string['taskcompletion-scale_error'] = 'Tehtävänantoon vastaaminen tulee olla välillä 0 ja 3';
$string['lexicogrammatical-scale_error'] = 'Laajuus tulee olla välillä 0 ja 3';
$string['pronunciation-scale_error'] = 'Ääntäminen tulee olla välillä 0 ja 4';

$string['error_url-not-set'] = 'url-osoitetta ei ole asetettu';
$string['error_no-evaluation'] = 'Arviointia ei löytynyt. Tarkista yhteys arviointipalvelimeen.';
$string['error-save-recording'] = 'Äänitteen tallennus ei onnistunut. Voit yrittää uudelleen.';

$string['results_link'] = 'Näytä raportti';
$string['results_student'] = 'Oppilas';
$string['results_text'] = 'Tyyppi';
$string['results_score_proficiency'] = 'Taitotaso';
$string['results_time'] = 'Aika';
$string['results_tries'] = 'Yritys';
$string['results_report'] = 'Arviointiraportti';
$string['results_denied'] = 'Pääsy kielletty';
$string['results_return'] = 'Palaa Digitalan etusivulle';
$string['results_view'] = 'Tarkastele oppilaiden tuloksia';
$string['results_timestamp'] = 'Suoritusaika';

$string['results_delete'] = 'Poista suoritus';
$string['results_delete-confirm'] = 'Vahvista suorituksen poistaminen';
$string['results_delete-all'] = 'Poista kaikki';
$string['results_delete-one-text'] = 'Haluatko varmasti poistaa ja nollata suoritukset käyttäjältä {$a}?';
$string['results_delete-all-text'] = 'Haluatko varmasti poistaa ja nollata suoritukset kaikilta käyttäjiltä?';
$string['results_no-show'] = 'Ei vielä suorituksia.';
$string['results_title'] = 'Käyttäjien suoritukset';
$string['results_delete-title'] = 'Varoitus';
$string['results_waiting-title'] = 'Evaluation in progress';
$string['results_waiting-info'] = 'Evaluation is in progress, please hold. This could take up to few eternities.';
$string['results_waiting-refresh'] = 'Press here to check if evaluation is completed.';
$string['results_waiting-loading'] = 'Loading...';

$string['export_attempts'] = 'Lataa kaikki yritykset CSV-muodossa';
$string['export_attempts_feedback'] = 'Lataa kaikki palautteet jokaiselle yritykselle CSV-muodossa';
$string['export_success'] = 'CSV-tiedoston luonti onnistui.';
$string['teachergrade'] = "Opettajan arvosanaehdotus: ";
$string['teacherreason'] = "Kommentti arvosanan muutoksesta: ";
$string['feedback_success'] = 'Kommentti opiskelijan raportista on tallennettu onnistuneesti.';
$string['feedback_not-found'] = 'Opiskelijalle ei löydy tuloksia.';

$string['task-send_to_evaluations'] = 'Send to evaluation';
$string['task-check_failed_evaluation'] = 'Check for failed evaluations';
