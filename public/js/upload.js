$(document).on('ready', function() {
    $("#input-44").fileinput({
        uploadUrl: '/file-upload-batch/2',
        maxFilePreviewSize: 10240,
        maxFileCount: 4,
    });
});
