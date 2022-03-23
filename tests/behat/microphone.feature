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

  Scenario: Start button is visible but stop button is not before starting recording
    When I am on "Course 1" course homepage
    And I click on "Test digitala name" "link"
    And I click on "Info" "link"
    Then "record" "button" should be visible
    And "stopRecord" "button" should not be visible

  Scenario: Stop button is visible but start button is not after starting recording
    When I am on "Course 1" course homepage
    And I click on "Test digitala name" "link"
    And I click on "Info" "link"
    And I click on "record" "button"
    Then "record" "button" should not be visible
    And "stopRecord" "button" should be visible

  Scenario: Listening button should always be visible
    When I am on "Course 1" course homepage
    And I click on "Test digitala name" "link"
    And I click on "Info" "link"
    Then "listenButton" "button" should be visible
    And I click on "record" "button"
    Then "listenButton" "button" should be visible
    And I click on "stopRecord" "button"
    Then "listenButton" "button" should be visible

  Scenario: Microphone border should be visible
    When I am on "Course 1" course homepage
    And I click on "Test digitala name" "link"
    And I click on "Info" "link"
    And I click on "record" "button"
    And I click on "stopRecord" "button"
    And I click on "listenButton" "button"
    Then "microphoneIconBox" "region" should exist
