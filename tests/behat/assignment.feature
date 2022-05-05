@mod @mod_digitala @javascript
Feature: Student can see assignment text and resources
  Student can send answer for evaluation to Aalto ASR
  Student can receive assessment from Aalto ASR

  Background:
    Given the following "users" exist:
      | username | firstname | lastname   | email                     |
      | ossi     | Ossi      | Opettaja   | ossi.opettaja@koulu.fi    |
      | olli     | Olli      | Opiskelija | olli.opiskelija@koulu.fi  |
      | essi     | Essi      | Opiskelija | essi.opiskelija@koulu.fi  |
      | seppo    | Seppo     | Opiskelija | seppo.opiskelija@koulu.fi |
      | milla    | Milla     | Opiskelija | milla.opiskelja@koulu.fi  |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user  | course | role    |
      | ossi  | C1     | manager |
      | olli  | C1     | student |
      | essi  | C1     | student |
      | seppo | C1     | student |
      | milla | C1     | student |
    And the following "activities" exist:
      | activity | name      | intro                | course | idnumber  | attemptlang | attempttype | assignment                 | resources                                  | resourcesformat | attemptlimit | maxlength | information     | informationformat |
      | digitala | Freeform  | This is a freeform.  | C1     | freeform  | sv          | freeform    | Berätta om Tigerjakt.      | Här är filmen om tiger.                    | 1               | 2            | 5         | testinformation | 1                 |
      | digitala | Readaloud | This is a readaloud. | C1     | readaloud | fi          | readaloud   | Lue seuraava lause ääneen. | Tämä on liikennevalojen perusteet -kurssi. | 1               | 2            | 5         | testinformation | 1                 |

  Scenario: On assignment page the assignment text, resources text, timer and number of attempts are shown
    When I am on the "Freeform" "mod_digitala > Assignment" page logged in as "olli"
    Then I should see "Berätta om Tigerjakt."
    And I should see "Här är filmen om tiger."
    And I should see "Assignment"
    And I should see "Material"
    And I should see "Number of attempts remaining: 2"
    And I should see "00:00 / 00:05"

  Scenario: Submit button is shown when the timer runs out and when pressing stop button
    When I am on the "Freeform" "mod_digitala > Assignment" page logged in as "olli"
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
    When I am on the "Freeform" "mod_digitala > Assignment" page logged in as "olli"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 2 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"
    Then I should see "Evaluation in progress"
    And I run all adhoc tasks
    Then I click on "Press here to check if evaluation is completed." "link"
    Then I should see "A transcript of your speech sample"
    And I should see "Analytic grading"
    And I should see "Proficiency level"
    And I should see "Fluency"
    Then I am on the "Freeform" "mod_digitala > Assignment" page logged in as "olli"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 1 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"
    Then I should see "Evaluation in progress"
    And I run all adhoc tasks
    Then I click on "Press here to check if evaluation is completed." "link"
    Then I should see "Analytic grading"
    And I click on "Assignment" "link"
    Then I should see "Your answer has already been submitted."
    And I should not see "Listen recording"

  Scenario: Feedback is deleted when student creates a new attempt
    When I am on the "Freeform" "mod_digitala > Assignment" page logged in as "olli"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    And I click on "id_submitbutton" "button"
    Then I should see "Evaluation in progress"
    And I run all adhoc tasks
    Then I click on "Press here to check if evaluation is completed." "link"
    Then I should see "Fluency"
    Then I am on the "Freeform > olli" "mod_digitala > Teacher Report Feedback" page logged in as "ossi"
    Then I set the following fields to these values:
      | Fluency                     | 2.00                              |
      | Feedback on Fluency         | Evaluation was too high.          |
      | Task completion             | 3.00                              |
      | Feedback on Task completion | Evaluation was too low.           |
      | Range                       | 2.34                              |
      | Feedback on Range           | Evaluation was out of boundaries. |
      | Pronunciation               | 2.37                              |
      | Feedback on Pronunciation   | Sounds like pro finn.             |
      | Proficiency                 | 6.50                              |
      | Feedback on Proficiency     | This meets all values for this.   |
    And I press "Save changes"
    Then I am on the "Freeform" "mod_digitala > Report" page logged in as "olli"
    Then I should see "Teacher's grade suggestion:"
    Then I am on the "Freeform" "mod_digitala > Assignment" page logged in as "olli"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    And I click on "id_submitbutton" "button"
    Then I should see "Evaluation in progress"
    And I run all adhoc tasks
    Then I click on "Press here to check if evaluation is completed." "link"
    Then I should see "Fluency"
    And I should not see "Teacher's grade suggestion:"

  Scenario: Attempt in status retry gets re-evaluated
    When I am on the "Freeform" "mod_digitala > Assignment" page logged in as "olli"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 2 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"
    Then I should see "Evaluation in progress"
    Then I set evaluation status to:
      | name     | username | status |
      | Freeform | olli     | retry  |
    Then I click on "Press here to check if evaluation is completed." "link"
    And I should see "Automated evaluation failed and will be run again in couple of hours. The new evaluation attempt can take some time."
    And I run the scheduled task "mod_digitala\task\check_failed_evaluation"
    And I run all adhoc tasks
    Then I am on the "Freeform" "mod_digitala > Report" page logged in as "olli"
    Then I should see "Analytic grading"

  Scenario: Attempt in status waiting for over one hour gets re-evaluated
    When I am on the "Freeform" "mod_digitala > Assignment" page logged in as "olli"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 2 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"
    Then I should see "Evaluation in progress"
    And I run the scheduled task "mod_digitala\task\check_failed_evaluation"
    Then I click on "Press here to check if evaluation is completed." "link"
    And I should see "Evaluation in progress"
    Then I set attempts creation time to:
      | name     | username | time |
      | Freeform | olli     | 0    |
    And I run the scheduled task "mod_digitala\task\check_failed_evaluation"
    Then I click on "Press here to check if evaluation is completed." "link"
    And I should see "Automated evaluation failed and will be run again in couple of hours. The new evaluation attempt can take some time."
    And I run all adhoc tasks
    Then I am on the "Freeform" "mod_digitala > Report" page logged in as "olli"
    Then I should see "Analytic grading"

  Scenario: If multiple students answer to same assignment, recording of all students is preserved
    When I am on the "Freeform" "mod_digitala > Assignment" page logged in as "olli"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 2 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"
    Then I am on the "Freeform" "mod_digitala > Assignment" page logged in as "essi"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 2 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"
    Then I am on the "Freeform" "mod_digitala > Assignment" page logged in as "seppo"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 2 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"
    Then I am on the "Freeform" "mod_digitala > Assignment" page logged in as "milla"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 2 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"

    Then I check if recording exists:
      | name     | username |
      | Freeform | olli     |
      | Freeform | essi     |
      | Freeform | seppo    |
      | Freeform | milla    |

    And I run all adhoc tasks

    Then I check if recording exists:
      | name     | username |
      | Freeform | olli     |
      | Freeform | essi     |
      | Freeform | seppo    |
      | Freeform | milla    |

    When I am on the "Freeform" "mod_digitala > Assignment" page logged in as "olli"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 1 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"
    Then I am on the "Freeform" "mod_digitala > Assignment" page logged in as "essi"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 1 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"

    Then I check if recording exists:
      | name     | username |
      | Freeform | olli     |
      | Freeform | essi     |
      | Freeform | seppo    |
      | Freeform | milla    |

    And I run all adhoc tasks

    Then I check if recording exists:
      | name     | username |
      | Freeform | olli     |
      | Freeform | essi     |
      | Freeform | seppo    |
      | Freeform | milla    |

  Scenario: If multiple students answer to multiple assignment, recording of all students is preserved
    When I am on the "Freeform" "mod_digitala > Assignment" page logged in as "olli"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 2 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"
    Then I am on the "Freeform" "mod_digitala > Assignment" page logged in as "essi"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 2 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"
    Then I am on the "Readaloud" "mod_digitala > Assignment" page logged in as "seppo"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 2 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"
    Then I am on the "Readaloud" "mod_digitala > Assignment" page logged in as "milla"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 2 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"

    Then I check if recording exists:
      | name      | username |
      | Freeform  | olli     |
      | Freeform  | essi     |
      | Readaloud | seppo    |
      | Readaloud | milla    |

    And I run all adhoc tasks

    Then I check if recording exists:
      | name      | username |
      | Freeform  | olli     |
      | Freeform  | essi     |
      | Readaloud | seppo    |
      | Readaloud | milla    |

    When I am on the "Readaloud" "mod_digitala > Assignment" page logged in as "olli"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 2 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"
    Then I am on the "Readaloud" "mod_digitala > Assignment" page logged in as "essi"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 2 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"
    Then I am on the "Freeform" "mod_digitala > Assignment" page logged in as "seppo"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 2 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"
    Then I am on the "Freeform" "mod_digitala > Assignment" page logged in as "milla"
    And I click on "record" "button"
    And I wait "6" seconds
    And I click on "submitModalButton" "button"
    Then I should see "You still have 2 attempts remaining on this assignment."
    And I click on "id_submitbutton" "button"

    Then I check if recording exists:
      | name      | username |
      | Freeform  | olli     |
      | Freeform  | essi     |
      | Freeform  | seppo    |
      | Freeform  | milla    |
      | Readaloud | olli     |
      | Readaloud | essi     |
      | Readaloud | seppo    |
      | Readaloud | milla    |

    And I run all adhoc tasks

    Then I check if recording exists:
      | name      | username |
      | Freeform  | olli     |
      | Freeform  | essi     |
      | Freeform  | seppo    |
      | Freeform  | milla    |
      | Readaloud | olli     |
      | Readaloud | essi     |
      | Readaloud | seppo    |
      | Readaloud | milla    |
