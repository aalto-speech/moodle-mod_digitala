#!/bin/bash
echo $(ls)
cd plugin
echo $(ls)
old_version=$(cat version.php | grep '$plugin->version = ')
old_version=${old_version/\$plugin->version = /}
old_version=${old_version/;/}

new_version=$((old_version + 1))

if [ $? -eq 0]
then
    echo 'Found current version: ' ${old_version}
else
    echo 'version.php not found'
    exit 1
fi

sed -i "s+${old_version}+${new_version}+g" version.php

echo 'Updated plugin version from '${old_version}' to '${new_version}