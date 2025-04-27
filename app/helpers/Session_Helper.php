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
        
        // For debugging: Add a timestamp to track when the message was set
        $_SESSION[$name . '_time'] = time();
        
        return true; // Indicate successful setting
    }
    // Displaying a flash message
    elseif (isset($_SESSION[$name]) && !empty($_SESSION[$name])) {
        // Get the class if it exists
        $class = isset($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : $class;
        
        // Get debug info
        $timeSet = isset($_SESSION[$name . '_time']) ? $_SESSION[$name . '_time'] : 'unknown';
        $timeAgo = isset($_SESSION[$name . '_time']) ? (time() - $_SESSION[$name . '_time']) : 'unknown';

        // Display the message with better visibility
        echo '<div class="' . $class . '" id="msg-flash" style="padding: 10px; margin: 10px 0; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                ' . $_SESSION[$name] . '
              </div>';

        // Clear the session variables
        unset($_SESSION[$name]);
        unset($_SESSION[$name . '_class']);
        unset($_SESSION[$name . '_time']);
        
        return true; // Indicate successful display
    }
    
    return false; // Indicate no action was taken
}
