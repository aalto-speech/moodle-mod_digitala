#!/bin/bash
cd $(pwd)/moodle
php -S localhost:8000 &>/dev/null & echo 'Started Behat testing server'
