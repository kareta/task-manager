
$(function () {
    $('#task-preview').on('click', handleTaskPreview);
});

function handleTaskPreview(event)
{
    event.preventDefault();
    $('.task-errors').html('');

    var fileData = $('#task-image').prop('files')[0];
    var formData = new FormData();
    formData.append('image', fileData);
    formData.append('username', $('#task-username').val());
    formData.append('email', $('#task-email').val());
    formData.append('content', $('#task-content').val());

    $.ajax({
        url: '/tasks/preview', data: formData, type: 'post',
        cache: false, contentType: false, processData: false,
        success: handleTaskPreviewSuccess,
        error: handleTaskPreviewError,
    });
}

function handleTaskPreviewSuccess(response)
{
    var previewModal = $('#preview-modal');

    previewModal.modal('toggle');
    $('.modal-body').append(response);

    previewModal.on('hidden.bs.modal', function () {
        $('.modal-body').html('');
    });
}

function handleTaskPreviewError(response)
{
    $('#task-form').before(response.responseText);
}