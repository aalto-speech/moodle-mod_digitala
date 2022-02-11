@mod @mod_digitala
Feature: Student can see assignment text and resources

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
      | activity    | name               | intro               | course | idnumber  |
      | digitala    | Test digitala name | Test digitala intro | C1     | digitala1 |
    And I log in as "student1"

  Scenario: On assignment page the assignment text is shown
    When I am on "Course 1" course homepage
    And I click on "Test digitala name" "link"
    And I click on "Assignment" "link"
    Then I should see "Tell me about Rick's"

  Scenario: On assignment page the resources box is shown
    When I am on "Course 1" course homepage
    And I click on "Test digitala name" "link"
    And I click on "Assignment" "link"
    Then I should see "Resources"
    And I should see "Lyrics"
