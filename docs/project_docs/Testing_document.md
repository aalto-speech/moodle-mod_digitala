
Installing the PHPUnit test environment:

For detailed installation instructions, please see:
https://docs.moodle.org/dev/PHPUnit
or the Docker version:
https://github.com/moodlehq/moodle-docker

Initializing the PHPUnit test environment:

php admin/tool/phpunit/cli/init.php

Running all the PHPUnit tests from the Digitala Activity module:

vendor/bin/phpunit --group mod_digitala

Installing, initializing and running the Behat-test framework.

For detailed installation instructions, please see:
https://docs.moodle.org/dev/Running_acceptance_test
or the Docker version:
https://github.com/moodlehq/moodle-docker

For acceptance testing, this plugin uses Behat, which is a PHP framework for automated functional testing. 

Initializing the Behat-test framework.

php admin/tool/behat/cli/init.php

Running all the Behat-tests from the Digitala Activity module:

php admin/tool/behat/cli/run.php --tags=@mod_digitala

Manual testing

All changes are reviewed by developers other than the makers before manually before merging into main.
All code must adhere to the coding guidelines.

Automated testing

For the Continuous Integration pipeline, we have automated checks for all the following 
CI-pipeline:
- PHP Lint
- PHP Copy/Paste detector
- PHP Mess detector
- Moodle Code Checker
- Moodle PHPDoc Checker
- Codecov
