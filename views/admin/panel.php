<?php if ($request->user()): ?>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="">Admin panel</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href=""> Hello, <?= $request->user()->name ?></a>
                </li>
                <li>
                    <a href="/auth/logout">
                        <span class="glyphicon glyphicon-log-out"></span> Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>
<?php endif; ?>