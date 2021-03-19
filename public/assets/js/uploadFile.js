$(document).ready(function(){
    $("#fileImg").change(function(){
        readURL(this);
    });
    $(".btn-pilihFile").click(function(){
        $("#fileImg").click();
    });
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (event) {
            $('#wizardPicturePreview').attr('src', event.target.result).fadeIn('slow');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function checkIfFileLoaded(fileName) {
    $('img').load(fileName, function(response, status, xhr) {
        if (status == "error") {
            $(this).attr('src', '../../assets/img/camera-add.png');
        } else {
            $(this).attr('src', fileName);
        }
    });
}