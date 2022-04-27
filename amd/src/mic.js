// Standard license block omitted.
/*
 * @module     mod_digitala/mic
 * @copyright  2022 Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/* eslint-disable no-nested-ternary */

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
let interval;
let sec;

const convertSecondsToString = (seconds) => {
    let hours = Math.floor(seconds / 3600);
    let minutes = Math.floor((seconds - (hours * 3600)) / 60);
    let second = Math.floor(seconds - (hours * 3600) - (minutes * 60));

    hours = hours === 0
        ? ''
        : hours < 10
            ? `0${hours}:`
            : `${hours}:`;
    minutes = minutes < 10 ? `0${minutes}` : `${minutes}`;
    second = second < 10 ? `0${second}` : `${second}`;

    return `${hours}${minutes}:${second}`;
};

const startRecording = async() => {
    const notGranted = (await navigator.mediaDevices.enumerateDevices())[0].label === '';
    if (notGranted) {
        try {
            navigator.mediaDevices.getUserMedia({audio: true});
            recButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true">'
            + '</span><span class="sr-only">' + langStrings[2] + '</span>';
        } catch {
            recButton.textContent = langStrings[3];
            return;
        }
    }

    clearTimeout(timeout);
    clearInterval(interval);

    if (navigator.mediaDevices !== undefined) {
        navigator.mediaDevices.getUserMedia({audio: true})
        .then(stream => {
            const options = {
                audioBitsPerSecond: 16000,
                desiredSampRate: 16000,
                type: 'audio',
                recorderType: RecordRTC.StereoAudioRecorder,
                mimeType: 'audio/wav',
                numberOfAudioChannels: 1,
                disableLogs: true
            };
            recorder = new RecordRTC(stream, options);

            recorder.startRecording();

            recButton.innerHTML = '<span>' + langStrings[1] + '</span> ' + document.getElementById('stopIcon').innerHTML;
            recButton.onclick = stopRecording;
            listenButton.disabled = true;

            sec = 0;
            interval = setInterval(() => {
                sec += 1;
                document.getElementById('recordingLength').textContent = convertSecondsToString(sec);
            }, 1000);

            if (pagenum == 1 && maxLength != 0) {
                timeout = setTimeout(() => {
                    stopRecording();
                }, maxLength * 1000);
            }
            return;
        })
        .catch(() => {
            recButton.textContent = langStrings[3];
        });
    } else {
        recButton.textContent = langStrings[3];
        return;
    }
};

const stopRecording = () => {
    if (recorder.getState() === 'recording') {

        recorder.stopRecording(() => {
            clearTimeout(timeout);
            clearInterval(interval);
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
                        if (event.target.status === 200) {
                            document.forms.answerrecording[0].value = event.target.response;
                            document.forms.answerrecording[1].value = sec;
                            document.getElementById('submitModalButton').style.display = '';
                        } else {
                            document.getElementById('submitErrors').innerHTML = langStrings[4];
                        }
                    }
                });
                req.send(form);
            }
            recButton.innerHTML = '<span>' + langStrings[0] + '</span> ' + document.getElementById('startIcon').innerHTML;
            recButton.onclick = startRecording;
            listenButton.disabled = false;
        });
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

            },
            {
                key: 'startbutton-loading',
                component: 'digitala'

            },
            {
                key: 'startbutton-error',
                component: 'digitala'
            },
            {
                key: 'error-save-recording',
                component: 'digitala'
            }
        ]
    );

    try {
        recButton.onclick = startRecording;
        listenButton.onclick = listenRecording;
    } catch (e) {
        return;
    }
};
