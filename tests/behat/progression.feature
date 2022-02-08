@mod @mod_digitala
Feature: Student can see current progress in the assignment.

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Terry1    | Teacher1 | teacher1@example.com |
      | student1 | Sam1      | Student1 | student1@example.com |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
      | student1 | C1     | student        |
    When I log in as "teacher1"
    And I am on "Course 1" course homepage with editing mode on
    And I add a "Digitala" to section "1" and I fill the form with:
      | Assignment name | Test digitala name        |
      | Description     | Test digitala description |
    And I log out
    And I log in as "student1"

  Scenario: Assignment 
    When I am on "Course 1" course homepage
    And I click on "Test digitala name" "link"
    And I click on "Assignment" "link"
    Then I should see "Assignment"