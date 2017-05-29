<nav class="text-center">
    <ul class="pagination">

        <li class="page-item">
            <a class="page-link" href="<?= $paginator->firstLink() ?>">
                First
            </a>
        </li>

        <?php foreach ($paginator->links(3) as $page => $link): ?>
            <?php if ($page == $paginator->getPage()): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $link ?>">
                        <b><?= $page ?></b>
                    </a>
                </li>
            <?php else: ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $link ?>">
                        <?= $page ?>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>

        <li class="page-item">
            <a class="page-link" href="<?= $paginator->lastLink() ?>">
                Last
            </a>
        </li>
    </ul>
</nav>

