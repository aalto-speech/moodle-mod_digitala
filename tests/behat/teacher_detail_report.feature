@mod @mod_digitala @javascript
Feature: Teacher can see students detailed report

  Background:
    Given the following "users" exist:
      | username | firstname | lastname   | email                    |
      | ossi     | Ossi      | Opettaja   | ossi.opettaja@koulu.fi   |
      | olli     | Olli      | Opiskelija | olli.opiskelija@koulu.fi |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user | course | role    |
      | ossi | C1     | manager |
      | olli | C1     | student |
    And the following "activities" exist:
      | activity | name      | intro                | course | idnumber  | attemptlang | attempttype | assignment                 | resources                                  | resourcesformat | attemptlimit |
      | digitala | Freeform  | This is a freeform.  | C1     | freeform  | sv          | freeform    | Berätta om Tigerjakt.      | Här är filmen om tiger.                    | 1               | 0            |
      | digitala | Readaloud | This is a readaloud. | C1     | readaloud | fin         | readaloud   | Lue seuraava lause ääneen. | Tämä on liikennevalojen perusteet -kurssi. | 1               | 2            |
    And I add freeform attempt to database:
      | name     | username | attemptnumber | file  | transcript  | fluency | fluencymean | speechrate | taskachievement | accuracy | lexicalprofile | nativeity | holistic | recordinglength |
      | Freeform | olli     | 1             | file1 | transcript1 | 1       | 2           | 3          | 1               | 2        | 3              | 1         | 2        | 1               |
    And I add readaloud attempt to database:
      | name      | username | attemptnumber | file  | transcript  | gop_score | recordinglength |
      | Readaloud | olli     | 1             | file2 | transcript2 | 0.7       | 2               |

  Scenario: Detailed report does not show for student in freeform
    When I am on the "Freeform > olli" "mod_digitala > Teacher Report Details" page logged in as "olli"
    And I should see "Access denied"

  Scenario: Detailed report does not show for student in readaloud
    When I am on the "Readaloud > olli" "mod_digitala > Teacher Report Details" page logged in as "olli"
    And I should see "Access denied"

  Scenario: Detailed report shows correctly for freeform
    When I am on the "Freeform > olli" "mod_digitala > Teacher Report Details" page logged in as "ossi"
    And I should see "Assignment"
    And I should see "Language: Swedish"
    And I should see "Assignment type: Freeform"
    And I should see "Berätta om Tigerjakt."
    And I click on "Material" "button"
    And I should see "Material"
    And I should see "Här är filmen om tiger."
    And I should see "There is no limit set for the number of attempts on this assignment."
    And I should see "A transcript of your speech sample"
    And I should see "transcript1"
    And I should see "Task completion"
    And I should see "1/3"
    And I should see "Tämä mittari perustuu vastauksiin, joilla kone on opetettu arvioimaan tätä tehtävää. Automaattisen arvion mukaan vaikuttaa siltä, että task achievement score is 1, light red score."
    And I should see "Fluency"
    And I should see "1/3"
    And I should see "Tämä mittari kertoo puhenäytteesi nopeudesta, taukojen määrästä ja empimisestä. Automaattisen arvion mukaan vaikuttaa siltä, että fluency score is 1, light red score."
    And I should see "Nativeity"
    And I should see "1/3"
    And I should see "Näet yllä, että kone muunsi puheesi tekstiksi. Voit tarkistaa tekstistä, lausuitko kaikki sanat oikein. Tämä mittari kertoo, kuinka hyvin ja varmasti kone tunnistaa puheesi. Tunnistamistarkkuuteen vaikuttavat puhenäytteet, joita kone on aiemmin opetusvaiheessa saanut. Automaattisen arvion mukaan vaikuttaa siltä, että nativeity score is 1, light red score."
    And I should see "Lexical profile"
    And I should see "3/3"
    And I should see "Tämä mittari kertoo, kuinka paljon olet puhunut sekä käyttämiesi sanojen ja lauseiden monipuolisuudesta. Automaattisen arvion mukaan vaikuttaa siltä, että lexical profile is 3, green score."
    And I click on "Holistic" "button"
    And I should see "Holistic"
    And I should see "A2"
    And I should see "Holistic score is 2, brown score."

  Scenario: Detailed report shows correctly for readaloud
    When I am on the "Readaloud > olli" "mod_digitala > Teacher Report Details" page logged in as "ossi"
    And I should see "Assignment"
    And I should see "Language: Finnish"
    And I should see "Assignment type: Read aloud"
    And I should see "Lue seuraava lause ääneen."
    And I click on "Material" "button"
    And I should see "Material"
    And I should see "Tämä on liikennevalojen perusteet -kurssi."
    And I should see "Number of attempts remaining: 1"
    And I should not see "A transcript of your speech sample"
    And I should not see "transcript2"
    And I should see "Goodness of pronunciation"
    And I should see "70%"
    And I should see "Pronunciation score is 7, big pink score."
