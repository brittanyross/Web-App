<?php
include_once('../models/DashboardPanel.php');

if (isset($_GET['role'])) {
    $_SESSION['role'] = $_GET['role'];
}

$roleViews = [
    Role::User => [
        new DashboardPanel("#", "Participant Referrals", "Participants", "file-text-o"),
        new DashboardPanel("#", "Class Activity", "Classes", "book"),
        new DashboardPanel(BASEURL."/agency-requests", "Agency Requests", "Participants", "search"),
        new DashboardPanel("#", "Participant Intake", "Participants", "file-text-o"),
    ],
    Role::Coordinator => [
        new DashboardPanel(BASEURL."/agency-requests", "Agency Requests", "Participants", "search"),
        new DashboardPanel("#", "Participant Intake", "Participants", "file-text-o"),
        new DashboardPanel("/curricula", "Manage Curricula and Classes", "Classes", "university"),
        new DashboardPanel("/locations", "Manage Locations", "Classes", "map-marker"),
    ],
    Role::Admin => [
        new DashboardPanel("/curricula", "Manage Curricula and Classes", "Classes", "university"),
        new DashboardPanel("/locations", "Manage Locations", "Classes", "map-marker"),
        new DashboardPanel("#", "Reports", "Reporting", "bar-chart"),
        new DashboardPanel("#", "User Management", "Participants", "users"),
    ],
    Role::Superuser => [
        new DashboardPanel("/curricula", "Manage Curricula and Classes", "Classes", "university"),
        new DashboardPanel("/locations", "Manage Locations", "Classes", "map-marker"),
        new DashboardPanel("/classes", "Manage Classes", "Participants", "book"),
        new DashboardPanel("#", "Manage Participants", "Users", "users"),
        new DashboardPanel("#", "User Management", "Users", "users"),
    ]
];

include('header.php');

?>

    <div id="dashboard-wrapper" class="d-flex flex-row justify-content-center flex-wrap">
        <?php
        if ($_SESSION['role'] != Role::NewUser) {
            /* @var $panel DashboardPanel */
            foreach ($roleViews[$_SESSION['role']] as $panel) {
                $panel->createPanel();
            }
        } else {
            ?>
            <div class="jumbotron align-self-center text-center" style="max-width: 700px; margin: 0 auto; width: 100%">
                <h1 class="display-3" style="color: #5C629C"><i class="fa fa-child"></i></h1>
                <h1 class="display-3">Welcome!</h1>
                <p class="lead">You currently have no role assigned, please see your supervisor.</p>
            </div>
            <?php
        }
        ?>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){

            showTutorial('menu');

            $("#login-btn").click(function(){
                $("#myModal").modal()
                $("#myModal").on('hidden.bs.modal', function () {
                    var username = $(".username").val();
                    $(".navbar-right").empty();
                    $(".navbar-right").html("<span class='userLoggedIn'>Welcome, "+username+"!</span>");
                })
            })
        });
    </script>

<?php
include('footer.php');
?>