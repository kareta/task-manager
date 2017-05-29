<?php include $this->basePath() .  'common/header.php' ?>

<h1 class="text-center">Task Manager</h1>

<?php include $this->basePath() . 'task/create.php' ?>

<div class="tasks-list">
    <?php if (!empty($tasks)): ?>
        <?php include $this->basePath() . 'task/list.php' ?>
    <?php endif; ?>
</div>

<?php include $this->basePath() . 'task/preview-modal.php' ?>

<?php include $this->basePath() .  'common/footer.php' ?>
