// Standard license block omitted.
/*
 * @module     mod_digitala/mic
 * @copyright  2022 Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

let recorder;
let isRecording = false;
let audioChunks = [];
let audio;

const startStopRecording = () => {
    switch (isRecording) {
        case false:
            navigator.mediaDevices.getUserMedia({audio: true})
                .then(stream => {
                    recorder = new MediaRecorder(stream);
                    isRecording = true;
                    audioChunks = [];
                    recorder.start();
                    window.console.log('started to record');

                    recorder.addEventListener("dataavailable", event => {
                        audioChunks.push(event.data);
                    });

                    recorder.addEventListener('stop', () => {
                        const audioBlob = new Blob(audioChunks);
                        const audioUrl = URL.createObjectURL(audioBlob);
                        audio = new Audio(audioUrl);
                        window.console.log('audioUrl', audioUrl);
                    });
                    return;
                })
                .catch((err) => {
                    window.console.error(err);
                });
            break;

        case true:
            isRecording = false;
            recorder.stop();
            window.console.log('recording stopped');
            break;
    }
};

const listenRecording = () => {
    if (audio !== undefined) {
        audio.play();
    }
};

export const initializeMicrophone = () => {
    const recButton = document.getElementById('record');
    const stopButton = document.getElementById('stopRecord');
    const listenButton = document.getElementById('listenButton');
    stopButton.disabled = true;
    listenButton.disabled = true;

    recButton.onclick = () => {
        recButton.style.backgroundColor = "blue";
        recButton.disabled = true;
        stopButton.disabled = false;
        listenButton.style.display = 'none';
        startStopRecording();
    };
    stopButton.onclick = () => {
        recButton.style.backgroundColor = "red";
        recButton.disabled = false;
        stopButton.disabled = true;
        listenButton.disabled = false;
        listenButton.style.display = 'inline-block';
        startStopRecording();
    };
    listenButton.onclick = () => {
        listenRecording();
    };
};