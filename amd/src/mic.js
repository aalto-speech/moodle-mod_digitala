// Standard license block omitted.
/*
 * @module     mod_digitala/mic
 * @copyright  2022 Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

export const init = () => {
    document.addEventListener('click', e => {
        const record = e.target.closest('.record');
        const stopRecord = e.target.closest('.stopRecord');
        if (record) {
            record.disabled = true;
            record.style.backgroundColor = "blue";
            document.getElementById("stopRecord").disabled = false;

        }
        if (stopRecord) {
            document.getElementById("record").disabled = false;
            document.getElementById("record").style.backgroundColor = "red";
        }
    });
};