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
      | user  | course | role           |
      | ossi  | C1     | editingteacher |
    And I log in as "ossi"
    And I visit "/user/files.php"
    And I upload "mod/digitala/tests/fixtures/tottoroo.wav" file to "Files" filemanager
    And I upload "mod/digitala/tests/fixtures/pic-1.png" file to "Files" filemanager
    And I upload "mod/digitala/tests/fixtures/video-1.mp4" file to "Files" filemanager
    And I click on "Save changes" "button"

  Scenario Outline: On course page add new task
    When I am on the "C1" "Course" page
    And I turn editing mode on
    Then I add a "digitala" to section "2" and I fill the form with:
      | Name             | <name>            |
      | Language         | <attemptlang>     |
      | Type             | <attempttype>     |
      | Assignment       | <assignmenttext>  |
      | Material         | <resourcestext>   |
      | More information | <informationtext> |
    Then I am on the "<name>" "digitala activity" page
    And I click on "Next" "link"
    Then I should see "Assignment"
    And I should see "<assignmenttext>"
    And I should see "Material"
    And I should see "<resourcestext>"

    Examples:
      | name          | attemptlang | attempttype | assignmenttext                   | resourcestext                                                          | informationtext  |
      | SWE Readaloud | Swedish     | Read aloud  | Läs följande avsnitt högt.       | Hejsan, jag heter Jonne-Peter.                                         | some information |
      | FIN Readaloud | Finnish     | Read aloud  | Lue seuraava lause ääneen.       | Tämä on liikennevalojen perusteet -kurssi.                             | some information |
      | SWE Freeform  | Swedish     | Freeform    | Berätta om Tigerjakt.            | Här är filmen om tiger.                                                | some information |
      | FIN Freeform  | Finnish     | Freeform    | Pidä oppitunti liikennevaloista. | Liikennevaloissa kolme valoa ja ne ovat punainen, keltainen ja vihreä. | some information |
      | FIN Freeform  | Finnish     | Freeform    | Pidä oppitunti liikennevaloista. | Liikennevaloissa kolme valoa ja ne ovat punainen, keltainen ja vihreä. | some information |

  Scenario: On course page add freeform task in Swedish and add local image to resources
    When I am on the "C1" "Course" page
    And I turn editing mode on
    And I add a "digitala" to section "2"
    And I wait until the page is ready
    Then I set the following fields to these values:
      | Name       | SWE Freeform IMG        |
      | Language   | Swedish                 |
      | Type       | Freeform                |
      | Assignment | Berätta om Tigerjakt.   |
      | Material   | Här är filmen om tiger. |
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
    And I should see "Material"
    And I should see "Här är filmen om tiger."
    And "//img[@alt='nää on liikennevalot XD']" "xpath_element" should exist
    And the image at "//img[@alt='nää on liikennevalot XD']" "xpath_element" should be identical to "mod/digitala/tests/fixtures/pic-1.png"

  Scenario: On course page add freeform task in Swedish and add local audio to resources
    When I am on the "C1" "Course" page
    And I turn editing mode on
    And I add a "digitala" to section "2"
    And I wait until the page is ready
    Then I set the following fields to these values:
      | Name       | SWE Freeform AUDIO      |
      | Language   | Swedish                 |
      | Type       | Freeform                |
      | Assignment | Berätta om Tigerjakt.   |
      | Material   | Här är filmen om tiger. |
    And I press "Insert or edit an audio/video file"
    And I click on "Audio" "link"
    And I click on "Browse repositories..." "button" in the "#id_resources_editor_audio .atto_media_source.atto_media_media_source" "css_element"
    And I wait "1" seconds
    And I select "Private files" repository in file picker
    And I click on "tottoroo.wav" "file" in repository content area
    And I press "Select this file"
    And I click on "Display options" "link" in the "#id_resources_editor_audio" "css_element"
    And I set the field "audio_media-title-entry" to "töttöröö :D"
    And I press "Insert media"
    And I wait "1" seconds
    And I press "Save and display"
    And I click on "Next" "link"
    Then I should see "Assignment"
    And I should see "Berätta om Tigerjakt."
    And I should see "Material"
    And I should see "Här är filmen om tiger."
    And "//audio[@title='töttöröö :D']" "xpath_element" should exist

  Scenario: On course page add freeform task in Swedish and add local video to resources
    When I am on the "C1" "Course" page
    And I turn editing mode on
    And I add a "digitala" to section "2"
    And I wait until the page is ready
    Then I set the following fields to these values:
      | Name       | SWE Freeform VIDEO      |
      | Language   | Swedish                 |
      | Type       | Freeform                |
      | Assignment | Berätta om Tigerjakt.   |
      | Material   | Här är filmen om tiger. |
    And I press "Insert or edit an audio/video file"
    And I click on "Video" "link"
    And I click on "Browse repositories..." "button" in the "#id_resources_editor_video .atto_media_source.atto_media_media_source" "css_element"
    And I wait "1" seconds
    And I select "Private files" repository in file picker
    And I click on "video-1.mp4" "file" in repository content area
    And I press "Select this file"
    And I click on "Display options" "link" in the "#id_resources_editor_video" "css_element"
    And I set the field "video_media-title-entry" to "behats are all over the places :D"
    And I press "Insert media"
    And I wait "1" seconds
    And I press "Save and display"
    And I click on "Next" "link"
    Then I should see "Assignment"
    And I should see "Berätta om Tigerjakt."
    And I should see "Material"
    And I should see "Här är filmen om tiger."
    And "//video[@title='behats are all over the places :D']" "xpath_element" should exist

  Scenario: On course page add freeform task in Swedish and add internet image to resources
    When I am on the "C1" "Course" page
    And I turn editing mode on
    And I add a "digitala" to section "2"
    And I wait until the page is ready
    Then I set the following fields to these values:
      | Name       | SWE Freeform INTERNET IMG |
      | Language   | Swedish                   |
      | Type       | Freeform                  |
      | Assignment | Berätta om Tigerjakt.     |
      | Material   | Här är filmen om tiger.   |
    And I press "Insert or edit image"
    And I set the field "Enter URL" to "http://digitala-api:3000/resources/pic-1.png"
    And I set the field "Describe this image for someone who cannot see it" to "nää on liikennevalot XD"
    And I press "Save image"
    And I wait "1" seconds
    And I press "Save and display"
    And I click on "Next" "link"
    Then I should see "Assignment"
    And I should see "Berätta om Tigerjakt."
    And I should see "Material"
    And I should see "Här är filmen om tiger."
    And "//img[@alt='nää on liikennevalot XD']" "xpath_element" should exist
    And the image at "//img[@alt='nää on liikennevalot XD']" "xpath_element" should be identical to "mod/digitala/tests/fixtures/pic-1.png"

  Scenario: On course page add freeform task in Swedish and add local audio to resources
    When I am on the "C1" "Course" page
    And I turn editing mode on
    And I add a "digitala" to section "2"
    And I wait until the page is ready
    Then I set the following fields to these values:
      | Name       | SWE Freeform INTERNET AUDIO |
      | Language   | Swedish                     |
      | Type       | Freeform                    |
      | Assignment | Berätta om Tigerjakt.       |
      | Material   | Här är filmen om tiger.     |
    And I press "Insert or edit an audio/video file"
    And I click on "Audio" "link"
    And I set the field with xpath "//div[@data-medium-type='audio']/div/div/div/input" to "http://digitala-api:3000/resources/tottoroo.wav"
    And I click on "Display options" "link" in the "#id_resources_editor_audio" "css_element"
    And I set the field "audio_media-title-entry" to "töttöröö :D"
    And I press "Insert media"
    And I wait "1" seconds
    And I press "Save and display"
    And I click on "Next" "link"
    Then I should see "Assignment"
    And I should see "Berätta om Tigerjakt."
    And I should see "Material"
    And I should see "Här är filmen om tiger."
    And "//audio[@title='töttöröö :D']" "xpath_element" should exist

  Scenario: On course page add freeform task in Swedish and add local audio to resources
    When I am on the "C1" "Course" page
    And I turn editing mode on
    And I add a "digitala" to section "2"
    And I wait until the page is ready
    Then I set the following fields to these values:
      | Name       | SWE Freeform INTERNET VIDEO |
      | Language   | Swedish                     |
      | Type       | Freeform                    |
      | Assignment | Berätta om Tigerjakt.       |
      | Material   | Här är filmen om tiger.     |
    And I press "Insert or edit an audio/video file"
    And I click on "Video" "link"
    And I set the field with xpath "//div[@data-medium-type='video']/div/div/div/input" to "http://digitala-api:3000/resources/video-1.mp4"
    And I click on "Display options" "link" in the "#id_resources_editor_video" "css_element"
    And I set the field "video_media-title-entry" to "behats are all over the places :D"
    And I press "Insert media"
    And I wait "1" seconds
    And I press "Save and display"
    And I click on "Next" "link"
    Then I should see "Assignment"
    And I should see "Berätta om Tigerjakt."
    And I should see "Material"
    And I should see "Här är filmen om tiger."
    And "//video[@title='behats are all over the places :D']" "xpath_element" should exist
