<?php
/**
 * PEP Capping 2017 Algozzine's Class
 *
 * Displays help about the system to the user.
 *
 * The help is context specific based on the page you were
 * just at. If you go to the help directly then the general
 * help will be displayed. Help is also role-specific too.
 *
 * @author Jack Grzechowiak
 * @copyright 2017 Marist College
 * @version 0.3.3
 * @since 0.3.3
 */

if (isset($_SERVER['HTTP_REFERER'])) {
    $referrer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);

    // Maps URL route to href
    $routeToHref = array(
        '/agency-requests' => '#agency',
        '/curricula' => '#curricula',
        '/curricula/create' => '#curricula-create',
        '/curricula/archive' => '#curricula-archives',
        '/curricula/classes' => '#curricula-add-class',
        '/classes' => '#classes',
        '/classes/create' => '#classes-create',
        '/classes/archive' => '#classes-archives',
        '/quarterly-reports' => '#reports-quarterly',
        '/year-end-reports' => '#reports-half-year',
        '/monthly-reports' => '#reports-monthly',
        '/custom-reports' => '#reports-custom',
        '/custom-reports-table' => '#reports-custom',
        '/referral-form' => '#referral-form',
        '/self-referral-form' => '#self-referral-form',
        '/form-success' => '#referrals',
    );

    // Check for general routes
    if (isset($routeToHref[$referrer])) {
        $href = $routeToHref[$referrer];
    }
    // If not found, be more specific
    else {
        if (startsWith($referrer, "/participant-search") ||
            startsWith($referrer, "/view-participant")) {
            $href = '#agency';
        } else if (startsWith($referrer, '/curricula/view') ||
            startsWith($referrer, '/curricula/edit')) {
            $href = '#curricula';
        } else if (startsWith($referrer, '/curricula/delete')) {
            $href = '#curricula-delete';
        } else if (startsWith($referrer, '/classes/view') ||
            startsWith($referrer, '/classes/edit')) {
            $href = '#classes';
        } else if (startsWith($referrer, '/classes/delete')) {
            $href = '#classes-delete';
        }
    }
}

include('header.php');
?>

<div data-spy="scroll" data-target="#toc-list" data-offset="75" id="help-section" style="flex: 1; padding: 0 1rem">
    <h4 id="general">General</h4>
    <p>This page provides detailed descriptions of various user functions in the PEP Manager. If after looking through the help sections you still have not solved your problem, please contact IT for further information.</p>
    <h5 id="display">Display</h5>
    <p>The PEP Manager display is set up in three parts: the top bar, the side menu, and the main content section.</p>
    <ul>
        <li><b>Top Bar</b> - This bar contains the name of the system, the current page you are on, and user specific links (Logout, Account Settings, Help).</li>
        <li><b>Side Menu</b> - This menu contains the navigation links to get to every page within the PEP Manager.</li>
        <li><b>Main Content</b> - This is the largest portion of the page which will display all of the content for each page.</li>
    </ul>

    <?php if (hasRole(Role::User)) { ?>
        <h4 id="agency">Agency Requests</h4>
        <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>

        <h4 id="referrals">Referrals & Intake</h4>
        <h5 id="referral-form">Referral Form</h5>
        <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>
        <h5 id="self-referral-form">Self-Referral Form</h5>
        <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>
        <h5 id="intake-packet">Intake Packet</h5>
        <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>

        <h4 id="curricula">Curricula</h4>
        <h5 id="curricula-search">Search / Grid</h5>
        <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>
        <?php if (hasRole(Role::Coordinator)) { ?>
            <h5 id="curricula-create">Create New</h5>
            <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>
            <h5 id="curricula-add-class">Add / Remove Classes</h5>
            <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>
            <h5 id="curricula-delete">Deleting</h5>
            <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>
            <h5 id="curricula-archives">Restore / Archived</h5>
            <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>
        <?php } ?>

        <h4 id="classes">Classes</h4>
        <h5 id="classes-search">Search / Grid</h5>
        <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>
        <?php if (hasRole(Role::Coordinator)) { ?>
            <h5 id="classes-create">Create New</h5>
            <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>
            <h5 id="classes-delete">Deleting</h5>
            <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>
            <h5 id="classes-archives">Restore / Archived</h5>
            <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>
        <?php } ?>

        <?php if (hasRole(Role::Coordinator)) { ?>
            <h4 id="reports">Reports</h4>
            <h5 id="reports-monthly">Monthly</h5>
            <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>
            <h5 id="reports-quarterly">Quarterly</h5>
            <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>
            <h5 id="reports-half-year">Half-Year / Year-End</h5>
            <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>
            <h5 id="reports-custom">Custom</h5>
            <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>
        <?php } ?>

        <?php if (hasRole(Role::Admin)) { ?>
            <h4 id="user-manage">User Management</h4>
            <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>
        <?php } ?>

        <h4 id="class-activity">Class Activity</h4>
        <h5 id="attendance">Attendance</h5>
        <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>
        <h5 id="surveys">Surveys</h5>
        <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>
    <?php } ?>

    <h4 id="faq">FAQ</h4>
    <p>Deserunt quis elit Lorem eiusmod amet enim enim amet minim Lorem proident nostrud. Ea id dolore anim exercitation aute fugiat labore voluptate cillum do laboris labore. Ex velit exercitation nisi enim labore reprehenderit labore nostrud ut ut. Esse officia sunt duis aliquip ullamco tempor eiusmod deserunt irure nostrud irure. Ullamco proident veniam laboris ea consectetur magna sunt ex exercitation aliquip minim enim culpa occaecat exercitation. Est tempor excepteur aliquip laborum consequat do deserunt laborum esse eiusmod irure proident ipsum esse qui.</p>
