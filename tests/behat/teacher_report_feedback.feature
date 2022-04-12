@mod @mod_digitala @javascript @onlyone
Feature: Teacher can give feedback on ASR evaluation

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

  Scenario: Feedback button works correctly in teachers report detail page in freeform
    When I am on the "Freeform > olli" "mod_digitala > Teacher Report Details" page logged in as "ossi"
    And I click on "Give feedback on report" "link"
    And I should see "Feedback on Fluency"

  Scenario: Feedback button works correctly in teachers report detail page in readaloud
    When I am on the "Readaloud > olli" "mod_digitala > Teacher Report Details" page logged in as "ossi"
    And I click on "Give feedback on report" "link"
    And I should see "Feedback on goodness of pronunciation"

  Scenario: Feedback can be given on Freeform
    When I am on the "Freeform > olli" "mod_digitala > Teacher Report Feedback" page logged in as "ossi"
    Then I set the following fields to these values:
      | Fluency                      | 2.00                              |
      | Feedback on Fluency          | Evaluation was too high.          |
      | Task completion              | 3.00                              |
      | Feedback on Task completion  | Evaluation was too low.           |
      | Range                        | 2.34                              |
      | Feedback on Range            | Evaluation was out of boundaries. |
      | Pronunciation                | 2.37                              |
      | Feedback on Pronunciation    | Sounds like pro finn.             |
      | Proficiency                  | 6.50                              |
      | Feedback on Proficiency      | This meets all values for this.   |
    And I press "Save changes"
    And the following feedback is found:
      | name     | username |
      | Freeform | olli     |

  Scenario: Feedback can be given on Readaloud
    When I am on the "Readaloud > olli" "mod_digitala > Teacher Report Feedback" page logged in as "ossi"
    Then I set the following fields to these values:
      | Goodness of pronunciation             | 0.56                  |
      | Feedback on goodness of pronunciation | Evaluation was wrong. |
    And I press "Save changes"
    And the following feedback is found:
      | name      | username |
      | Readaloud | olli     |
