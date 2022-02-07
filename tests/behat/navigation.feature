@mod @mod_digitala
Feature: Student can see the phases of the whole assignment.

  Background:
    Given the following "courses" exist:
      | name     | shortname |
      | Course 1 | C1        |
    And the following "users" exist:
      | username | firstname | lastname | email               |
      | student1 | Stud1    | Student1 | student1@example.com |
    And the following "activities" exist:
      | activity | name         | intro                  | course   | idnumber  |
      | digitala | Digitala 1   | Digitala 1 description | C1       | digitala1 |

  Scenario: See the phases of assignment on page
    When I am on the "Digitala 1" "mod_digitala > View" page logged in as "student1"
    Then I should see "Info"
