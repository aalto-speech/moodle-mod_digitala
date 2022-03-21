@mod @mod_digitala @javascript @_file_upload
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
             When I follow "Manage private files..."
              And I upload "mod/digitala/tests/fixtures/pic-1.png" file to "Files" filemanager
              And I click on "Save changes" "button"
             Then I am on the "C1" "Course" page
              And I turn editing mode on
              And I add a "digitala" to section "2"
              And I wait until the page is ready
             Then I set the following fields to these values:
                  | Name             | SWE Freeform IMG        |
                  | Attempt language | Swedish                 |
                  | Attempt type     | Free-form               |
                  | Assignment       | Berätta om Tigerjakt.   |
                  | Resources        | Här är filmen om tiger. |
              And I press "Insert or edit image"
              And I press "Browse repositories..."
              And I select "Private files" repository in file picker
              And I click on "pic-1.png" "file" in repository content area
              And I press "Select this file"
              And I set the field "Describe this image for someone who cannot see it" to "nää on liikennevalot XD"
              And I press "Save image"
              And I wait "1" seconds
              And I press "Save and display"
              And I click on "Next" "link"
             Then I should see "Assignment"
              And I should see "Berätta om Tigerjakt."
              And I should see "Resources"
              And I should see "Här är filmen om tiger."
              And "//img[@alt='nää on liikennevalot XD']" "xpath_element" should exist
              And the image at "//img[@alt='nää on liikennevalot XD']" "xpath_element" should be identical to "mod/digitala/tests/fixtures/pic-1.png"

        Scenario: On course page add freeform task in Swedish and add local audio to resources
             When I follow "Manage private files..."
              And I upload "mod/digitala/tests/fixtures/tottoroo.wav" file to "Files" filemanager
              And I click on "Save changes" "button"
             Then I am on the "C1" "Course" page
              And I turn editing mode on
              And I add a "digitala" to section "2"
              And I wait until the page is ready
             Then I set the following fields to these values:
                  | Name             | SWE Freeform AUDIO      |
                  | Attempt language | Swedish                 |
                  | Attempt type     | Free-form               |
                  | Assignment       | Berätta om Tigerjakt.   |
                  | Resources        | Här är filmen om tiger. |
              And I press "Insert or edit an audio/video file"
              And I click on "Audio" "link"
              And I click on "//div[@data-medium-type='audio']/div/div/div/span/button[contains(text(), 'Browse repositories...')]" "xpath_element"
              And I wait "1" seconds
              And I select "Private files" repository in file picker
              And I click on "tottoroo.wav" "file" in repository content area
              And I press "Select this file"
              And I click on "//a[@aria-controls='id_resources_audio-display-options']" "xpath_element"
              And I set the field with xpath "//input[@id='audio_media-title-entry']" to "töttöröö :D"
              And I press "Insert media"
              And I wait "1" seconds
              And I press "Save and display"
              And I click on "Next" "link"
             Then I should see "Assignment"
              And I should see "Berätta om Tigerjakt."
              And I should see "Resources"
              And I should see "Här är filmen om tiger."
              And "//audio[@title='töttöröö :D']" "xpath_element" should exist

        Scenario: On course page add freeform task in Swedish and add local video to resources
             When I follow "Manage private files..."
              And I upload "mod/digitala/tests/fixtures/video-1.mp4" file to "Files" filemanager
              And I click on "Save changes" "button"
             Then I am on the "C1" "Course" page
              And I turn editing mode on
              And I add a "digitala" to section "2"
              And I wait until the page is ready
             Then I set the following fields to these values:
                  | Name             | SWE Freeform VIDEO      |
                  | Attempt language | Swedish                 |
                  | Attempt type     | Free-form               |
                  | Assignment       | Berätta om Tigerjakt.   |
                  | Resources        | Här är filmen om tiger. |
              And I press "Insert or edit an audio/video file"
              And I click on "Video" "link"
              And I click on "//div[@data-medium-type='video']/div/div/div/span/button[contains(text(), 'Browse repositories...')]" "xpath_element"
              And I wait "1" seconds
              And I select "Private files" repository in file picker
              And I click on "video-1.mp4" "file" in repository content area
              And I press "Select this file"
              And I click on "//a[@aria-controls='id_resources_video-display-options']" "xpath_element"
              And I set the field with xpath "//input[@id='video_media-title-entry']" to "behats are all over the places :D"
              And I press "Insert media"
              And I wait "1" seconds
              And I press "Save and display"
              And I click on "Next" "link"
             Then I should see "Assignment"
              And I should see "Berätta om Tigerjakt."
              And I should see "Resources"
              And I should see "Här är filmen om tiger."
              And "//video[@title='behats are all over the places :D']" "xpath_element" should exist
