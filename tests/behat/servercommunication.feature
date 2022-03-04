@mod @mod_digitala  @javascript
Feature: Student can send answer and receive assessment from Aalto ASR

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
    And I am on "Course 1" course homepage
    And I click on "Test digitala name" "link"
    And I click on "Assignment" "link"
    And I click on "record" "button"
    Then I wait 2 seconds
    And I click on "stopRecord" "button"

  Scenario: On assignment page a submit button is shown after recording
    Then ".btn" "css_element" should be visible

  Scenario: After successful submission and assessment response the user is redirected to report page
    When I click on ".btn" "css_element"
    Then I should see "Transcription"
