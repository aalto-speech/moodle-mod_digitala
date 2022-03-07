@mod @mod_digitala
Feature: Student can see report with transcription and gradings

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

  Scenario: On a graded report page the gradings are shown
    When I am on "Course 1" course homepage
    And I click on "Test digitala name" "link"
    And I click on "Report" "link"
    Then I should see "No significant shortcomings."

  Scenario: On a graded report page the report not available text is not shown
    When I am on "Course 1" course homepage
    And I click on "Test digitala name" "link"
    And I click on "Report" "link"
    Then I should not see "A report for this assignment is not available yet."

  Scenario: On a graded report page the transcription is shown
    When I am on "Course 1" course homepage
    And I click on "Test digitala name" "link"
    And I click on "Report" "link"
    Then I should see "Transcription"
    And I should see "Lorem ipsum"
