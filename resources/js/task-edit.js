
$(function () {
    $('.task-edit').on('click', handleTaskEdit);
    $('.task-complete').on('click', handleTaskComplete);
});

function handleTaskEdit(event)
{
    event.preventDefault();
    $('.task-errors').html('');

    var taskId = $(event.target).attr('data-id');

    $.ajax({
        url: '/tasks/' + taskId + '/edit', type: 'get',
        success: function (response) {
            handleTaskEditSuccess(response, taskId)
        },
        error: handleTaskEditError,
    });
}

function handleTaskEditSuccess(response, taskId)
{
    $(".task[data-id='" + taskId + "']" ).html(response);
    $(".task[data-id='" + taskId + "'] .task-content-editable").height( $('.task-content-editable')[0].scrollHeight );
    $(".task[data-id='" + taskId + "'] .task-save").on('click', handleTaskSave);
    $(".task[data-id='" + taskId + "'] .task-complete").on('click', handleTaskComplete);
}

function handleTaskEditError(response)
{

}

function handleTaskComplete(event)
{
    event.preventDefault();
    $('.task-errors').html('');

    var taskId = $(event.target).attr('data-id');

    $.ajax({
        url: '/tasks/' + taskId + '/complete', type: 'get',
        success: function (response) {
            handleTaskCompleteSuccess(response, taskId)
        },
        error: handleTaskCompleteError,
    });
}

function handleTaskCompleteSuccess(response, taskId)
{

    $(".task[data-id='" + taskId + "']" ).html(response);
    $(".task[data-id='" + taskId + "'] .task-edit").on('click', handleTaskEdit);
    $(".task[data-id='" + taskId + "'] .task-complete").on('click', handleTaskComplete);
}

function handleTaskCompleteError(response)
{

}

function handleTaskSave(event)
{
    event.preventDefault();

    $('.task-errors').html('');

    var taskId = $(event.target).attr('data-id');

    var fileData = $(".task-image-editable[data-id='" + taskId + "']").prop('files')[0];
    var formData = new FormData();
    formData.append('image', fileData);

    var content = $(".task[data-id='" + taskId + "'] .task-content-editable").val();
    formData.append('content', content.trim());

    $.ajax({
        url: '/tasks/' + taskId + '/edit', data: formData, type: 'post',
        cache: false, contentType: false, processData: false,
        success: function (response) {
            handleTaskSaveSuccess(response, taskId)
        },
        error: function (response) {
            handleTaskSaveError(response, taskId)
        },
    });
}

function handleTaskSaveSuccess(response, taskId)
{
    $(".task[data-id='" + taskId + "']" ).html(response);
    $(".task[data-id='" + taskId + "'] .task-edit").on('click', handleTaskEdit);
    $(".task[data-id='" + taskId + "'] .task-complete").on('click', handleTaskComplete);
}

function handleTaskSaveError(response, taskId)
{
    $(".task[data-id='" + taskId + "'] .thumbnail").prepend(response.responseText);
}