<?php
/**
 * PEP Capping 2017 Algozzine's Class
 *
 * Displays a page to allow class additions to curricula.
 *
 * This page provides various sections to allow an
 * admin to edit details about a curriculum's classes.
 * Once the form is filled out, if there are any errors, they will
 * be displayed upon submission.
 *
 * @author Jack Grzechowiak
 * @copyright 2017 Marist College
 * @version 0.3.3
 * @since 0.3.3
 */

global $params, $db;

array_shift($params);
$curriculaName = rawurldecode(implode('/', $params));

$db->prepare("get_curr_classes", "SELECT * FROM curriculumclasses WHERE curriculumname = $1 ORDER BY topicname");
$db->prepare("get_other_classes",
    "SELECT * FROM classes WHERE topicname NOT IN (" .
    "SELECT topicname FROM curriculumclasses WHERE curriculumname = $1" .
    ") AND df = 0 ORDER BY topicname");

$topics = $db->execute("get_curr_classes", [$curriculaName]);
$allTopics = $db->execute("get_other_classes", [$curriculaName]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class = isset($_POST['class']) ? $_POST['class'] : '';

    // remove class
    if (isset($_POST['remove'])) {
        $res = $db->query("DELETE FROM curriculumclasses WHERE topicname = $1 AND curriculumname = $2",
            [$class, $curriculaName]);
        if ($res) {
            $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
            if ($state == 0) {
                $note['title'] = 'Success!';
                $note['msg'] = 'Class was successfully removed from the curriculum.';
                $note['type'] = 'success';
                # Refresh display
                $topics = $db->execute("get_curr_classes", [$curriculaName]);
                $allTopics = $db->execute("get_other_classes", [$curriculaName]);
            } else if ($state == "23503") { // foreign key error
                if (!hasRole(Role::Superuser)) {
                    $note['title'] = 'Error!';
                    $note['msg'] = "You do not have permission to remove this class.";
                    $note['type'] = 'danger';
                } else {
                    $confirmDelete = true;
                }
            } else {
                $note['title'] = 'Error!';
                $note['msg'] = "Class wasn't removed from the curriculum. [$state]";
                $note['type'] = 'danger';
            }
        }
    }
    // remove class with foreign key issue
    else if (isset($_POST['full-delete']) && hasRole(Role::Superuser)) {
        $errorState = "";
        // Delete from Participant Class Attendance
        $res = $db->query("DELETE FROM participantclassattendance ".
            "WHERE topicname = $1 AND curriculumname = $2 ", [$class, $curriculaName]);
        $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
        if ($state != 0) {
            $error = true;
            $errorState .= $state . ":PCA ";
        }
        // Delete from Facilitator Class Attendance
        $res = $db->query("DELETE FROM facilitatorclassattendance ".
            "WHERE topicname = $1 AND curriculumname = $2 ", [$class, $curriculaName]);
        $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
        if ($state != 0) {
            $error = true;
            $errorState .= $state . ":FCA ";
        }
        // Delete from Class Offering
        $res = $db->query("DELETE FROM classoffering ".
            "WHERE topicname = $1 AND curriculumname = $2 ", [$class, $curriculaName]);
        $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
        if ($state != 0) {
            $error = true;
            $errorState .= $state . ":CO";
        }

        // Error deleting connections
        if (isset($error)) {
            str_replace(" ", ", ", $errorState);
            $note['title'] = 'Error!';
            $note['msg'] = "The class could not be fully deleted [$errorState]";
            $note['type'] = 'danger';
        }
        // Remove actual curriculum-class connection
        else {
            $res = $db->query("DELETE FROM curriculumclasses WHERE topicname = $1 AND curriculumname = $2",
                [$class, $curriculaName]);
            if ($res) {
                $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
                if ($state == 0) {
                    $note['title'] = 'Success!';
                    $note['msg'] = 'Class was successfully removed from the curriculum.';
                    $note['type'] = 'success';
                    # Refresh display
                    $topics = $db->execute("get_curr_classes", [$curriculaName]);
                    $allTopics = $db->execute("get_other_classes", [$curriculaName]);
                } else {
                    $note['title'] = 'Error!';
                    $note['msg'] = "Class wasn't removed from the curriculum. [$state]";
                    $note['type'] = 'danger';
                }
            }
        }
    }
    // add class
    else {
        if (empty($class)) {
            $note['title'] = 'Error!';
            $note['msg'] = "Please select a class.";
            $note['type'] = 'danger';
        } else {
            $res = $db->query("INSERT INTO curriculumclasses VALUES ($1, $2)", [$class, $curriculaName]);
            if ($res) {
                $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
                if ($state == 0) {
                    $note['title'] = 'Success!';
                    $note['msg'] = 'Class was successfully added to the curriculum.';
                    $note['type'] = 'success';
                    # Refresh display
                    $topics = $db->execute("get_curr_classes", [$curriculaName]);
                    $allTopics = $db->execute("get_other_classes", [$curriculaName]);
                } else {
                    $note['title'] = 'Error!';
                    $note['msg'] = "Class wasn't added to the curriculum. [$state]";
                    $note['type'] = 'danger';
                }
            }
        }
    }

}

