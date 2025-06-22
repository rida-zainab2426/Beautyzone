<?php
// admin/index.php (Direct Dashboard Access - DANGEROUS FOR PRODUCTION!)

// Start the session at the very beginning of the file
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Require necessary files
require_once __DIR__ . '/../config.php'; // Adjust path as needed
require_once 'includes/functions.php'; // This should contain redirectTo() and isAdminLoggedIn()

// --- Simulate a successful login for direct dashboard access ---
// This will set the session variables that dashboard.php likely checks
$_SESSION['admin_logged_in'] = true;
// Set dummy admin ID and username if dashboard.php or other pages rely on them
// You might need to adjust these values if your dashboard expects specific formats or existing data
$_SESSION['admin_id'] = 1; // Example ID - use an ID that exists in your 'admins' table if needed
$_SESSION['admin_username'] = 'direct_access_admin'; // Example Username - use a username that exists if needed

// Optionally, set a welcome message if your dashboard displays it
$_SESSION['message'] = 'Welcome! You have direct access to the dashboard (DEVELOPMENT MODE).';
$_SESSION['message_type'] = 'success';

// Redirect directly to the dashboard page
// This will make it appear as if you've logged in successfully
redirectTo('dashboard.php');

exit(); // Ensure no further code is executed after the redirect
?>