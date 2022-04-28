@mod @mod_digitala @javascript
Feature: Delete digitala activity

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                  |
      | ossi     | Ossi      | Opettaja | ossi.opettaja@koulu.fi |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user | course | role           |
      | ossi | C1     | editingteacher |
    And the following "activities" exist:
      | activity | name               | intro               | course | idnumber  | attemptlang | attempttype | assignment      | resources     | assignmentformat | resourcesformat | attemptlimit | information     | informationformat |
      | digitala | Test digitala name | Test digitala intro | C1     | digitala1 | fi          | freeform    | Assignment text | Resource text | 1                | 1               | 0            | testinformation | 1                 |

  Scenario: Delete activity
    When I am on the "C1" "Course" page logged in as "ossi"
    And I turn editing mode on
    Then I open "Test digitala name" actions menu
    Then I choose "Delete" in the open action menu
    And I press "Yes"
    And I wait until the page is ready
    Then I should not see "Test digitala name"
