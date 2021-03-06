@mod @mod_digitala @javascript
Feature: Teacher can give feedback on ASR evaluation
  Student can see given evaluation on the report page

  Background:
    Given the following "users" exist:
      | username | firstname | lastname   | email                     |
      | mauno    | Mauno     | Manager    | mauno.manager@koulu.fi    |
      | ossi     | Ossi      | Opettaja   | ossi.opettaja@koulu.fi    |
      | olli     | Olli      | Opiskelija | olli.opiskelija@koulu.fi  |
      | essi     | Essi      | Opiskelija | essi.opiskelija@koulu.fi  |
      | seppo    | Seppo     | Opiskelija | seppo.opiskelija@koulu.fi |
      | milla    | Milla     | Opiskelija | milla.opiskelja@koulu.fi  |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user  | course | role           |
      | mauno | C1     | manager        |
      | ossi  | C1     | editingteacher |
      | olli  | C1     | student        |
      | essi  | C1     | student        |
      | seppo | C1     | student        |
      | milla | C1     | student        |
    And the following "activities" exist:
      | activity | name      | intro                | course | idnumber  | attemptlang | attempttype | assignment                 | resources                                  | resourcesformat | attemptlimit | information     | informationformat |
      | digitala | Freeform  | This is a freeform.  | C1     | freeform  | sv          | freeform    | Berätta om Tigerjakt.      | Här är filmen om tiger.                    | 1               | 0            | testinformation | 1                 |
      | digitala | Readaloud | This is a readaloud. | C1     | readaloud | fi          | readaloud   | Lue seuraava lause ääneen. | Tämä on liikennevalojen perusteet -kurssi. | 1               | 2            | testinformation | 1                 |
    And I add freeform attempt to database:
      | name     | username | attemptnumber | file  | transcript  | fluency | taskcompletion | pronunciation | lexicogrammatical | holistic | recordinglength | status    |
      | Freeform | olli     | 1             | file1 | transcript1 | 1       | 1              | 2             | 3                 | 1        | 1               | evaluated |
      | Freeform | essi     | 1             | file2 | transcript2 | 0       | 0              | 0             | 0                 | 0        | 5               | waiting   |
      | Freeform | seppo    | 1             | file3 | transcript3 | 0       | 0              | 0             | 0                 | 0        | 4               | retry     |
      | Freeform | milla    | 1             | file4 | transcript4 | 0       | 0              | 0             | 0                 | 0        | 3               | failed    |
    And I add readaloud attempt to database:
      | name      | username | attemptnumber | file  | transcript  | feedback | fluency | pronunciation | recordinglength | status    |
      | Readaloud | olli     | 1             | file5 | transcript5 | feedback | 2.2     | 1.4           | 6               | evaluated |
      | Readaloud | essi     | 1             | file6 | transcript6 | feedback | 0       | 0             | 7               | waiting   |
      | Readaloud | seppo    | 1             | file7 | transcript7 | feedback | 0       | 0             | 8               | retry     |
      | Readaloud | milla    | 1             | file8 | transcript8 | feedback | 0       | 0             | 9               | failed    |

  Scenario: Feedback button works correctly in teachers report detail page in freeform
    When I am on the "Freeform > olli" "mod_digitala > Teacher Report Details" page logged in as "ossi"
    And I click on "Suggest changes to automatic evaluation report" "link"
    And I should see "Feedback on Fluency"

  Scenario: Feedback button works correctly in teachers report detail page in readaloud
    When I am on the "Readaloud > olli" "mod_digitala > Teacher Report Details" page logged in as "ossi"
    And I click on "Suggest changes to automatic evaluation report" "link"
    And I should see "Feedback on Fluency"

  Scenario Outline: Feedback can be given on Freeform and student can see it on their report
    When I am on the "Freeform > olli" "mod_digitala > Teacher Report Feedback" page logged in as "<user>"
    Then I set the following fields to these values:
      | Fluency                     | 2.00                              |
      | Feedback on Fluency         | Evaluation was too high.          |
      | Task completion             | 3.00                              |
      | Feedback on Task completion | Evaluation was too low.           |
      | Range                       | 2.34                              |
      | Feedback on Range           | Evaluation was out of boundaries. |
      | Pronunciation               | 2.37                              |
      | Feedback on Pronunciation   | Sounds like pro finn.             |
      | Proficiency                 | 6.50                              |
      | Feedback on Proficiency     | This meets all values for this.   |
    And I press "Save changes"
    And the following feedback is found:
      | name     | username |
      | Freeform | olli     |
    And I should see "Comment added successfully to student's report."
    And I am on the "Freeform" "mod_digitala > Report" page logged in as "olli"
    Then I should see "Teacher's grade suggestion: 2.0"
    And I should see "Evaluation was too high."
    And I should see "Teacher's grade suggestion: 3.0"
    And I should see "Evaluation was too low."

    Examples:
      | user  |
      | mauno |
      | ossi  |

  Scenario: Feedback can be given on Readaloud and student can see it on their report
    When I am on the "Readaloud > olli" "mod_digitala > Teacher Report Feedback" page logged in as "ossi"
    Then I set the following fields to these values:
      | Fluency                   | 2.00                     |
      | Feedback on Fluency       | Evaluation was too high. |
      | Pronunciation             | 2.37                     |
      | Feedback on Pronunciation | Sounds like pro finn.    |
    And I press "Save changes"
    And the following feedback is found:
      | name      | username |
      | Readaloud | olli     |
    And I should see "Comment added successfully to student's report."
    And I am on the "Readaloud" "mod_digitala > Report" page logged in as "olli"
    Then I should see "Teacher's grade suggestion: 2.37"
    And I should see "Evaluation was too high."

  Scenario Outline: Give feedback button is shown only for evaluated attempts
    When I am on the "<activity> > olli" "mod_digitala > Teacher Report Details" page logged in as "ossi"
    And I should see "Suggest changes to automatic evaluation report"
    When I am on the "<activity> > essi" "mod_digitala > Teacher Report Details" page logged in as "ossi"
    And I should not see "Suggest changes to automatic evaluation report"
    When I am on the "<activity> > seppo" "mod_digitala > Teacher Report Details" page logged in as "ossi"
    And I should not see "Suggest changes to automatic evaluation report"
    When I am on the "<activity> > milla" "mod_digitala > Teacher Report Details" page logged in as "ossi"
    And I should not see "Suggest changes to automatic evaluation report"

    Examples:
      | activity  |
      | Freeform  |
      | Readaloud |
