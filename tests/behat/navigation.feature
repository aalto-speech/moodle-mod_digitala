@mod @mod_digitala @javascript
Feature: Student can see all the phases and curren progress of the assignment

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

  Scenario: The digitala activity is shown on course page
    When I am on "Course 1" course homepage
    Then I should see "Test digitala name"

  Scenario: All the phases of activity are shown
    When I am on the "Test digitala name" "mod_digitala > Info" page logged in as "student1"
    Then I should see "Begin"
    And I should see "Assignment"
    And I should see "Evaluation"

  Scenario: On first page only info progress is shown highlighted on progress bar
    When I am on the "Test digitala name" "mod_digitala > Info" page logged in as "student1"
    Then ".pb-step.active" "css_element" should exist in the ".pb-step.first" "css_element"
    And ".pb-step.active" "css_element" should not exist in the ".pb-step.last" "css_element"

  Scenario: On report page only report progress is shown highlighted on progress bar
    When I am on the "Test digitala name" "mod_digitala > Report" page logged in as "student1"
    Then ".pb-step.active" "css_element" should exist in the ".pb-step.last" "css_element"
    And ".pb-step.active" "css_element" should not exist in the ".pb-step.first" "css_element"
