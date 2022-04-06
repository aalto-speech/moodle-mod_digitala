#!/bin/bash

version=$(cat digitala/version.php | grep '$plugin->version = ')
version=${version/\$plugin->version = /}
version=${version/;/}

release=$(cat digitala/version.php | grep '$plugin->release = ')
release=${release/\$plugin->release = /}
release=${release/;/}
release=${release//\'/}
release_line=${release//./-}

echo "version=${version}" >> $GITHUB_ENV
echo "release=${release}" >> $GITHUB_ENV
echo "release_line=${release_line}" >> $GITHUB_ENV

rm -rf digitala/scripts
rm -rf digitala/docs
rm -rf digitala/.github
rm -rf digitala/.git

zip -r moodle-mod-digitala-${release_line}-${version}.zip digitala