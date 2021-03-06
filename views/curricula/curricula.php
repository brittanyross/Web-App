<?php
/**
 * PEP Capping 2017 Algozzine's Class
 *
 * Page that displays the current curricula.
 *
 * This page displays curricula in a grid-like view
 * where users can then view, edit, or delete
 * curricula that appear. Superusers can view archived
 * curricula and restore them or fully delete them.
 *
 * @author Jack Grzechowiak
 * @copyright 2017 Marist College
 * @version 0.3.2
 * @since 0.1
 */

global $params, $route, $view;

include ('../models/Notification.php');

$pages = ['view','edit','create','delete','restore'];

# Update page title to reflect route
if (!empty($params) && in_array($params[0], $pages)) {
    $newTitle = $params[0];
    $route['title'] .= ' - ' . strtoupper($newTitle[0]) . strtolower(substr($newTitle, 1));
}

# Select page to display
if (!empty($params) && $params[0] == 'view') {
    $view->display('curricula/curricula_view.php');
} else if (!empty($params) && $params[0] == 'edit') {
    $view->display('curricula/curricula_modify.php');
} else if (!empty($params) && $params[0] == 'create') {
    $view->display('curricula/curricula_modify.php');
} else if (!empty($params) && $params[0] == 'delete') {
    $view->display('curricula/curricula_archive.php');
} else {
    include('header.php');
    global $db;

    $filter = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $filter = isset($_POST['filter']) ? "%" . $_POST['filter'] . "%" : "%%";
        $result = $db->query("SELECT * FROM curricula WHERE LOWER(curriculumname::text) LIKE LOWER($1) " .
            "OR LOWER(curriculumtype::text) LIKE LOWER($1) ORDER BY curriculumname", [$filter]);
    } else {
        $result = $db->query("SELECT * FROM curricula ORDER BY curriculumname", []);
    }

    ?>
    <div style="width: 100%">
        <?php
        if (isset($_SESSION['delete-success']) && $_SESSION['delete-success']) {
            $notification = new Notification('Success!', 'Curriculum was successfully deleted!', 'success');
            $notification->display();
            unset($_SESSION['delete-success']);
        }
        ?>
        <div id="curriculum-btn-group" class="input-group">
            <?php if (hasRole(Role::Coordinator)) { ?>
                <a id="new-curriculum-btn" href="/curricula/create">
                    <button class="cpca btn"><i class="fa fa-plus"></i> Create Curriculum</button>
                </a>
            <?php
            }
            if (hasRole(Role::Superuser)) {
            ?>
                <a id="restore-curriculum-btn" class="ml-3" href="/curricula/restore">
                    <button class="btn-outline-secondary btn"><i class="fa fa-repeat"></i> Restore</button>
                </a>
            <?php } ?>
        </div><br />

        <form id="curriculum-filter" action="/curricula" method="post" class="input-group" style="max-width: 500px; width: 100%; margin: 0 auto">
            <input type="text" class="form-control" placeholder="Filter for..." name="filter" value="<?= str_replace('%', '', $filter) ?>">
            <span class="input-group-btn">
                <button class="btn btn-secondary" type="submit">Search</button>
            </span>
        </form>
        <br />
        <div class="d-flex flex-row justify-content-center flex-wrap">
            <?php
            while ($r = pg_fetch_assoc($result)) {
                ?>
                <div class="card text-center result-card">
                    <div class="card-body">
                        <h4 class="card-title"><?= $r['curriculumname'] ?></h4>
                        <h6 class="card-subtitle text-muted"><?= $r['curriculumtype'] ?></h6>
                    </div>
                    <div class="card-footer d-flex flex-row justify-content-center">
                        <a href="/curricula/view/<?= $r['curriculumid'] ?>">
                            <button class="btn btn-outline-secondary btn-sm ml-2">View</button>
                        </a>
                        <?php if (hasRole(Role::Coordinator)) { ?>
                            <a href="/curricula/edit/<?= $r['curriculumid'] ?>">
                                <button class="btn btn-outline-secondary btn-sm ml-2">Edit</button>
                            </a>
                            <a href="/curricula/delete/<?= $r['curriculumid'] ?>">
                                <button class="btn btn-outline-danger btn-sm ml-2">Delete</button>
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <script>
        $(function() {
            showTutorial('curriculum');
        });
    </script>

    <?php
    include('footer.php');
}
?>