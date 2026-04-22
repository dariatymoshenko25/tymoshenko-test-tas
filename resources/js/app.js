import './bootstrap';
import jQuery from 'jquery';
window.$ = jQuery;

(function($) {
    $(document).ready(function () {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrfToken } });

        const uploadArea = $('#upload-area');
        const fileInput = $('#fileInput');
        const progressWrapper = $('#progressWrapper');
        const progressBar = $('#progressBar');
        const uploadStatus = $('#uploadStatus');

        fileInput.on('click', function(e) {
            e.stopPropagation();
        });

        uploadArea.on('click', () => fileInput.click());

        uploadArea.on('dragover dragenter', function(e) {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.addClass('dragover');
        });

        uploadArea.on('dragleave drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.removeClass('dragover');
        });

        uploadArea.on('drop', function(e) {
            const file = e.originalEvent.dataTransfer.files[0];
            if (file) handleFile(file);
        });

        fileInput.on('change', function(e) {
            const file = e.target.files[0];
            if (file) handleFile(file);
        });

        function handleFile(file) {
            if (!file) return;

            const allowedTypes = [
                'application/pdf',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];

            if (!allowedTypes.includes(file.type)) {
                alert('Only PDF and DOCX files are allowed.');
                return;
            }

            const MAX_SIZE = 10 * 1024 * 1024;
            if (file.size > MAX_SIZE) {
                alert('The file is too large. Maximum 10 MB.');
                return;
            }

            const formData = new FormData();
            formData.append('file', file);

            progressWrapper.removeClass('d-none');
            progressBar.css('width', '0%').removeClass('bg-danger').addClass('bg-primary');
            uploadStatus.text('Loading...').removeClass('text-danger text-success');

            $.ajax({
                url: '/upload',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function () {
                    const xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function (evt) {
                        if (evt.lengthComputable) {
                            const percent = Math.round((evt.loaded / evt.total) * 100);
                            progressBar.css('width', percent + '%').text(percent + '%');
                        }
                    });
                    return xhr;
                },
                success: function (res) {
                    uploadStatus.text(res.message || 'Success!').addClass('text-success');
                    reloadFiles();
                    resetUploader();
                },
                error: function (xhr) {
                    let errMsg = 'Loading error';
                    if (xhr.responseJSON?.errors?.file) {
                        errMsg = xhr.responseJSON.errors.file[0];
                    } else if (xhr.responseJSON?.message) {
                        errMsg = xhr.responseJSON.message;
                    }
                    uploadStatus.text(errMsg).addClass('text-danger');
                    progressBar.css('width', '100%').addClass('bg-danger');
                    resetUploader();
                }
            });
        }

        function resetUploader() {
            setTimeout(() => {
                progressWrapper.addClass('d-none');
                progressBar.css('width', '0%').removeClass('bg-danger bg-success bg-primary').text('');
                uploadStatus.text('').removeClass('text-success text-danger');
                fileInput.val('');
            }, 1000);
        }

        function reloadFiles(page = null) {
            let url = '/files/list';

            if (page) {
                url += `?page=${page}`;
            }

            $.get(url, function (html) {
                $('#filesContainer').replaceWith(html);
            });
        }

        $(document).on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            const row = $(`tr[data-id="${id}"]`);

            if (!confirm('Should I delete this file?')) return;

            $.ajax({
                url: `/files/${id}`,
                type: 'DELETE',
                success: () => {
                    reloadFiles();
                },
                error: () => alert('Failed to delete file')
            });
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();

            const url = $(this).attr('href');
            const page = new URL(url).searchParams.get('page');

            reloadFiles(page);
        });
    });
})(jQuery);
