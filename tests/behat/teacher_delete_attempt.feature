@mod @mod_digitala @javascript
Feature: Teacher can delete attempts from overview page

  Background:
    Given the following "users" exist:
      | username | firstname | lastname   | email                    |
      | ossi     | Ossi      | Opettaja   | ossi.opettaja@koulu.fi   |
      | olli     | Olli      | Opiskelija | olli.opiskelija@koulu.fi |
      | essi     | Essi      | Opiskelija | essi.opiskelija@koulu.fi |
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
      | digitala | Readaloud | This is a readaloud. | C1     | readaloud | fi          | readaloud   | Lue seuraava lause ääneen. | Tämä on liikennevalojen perusteet -kurssi. | 1               | 2            |
    And I add freeform attempt to database:
      | name     | username | attemptnumber | file  | transcript  | fluency | taskcompletion | pronunciation | lexicogrammatical | holistic | recordinglength |
      | Freeform | olli     | 1             | file1 | transcript1 | 1       | 1              | 2             | 3                 | 1        | 1               |
      | Freeform | essi     | 1             | file2 | transcript2 | 1       | 1              | 2             | 3                 | 1        | 1               |
    And I add readaloud attempt to database:
      | name      | username | attemptnumber | file  | transcript  | feedback | gop_score | recordinglength |
      | Readaloud | olli     | 1             | file3 | transcript3 | feedback | 0.7       | 2               |
      | Readaloud | essi     | 1             | file4 | transcript4 | feedback | 0.7       | 3               |

  Scenario: Delete buttons show for teacher
    When I am on the "C1" "Course" page logged in as "ossi"
    And I click on "Freeform" "link"
    And I click on "Actions menu" "link"
    And I click on "View student results" "link"
    Then I should see "Delete all"
    And I should see "Delete attempt"

  Scenario: Teacher can delete all attempts
    When I am on the "C1" "Course" page logged in as "ossi"
    And I click on "Freeform" "link"
    And I click on "Actions menu" "link"
    And I click on "View student results" "link"
    Then I should see "Olli Opiskelija"
    And I should see "Essi Opiskelija"
    And I click on "Delete all" "button"
    Then I should see "Warning"
    And I click on "Confirm delete" "link"
    Then I should not see "Olli Opiskelija"
    And I should not see "Essi Opiskelija"
    And I should see "No results to show yet."

  Scenario: Teacher can delete one attempt
    When I am on the "C1" "Course" page logged in as "ossi"
    And I click on "Freeform" "link"
    And I click on "Actions menu" "link"
    And I click on "View student results" "link"
    Then I should see "Olli Opiskelija"
    And I should see "Essi Opiskelija"
    And I click on "deleteButton131002" "button"
    Then I should see "Warning"
    And I click on "deleteRedirectButton131002" "link"
    Then I should see "Olli Opiskelija"
    And I should not see "Essi Opiskelija"
