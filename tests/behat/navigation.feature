@mod @mod_digitala
Feature: Student can see the phases of the whole assignment.

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
      | activity    | name               | intro               | course | idnumber  | attemptlang | attempttype | assignment      | resources     |
      | digitala    | Test digitala name | Test digitala intro | C1     | digitala1 | fin         | freeform    | Assignment text | Resource text |
    And I log in as "student1"

  Scenario: The digitala activity is shown on course page
    When I am on "Course 1" course homepage
    Then I should see "Test digitala name"

  Scenario: All the phases of activity are shown
    When I am on "Course 1" course homepage
    And I click on "Test digitala name" "link"
    Then I should see "Info"
    And I should see "Assignment"
    And I should see "Report"