</div>

<!-- Table of Contents -->
<div id="toc">
    <nav class="nav flex-column" id="toc-list">
        <a class="nav-link toc-entry" href="#general">General</a>
        <nav class="nav flex-column">
            <a class="nav-link toc-entry" href="#display">Display</a>
        </nav>
        <?php if (hasRole(Role::User)) { ?>
            <a class="nav-link toc-entry" href="#agency">Agency Requests</a>
            <a class="nav-link toc-entry" href="#referrals">Referrals & Intake</a>
            <nav class="nav flex-column">
                <a class="nav-link toc-entry" href="#referral-form">Referral Form</a>
                <a class="nav-link toc-entry" href="#self-referral-form">Self-Referral Form</a>
                <a class="nav-link toc-entry" href="#intake-packet">Intake Packet</a>
            </nav>
            <a class="nav-link toc-entry" href="#curricula">Curricula</a>
            <nav class="nav flex-column">
                <a class="nav-link toc-entry" href="#curricula-search">Search / Grid</a>
                <?php if (hasRole(Role::Coordinator)) { ?>
                    <a class="nav-link toc-entry" href="#curricula-create">Create New</a>
                    <a class="nav-link toc-entry" href="#curricula-add-class">Add / Remove Classes</a>
                    <a class="nav-link toc-entry" href="#curricula-delete">Deleting</a>
                    <a class="nav-link toc-entry" href="#curricula-archives">Restore / Archived</a>
                <?php } ?>
            </nav>
            <a class="nav-link toc-entry" href="#classes">Classes</a>
            <nav class="nav flex-column">
                <a class="nav-link toc-entry" href="#classes-search">Search / Grid</a>
                <?php if (hasRole(Role::Coordinator)) { ?>
                    <a class="nav-link toc-entry" href="#classes-create">Create New</a>
                    <a class="nav-link toc-entry" href="#classes-delete">Deleting</a>
                    <a class="nav-link toc-entry" href="#classes-archives">Restore / Archived</a>
                <?php } ?>
            </nav>
            <?php if (hasRole(Role::Coordinator)) { ?>
                <a class="nav-link toc-entry" href="#reports">Reports</a>
                <nav class="nav flex-column">
                    <a class="nav-link toc-entry" href="#reports-monthly">Monthly</a>
                    <a class="nav-link toc-entry" href="#reports-quarterly">Quarterly</a>
                    <a class="nav-link toc-entry" href="#reports-half-year">Half-Year / Year-End</a>
                    <a class="nav-link toc-entry" href="#reports-custom">Custom</a>
                </nav>
            <?php } ?>
            <?php if (hasRole(Role::Admin)) { ?>
                <a class="nav-link toc-entry" href="#user-manage">User Management</a>
            <?php } ?>
            <a class="nav-link toc-entry" href="#class-activity">Class Activity</a>
            <nav class="nav flex-column">
                <a class="nav-link toc-entry" href="#attendance">Attendance</a>
                <a class="nav-link toc-entry" href="#surveys">Surveys</a>
            </nav>
        <?php } ?>
        <a class="nav-link toc-entry" href="#faq">FAQ</a>
    </nav>
</div>

<?php if(isset($href)) { ?>
    <script>
        window.location.href = "<?= $href ?>";
    </script>
<?php } ?>

<?php
include('footer.php');
?>
