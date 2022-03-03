// Standard license block omitted.
/*
 * @module     mod_digitala/navigation
 * @copyright  2022 Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

let button1;
let button2;

export const initializeNavbuttons = (pagenum) => {
    switch (pagenum) {
        case 0:
            button1 = document.getElementById('nextButton');
            button1.onclick = () => {
            window.console.log('page number from button', pagenum);
            };
            break;

        case 1:
            button1 = document.getElementById('prevButton');
            button1.onclick = () => {
            window.console.log('page number from button', pagenum);
            };
            break;

        case 2:
            button1 = document.getElementById('tryAgainButton');
            button2 = document.getElementById('feedbackButton');
            button1.onclick = () => {
                window.console.log('You wanna try again?');
            };
            button2.onclick = () => {
                window.console.log('Your feedback received');
            };
            break;
    }
};