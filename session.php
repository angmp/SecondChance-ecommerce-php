<?php
session_start(); // Start the session

/**
 * Function to log in a user
 *
 * @param string $username The username of the user
 * @param int $userId The user ID of the user
 * @param bool $isSeller Whether the user is a seller
 */
function loginUser ($username, $userId, $isSeller = false) {
    $_SESSION['loggedin'] = true; // Set logged in status
    $_SESSION['username'] = htmlspecialchars($username); // Store username
    $_SESSION['userId'] = $userId; // Store user ID
    $_SESSION['is_seller'] = $isSeller; // Store seller status
}

/**
 * Function to log out a user
 */
function logoutUser () {
    // Unset all session variables
    $_SESSION = array();

    // If it's desired to kill the session, also delete the session cookie.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finally, destroy the session.
    session_destroy();
}

/**
 * Function to check if a user is logged in
 *
 * @return bool True if logged in, false otherwise
 */
function isLoggedIn() {
    return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
}

/**
 * Function to get the username of the logged-in user
 *
 * @return string|null The username or null if not logged in
 */
function getUsername() {
    return isLoggedIn() ? $_SESSION['username'] : null;
}

/**
 * Function to get the user ID of the logged-in user
 *
 * @return int|null The user ID or null if not logged in
 */
function getUserId() {
    return isLoggedIn() ? $_SESSION['userId'] : null;
}

/**
 * Function to check if the logged-in user is a seller
 *
 * @return bool True if the user is a seller, false otherwise
 */
function isSeller() {
    return isLoggedIn() && isset($_SESSION['is_seller']) && $_SESSION['is_seller'] === true;
}
?>