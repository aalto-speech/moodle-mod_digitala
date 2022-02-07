@mod
Feature: Student can see the phases of the whole assignment.

  Background:
    Given the following "courses" exist:
      | name     | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "activities" exist:
      | activity | name         | intro                  | course   | idnumber  |
      | digitala | Digitala 1   | Digitala 1 description | C1       | digitala1 |

  Scenario: See the phases of assignment on page
    When I am on the "Digitala 1" "mod_digitala > View" page logged in as "admin"
    Then I should see "Info"
    And I should see "Assignment"
    And I should see "Report"
