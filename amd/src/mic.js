// Standard license block omitted.
/*
 * @module     mod_digitala/mic
 * @copyright  2022 Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
import RecordRTC from 'RecordRTC';
import mdlcfg from 'core/config';
import {get_strings as getStrings} from 'core/str';

let recorder;
const recButton = document.getElementById('record');
const listenButton = document.getElementById('listen');
let audio;
let langStrings;
let pagenum;
let assignmentId;
let userId;
let username;
let maxLength;
let timeout;

const startRecording = () => {
    navigator.mediaDevices.getUserMedia({audio: true})
    .then(stream => {
        const options = {
            audioBitsPerSecond: 16000,
            type: 'audio',
            recorderType: RecordRTC.StereoAudioRecorder,
            mimeType: 'audio/wav',
            numberOfAudioChannels: 1,
            disableLogs: true
        };
        recorder = new RecordRTC(stream, options);

        recorder.startRecording();
        window.console.log('Digitala: Started to record');

        recButton.textContent = langStrings[1];
        recButton.onclick = stopRecording;
        listenButton.disabled = true;

        timeout = setTimeout(stopRecording, maxLength * 100);
        return;
    })
    .catch((err) => {
        window.console.error(err);
    });
};

const stopRecording = () => {
    if (recorder.getState() === "recording") {
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
                    if (event.target.readyState === 4) {
                        document.forms.answerrecording[0].value = event.target.response;
                        document.getElementById('id_submitbutton').style.display = '';
                    }
                });
                req.send(form);
            }
            recButton.textContent = langStrings[0];
            recButton.onclick = startRecording;
            listenButton.disabled = false;
            clearTimeout(timeout);
        });
        window.console.log('Digitala: Recording stopped');
    }



};

const listenRecording = () => {
    const microphoneIcon = document.getElementById('microphoneIconBox');
    if (audio !== undefined) {
        audio.play();
        if (pagenum === 0) {
            microphoneIcon.style.border = '2.5px dashed green';
        }

    } else {
        if (pagenum === 0) {
            microphoneIcon.style.border = '2.5px dashed red';
        }

    }
};

export const initializeMicrophone = async(pagenumIn, assignmentIdIn, userIdIn, usernameIn, maxLengthIn) => {
    window.console.log('Digitala: Starting to initalize microphones');

    pagenum = pagenumIn;
    assignmentId = assignmentIdIn;
    userId = userIdIn;
    username = usernameIn;
    maxLength = maxLengthIn;
    langStrings = await getStrings(
        [
            {
                key: 'startbutton-again',
                component: 'digitala'
            },
            {
                key: 'stopbutton',
                component: 'digitala'

            }
        ]
    );

    if (pagenum !== 2) {
        recButton.onclick = startRecording;
        listenButton.onclick = listenRecording;
    }
};