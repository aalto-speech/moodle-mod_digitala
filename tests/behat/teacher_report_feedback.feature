@mod @mod_digitala @javascript
Feature: Teacher can see students detailed report

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
      | activity | name      | intro                | course | idnumber  | attemptlang | attempttype | assignment                 | resources                                  | resourcesformat | attemptlimit |
      | digitala | Freeform  | This is a freeform.  | C1     | freeform  | sv          | freeform    | Berätta om Tigerjakt.      | Här är filmen om tiger.                    | 1               | 0            |
      | digitala | Readaloud | This is a readaloud. | C1     | readaloud | fin         | readaloud   | Lue seuraava lause ääneen. | Tämä on liikennevalojen perusteet -kurssi. | 1               | 2            |
    And I add freeform attempt to database:
      | name     | username | attemptnumber | file  | transcript  | fluency | fluencymean | speechrate | taskachievement | accuracy | lexicalprofile | nativeity | holistic | recordinglength |
      | Freeform | olli     | 1             | file1 | transcript1 | 1       | 2           | 3          | 1               | 2        | 3              | 1         | 2        | 1               |
    And I add readaloud attempt to database:
      | name      | username | attemptnumber | file  | transcript  | gop_score | recordinglength |
      | Readaloud | olli     | 1             | file2 | transcript2 | 0.7       | 2               |

  Scenario: Detailed report shows correctly for freeform
    When I am on the "C1" "Course" page logged in as "ossi"
    And I click on "Freeform" "link"
    And I click on "Info" "link"
    And I click on "Overview" "link"
    And I click on "Details" "link"
    And I click on "Give feedback on report" "link"
    Then I set the following fields to these values:
      | Fluency                     | 2.00                              |
      | Feedback on fluency         | Evaluation was too high.          |
      | Accuracy                    | 3.00                              |
      | Feedback on accuracy        | Evaluation was too low.           |
      | Lexical profile             | 2.34                              |
      | Feedback on lexical profile | Evaluation was out of boundaries. |
      | Nativeity                   | 2.37                              |
      | Feedback on nativeity       | Sounds like pro finn.             |
      | Holistic                    | 6.50                              |
      | Feedback on holistic        | This meets all values for this.   |
    And I press "Save changes"
    And the following feedback is found:
      | name     | username |
      | Freeform | olli     |

  Scenario: Detailed report shows correctly for readaloud
    When I am on the "C1" "Course" page logged in as "ossi"
    And I click on "Readaloud" "link"
    And I click on "Info" "link"
    And I click on "Overview" "link"
    And I click on "Details" "link"
    And I click on "Give feedback on report" "link"
    Then I set the following fields to these values:
      | Goodness of pronunciation             | 0.56                  |
      | Feedback on goodness of pronunciation | Evaluation was wrong. |
    And I press "Save changes"
    And the following feedback is found:
      | name      | username |
      | Readaloud | olli     |
