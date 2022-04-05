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
$string['modulenameplural'] = 'Digitala';
$string['pluginadministration'] = 'Administation';

$string['assignmentname'] = 'Namn';
$string['assignmentname_help'] = 'Skriv namnet av Digitala.';
$string['attemptlang'] = 'Språk';
$string['attemptlang_help'] = 'Välja språket för Digitala';
$string['finnish'] = 'finska';
$string['swedish'] = 'svenska';
$string['unlimited'] = 'Ei rajaa';
$string['attemptlimit'] = 'Vastausyritysten määrä';
$string['attemptlimit_help'] = 'Käyttäjän vastausyritysten määrä.';
$string['attempttype'] = 'Uppgift typ';
$string['attempttype_help'] = 'I Läsa högt -typ måste man läsa texten i Resurser-lådan. I Fri tal -typ kan man tala friare om temat i .';
$string['readaloud'] = 'Läsa högt';
$string['freeform'] = 'Fri tal';
$string['assignment'] = 'Uppgift';
$string['assignment_help'] = 'Uppgift texten som innehåller instruktioner om hur man borde prata';
$string['assignmentresource'] = 'Resurser';
$string['assignmentresource_help'] = 'Komplentterande materialer. I Läsa högt -typ finns texten för läsning här. I Fri tal kan lådan innehålla till exempel texter, bilder eller video.';

$string['navnext'] = 'Nästa >';
$string['navprevious'] = '< Förra';
$string['navstartagain'] = 'Se uppgiften';
$string['navtryagain'] = 'Try again';
$string['navfeedback'] = 'Ge respons';
$string['info'] = 'Info';
$string['microphone'] = 'Mikrofon';
$string['startbutton-no_permissions'] = "Paina uudelleen nauhoittaaksesi.";
$string['startbutton-error'] = "Virhe mikrofoonin kanssa. Tarkasta mikrofoniasetukset.";
$string['attemptsunlimited'] = 'Tässä tehtävässä ei ole yrityskertojen rajaa.';
$string['attemptsremaining'] = 'Sinä voit vielä {$a} kertaa yrittää tätä uudestaan.';
$string['infotext'] = 'Testa mikrofonen före uppgiften.';
$string['startbutton'] = 'Start';
$string['stopbutton'] = 'Stop';
$string['listenbutton'] = 'Lyssna';
$string['assignmentrecord'] = 'Spela in svaret';
$string['submit'] = 'Skicka';
$string['alreadysubmitted'] = "Du har redan skickat din svar. Gå till nästa sidan för att se rapporten.";
$string['report'] = 'Rapport';
$string['reportnotavailable'] = 'Det finns ingen raporten ännu.';
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
$string['holistic_level-0'] = 'Alle A1';
$string['holistic_level-1'] = 'A1';
$string['holistic_level-2'] = 'A2';
$string['holistic_level-3'] = 'B1';
$string['holistic_level-4'] = 'B2';
$string['holistic_level-5'] = 'C1';
$string['holistic_level-6'] = 'C2';
$string['holistic_score-0'] = '<ul><li>Pystyy tuottamaan vain joitakin yksittäisiä, irrallisia sanoja kohdekielellä</li></ul>';
$string['holistic_score-1'] = '<ul>'.
    '<li>Osaa kertoa lyhyesti itsestään ja lähipiiristään, selviytyy kaikkein yksinkertaisimmista vuoropuheluista ja palvelutilanteista</li>'.
    '<li>Tauot, toistot ja katkokset ovat yleisiä</li>'.
    '<li>Ääntäminen voi tuottaa ymmärtämisongelmia</li>'.
    '<li>Osaa suppean perussanaston, perustason lauserakenteita sekä ulkoa opeteltuja ilmauksia ja fraaseja</li>'.
    '<li>Kielioppivirheitä esiintyy paljon vapaassa puheessa</li>'.
    '</ul>';
