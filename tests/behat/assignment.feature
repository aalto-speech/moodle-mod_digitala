@mod @mod_digitala @javascript
Feature: Student can see assignment text and resources
  Student can send answer for evaluation to Aalto ASR
  Student can receive assessment from Aalto ASR

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
      | activity | name     | intro               | course | idnumber | attemptlang | attempttype | assignment            | resources               | resourcesformat | attemptlimit | maxlength |
      | digitala | Freeform | This is a freeform. | C1     | freeform | sv          | freeform    | Berätta om Tigerjakt. | Här är filmen om tiger. | 1               | 2            | 5         |
    And I log in as "student1"

  Scenario: On assignment page the assignment text, resources text, timer and number of attempts are shown
    When I am on "Course 1" course homepage
    Then I am on the "Freeform" "digitala activity" page
    And I click on "Assignment" "link"
    Then I should see "Berätta om Tigerjakt."
    And I should see "Här är filmen om tiger."
    And I should see "Assignment"
    And I should see "Material"
    And I should see "Number of attempts remaining: 2"
    And I should see "00:00 / 00:05"

  Scenario: Submit button is shown when the timer runs out and when pressing stop button
    When I am on "Course 1" course homepage
    Then I am on the "Freeform" "digitala activity" page
    And I click on "Assignment" "link"
    And I click on "record" "button"
    And I wait "6" seconds
    Then I should see "Submit answer"
    And I should see "00:05 / 00:05"
    And I click on "record" "button"
    And I wait "2" seconds
    Then I should see "00:02 / 00:05"
    And I click on "Stop recording" "button"
    Then I should see "Submit answer"

  Scenario: Succesful submit directs to report page and the attemptlimit decreases
    When I am on "Course 1" course homepage
    Then I am on the "Freeform" "digitala activity" page
    And I click on "Assignment" "link"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 2 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"
    Then I should see "A transcript of your speech sample"
    And I should see "Analytic grading"
    And I should see "Proficiency level"
    And I should see "Fluency"
    And I click on "Assignment" "link"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 1 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"
    Then I should see "Analytic grading"
    And I click on "Assignment" "link"
    Then I should see "Your answer has already been submitted."
    And I should not see "Listen recording"
