@mod @mod_digitala @javascript @onlyone
Feature: Create new digitala

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
              And I log in as "ossi"

        Scenario: On course page add readaloud task in Swedish
             When I am on the "C1" "Course" page
              And I turn editing mode on
             Then I add a "digitala" to section "2" and I fill the form with:
                  | Name             | SWE Readaloud                                        |
                  | Attempt language | Swedish                                              |
                  | Attempt type     | Read aloud                                           |
                  | Assignment       | Läs följande avsnitt högt.                           |
                  | Resources        | Hejsan, jag heter Jonne-Peter och imppar Eri Keeper. |
              And I click on "SWE Readaloud" "link"
              And I click on "Next" "link"
             Then I should see "Assignment"
              And I should see "Läs följande avsnitt högt."
              And I should see "Resources"
              And I should see "Hejsan, jag heter Jonne-Peter och imppar Eri Keeper."

        Scenario: On course page add readaloud task in Finnish
             When I am on the "C1" "Course" page
              And I turn editing mode on
             Then I add a "digitala" to section "2" and I fill the form with:
                  | Name             | FIN Readaloud                                   |
                  | Attempt language | Finnish                                         |
                  | Attempt type     | Read aloud                                      |
                  | Assignment       | Lue seuraava lause ääneen.                      |
                  | Resources        | Terveppä terve ja heipä hei, se on Osteri-Ossi. |
              And I click on "FIN Readaloud" "link"
              And I click on "Next" "link"
             Then I should see "Assignment"
              And I should see "Lue seuraava lause ääneen."
              And I should see "Resources"
              And I should see "Terveppä terve ja heipä hei, se on Osteri-Ossi."

        Scenario: On course page add freeform task in Swedish
             When I am on the "C1" "Course" page
              And I turn editing mode on
             Then I add a "digitala" to section "2" and I fill the form with:
                  | Name             | SWE Freeform            |
                  | Attempt language | Swedish                 |
                  | Attempt type     | Free-form               |
                  | Assignment       | Berätta om Tigerjakt.   |
                  | Resources        | Här är filmen om tiger. |
              And I click on "SWE Freeform" "link"
              And I click on "Next" "link"
             Then I should see "Assignment"
              And I should see "Berätta om Tigerjakt."
              And I should see "Resources"
              And I should see "Här är filmen om tiger."

        Scenario: On course page add freeform task in Finnish
             When I am on the "C1" "Course" page
              And I turn editing mode on
             Then I add a "digitala" to section "2" and I fill the form with:
                  | Name             | FIN Freeform                      |
                  | Attempt language | Finnish                           |
                  | Attempt type     | Free-form                         |
                  | Assignment       | Kertoileppa tarina Osteri-Ossista |
                  | Resources        | Tää on Salkkarikamaa, tiesiksää?! |
              And I click on "FIN Freeform" "link"
              And I click on "Next" "link"
             Then I should see "Assignment"
              And I should see "Kertoileppa tarina Osteri-Ossista"
              And I should see "Resources"
              And I should see "Tää on Salkkarikamaa, tiesiksää?!"