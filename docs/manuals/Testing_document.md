## Automated testing

### PHPUnit

For unittesting, this plugin uses PHPUnit, which is a unittesting framework for PHP.

#### Installing the PHPUnit test environment:

For detailed installation instructions, please see:   
https://docs.moodle.org/dev/PHPUnit   
or the Docker version:   
https://github.com/moodlehq/moodle-docker   

#### Initializing the PHPUnit test environment:

`php admin/tool/phpunit/cli/init.php`

#### Running all the PHPUnit tests from the Digitala Activity module:

`vendor/bin/phpunit --group mod_digitala`

### Behat

For acceptance testing, this plugin uses Behat, which is a PHP framework for automated functional testing. 

#### Installing the Behat-test framework:

For detailed installation instructions, please see:   
https://docs.moodle.org/dev/Running_acceptance_test   
or the Docker version:   
https://github.com/moodlehq/moodle-docker   

#### Initializing the Behat-test framework:

`php admin/tool/behat/cli/init.php`

#### Running all the Behat-tests from the Digitala Activity module:

`php admin/tool/behat/cli/run.php --tags=@mod_digitala`

During development phase, the Continuous Integration pipeline ran the following checks for all incoming code changes:

- **PHP Lint**: checks for any PHP coding errors.
- **PHP Copy/Paste detector**: checks for PHP copy/paste.
- **PHP Mess detector**: checks for any PHP coding errors.
- **Moodle Code Checker**: checks for any Moodle Code violations.
- **Moodle PHPDoc Checker**: checks PHP Documentation for any errors.
- **Grunt**: runs Grunt (Javascript task runner) and checks for any errors.
- **PHPUnit**: sets up a PHPUnit container to run all current PHPUnit-tests.
- **Behat**: sets up a Behat container to run all current Behat-tests.
- **Codecov**: upload into Codecov to check code coverage changes.

## Manual testing

All changes are reviewed by developers other than the original creators manually before merging into the main branch.  
This involves checking for bugs and making sure the functionality works.  
All code merged into the main branch must adhere to the Definition of Done.

Definition of Done:  
* kaikki muutokset tehdään omaan branchiin, josta tehdään pull request ja toisen kehittäjän tulee hyväksyä se
* yksikkö- ja integraatiotestit ominaisuudelle on tehty
* tyyli noudattaa yhdessä sovittuja muotoilusääntöjä



