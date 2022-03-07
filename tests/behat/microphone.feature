@mod @mod_digitala  @javascript
Feature: Student can record with the microphone

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | student1 | Sam1      | Student1 | student1@example.com |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | student1 | C1     | student        |
    And the following "activities" exist:
      | activity    | name               | intro               | course | idnumber  | attemptlang | attempttype | assignment      | resources     | assignmentformat | resourcesformat | 
      | digitala    | Test digitala name | Test digitala intro | C1     | digitala1 | fin         | freeform    | Assignment text | Resource text | 1                | 1               |
    And I log in as "student1"

  Scenario: Start and stop buttons are visible but listening button is not
    When I am on "Course 1" course homepage
    And I click on "Test digitala name" "link"
    And I click on "Info" "link"
    Then "record" "button" should be visible
    And "stopRecord" "button" should be visible
    And "listenButton" "button" should not be visible

  Scenario: Listening button not visible after recording start
    When I am on "Course 1" course homepage
    And I click on "Test digitala name" "link"
    And I click on "Info" "link"
    And I click on "record" "button"
    Then "listenButton" "button" should not be visible

  Scenario: Listening button visible after recording stopped
    When I am on "Course 1" course homepage
    And I click on "Test digitala name" "link"
    And I click on "Info" "link"
    And I click on "record" "button"
    And I click on "stopRecord" "button"
    Then "listenButton" "button" should be visible
