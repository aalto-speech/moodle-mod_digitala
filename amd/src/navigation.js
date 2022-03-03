// Standard license block omitted.
/*
 * @module     mod_digitala/navigation
 * @copyright  2022 Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

let button1;
let button2;
let url = window.location.href;
let newUrl = url.slice(0, -1);

export const initializeNavbuttons = (pagenum) => {
    switch (pagenum) {
        case 0:
            button1 = document.getElementById('nextButton');
            button1.onclick = () => {
                newUrl = newUrl.concat('', '1');
                window.location = newUrl;
            };
            break;

        case 1:
            button1 = document.getElementById('prevButton');
            button1.onclick = () => {
                newUrl = newUrl.concat('', '0');
                window.location = newUrl;
            };
            break;

        case 2:
            button1 = document.getElementById('tryAgainButton');
            button2 = document.getElementById('feedbackButton');
            button1.onclick = () => {
                newUrl = newUrl.concat('', '0');
                window.location = newUrl;

            };
            button2.onclick = () => {
                window.open('https://educationhelsinki.eu.qualtrics.com/jfe/form/SV_9Lw5rKlwlpuFcWO', '_blank');
            };
            break;
    }
};