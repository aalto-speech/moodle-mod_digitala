// Standard license block omitted.
/*
 * @module     mod_digitala/mic
 * @copyright  2022 Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
import RecordRTC from 'RecordRTC';
import mdlcfg from 'core/config';

let recorder;
let isRecording = false;
let audio;

const startStopRecording = (pagenum, assignmentId, userId, username) => {
    switch (isRecording) {
        case false:
            navigator.mediaDevices.getUserMedia({audio: true})
                .then(stream => {
                    const options = {
                        audioBitsPerSecond: 16000,
                        type: 'audio',
                        recorderType: RecordRTC.StereoAudioRecorder,
                        mimeType: 'audio/wav',
                        numberOfAudioChannels: 1
                    };
                    recorder = new RecordRTC(stream, options);
                    isRecording = true;

                    recorder.startRecording();

                    return;
                })
                .catch((err) => {
                    window.console.error(err);
                });
            break;

        case true:
            isRecording = false;
            recorder.stopRecording(() => {
                const audioBlob = recorder.getBlob();

                const audioUrl = URL.createObjectURL(audioBlob);
                audio = new Audio(audioUrl);

                if (pagenum === 1) {
                    const form = new FormData();
                    form.append('repo_id', '5');
                    form.append('ctx_id', mdlcfg.contextid);
                    form.append('itemid', '0');
                    form.append('savepath', '/');
                    form.append('sesskey', mdlcfg.sesskey);
                    form.append('repo_upload_file', audioBlob,
                        `ans-${assignmentId}-${userId}-${username}-${new Date().valueOf()}.wav`);
                    form.append('overwrite', '1');

                    const req = new XMLHttpRequest();
                    req.open('POST', mdlcfg.wwwroot + '/repository/repository_ajax.php?action=upload');
                    req.addEventListener('readystatechange', (event) => {
                        document.forms.answerrecording[0].value = event.target.response;
                        document.getElementById('submitModalButton').style.display = '';
                    });
                    req.send(form);
                }
            });
            break;
    }
};

const listenRecording = () => {
    const microphoneIcon = document.getElementById('microphoneIconBox');
    if (audio !== undefined) {
        audio.play();
        microphoneIcon.style.border = '2.5px dashed green';
    } else {
        microphoneIcon.style.border = '2.5px dashed red';
    }
};

export const initializeMicrophone = (pagenum, assignmentId, userId, username) => {
    if (pagenum !== 2) {
        const recButton = document.getElementById('record');
        const stopButton = document.getElementById('stopRecord');
        const listenButton = document.getElementById('listenButton');
        listenButton.disabled = true;

        recButton.onclick = () => {
            recButton.disabled = true;
            stopButton.disabled = false;
            listenButton.disabled = true;
            recButton.style.display = 'none';
            stopButton.style.display = 'inline-block';
            startStopRecording(pagenum, assignmentId, userId, username);
        };
        stopButton.onclick = () => {
            recButton.disabled = false;
            stopButton.disabled = true;
            listenButton.disabled = false;
            recButton.style.display = 'inline-block';
            stopButton.style.display = 'none';
            startStopRecording(pagenum, assignmentId, userId, username);
        };
        listenButton.onclick = () => {
            listenRecording();
        };
    }
};