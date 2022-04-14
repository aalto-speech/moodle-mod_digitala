@mod @mod_digitala @javascript
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
      | activity | name               | intro               | course | idnumber  | attemptlang | attempttype | assignment      | resources     | assignmentformat | resourcesformat | attemptlimit |
      | digitala | Test digitala name | Test digitala intro | C1     | digitala1 | fi          | freeform    | Assignment text | Resource text | 1                | 1               | 0            |
    And I log in as "ossi"

  Scenario Outline: Edit a task on course page
    When I am on the "C1" "Course" page
    And I turn editing mode on
    Then I open "Test digitala name" actions menu
    Then I choose "Edit settings" in the open action menu
    And I wait until the page is ready
    Then I set the following fields to these values:
      | Name       | <name>           |
      | Language   | <attemptlang>    |
      | Type       | <attempttype>    |
      | Assignment | <assignmenttext> |
      | Material   | <resourcestext>  |
    And I press "Save and display"
    And I click on "<name>" "link"
    And I click on "Next" "link"
    Then I should see "Assignment"
    And I should see "<assignmenttext>"
    And I should see "Material"
    And I should see "<resourcestext>"

    Examples:
      | name          | attemptlang | attempttype | assignmenttext                   | resourcestext                                                          |
      | SWE Readaloud | Swedish     | Read aloud  | Läs följande avsnitt högt.       | Hejsan, jag heter Jonne-Peter.                                         |
      | FIN Readaloud | Finnish     | Read aloud  | Lue seuraava lause ääneen.       | Tämä on liikennevalojen perusteet -kurssi.                             |
      | SWE Freeform  | Swedish     | Freeform    | Berätta om Tigerjakt.            | Här är filmen om tiger.                                                |
      | FIN Freeform  | Finnish     | Freeform    | Pidä oppitunti liikennevaloista. | Liikennevaloissa kolme valoa ja ne ovat punainen, keltainen ja vihreä. |