$string['holistic_score-2'] = '<ul>'.
    '<li>Selviytyy yksinkertaisista sosiaalisista kohtaamisista, osaa aloittaa ja lopettaa lyhyen vuoropuhelun</li>'.
    '<li>Puheessa voi olla välillä sujuvaa, mutta taukoja, katkoksia ja vääriä aloituksia esiintyy paljon</li>'.
    '<li>Ääntäminen on ymmärrettävää, mutta satunnaisia ymmärtämisongelmia voi esiintyä ääntämisen takia</li>'.
    '<li>Hallitsee perussanaston ja perusrakenteita sekä joitakin idiomaattisia ilmauksia</li>'.
    '<li>Hallitsee yksinkertaisimman peruskieliopin, mutta virheitä voi esiintyä paljon perusrakenteissakin</li>'.
    '</ul>';
$string['holistic_score-3'] = '<ul>'.
    '<li>Osaa kuvailla konkreetteja aiheita, selviytyy tavallisimmista arkitilanteista, mutta ilmaisu ei välttämättä ole kovin tarkkaa</li>'.
    '<li>Osaa pitää yllä melko sujuvaa puhetta</li>'.
    '<li>Ääntäminen on ymmärrettävää, mutta ääntämisvirheitä, kohdekielelle epätyypillistä intonaatiota ja painotusta esiintyy</li>'.
    '<li>Käyttää melko laajaa sanastoa ja tavallisia idiomeja, erilaisia rakenteita ja lauseita</li>'.
    '<li>Kielioppivirheitä esiintyy, mutta ne haittaavat harvoin viestin välittymistä</li>'.
    '</ul>';
$string['holistic_score-4'] = '<ul>'.
    '<li>Osaa ilmaista itseään varmasti, selkeästi ja kohteliaasti tilanteen vaatimalla tavalla, osaa keskustella monista asioista, mutta tarvitsee joskus kiertoilmauksia</li>'.
    '<li>Puhuu sujuvasti myös spontaanisti, puheessa on harvoin pidempiä taukoja tai epäröintiä</li>'.
    '<li>Ääntäminen on ymmärrettävää, ääntäminen ja intonaatio ovat selkeitä ja luontevia</li>'.
    '<li>Laajahkoa sanastoa konkreeteista ja käsitteellisistä sekä tutuista ja tuntemattomista aiheista, monipuolisia rakenteita</li>'.
    '<li>Kieliopin hallinta on hyvää, satunnaiset kielioppivirheet eivät vaikuta ymmärrettävyyteen, korjaa välillä ne itse</li>'.
    '</ul>';
$string['holistic_score-5'] = '<ul>'.
    '<li>Osallistuu aktiivisesti monimutkaisiin käsitteellisiä ja yksityiskohtia sisältäviin tilanteisiin, selviää monenlaisesta sosiaalisesta vuorovaikutuksesta tilanteen vaatimalla tavalla</li>'.
    '<li>Puhe on sujuvaa, spontaania ja lähes vaivatonta</li>'.
    '<li>Ääntäminen on ymmärrettävää, vaihtelee intonaatiota ja hallitsee lausepainot</li>'.
    '<li>Sanasto ja rakenteet ovat laajat, eivätkä juuri rajoita ilmaisua</li>'.
    '<li>Kieliopin hallinta on hyvää, satunnaiset kielioppivirheet eivät vaikuta ymmärrettävyyteen, korjaa ne itse</li>'.
    '</ul>';
$string['holistic_score-6'] = '<ul>'.
    '<li>Osallistuu vaivatta kaikenlaisiin keskusteluihin tilanteen ja puhekumppanien edellyttämällä tavalla, välittää täsmällisesti hienojakin merkitysvivahteita</li>'.
    '<li>Puhuu sujuvasti, luontevasti ja epäröimättä myös pitkäkestoisessa puhetilanteessa</li>'.
    '<li>Ääntäminen on täysin ymmärrettävää, vaihtelee intonaatiota ja hallitsee lausepainot</li>'.
    '<li>Ilmaisu täsmällistä ja asianmukaista, merkitysvivahteetkin välittyvät, käyttää idiomaattisia tai puhekielisiä ilmauksia, sanasto ja rakenteet eivät rajoita ilmaisua</li>'.
    '<li>Hallitsee vaativatkin rakenteet, korjaa tarvittaessa ilmaisuaan, kiertää vaikeudet</li>'.
    '</ul>';

