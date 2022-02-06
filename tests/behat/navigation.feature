@mod @mod_digitala
Feature: Student can see the phases of the whole assignment.

  Background:
    Given the following user exists:
      | username   | student |

    And the following course exists:
      | Name      | C1 |

    And the following "activities" exist:
      | activity | name         | intro              | course | idnumber  |
      | digitala | DigitalaTest | Quiz 1 description | C1     | digitala1 |
    And I am on the "DigitalaTest" "mod_digitala > View" page logged in as "student"

  Scenario: See the phases of assignment on page
    When I navigate to "DigitalaTest" in current page administration
    Then I should see "1Info"
    And I should see "2Assignment"
    And I should see "3Report"