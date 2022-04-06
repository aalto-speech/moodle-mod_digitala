#!/bin/bash
cd $(pwd)/moodle
php -S localhost:8000 & echo 'started local'
