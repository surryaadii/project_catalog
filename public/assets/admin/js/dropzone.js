Dropzone.autoDiscover = false
$(document).ready(function () {
    let myDropzone = { 
        uploadMultiple: false,
        parallelUploads: 2,
        maxFilesize: 16,
        // previewTemplate: $('#preview-template').html(),
        // addRemoveLinks: true,
        // dictRemoveFile: 'Remove file',
        // dictRemoveFileConfirmation:  "Are you sure you want to delete this file?",
        acceptedFiles: 'image/*',
        dictFileTooBig: 'File is larger than 16MB',
        timeout: 10000,
        headers: {
            'Authorization': `Bearer ${getCookie('auth_token')}`,
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        init: function () {
            let $this = this
            $this.on("error", function(file) {
                file._retryButton = Dropzone.createElement(
                    `<a class="dz-retry" href="javascript:undefined;" data-dz-retry>Retry</a>`
                    );
                file._deleteButton = Dropzone.createElement(
                    `<a class="dz-delete" href="javascript:undefined;" data-dz-delete>Remove</a>`
                )
                file.previewElement.appendChild(file._retryButton);
                file.previewElement.appendChild(file._deleteButton);
                file._deleteButton.addEventListener("click", function() {
                    $this.removeFile(file)
                })

                file._retryButton.addEventListener("click", function() {
                    //make queued file
                    file.status = Dropzone.QUEUED;
                    $this.processQueue();
                    $(file.previewElement).find('.dz-retry').remove()
                    $(file.previewElement).find('.dz-delete').remove()
                })
            })
            var oTable = $(table).DataTable()
            this.on('queuecomplete', function(file) {
                oTable.ajax.reload()
              });
        },
        success: function (file, $request) {
            console.log(file)
        }
    };
    new Dropzone("#my-dropzone", myDropzone);
})
