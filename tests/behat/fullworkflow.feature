@mod @mod_digitala @javascript @onlyone
Feature: Full activity workflow from creating acitivty to students' answering

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

        Scenario: On course page add readaloud task in Swedish
             When I am on the "C1" "Course" page logged in as "ossi"
              And I turn editing mode on
             Then I add a "digitala" to section "2" and I fill the form with:
                  | Name             | SWE Readaloud Full Workflow                          |
                  | Attempt language | Swedish                                              |
                  | Attempt type     | Read aloud                                           |
                  | Assignment       | Läs följande avsnitt högt.                           |
                  | Resources        | Hejsan, jag heter Jonne-Peter och imppar Eri Keeper. |
             Then I am on the "C1" "Course" page logged in as "olli"
              And I click on "SWE Readaloud Full Workflow" "link"
             Then I click on "Start" "button"
              And I wait "3" seconds
             Then I click on "Stop" "button"
              And I wait "1" seconds
             Then I click on "Listen recording" "button"
              And I wait "5" seconds
             Then I click on "Next" "link"
             Then I should see "Assignment"
              And I should see "Läs följande avsnitt högt."
              And I should see "Resources"
              And I should see "Hejsan, jag heter Jonne-Peter och imppar Eri Keeper."
             Then I click on "Start" "button"
              And I wait "10" seconds
             Then I click on "Stop" "button"
              And I wait "5" seconds
             Then I click on "Listen recording" "button"
              And I wait "30" seconds
             Then I press "id_submitbutton"
