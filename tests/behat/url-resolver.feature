@mod @mod_digitala @javascript
Feature: URL resolver works in behats

  Background:
    Given the following "users" exist:
      | username | firstname | lastname   | email                    |
      | ossi     | Ossi      | Opettaja   | ossi.opettaja@koulu.fi   |
      | olli     | Olli      | Opiskelija | olli.opiskelija@koulu.fi |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user | course | role    |
      | ossi | C1     | manager |
      | olli | C1     | student |
    And the following "activities" exist:
      | activity | name      | intro                | course | idnumber  | attemptlang | attempttype | assignment                 | resources                                  | resourcesformat | attemptlimit | information     | informationformat |
      | digitala | Freeform  | This is a freeform.  | C1     | freeform  | sv          | freeform    | Berätta om Tigerjakt.      | Här är filmen om tiger.                    | 1               | 0            | testinformation | 1                 |
      | digitala | Readaloud | This is a readaloud. | C1     | readaloud | fi          | readaloud   | Lue seuraava lause ääneen. | Tämä on liikennevalojen perusteet -kurssi. | 1               | 2            | testinformation | 1                 |
    And I add freeform attempt to database:
      | name     | username | attemptnumber | file  | transcript  | fluency | taskcompletion | pronunciation | lexicogrammatical | holistic | recordinglength | status    |
      | Freeform | olli     | 1             | file1 | transcript1 | 1       | 1              | 2             | 3                 | 1        | 1               | evaluated |
    And I add readaloud attempt to database:
      | name      | username | attemptnumber | file  | transcript  | feedback | fluency | pronunciation | recordinglength | status    |
      | Readaloud | olli     | 1             | file2 | transcript2 | feedback | 0.7     | 1.5           | 2               | evaluated |
    And I add freeform feedback to database:
      | name     | username | old_fluency | fluency | fluency_reason       | old_pronunciation | pronunciation | pronunciation_reason | old_taskcompletion | taskcompletion | taskcompletion_reason | old_lexicogrammatical | lexicogrammatical | lexicogrammatical_reason | old_holistic | holistic | holistic_reason |
      | Freeform | olli     | 111         | 222     | freeform_fluency_syy | 333               | 444           | pronunciation_syy    | 555                | 666            | taskcompletion_syy    | 777                   | 888               | lexicogrammatical_syy    | 999          | 420      | holistic_syy    |
    And I add readaloud feedback to database:
      | name      | username | old_fluency | fluency | fluency_reason        | old_pronunciation | pronunciation | pronunciation_reason |
      | Readaloud | olli     | 111         | 222     | readaloud_fluency_syy | 333               | 444           | pronunciation_syy    |

  Scenario Outline: Page URL resolver works
    When I am on the "<activity>" "mod_digitala > Invalid" page logged in as "<student>"
    And I should see "Access denied"
    When I am on the "<activity>" "mod_digitala > Info" page logged in as "<student>"
    And I should see "Test your microphone here"
    Then I am on the "<activity>" "mod_digitala > Assignment" page logged in as "<student>"
    And I should see "Material"
    Then I am on the "<activity>" "mod_digitala > Report" page logged in as "<student>"
    And I should see "<reportpage>"
    Then I am on the "<activity>" "mod_digitala > Teacher Reports Overview" page logged in as "<teacher>"
    And I should see "See report"
    Then I am on the "<activity> > <student>" "mod_digitala > Teacher Report Details" page logged in as "<teacher>"
    And I should see "Assignment"
    And I should see "<reportpage>"
    Then I am on the "<activity> > <student>" "mod_digitala > Teacher Report Feedback" page logged in as "<teacher>"
    And I should see "Edit the evaluation report"
    Then I am on the "<activity> > attempts" "mod_digitala > Export" page logged in as "<teacher>"
    And I should see "id,digitala,userid,attemptnumber,file,transcript,feedback,fluency,fluency_features,taskcompletion,pronunciation,pronunciation_features,lexicogrammatical,lexicogrammatical_features,holistic,timecreated,timemodified,recordinglength,status"
    And I should see "<transcript>"
    Then I am on the "<activity> > feedback" "mod_digitala > Export" page logged in as "<teacher>"
    And I should see "id,attempt,digitala,old_fluency,fluency,fluency_reason,old_taskcompletion,taskcompletion,taskcompletion_reason,old_lexicogrammatical,lexicogrammatical,lexicogrammatical_reason,old_pronunciation,pronunciation,pronunciation_reason,old_holistic,holistic,holistic_reason,timecreated"
    And I should see "<reason>"
    Then I am on the "<activity> > recordings" "mod_digitala > Export" page logged in as "<teacher>"
    And I should not see "See report"

    Examples:
      | activity  | student | teacher | reportpage | transcript  | reason                |
      | Freeform  | olli    | ossi    | Range      | transcript1 | freeform_fluency_syy  |
      | Readaloud | olli    | ossi    | Fluency    | transcript2 | readaloud_fluency_syy |
