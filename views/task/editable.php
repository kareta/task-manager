<div class="thumbnail">
    <p>
        <b>username:</b> <?= $task->username ?>
        <b>email:</b> <?= $task->email ?>

        <?php if ($task->completed): ?>
            <span class="text-success">[completed]</span>
        <?php endif; ?>
    </p>

    <?php if (!empty($task->image_path)): ?>
        <img src="/tasks/<?= $task->id ?>/image" alt="image">
    <?php endif; ?>

    <div class="caption">
        <div class="form-group" >
            <label for="task-image-editable" class="file-label" >Change the image</label>
            <input class="task-image-editable" data-id="<?= $task->id ?>" type="file" name="image" >
        </div>

        <textarea class="form-control task-content-editable"><?= $this->escape($task->content) ?></textarea>

        <p>
            <button data-id="<?= $task->id ?>" class="task-save btn btn-default">Save</button>
            <?php if (!$task->completed): ?>
                <button data-id="<?= $task->id ?>" class="task-complete btn btn-default">Complete</button>
            <?php endif; ?>
        </p>
    </div>

</div>