@mod @mod_digitala
Feature: Edit digitala activity

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                  |
      | ossi     | Ossi      | Opettaja | ossi.opettaja@koulu.fi |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user | course | role    |
      | ossi | C1     | manager |
    And the following "activities" exist:
      | activity    | name               | intro               | course | idnumber  | attemptlang | attempttype | assignment      | resources     | assignmentformat | resourcesformat |
      | digitala    | Test digitala name | Test digitala intro | C1     | digitala1 | fin         | freeform    | Assignment text | Resource text | 1                | 1               |
    And I log in as "ossi"

  Scenario Outline: Edit a task on course page
    Given I am on the "Test digitala name" "mod_digitala > Edit" page logged in as "ossi"
    Then I add a "digitala" to section "2" and I fill the form with:
      | Name             | <name>           |
      | Attempt language | <attemptlang>    |
      | Attempt type     | <attempttype>    |
      | Assignment       | <assignmenttext> |
      | Resources        | <resourcestext>  |
    And I click on "<name>" "link"
    And I click on "Next" "link"
    Then I should see "Assignment"
    And I should see "<assignmenttext>"
    And I should see "Resources"
    And I should see "<resourcestext>"

    Examples:
      | name          | attemptlang | attempttype | assignmenttext                   | resourcestext                                                          |
      | SWE Readaloud | Swedish     | Read aloud  | Läs följande avsnitt högt.       | Hejsan, jag heter Jonne-Peter.                                         |
      | FIN Readaloud | Finnish     | Read aloud  | Lue seuraava lause ääneen.       | Tämä on liikennevalojen perusteet -kurssi.                             |
      | SWE Freeform  | Swedish     | Free-form   | Berätta om Tigerjakt.            | Här är filmen om tiger.                                                |
      | FIN Freeform  | Finnish     | Free-form   | Pidä oppitunti liikennevaloista. | Liikennevaloissa kolme valoa ja ne ovat punainen, keltainen ja vihreä. |
