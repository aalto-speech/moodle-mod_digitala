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
            //audioChunks = [];
            //rec.start();
        }
        if (stopRecord) {
            document.getElementById("record").disabled = false;
            document.getElementById("record").style.backgroundColor = "red";
            //record.style.backgroundColor = "red"
            //rec.stop();
        }
    });
};

/*
navigator.mediaDevices.getUserMedia({audio:true})
    .then(stream => {handlerFunction(stream)})


function handlerFunction(stream) {
    rec = new MediaRecorder(stream);
    rec.ondataavailable = e => {
        audioChunks.push(e.data);
        if (rec.state == "inactive"){
            let blob = new Blob(audioChunks,{type:'audio/mpeg-3'});
            recordedAudio.src = URL.createObjectURL(blob);
            recordedAudio.controls=true;
            recordedAudio.autoplay=true;
            sendData(blob)
        }
    }
}

function sendData(data) {}


record.onclick = e => {
    //console.log('I was clicked')
    record.disabled = true;
    record.style.backgroundColor = "blue"
    stopRecord.disabled=false;
    audioChunks = [];
    rec.start();
}

stopRecord.onclick = e => {
    //console.log("I was clicked")
    record.disabled = false;
    stop.disabled=true;
    record.style.backgroundColor = "red"
    rec.stop();
}
*/