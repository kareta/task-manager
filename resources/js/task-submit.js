
$(function () {
    $('#task-submit').on('click', handleTaskSubmit);
});

function handleTaskSubmit(event)
{
    event.preventDefault();
    $('.task-errors').html('');

    var fileData = $('#task-image').prop('files')[0];
    var formData = new FormData();
    formData.append('image', fileData);
    formData.append('username', $('#task-username').val());
    formData.append('email', $('#task-email').val());
    formData.append('content', $('#task-content').val());
    formData.append('csrf_token', $('#task-form input[name="csrf_token"]').val());

    $.ajax({
        url: '/tasks', data: formData, type: 'post',
        cache: false, contentType: false, processData: false,
        success: handleTaskSubmitSuccess,
        error: handleTaskSubmitError,
    });
}

function handleTaskSubmitSuccess(response)
{
    clearTaskForm();
    $('.tasks-list').html(response);
    $('.task-edit').on('click', handleTaskEdit);
    $('.task-complete').on('click', handleTaskComplete);
}

function handleTaskSubmitError(response)
{
    $('#task-form').before(response.responseText);
}

function clearTaskForm()
{
    $('#task-form').find("input, textarea").val("");
}
