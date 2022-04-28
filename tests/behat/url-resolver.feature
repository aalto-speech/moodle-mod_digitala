@mod @mod_digitala @javascript
Feature: URL resolver works in behats

  Background:
    Given the following "users" exist:
      | username | firstname | lastname   | email                    |
      | mauno    | Mauno     | Manager    | mauno.manager@koulu.fi   |
      | ossi     | Ossi      | Opettaja   | ossi.opettaja@koulu.fi   |
      | olli     | Olli      | Opiskelija | olli.opiskelija@koulu.fi |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user  | course | role           |
      | mauno | C1     | manager        |
      | ossi  | C1     | editingteacher |
      | olli  | C1     | student        |
    And the following "activities" exist:
      | activity | name      | intro                | course | idnumber  | attemptlang | attempttype | assignment                 | resources                                  | resourcesformat | attemptlimit | information     | informationformat |
      | digitala | Freeform  | This is a freeform.  | C1     | freeform  | sv          | freeform    | Berätta om Tigerjakt.      | Här är filmen om tiger.                    | 1               | 0            | testinformation | 1                 |
      | digitala | Readaloud | This is a readaloud. | C1     | readaloud | fi          | readaloud   | Lue seuraava lause ääneen. | Tämä on liikennevalojen perusteet -kurssi. | 1               | 2            | testinformation | 1                 |
    And I add freeform attempt to database:
      | name     | username | attemptnumber | file  | transcript  | fluency | taskcompletion | pronunciation | lexicogrammatical | holistic | recordinglength | status    |
      | Freeform | olli     | 1             | file1 | transcript1 | 1       | 1              | 2             | 3                 | 1        | 1               | evaluated |
    And I add readaloud attempt to database:
      | name      | username | attemptnumber | file  | transcript  | feedback | fluency | pronunciation | recordinglength | status    |
      | Readaloud | olli     | 1             | file2 | transcript2 | feedback | 0.7     | 1.5           | 2               | evaluated |

  Scenario Outline: Page URL resolver works
    When I am on the "<activity>" "mod_digitala > Invalid" page logged in as "<student>"
    And I should see "Access denied"
    When I am on the "<activity>" "mod_digitala > Info" page logged in as "<student>"
    And I should see "Test your microphone here"
    Then I am on the "<activity>" "mod_digitala > Assignment" page logged in as "<student>"
    And I should see "Material"
    Then I am on the "<activity>" "mod_digitala > Report" page logged in as "<student>"
    And I should see "<reportpage>"
    Then I am on the "<activity>" "mod_digitala > Teacher Reports Overview" page logged in as "<teacher>"
    And I should see "See report"
    Then I am on the "<activity> > <student>" "mod_digitala > Teacher Report Details" page logged in as "<teacher>"
    And I should see "Assignment"
    And I should see "<reportpage>"
    Then I am on the "<activity> > <student>" "mod_digitala > Teacher Report Feedback" page logged in as "<teacher>"
    And I should see "Edit the evaluation report"

    Examples:
      | activity  | student | teacher | reportpage |
      | Freeform  | olli    | ossi    | Range      |
      | Readaloud | olli    | ossi    | Fluency    |
      | Freeform  | olli    | mauno   | Range      |
