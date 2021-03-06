@mod @mod_digitala @javascript
Feature: Student can record with the microphone

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | student1 | Sam1      | Student1 | student1@example.com |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user     | course | role    |
      | student1 | C1     | student |
    And the following "activities" exist:
      | activity | name               | intro               | course | idnumber  | attemptlang | attempttype | assignment      | resources     | assignmentformat | resourcesformat | attemptlimit | information     | informationformat |
      | digitala | Test digitala name | Test digitala intro | C1     | digitala1 | fi          | freeform    | Assignment text | Resource text | 1                | 1               | 0            | testinformation | 1                 |
    And I log in as "student1"

  Scenario: Start button is visible but stop button is not before starting recording
    When I am on "Course 1" course homepage
    Then I am on the "Test digitala name" "digitala activity" page
    And I click on "Begin" "link"
    Then I should see "Record"
    And I should not see "Stop recording"

  Scenario: Stop button is visible but start button is not after starting recording
    When I am on "Course 1" course homepage
    Then I am on the "Test digitala name" "digitala activity" page
    And I click on "Begin" "link"
    And I click on "record" "button"
    And I wait "2" seconds
    Then "//button[contains(text(),'Record')]" "xpath_element" should not exist
    And I should see "Stop recording"

  Scenario: After first recording, record button shows record again label
    When I am on "Course 1" course homepage
    Then I am on the "Test digitala name" "digitala activity" page
    And I click on "Begin" "link"
    And I click on "record" "button"
    Then I wait "2" seconds
    And I click on "record" "button"
    And I wait "2" seconds
    And I should see "Record again"

  Scenario: Listening button should always be visible
    When I am on "Course 1" course homepage
    Then I am on the "Test digitala name" "digitala activity" page
    And I click on "Begin" "link"
    Then "listen" "button" should be visible
    And I click on "record" "button"
    Then "listen" "button" should be visible
    And I click on "record" "button"
    Then "listen" "button" should be visible

  Scenario: Microphone border should be visible
    When I am on "Course 1" course homepage
    Then I am on the "Test digitala name" "digitala activity" page
    And I click on "Begin" "link"
    And I click on "record" "button"
    And I wait "2" seconds
    And I click on "record" "button"
    And I click on "listen" "button"
    Then "microphoneIconBox" "region" should exist
