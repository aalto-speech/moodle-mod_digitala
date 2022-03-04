// Standard license block omitted.
/*
 * @module     mod_digitala/navigation
 * @copyright  2022 Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

let button1;
let button2;
let url = window.location.href;
let idx = url.search('id');
let newUrl = url.slice(0, idx);

export const initializeNavbuttons = (courseid, digitalaid, pagenum) => {
    switch (pagenum) {
        case 0:
            button1 = document.getElementById('nextButton');
            button1.onclick = () => {
                newUrl = newUrl.concat('', 'id=', courseid, '&d=', digitalaid, '&page=1');
                window.location = newUrl;
            };
            break;

        case 1:
            button1 = document.getElementById('prevButton');
            button2 = document.getElementById('id_submitbutton');
            button1.onclick = () => {
                newUrl = newUrl.concat('', 'id=', courseid, '&d=', digitalaid, '&page=0');
                window.location = newUrl;
            };
            break;

        case 2:
            button1 = document.getElementById('tryAgainButton');
            button2 = document.getElementById('feedbackButton');
            button1.onclick = () => {
                newUrl = newUrl.concat('', 'id=', courseid, '&d=', digitalaid, '&page=0');
                window.location = newUrl;

            };
            button2.onclick = () => {
                window.open('https://educationhelsinki.eu.qualtrics.com/jfe/form/SV_9Lw5rKlwlpuFcWO', '_blank');
            };
            break;
    }
};