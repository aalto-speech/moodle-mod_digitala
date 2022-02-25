#!/bin/bash
echo $(ls)
old_version=$(cat version.php | grep '$plugin->version = ')
old_version=${old_version/\$plugin->version = /}
old_version=${old_version/;/}

new_version=$((old_version + 1))

sed -i "s+${old_version}+${new_version}+g" version.php

echo 'Updated plugin version from '${old_version}' to '${new_version}