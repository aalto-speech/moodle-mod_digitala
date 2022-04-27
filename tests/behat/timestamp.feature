@mod @mod_digitala @javascript
Feature: Timestamp of attempt's creation time is shown on report pages

  Background:
    Given the following "users" exist:
      | username | firstname | lastname   | email                    |
      | olli     | Olli      | Opiskelija | olli.opiskelija@koulu.fi |
      | ossi     | Ossi      | Opettaja   | ossi.opettaja@koulu.fi   |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user | course | role    |
      | olli | C1     | student |
      | ossi | C1     | teacher |
    And the following "activities" exist:
      | activity | name     | intro               | course | idnumber | attemptlang | attempttype | assignment            | resources               | resourcesformat | attemptlimit | maxlength |
      | digitala | Freeform | This is a freeform. | C1     | freeform | sv          | freeform    | Berätta om Tigerjakt. | Här är filmen om tiger. | 1               | 2            | 5         |
    And I add freeform attempt to database:
      | name     | username | attemptnumber | file  | transcript  | fluency | taskcompletion | pronunciation | lexicogrammatical | holistic | recordinglength | status    |
      | Freeform | olli     | 666           | file1 | transcript1 | 1       | 2              | 4             | 3                 | 0.45     | 69              | evaluated |

  Scenario: Timestamp is shown on overview
    When I am on the "Freeform" "mod_digitala > Info" page logged in as "ossi"
    Then I navigate to "View student results" in current page administration
    Then I set attempts creation time to:
      | name     | username | time          |
      | Freeform | olli     | 1651038371    |
    Then I press the "reload" button in the browser
    Then I should see "08.46:11 27.04.2022"

  Scenario: Timestamp is shown on detail report
    When I am on the "Freeform > olli" "mod_digitala > Teacher Report Details" page logged in as "ossi"
    Then I set attempts creation time to:
      | name     | username | time          |
      | Freeform | olli     | 1651038371    |
    Then I press the "reload" button in the browser
    Then I should see "08.46:11 27.04.2022"

  Scenario: Timestamp is shown on student report
    When I am on the "Freeform" "mod_digitala > Report" page logged in as "olli"
    Then I set attempts creation time to:
      | name     | username | time          |
      | Freeform | olli     | 1651038371    |
    Then I press the "reload" button in the browser
    Then I should see "08.46:11 27.04.2022"