$string['fluency'] = 'Sujuvuus';
$string['fluency_score-0'] = 'Ei voi arvioida.';
$string['fluency_score-1'] = 'Epäsujuva; paljon häiritseviä taukoja, toistoja, katkoksia ja empimistä.';
$string['fluency_score-2'] = 'Kohtalaisen sujuva; joitakin häiritseviä taukoja, toistoja, katkoksia ja empimistä.';
$string['fluency_score-3'] = 'Sujuva ja vaivaton; ei häiritseviä taukoja, toistoja, katkoksia tai empimistä.';
$string['fluency_score-4'] = 'Todella sujuva ja vaivaton; ei häiritseviä taukoja, toistoja, katkoksia tai empimistä.';

$string['accuracy'] = 'Sanaston ja kieliopin tarkkuus';
$string['accuracy_score-0'] = 'Ei voi arvioida.';
$string['accuracy_score-1'] = 'Paljon ymmärrettävyyttä haittaavia sanasto- ja kielioppivirheitä';
$string['accuracy_score-2'] = 'Joitakin ymmärrettävyyttä haittaavia sanasto- ja kielioppivirheitä';
$string['accuracy_score-3'] = 'Ei juurikaan ymmärrettävyyttä haittaavia sanasto- ja kielioppivirheitä';
$string['accuracy_score-4'] = 'Ei häiritseviä sanasto- tai kielioppivirheitä tai puhuja korjaa virheet itse.';

$string['lexicalprofile'] = 'Ilmaisun laajuus';
$string['lexicalprofile_score-0'] = 'Ei voi arvioida.';
$string['lexicalprofile_score-1'] = 'Suppea (esim. yksittäisiä sanoja, kaavamaisia ilmaisuja';
$string['lexicalprofile_score-2'] = 'Riittävä (perussanasto, esim. lauseita)';
$string['lexicalprofile_score-3'] = 'Laaja (monipuolinen sana- ja ilmaisuvaranto)';

$string['nativeity'] = 'Ääntäminen';
$string['nativeity_score-0'] = 'Ei voi arvioida.';
$string['nativeity_score-1'] = 'Heikko, vaikea ymmärtää, paljon ongelmia ääntämisessä.';
$string['nativeity_score-2'] = 'Kohtalainen, melko helppo ymmärtää, mutta joitakin ongelmia ääntämisessä.';
$string['nativeity_score-3'] = 'Hyvä, ymmärrettävä, ei suurempia ongelmia ääntämisessä.';
$string['nativeity_score-4'] = 'Todella hyvä, selkeä ja luonteva ääntäminen.';

$string['api'] = 'API-palvelimen osoite';
$string['api_help'] = 'Anna API-palvelimen osoite.';
$string['key'] = 'API-palvelimen avain';
$string['key_help'] = 'Anna API-palvelimen tunnistautumiseen käytettävä avain.';
$string['error_url-not-set'] = 'url-adress har inte bestämt';
$string['error_no-evaluation'] = 'Det finns ingen bedömning. Kolla kopplingen med API-server.';

$string['results_link'] = 'Visa rapport';
$string['results_student'] = 'Student';
$string['results_text'] = 'Typ';
$string['results_score'] = 'Betyg/GOP';
$string['results_time'] = 'Tid';
$string['results_tries'] = 'Försök';
$string['results_report'] = 'Rapport';
$string['results_denied'] = 'Pääsy kielletty';
$string['results_return'] = 'Palaa Digitalan etusivulle';
