import EM from 'EventEmitter';
export let em;
var upload_path = "";
export function Init(el, url) {
    em = new EM();
    upload_path = url;

    el.addEventListener("dragover", FileDragHover, false);
    el.addEventListener("dragleave", FileDragHover, false);
    el.addEventListener("drop", FileSelectHandler, false);
}

function FileDragHover(e) {
    e.stopPropagation();
    e.preventDefault();
    if (e.type == "dragover")
        e.target.classList.add("hover");
    else
        e.target.classList.remove("hover");
}

function FileSelectHandler(e) {
    e.stopPropagation();
    e.preventDefault();
    FileDragHover(e);

    var files = e.target.files || e.dataTransfer.files;

    if(!files || !files.length)
        return;

    let file = files[0];

    if (file.type.indexOf("image") == -1) {
        em.emit("nonimage", file.name);
        return;
    }

    var reader = new FileReader();
    reader.onload = function (e) {
        em.emit("loaded", file, e.target.result);
        UploadFile(file);
    }
    reader.readAsDataURL(file);
}

function UploadFile(file){
    var xhr = new XMLHttpRequest();
    // && file.size <= $id("MAX_FILE_SIZE").value
    // if (xhr.upload && file.type == "image/jpeg") {
    xhr.upload.addEventListener("progress", function(progressEvent) {
        var per = progressEvent.loaded / progressEvent.total * 100;
        console.log(per);
        em.emit("progress", per);
    }, false);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            const data = xhr.responseText;
            console.log( xhr.status == 200 && data != null);
            em.emit("complete", xhr.status == 200 && data != null, data);
        }
    };

    // start upload
    xhr.open("POST", upload_path, true);
    xhr.setRequestHeader("X-FILENAME", file.name.replace(/ /g, "_"));
    xhr.send(file);
}