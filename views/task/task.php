<div class="thumbnail">
    <p>
        <b>username:</b> <?= $task->username ?>
        <b>email:</b> <?= $task->email ?>
        <?php if ($task->completed): ?>
            <span class="text-success">[completed]</span>
        <?php endif; ?>
    </p>

    <?php if (!empty($task->image_path)): ?>
        <img src="/tasks/<?= $task->id?>/image" alt="image">
    <?php endif; ?>

    <div class="caption">

        <p> <?= $this->escape($task->content)?></p>

        <?php if ($request->user()): ?>
        <p>
            <button data-id="<?= $task->id ?>" class="task-edit btn btn-default">Edit</button>

            <?php if (!$task->completed): ?>
                <button data-id="<?= $task->id ?>" class="task-complete btn btn-default">Complete</button>
            <?php endif; ?>

        </p>
        <?php endif; ?>
    </div>

</div>