#!/bin/bash
cd ${1:-.}
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

old_release=$(cat version.php | grep '$plugin->release = ')
old_release=${old_release/\$plugin->release = /}
old_release=${old_release//\'/}
old_release=${old_release/;/}

x=$(echo "${old_release}" | cut -d'.' -f 1)
y=$(echo "${old_release}" | cut -d'.' -f 2)
z=$(echo "${old_release}" | cut -d'.' -f 3)

if [ $z -eq -1 ]
then
    z=0
else
    z=$((z + 1))
fi

new_release=${x}.${y}.${z}

sed -i "s+\$plugin->version = ${old_version}+\$plugin->version = ${new_version}+g" version.php
sed -i "s+\$plugin->release = '${old_release}+\$plugin->release = '${new_release}+g" version.php

echo "version=${new_version}" >> $GITHUB_ENV
echo "release=${new_release}" >> $GITHUB_ENV

echo 'Updated plugin version from '${old_release}' ('${old_version}') to '${new_release}' ('${new_version}')'