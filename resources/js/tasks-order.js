
$(function () {
    $(document.body).on('change', 'select', handleOrderChange);
});


function handleOrderChange(event)
{
    var select = $(event.target).val();
    $('task-errors').html('');

    $.ajax({
        url: '/tasks-list?order=' + select, type: 'get',
        success: handleTaskOrderChangeSuccess,
        error: handleTaskOrderChangeError,
    });

}

function handleTaskOrderChangeSuccess(response)
{
    $('.tasks-list').html(response);
    $('.task-edit').on('click', handleTaskEdit);
    $('.task-complete').on('click', handleTaskComplete);
}

function handleTaskOrderChangeError(response)
{

}
