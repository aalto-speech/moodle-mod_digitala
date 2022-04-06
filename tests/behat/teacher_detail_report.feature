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
    And I should see "Nothing to see here, mate!"

  Scenario: Detailed report does not show for student in readaloud
    When I am on the "Readaloud > olli" "mod_digitala > Teacher Report Details" page logged in as "olli"
    And I should see "Nothing to see here, mate!"

  Scenario: Detailed report shows correctly for freeform
    When I am on the "Freeform > olli" "mod_digitala > Teacher Report Details" page logged in as "ossi"
    And I should see "Assignment"
    And I should see "Attempt language: Swedish"
    And I should see "Attempt type: Freeform"
    And I should see "Berätta om Tigerjakt."
    And I click on "Resources" "button"
    And I should see "Resources"
    And I should see "Här är filmen om tiger."
    And I should see "There is no limit set for the number of attempts on this assignment."
    And I should see "Transcription"
    And I should see "transcript1"
    And I should see "Fluency"
    And I should see "1/3"
    And I should see "Fluency score is 1, light red score."
    And I should see "Accuracy"
    And I should see "2/3"
    And I should see "Accuracy score is 2, yellow score."
    And I should see "Lexical profile"
    And I should see "3/3"
    And I should see "Lexical profile is 3, green score"
    And I should see "Nativeity"
    And I should see "1/3"
    And I should see "Nativeity score is 1, light red score."
    And I click on "Holistic" "button"
    And I should see "Holistic"
    And I should see "A2"
    And I should see "Holistic score is 2, brown score."

  Scenario: Detailed report shows correctly for readaloud
    When I am on the "Readaloud > olli" "mod_digitala > Teacher Report Details" page logged in as "ossi"
    And I should see "Assignment"
    And I should see "Attempt language: Finnish"
    And I should see "Attempt type: Read aloud"
    And I should see "Lue seuraava lause ääneen."
    And I click on "Resources" "button"
    And I should see "Resources"
    And I should see "Tämä on liikennevalojen perusteet -kurssi."
    And I should see "Number of attempts remaining: 1"
    And I should not see "Transcript"
    And I should not see "transcript2"
    And I should see "Goodness of pronunciation"
    And I should see "70/100"
    And I should see "Pronunciation score is 7, big pink score."
