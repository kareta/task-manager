
<h2 class="text-center">Tasks List</h2>

<div class="form-inline text-center"">
    <label for="order">Order</label>
    <select class="form-control" id="order">

        <?php
            $options = ['none', 'username', 'email', 'uncompleted first'];

            foreach ($options as $option) {
                if ($order == $option) {
                    echo "<option selected>$option</option>";
                } else {
                    echo "<option>$option</option>";
                }
            }
        ?>

    </select>
</div>


<?php include $this->basePath() . '/common/pagination.php'?>

<ul class="list-unstyled">

    <?php foreach ($tasks as $task): ?>

        <li>
            <div class="task" data-id="<?= $task->id ?>">
                <?php include $this->basePath() . 'task/task.php'?>
            </div>
        </li>

    <?php endforeach; ?>
</ul>

<?php include $this->basePath() . 'common/pagination.php'?>
