@mod @mod_digitala @javascript
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

        Scenario: On course page add freeform task in Swedish and add local video to resources
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

        Scenario: On course page add freeform task in Swedish and add local audio to resources
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

        Scenario: On course page add freeform task in Swedish and add internet image to resources
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

        Scenario: On course page add freeform task in Swedish and add internet video to resources
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

        Scenario: On course page add freeform task in Swedish and add internet audio to resources
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