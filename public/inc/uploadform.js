//uploadform
var output = document.getElementById('preview');
var fileToUpload = document.getElementById('fileToUpload');
var accept = document.getElementById('accept');
var uploadbtn = document.getElementById('uploadbtn');

function loadFile(event) {
	output.src = URL.createObjectURL(event.target.files[0]);
	output.style.display="block";
	accept.style.display="block";
	uploadbtn.style.display="none";
};

function deleteimg() {
	output.src = "";
	output.style.display="none";
	accept.style.display="none";
	fileToUpload.value = "";
	uploadbtn.style.display="block";
}

/*
if(empty($_FILES['file']['name'][0]))
{
     //checking whether a single file uploaded or not
     //if enters here means no file uploaded
}
*/