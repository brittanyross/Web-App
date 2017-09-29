<?php

$router->add('/', 'dashboard.php', 'Home');
$router->add('/back', 'back.php', '');
$router->add('/dashboard', 'dashboard.php', 'Home');

$router->add('/login', 'login.php', 'Login');
$router->add('/logout', 'logout.php', '');

# Agency Requests
$router->add('/agency-requests', 'agency-requests/agency_requests.php', 'Agency Requests');
$router->add('/participant-search', 'agency-requests/agency_requests_results.php', 'Search Results');
$router->add('/view-participant', 'agency-requests/view_participant.php', 'View Participant');

# Manage Curricula & Classes
$router->add('/curricula', 'curricula/curricula.php', 'Curricula');
$router->add('/classes', 'classes/classes.php', 'Classes');
$router->add('/locations', 'locations/locations.php', 'Locations');

# Attendance Application
$router->add('/attendance', 'attendance/attendance_dashboard.php', 'Attendance Dashboard');
$router->add('/record-attendance', 'attendance/attendance_form.php', 'Attendance Form');
$router->add('/attendance-history', 'attendance/attendance_history.php', 'Attendance History');