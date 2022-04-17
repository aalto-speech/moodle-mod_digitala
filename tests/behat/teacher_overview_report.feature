@mod @mod_digitala @javascript @onlyone
Feature: Teacher can see students overview report

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
      | digitala | Readaloud | This is a readaloud. | C1     | readaloud | fi          | readaloud   | Lue seuraava lause ääneen. | Tämä on liikennevalojen perusteet -kurssi. | 1               | 2            |
    And I add freeform attempt to database:
      | name     | username | attemptnumber | file  | transcript  | fluency | taskcompletion | pronunciation | lexicogrammatical | holistic | recordinglength |
      | Freeform | olli     | 1             | file1 | transcript1 | 1       | 1              | 2             | 3                 | 1        | 1               |
    And I add readaloud attempt to database:
      | name      | username | attemptnumber | file  | transcript  | feedback | gop_score | recordinglength |
      | Readaloud | olli     | 1             | file2 | transcript2 | feedback | 0.7       | 2               |

  Scenario: Overview report link shows for teacher on actions menu
    When I am on the "C1" "Course" page logged in as "ossi"
    Then I am on the "Freeform" "digitala activity" page
    And "View student results" "link_or_button" should exist in current page administration

  Scenario: Overview report link shows for teacher
    When I am on the "C1" "Course" page logged in as "ossi"
    Then I am on the "Freeform" "digitala activity" page
    And I navigate to "View student results" in current page administration
    Then I should see "Student"
    And I should see "Proficiency/Analytic grades"
    And I should see "Time"
    And I should see "Tries"
    And I should see "Evaluation report"
    Then I should see "Olli Opiskelija"
    And I should see "2"
    And I should see "1"
    And I should see "1"
    And I should see "See report"
