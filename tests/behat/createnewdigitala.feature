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

        Scenario: On course page add freeform task in Swedish and add local image to resources
             When I am on the "C1" "Course" page
              And I turn editing mode on
              And I add a "digitala" to section "2"
              And I wait until the page is ready
             Then I set the following fields to these values:
                  | Name             | SWE Freeform IMG              |
                  | Attempt language | Swedish                       |
                  | Attempt type     | Free-form                     |
                  | Assignment       | Berätta om Tigerjakt.         |
                  | Resources        | Här är filmen om tiger. IMAGE |
              And I press "Insert or edit image"
              And I press "Browse repositories..."
              And I select "Upload a file" repository in file picker
              And I wait "5" seconds
              And I press "Save and display"
              And I click on "SWE Freeform IMG" "link"
              And I click on "Next" "link"
             Then I should see "Assignment"
              And I should see "Berätta om Tigerjakt."
              And I should see "Resources"
              And I should see "Här är filmen om tiger."
