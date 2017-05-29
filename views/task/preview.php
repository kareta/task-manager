
<div class="thumbnail">
    <p>
        <b>username:</b> <?= $this->escape($task->username) ?>
        <b>email:</b> <?= $this->escape($task->email) ?>

        <?php if ($task->completed): ?>
            <span class="text-success">[completed]</span>
        <?php endif; ?>
    </p>

    <?php if (isset($task->image_path)): ?>
        <img src="/tasks/preview-image" alt="image">
    <?php endif; ?>


    <div class="caption">

        <p>
            <?= $this->escape($task->content) ?>
        </p>

    </div>

</div>