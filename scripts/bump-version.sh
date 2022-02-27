#!/bin/bash
cd plugin
old_version=$(cat version.php | grep '$plugin->version = ')
old_version=${old_version/\$plugin->version = /}
old_version=${old_version/;/}

curr_date=$(date '+%Y%m%d')00

if [ $curr_date -gt $old_version ]
then
    new_version=$curr_date
else
    new_version=$((old_version + 1))
fi

sed -i "s+${old_version}+${new_version}+g" version.php

echo 'Updated plugin version from '${old_version}' to '${new_version}