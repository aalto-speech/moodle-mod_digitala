@mod @mod_digitala @javascript @onlytwo
Feature: Student can see report with transcript, numeric gradings and verbal feedback

  Background:
    Given the following "users" exist:
      | username | firstname | lastname   | email                    |
      | olli     | Olli      | Opiskelija | olli.opiskelija@koulu.fi |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user | course | role    |
      | olli | C1     | student |
    And the following "activities" exist:
      | activity | name               | intro                | course | idnumber  | attemptlang | attempttype | assignment                 | resources                                  | resourcesformat | attemptlimit |
      | digitala | Test digitala name | Test digitala intro  | C1     | digitala1 | fi         | freeform    | Assignment text            | Resource text                              | 1               | 0            |
      | digitala | Freeform           | This is a freeform.  | C1     | freeform  | sv          | freeform    | Berätta om Tigerjakt.      | Här är filmen om tiger.                    | 1               | 0            |
      | digitala | Readaloud          | This is a readaloud. | C1     | readaloud | fi         | readaloud   | Lue seuraava lause ääneen. | Tämä on liikennevalojen perusteet -kurssi. | 1               | 2            |
    And I add freeform attempt to database:
      | name     | username | attemptnumber | file  | transcript  | fluency | fluencymean | speechrate | taskachievement | accuracy | lexicalprofile | nativeity | holistic | recordinglength |
      | Freeform | olli     | 1             | file1 | transcript1 | 1       | 2           | 3          | 1               | 2        | 3              | 1         | 2        | 1               |
    And I add readaloud attempt to database:
      | name      | username | attemptnumber | file  | transcript  | gop_score | recordinglength |
      | Readaloud | olli     | 1             | file2 | transcript2 | 0.7       | 2               |
    And I log in as "olli"

  Scenario: On a non graded report page the grading tabs are not shown
    When I am on "Course 1" course homepage
    And I click on "Test digitala name" "link"
    And I click on "Evaluation" "link"
    Then I should not see "Task Grades"
    And I should not see "Fluency"

  Scenario: On a non graded report page the report not available text is shown
    When I am on "Course 1" course homepage
    And I click on "Test digitala name" "link"
    And I click on "Evaluation" "link"
    Then I should see "A report for this assignment is not available yet."

  Scenario: On a non graded report page the transcription is not shown
    When I am on "Course 1" course homepage
    And I click on "Test digitala name" "link"
    And I click on "Evaluation" "link"
    Then I should not see "A transcript of your speech sample"

  Scenario: Detailed report shows correctly for freeform
    When I am on "Course 1" course homepage
    And I click on "Freeform" "link"
    And I click on "Evaluation" "link"
    And I should see "There is no limit set for the number of attempts on this assignment."
    And I should see "A transcript of your speech sample"
    And I should see "transcript1"
    And I should see "Task completion"
    And I should see "1/3"
    And I should see "This measure is based on the previous responses that have been used in teaching the machine to grade this task. Based on the automatic grading, it seems that you only partially responded to the assignment."
    And I should see "Fluency"
    And I should see "1/3"
    And I should see "This measure reflects the speed, pauses, and hesitations in your speech. Based on the automatic grading, it seems that your speech has many pauses, breaks, or hesitations."
    And I should see "Pronunciation"
    And I should see "1/3"
    And I should see "Above you can see that the machine transformed your speech into text. There you can check whether you pronounced all the words right. This measure reflects how well the machine understands your speech. The speech samples that the machine has heard before affect its ability to understand you. Based on the automatic grading, it seems that the machine struggles to understand you."
    And I should see "Range"
    And I should see "3/3"
    And I should see "This measure reflects how much you have spoken and how comprehensive your vocabulary and sentence structures are. Based on the automatic grading, it seems that you have comprehensive vocabulary and use a variety of sentence structures."
    And I click on "Proficiency level" "button"
    And I should see "Proficiency level"
    And I should see "A2"
    And I should see "You know basic words and are able to form sentences in the target language (for example, start and end a short conversation)."

  Scenario: Detailed report shows correctly for readaloud
    When I am on "Course 1" course homepage
    And I click on "Readaloud" "link"
    And I click on "Evaluation" "link"
    And I should see "Number of attempts remaining: 1"
    And I should not see "A transcript of your speech sample"
    And I should not see "transcript2"
    And I should see "Goodness of pronunciation"
    And I should see "70%"
    And I should see "Pronunciation score is 7, big pink score."

  Scenario: Feedback box is visible on the report page
    When I am on "Course 1" course homepage
    And I click on "Readaloud" "link"
    And I click on "Evaluation" "link"
    And I should see "Give feedback"
    And "collapser" "button" should exist

  Scenario: Feedback site is visible on the report page when button is clicked
    When I am on "Course 1" course homepage
    And I click on "Readaloud" "link"
    And I click on "Evaluation" "link"
    And I click on "collapser" "button"
    Then "feedbacksite" "region" should exist
