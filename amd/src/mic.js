// Standard license block omitted.
/*
 * @module     mod_digitala/mic
 * @copyright  2022 Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

let recorder;
let isRecording = false;
let audioChunks = [];

const startStopRecording = () => {
    switch (isRecording) {
        case false:
            navigator.mediaDevices.getUserMedia({ audio: true })
                .then(stream => {
                    recorder = new MediaRecorder(stream);
                    isRecording = true;
                    audioChunks = [];
                    recorder.start();
                    window.console.log('started to record');

                    recorder.addEventListener("dataavailable", event => {
                        audioChunks.push(event.data);
                    });

                    recorder.addEventListener("stop", () => {
                        const audioBlob = new Blob(audioChunks);
                        const audioUrl = URL.createObjectURL(audioBlob);
                        const audio = new Audio(audioUrl);
                        window.console.log('audioUrl', audioUrl);
                        audio.play();
                    });
                });
            break;
        case true:
            isRecording = false;
            recorder.stop();
            window.console.log('recording stopped');
            break;
    }
};

export const initializeMicrophone = () => {
    const recButton = document.getElementById('record');
    const stopButton = document.getElementById('stopRecord');
    recButton.onclick = () => {
        recButton.style.backgroundColor = "blue";
        recButton.disabled = true;
        stopButton.disabled = false;
        startStopRecording();
    };
    stopButton.onclick = () => {
        recButton.style.backgroundColor = "red";
        recButton.disabled = false;
        stopButton.disabled = true;
        startStopRecording();
    };
};

export const init = () => {
    window.console.log('we have been started');
    //const button = document.getElementById('record');
};
/*
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
*/