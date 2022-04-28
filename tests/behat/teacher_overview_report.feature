@mod @mod_digitala @javascript
Feature: Teacher can see students overview report

  Background:
    Given the following "users" exist:
      | username | firstname | lastname   | email                     |
      | ossi     | Ossi      | Opettaja   | ossi.opettaja@koulu.fi    |
      | olli     | Olli      | Opiskelija | olli.opiskelija@koulu.fi  |
      | essi     | Essi      | Opiskelija | essi.opiskelija@koulu.fi  |
      | seppo    | Seppo     | Opiskelija | seppo.opiskelija@koulu.fi |
      | milla    | Milla     | Opiskelija | milla.opiskelja@koulu.fi  |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user | course | role           |
      | ossi | C1     | editingteacher |
      | olli | C1     | student        |
    And the following "activities" exist:
      | activity | name      | intro                | course | idnumber  | attemptlang | attempttype | assignment                 | resources                                  | resourcesformat | attemptlimit | information     | informationformat |
      | digitala | Freeform  | This is a freeform.  | C1     | freeform  | sv          | freeform    | Berätta om Tigerjakt.      | Här är filmen om tiger.                    | 1               | 0            | testinformation | 1                 |
      | digitala | Readaloud | This is a readaloud. | C1     | readaloud | fi          | readaloud   | Lue seuraava lause ääneen. | Tämä on liikennevalojen perusteet -kurssi. | 1               | 2            | testinformation | 1                 |
    And I add freeform attempt to database:
      | name     | username | attemptnumber | file  | transcript  | fluency | taskcompletion | pronunciation | lexicogrammatical | holistic | recordinglength | status    |
      | Freeform | olli     | 666           | file1 | transcript1 | 1       | 2              | 4             | 3                 | 0.45     | 69              | evaluated |
      | Freeform | essi     | 420           | file2 | transcript2 | 0       | 0              | 0             | 0                 | 0        | 260             | waiting   |
      | Freeform | seppo    | 69            | file3 | transcript3 | 0       | 0              | 0             | 0                 | 0        | 120             | retry     |
      | Freeform | milla    | 1337          | file4 | transcript4 | 0       | 0              | 0             | 0                 | 0        | 60              | failed    |
    And I add readaloud attempt to database:
      | name      | username | attemptnumber | file  | transcript  | feedback | fluency | pronunciation | recordinglength | status    |
      | Readaloud | olli     | 666           | file2 | transcript2 | feedback | 2.7     | 1.5           | 69              | evaluated |
      | Readaloud | essi     | 420           | file6 | transcript6 | feedback | 0       | 0             | 260             | waiting   |
      | Readaloud | seppo    | 69            | file7 | transcript7 | feedback | 0       | 0             | 120             | retry     |
      | Readaloud | milla    | 1337          | file8 | transcript8 | feedback | 0       | 0             | 60              | failed    |

  Scenario: Overview report link shows for teacher on actions menu
    When I am on the "Freeform" "mod_digitala > Info" page logged in as "ossi"
    Then I navigate to "View student results" in current page administration
    Then I should see "Student"
    And I should see "Proficiency/Analytic grades"
    And I should see "Time"
    And I should see "Tries"
    And I should see "Status"
    And I should see "Evaluation report"

  Scenario: Overview report link shows for teacher in freeform
    Then I am on the "Freeform" "mod_digitala > Teacher Reports Overview" page logged in as "ossi"
    Then I should see "Olli Opiskelija"
    And I should see "0.45"
    And I should see "01:09"
    And I should see "666"
    And I should see "See report"
    Then I should see "Essi Opiskelija"
    And I should see "-"
    And I should see "04:20"
    And I should see "420"
    And I should see "Waiting"
    Then I should see "Seppo Opiskelija"
    And I should see "-"
    And I should see "02:00"
    And I should see "69"
    And I should see "Retrying"
    Then I should see "Milla Opiskelija"
    And I should see "-"
    And I should see "01:00"
    And I should see "1337"
    And I should see "Failed"

  Scenario: Overview report link shows for teacher in readaloud
    Then I am on the "Readaloud" "mod_digitala > Teacher Reports Overview" page logged in as "ossi"
    Then I should see "Olli Opiskelija"
    And I should see "2.70"
    And I should see "01:09"
    And I should see "666"
    And I should see "See report"
    Then I should see "Essi Opiskelija"
    And I should see "-"
    And I should see "04:20"
    And I should see "420"
    And I should see "Waiting"
    Then I should see "Seppo Opiskelija"
    And I should see "-"
    And I should see "02:00"
    And I should see "69"
    And I should see "Retrying"
    Then I should see "Milla Opiskelija"
    And I should see "-"
    And I should see "01:00"
    And I should see "1337"
    And I should see "Failed"