include('header.php');
?>

<div class="page-wrapper">
    <?php if(isset($confirmDelete)) { ?>

        <!-- Confirms remove class when class is referenced by attendance -->
        <form class="card warning-card" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
            <h4 class="card-header card-title">
                <?= $curriculaName . ' - ' . $class ?>
            </h4>
            <div class="card-body">
                The class "<?= $class ?>" is currently being used for attendance. Removing this class
                from curriculum "<?= $curriculaName ?>" will also remove any attendance for this
                class in the curriculum.
                <br /><br />
                Are you sure you want to continue?
            </div>
            <div class="card-footer text-right">
                <a href="<?= $_SERVER['REQUEST_URI'] ?>"><button type="button" class="btn btn-light">No, Cancel</button></a>
                <button type="submit" name="full-delete" class="btn btn-danger">Yes, Remove</button>
            </div>
            <input type="hidden" value="<?= $class ?>" name="class"/>
        </form>

    <?php } else { ?>

        <a href="/curricula"><button class="cpca btn"><i class="fa fa-arrow-left"></i> Back</button></a>
        <div class="jumbotron form-wrapper mb-3">
            <?php
            if (isset($note)) {
                $notification = new Notification($note['title'], $note['msg'], $note['type']);
                $notification->display();
            }
            ?>
            <h2 class="display-4 text-center" style="font-size: 34px"><?= $curriculaName ?></h2>
            <h4>Current Classes</h4>
            <table class="table table-hover table-responsive table-striped table-sm">
                <tbody>
                <?php
                while($class = pg_fetch_assoc($topics)) {
                    ?>
                    <tr>
                        <td class="align-middle">
                            <span><?= $class['topicname'] ?></span>
                        </td>
                        <td class="text-right">
                            <form class="mb-0" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
                                <input type="hidden" name="class" value="<?= $class['topicname'] ?>" />
                                <button type="submit" class="btn btn-outline-danger btn-sm" name="remove">Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }

                if (pg_num_rows($topics) == 0) {
                    echo '<tr><i>No classes assigned to curriculum.</i></tr>';
                }
                pg_free_result($topics);
                ?>
                </tbody>
            </table>
            <form class="form" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>" novalidate>
                <h4>Add New Class</h4>
                <select id="class-selector" class="form-control" name="class" required>
                    <option value="" disabled selected>Select a Class</option>
                    <?php
                    while ($t = pg_fetch_assoc($allTopics)) {
                        ?>
                        <option value="<?= $t['topicname'] ?>"><?= $t['topicname'] ?></option>
                        <?php
                    }
                    pg_free_result($allTopics);
                    ?>
                </select>
                <div class="form-footer submit">
                    <button type="submit" class="btn cpca">Add Class</button>
                </div>
            </form>
        </div>

    <?php } ?>
</div>

<?php
include('footer.php');
?>
