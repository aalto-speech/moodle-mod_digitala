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
                    window.console.log('started to record');

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
                window.console.log('audioBlob:', audioBlob);

                const audioUrl = URL.createObjectURL(audioBlob);
                audio = new Audio(audioUrl);
                window.console.log('audioUrl', audioUrl);

                if (pagenum === 1) {
                    window.console.log('fuu >', pagenum, assignmentId, userId, username);

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
                        window.console.log(event);
                        window.console.log(JSON.parse(event.target.response));
                        document.forms.answerrecording[0].value = event.target.response;
                        window.console.log('Enable submit button');
                        document.getElementById('id_submitbutton').style.display = '';
                    });
                    req.send(form);
                }
            });
            window.console.log(M.cfg);
            window.console.log('recording stopped');
            break;
    }
};

const listenRecording = () => {
    if (audio !== undefined) {
        audio.play();
    }
};

export const initializeMicrophone = (pagenum, assignmentId, userId, username) => {
    const recButton = document.getElementById('record');
    const stopButton = document.getElementById('stopRecord');
    const listenButton = document.getElementById('listenButton');
    stopButton.disabled = true;
    listenButton.disabled = true;

    window.console.log('page number', pagenum);

    recButton.onclick = () => {
        recButton.style.backgroundColor = "blue";
        recButton.disabled = true;
        stopButton.disabled = false;
        listenButton.style.display = 'none';
        startStopRecording(pagenum, assignmentId, userId, username);
    };
    stopButton.onclick = () => {
        recButton.style.backgroundColor = "red";
        recButton.disabled = false;
        stopButton.disabled = true;
        listenButton.disabled = false;
        listenButton.style.display = 'inline-block';
        startStopRecording(pagenum, assignmentId, userId, username);
    };
    listenButton.onclick = () => {
        listenRecording();
    };
};