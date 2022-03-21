@mod @mod_digitala @javascript
Feature: Digitala activity is accessible for everyone and follows Moodles accessibility tests

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
      | activity | name          | intro         | course | idnumber     | attemptlang | attempttype | assignment                       | resources                                                              | assignmentformat | resourcesformat |
      | digitala | SWE Readaloud | SWE Readaloud | C1     | swereadaloud | sv          | readaloud   | Läs följande avsnitt högt.       | Hejsan, jag heter Jonne-Peter.                                         | 1                | 1               |
      | digitala | SWE Freeform  | SWE Freeform  | C1     | swefreeform  | sv          | freeform    | Berätta om Tigerjakt.            | Här är filmen om tiger.                                                | 1                | 1               |
      | digitala | FIN Readaloud | FIN Readaloud | C1     | finreadaloud | fin         | readaloud   | Lue seuraava lause ääneen.       | Tämä on liikennevalojen perusteet -kurssi.                             | 1                | 1               |
      | digitala | FIN Freeform  | FIN Freeform  | C1     | finfreeform  | fin         | freeform    | Pidä oppitunti liikennevaloista. | Liikennevaloissa kolme valoa ja ne ovat punainen, keltainen ja vihreä. | 1                | 1               |
    And I log in as "olli"

  @onlyone
  Scenario Outline: Test accessibility on every phase
    When I am on the "C1" "Course" page
    And I click on "<activityname>" "link"
    And I wait "2" seconds
    Then the page should meet accessibility standards
    And I click on "Assignment" "link"
    And I wait "2" seconds
    Then the page should meet accessibility standards

    Examples:
      | activityname  |
      | SWE Readaloud |
      | SWE Freeform  |
      | FIN Readaloud |
      | FIN Freeform  |
