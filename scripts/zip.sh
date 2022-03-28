#!/bin/bash

version=$(cat version.php | grep '$plugin->version = ')
version=${version/\$plugin->version = /}
version=${version/;/}

release=$(cat version.php | grep '$plugin->release = ')
release=${release/\$plugin->release = /}
release=${release/;/}
release=${release//\'/}
release_dot=${release//./-}

echo "version=${version}" >> $GITHUB_ENV
echo "release=${release}" >> $GITHUB_ENV
echo "release_dot=${release_dot}" >> $GITHUB_ENV

rm -rf digitala/scripts
rm -rf digitala/.github
rm -rf digitala/.git

zip -r moodle-mod-digitala-${release_dot}-${version}.zip digitala