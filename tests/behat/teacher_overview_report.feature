@mod @mod_digitala @javascript
Feature: Teacher can see students overview report

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
      | user | course | role           |
      | ossi | C1     | editingteacher |
      | olli | C1     | student        |
    And the following "activities" exist:
      | activity | name      | intro                | course | idnumber  | attemptlang | attempttype | assignment                 | resources                                  | resourcesformat | attemptlimit | information     | informationformat |
      | digitala | Freeform  | This is a freeform.  | C1     | freeform  | sv          | freeform    | Berätta om Tigerjakt.      | Här är filmen om tiger.                    | 1               | 0            | testinformation | 1                 |
      | digitala | Readaloud | This is a readaloud. | C1     | readaloud | fi          | readaloud   | Lue seuraava lause ääneen. | Tämä on liikennevalojen perusteet -kurssi. | 1               | 2            | testinformation | 1                 |
    And I add freeform attempt to database:
      | name     | username | attemptnumber | file  | transcript  | fluency | taskcompletion | pronunciation | lexicogrammatical | holistic | recordinglength | status    |
      | Freeform | olli     | 666           | file1 | transcript1 | 1001    | 1005           | 1003          | 1007              | 1009     | 69              | evaluated |
      | Freeform | essi     | 420           | file2 | transcript2 | 2001    | 2005           | 2003          | 2007              | 2009     | 260             | waiting   |
      | Freeform | seppo    | 69            | file3 | transcript3 | 3001    | 3005           | 3003          | 3007              | 3009     | 120             | retry     |
      | Freeform | milla    | 1337          | file4 | transcript4 | 4001    | 4005           | 4003          | 4007              | 4009     | 60              | failed    |
    And I add readaloud attempt to database:
      | name      | username | attemptnumber | file  | transcript  | feedback  | fluency | pronunciation | recordinglength | status    |
      | Readaloud | olli     | 666           | file5 | transcript5 | feedback5 | 5001    | 5003          | 69              | evaluated |
      | Readaloud | essi     | 420           | file6 | transcript6 | feedback6 | 6001    | 6003          | 260             | waiting   |
      | Readaloud | seppo    | 69            | file7 | transcript7 | feedback7 | 7001    | 7003          | 120             | retry     |
      | Readaloud | milla    | 1337          | file8 | transcript8 | feedback8 | 8001    | 8003          | 60              | failed    |
    And I add freeform feedback to database:
      | name     | username | old_fluency | fluency | fluency_reason             | old_pronunciation | pronunciation | pronunciation_reason             | old_taskcompletion | taskcompletion | taskcompletion_reason             | old_lexicogrammatical | lexicogrammatical | lexicogrammatical_reason             | old_holistic | holistic | holistic_reason             |
      | Freeform | olli     | 1001        | 1002    | freeform_olli_fluency_syy  | 1003              | 1004          | freeform_olli_pronunciation_syy  | 1005               | 1006           | freeform_olli_taskcompletion_syy  | 1007                  | 1008              | freeform_olli_lexicogrammatical_syy  | 1009         | 1010     | freeform_olli_holistic_syy  |
      | Freeform | essi     | 2001        | 2002    | freeform_essi_fluency_syy  | 2003              | 2004          | freeform_essi_pronunciation_syy  | 2005               | 2006           | freeform_essi_taskcompletion_syy  | 2007                  | 2008              | freeform_essi_lexicogrammatical_syy  | 2009         | 2010     | freeform_essi_holistic_syy  |
      | Freeform | seppo    | 3001        | 3002    | freeform_seppo_fluency_syy | 3003              | 3004          | freeform_seppo_pronunciation_syy | 3005               | 3006           | freeform_seppo_taskcompletion_syy | 3007                  | 3008              | freeform_seppo_lexicogrammatical_syy | 3009         | 3010     | freeform_seppo_holistic_syy |
      | Freeform | milla    | 4001        | 4002    | freeform_milla_fluency_syy | 4003              | 4004          | freeform_milla_pronunciation_syy | 4005               | 4006           | freeform_milla_taskcompletion_syy | 4007                  | 4008              | freeform_milla_lexicogrammatical_syy | 4009         | 4010     | freeform_milla_holistic_syy |
    And I add readaloud feedback to database:
      | name      | username | old_fluency | fluency | fluency_reason              | old_pronunciation | pronunciation | pronunciation_reason              |
      | Readaloud | olli     | 5001        | 5002    | readaloud_olli_fluency_syy  | 5003              | 5004          | readaloud_olli_pronunciation_syy  |
      | Readaloud | essi     | 6001        | 6002    | readaloud_essi_fluency_syy  | 6003              | 6004          | readaloud_essi_pronunciation_syy  |
      | Readaloud | seppo    | 7001        | 7002    | readaloud_seppo_fluency_syy | 7003              | 7004          | readaloud_seppo_pronunciation_syy |
      | Readaloud | milla    | 8001        | 8002    | readaloud_milla_fluency_syy | 8003              | 8004          | readaloud_milla_pronunciation_syy |

  Scenario: Overview report doesn't show for student
    When I am on the "Freeform" "mod_digitala > Teacher Reports Overview" page logged in as "olli"
    And I should see "Access denied"

  Scenario: Overview report link shows for teacher on actions menu
    When I am on the "Freeform" "mod_digitala > Info" page logged in as "ossi"
    Then I navigate to "View student results" in current page administration
    Then I should see "Student"
    And I should see "Proficiency"
    And I should see "Time"
    And I should see "Tries"
    And I should see "Status"
    And I should see "Evaluation report"
    And I should see "Timestamp"
    And I should see "Export all attempts as CSV"
    And I should see "Export all teacher feedback for attempts as CSV"
    And I should see "Export all recordings"

  Scenario: Overview report link shows for teacher in freeform
    Then I am on the "Freeform" "mod_digitala > Teacher Reports Overview" page logged in as "ossi"
    Then I should see "Olli Opiskelija"
    And I should see "1009"
    And I should see "01:09"
    And I should see "666"
    And I should see "See report"
    Then I should see "Essi Opiskelija"
    And I should see "-"
    And I should see "04:20"
    And I should see "420"
    And I should see "Waiting for evaluation"
    Then I should see "Seppo Opiskelija"
    And I should see "-"
    And I should see "02:00"
    And I should see "69"
    And I should see "Retrying automatic evaluation"
    Then I should see "Milla Opiskelija"
    And I should see "-"
    And I should see "01:00"
    And I should see "1337"
    And I should see "Evaluation failed"

  Scenario: Overview report link shows for teacher in readaloud
    Then I am on the "Readaloud" "mod_digitala > Teacher Reports Overview" page logged in as "ossi"
    Then I should see "Olli Opiskelija"
    And I should see "5001"
    And I should see "01:09"
    And I should see "666"
    And I should see "See report"
    Then I should see "Essi Opiskelija"
    And I should see "-"
    And I should see "04:20"
    And I should see "420"
    And I should see "Waiting for evaluation"
    Then I should see "Seppo Opiskelija"
    And I should see "-"
    And I should see "02:00"
    And I should see "69"
    And I should see "Retrying automatic evaluation"
    Then I should see "Milla Opiskelija"
    And I should see "-"
    And I should see "01:00"
    And I should see "1337"
    And I should see "Evaluation failed"

  Scenario: Export attempts as CSV works in readaloud:
    When I am on the "Readaloud > attempts" "mod_digitala > Export" page logged in as "ossi"
    Then I should see "id,digitala,userid,attemptnumber,file,transcript,feedback,fluency,fluency_features,taskcompletion,pronunciation,pronunciation_features,lexicogrammatical,lexicogrammatical_features,holistic,timecreated,timemodified,recordinglength,status"
    And I should see "666"
    And I should see "420"
    And I should see "69"
    And I should see "1337"
    And I should see "file5"
    And I should see "file6"
    And I should see "file7"
    And I should see "file8"
    And I should see "transcript5"
    And I should see "transcript6"
    And I should see "transcript7"
    And I should see "transcript8"
    And I should see "feedback5"
    And I should see "feedback6"
    And I should see "feedback7"
    And I should see "feedback8"
    And I should see "5001"
    And I should see "6001"
    And I should see "7001"
    And I should see "8001"
    And I should see "5003"
    And I should see "6003"
    And I should see "7003"
    And I should see "8003"
    And I should see "69"
    And I should see "260"
    And I should see "120"
    And I should see "60"
    And I should see "evaluated"
    And I should see "waiting"
    And I should see "retry"
    And I should see "failed"

  Scenario: Export attempts as CSV works in freeform:
    When I am on the "Freeform > attempts" "mod_digitala > Export" page logged in as "ossi"
    Then I should see "id,digitala,userid,attemptnumber,file,transcript,feedback,fluency,fluency_features,taskcompletion,pronunciation,pronunciation_features,lexicogrammatical,lexicogrammatical_features,holistic,timecreated,timemodified,recordinglength,status"
    And I should see "666"
    And I should see "420"
    And I should see "69"
    And I should see "1337"
    And I should see "file1"
    And I should see "file2"
    And I should see "file3"
    And I should see "file4"
    And I should see "transcript1"
    And I should see "transcript2"
    And I should see "transcript3"
    And I should see "transcript4"
    And I should see "1001"
    And I should see "2001"
    And I should see "3001"
    And I should see "4001"
    And I should see "1003"
    And I should see "2003"
    And I should see "3003"
    And I should see "4003"
    And I should see "1005"
    And I should see "2005"
    And I should see "3005"
    And I should see "4005"
    And I should see "1007"
    And I should see "2007"
    And I should see "3007"
    And I should see "4007"
    And I should see "1009"
    And I should see "2009"
    And I should see "3009"
    And I should see "4009"
    And I should see "1"
    And I should see "2"
    And I should see "3"
    And I should see "4"
    And I should see "69"
    And I should see "260"
    And I should see "120"
    And I should see "60"
    And I should see "evaluated"
    And I should see "waiting"
    And I should see "retry"
    And I should see "failed"

  Scenario: Export attempt feedback as CSV works in readaloud:
    When I am on the "Readaloud > feedback" "mod_digitala > Export" page logged in as "ossi"
    Then I should see "id,attempt,digitala,old_fluency,fluency,fluency_reason,old_taskcompletion,taskcompletion,taskcompletion_reason,old_lexicogrammatical,lexicogrammatical,lexicogrammatical_reason,old_pronunciation,pronunciation,pronunciation_reason,old_holistic,holistic,holistic_reason,timecreated"
    And I should see "5001"
    And I should see "6001"
    And I should see "7001"
    And I should see "8001"
    And I should see "5002"
    And I should see "6002"
    And I should see "7002"
    And I should see "8002"
    And I should see "5003"
    And I should see "6003"
    And I should see "7003"
    And I should see "8003"
    And I should see "5004"
    And I should see "6004"
    And I should see "7004"
    And I should see "8004"
    And I should see "readaloud_olli_fluency_syy"
    And I should see "readaloud_essi_fluency_syy"
    And I should see "readaloud_seppo_fluency_syy"
    And I should see "readaloud_milla_fluency_syy"
    And I should see "readaloud_olli_pronunciation_syy"
    And I should see "readaloud_essi_pronunciation_syy"
    And I should see "readaloud_seppo_pronunciation_syy"
    And I should see "readaloud_milla_pronunciation_syy"

  Scenario: Export attempt feedback as CSV works in freeform:
    When I am on the "Freeform > feedback" "mod_digitala > Export" page logged in as "ossi"
    Then I should see "id,attempt,digitala,old_fluency,fluency,fluency_reason,old_taskcompletion,taskcompletion,taskcompletion_reason,old_lexicogrammatical,lexicogrammatical,lexicogrammatical_reason,old_pronunciation,pronunciation,pronunciation_reason,old_holistic,holistic,holistic_reason,timecreated"
    And I should see "1001"
    And I should see "2001"
    And I should see "3001"
    And I should see "4001"
    And I should see "1002"
    And I should see "2002"
    And I should see "3002"
    And I should see "4002"
    And I should see "1003"
    And I should see "2003"
    And I should see "3003"
    And I should see "4003"
    And I should see "1004"
    And I should see "2004"
    And I should see "3004"
    And I should see "4004"
    And I should see "1005"
    And I should see "2005"
    And I should see "3005"
    And I should see "4005"
    And I should see "1006"
    And I should see "2006"
    And I should see "3006"
    And I should see "4006"
    And I should see "1007"
    And I should see "2007"
    And I should see "3007"
    And I should see "4007"
    And I should see "1008"
    And I should see "2008"
    And I should see "3008"
    And I should see "4008"
    And I should see "1009"
    And I should see "2009"
    And I should see "3009"
    And I should see "4009"
    And I should see "1010"
    And I should see "2010"
    And I should see "3010"
    And I should see "4010"
    And I should see "freeform_olli_fluency_syy"
    And I should see "freeform_essi_fluency_syy"
    And I should see "freeform_seppo_fluency_syy"
    And I should see "freeform_milla_fluency_syy"
    And I should see "freeform_olli_pronunciation_syy"
    And I should see "freeform_essi_pronunciation_syy"
    And I should see "freeform_seppo_pronunciation_syy"
    And I should see "freeform_milla_pronunciation_syy"
    And I should see "freeform_olli_taskcompletion_syy"
    And I should see "freeform_essi_taskcompletion_syy"
    And I should see "freeform_seppo_taskcompletion_syy"
    And I should see "freeform_milla_taskcompletion_syy"
    And I should see "freeform_olli_lexicogrammatical_syy"
    And I should see "freeform_essi_lexicogrammatical_syy"
    And I should see "freeform_seppo_lexicogrammatical_syy"
    And I should see "freeform_milla_lexicogrammatical_syy"
    And I should see "freeform_olli_holistic_syy"
    And I should see "freeform_essi_holistic_syy"
    And I should see "freeform_seppo_holistic_syy"
    And I should see "freeform_milla_holistic_syy"

  Scenario: Export recordings downloads file
    When I am on the "Freeform" "mod_digitala > Teacher Reports Overview" page logged in as "ossi"
    Then I click on "Export all recordings" "link"
    Then I am on the "Readaloud" "mod_digitala > Teacher Reports Overview" page logged in as "ossi"
    Then I click on "Export all recordings" "link"
