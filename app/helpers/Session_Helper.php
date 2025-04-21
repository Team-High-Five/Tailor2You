<?php
//start session
session_start();

function isLoggedIn()
{
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}

function flash($name = '', $message = '', $class = 'msg-flash')
{
    if (empty($name)) {
        return;
    }

    // Setting a flash message
    if (!empty($message)) {
        // Clear any existing flash with same name
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
        if (isset($_SESSION[$name . '_class'])) {
            unset($_SESSION[$name . '_class']);
        }

        // Set new flash message
        $_SESSION[$name] = $message;
        $_SESSION[$name . '_class'] = $class;
    }
    // Displaying a flash message
    elseif (isset($_SESSION[$name]) && !empty($_SESSION[$name])) {
        // Get the class if it exists
        $class = isset($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : $class;

        // Display the message
        echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';

        // Clear the session variables
        unset($_SESSION[$name]);
        unset($_SESSION[$name . '_class']);
    }
}
