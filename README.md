# Digitala ![Digitala plugin logo](/pix/icon.svg)

[![Moodle Plugin CI for Moodle 3.9 and 3.11](https://github.com/aalto-speech/moodle-puheentunnistus/actions/workflows/ci_moodle.yml/badge.svg)](https://github.com/aalto-speech/moodle-puheentunnistus/actions/workflows/ci_moodle.yml)[![codecov](https://codecov.io/gh/aalto-speech/moodle-puheentunnistus/branch/main/graph/badge.svg?token=TC3ZZJNEQO)](https://codecov.io/gh/aalto-speech/moodle-puheentunnistus)


Digitala is a Moodle plugin for making automatically assessed speech assignments in Finnish and Swedish. Students' speech performances are sent from the plugin to an evaluation API designed and built by Aalto University. Digitala-plugin is a part of the [DigiTala research project](https://www2.helsinki.fi/fi/unitube/video/3275014c-49bf-4583-befc-840128521998) and is constructed by Bachelor level Computer Science students during spring 2022 in the University of Helsinki (documentation and files related solely to the university project can be found in the [project docs](/docs/project_docs/)).

The basic usage of Digitala is shown in a [short introduction video](/).

## Installation

Download the latest release from the GitHub [releases](./releases). As an admin in Moodle, navigate to *Site administration -> Plugins -> Install plugins* page and place the downloaded zip-file in the given field.

If you're running Moodle locally or have otherwise access to the Moodle file system, you can navigate to *moodle/mod/* and clone this project via command line with ```git clone https://github.com/aalto-speech/moodle-puheentunnistus.git```. Change the project name to "digitala".

After installation you'll be prompted to give the address and key to the evaluation API which can be received from Aalto. These are defaulted to a mock server which will always give the same evaluations. You can also provide a link for users of the activity for gathering user axperiences.

## Upgrade

Download and install the latest [release](./releases). Locally you can update the cloned "digitala"-project in the project folder by pulling the latest version in main branch with ```git pull```.

## Manuals for different user roles

Manuals can be found in [documentation folder](/docs/manuals/user_roles.md).

## License

[GNU General Public License v3.0](/LICENSE)
