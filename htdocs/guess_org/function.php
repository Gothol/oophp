<?php
/**
* Start session
*/
function start_session()
{
    session_name("joss19");
    session_start();
}

function destroy_session()
{
    /**
    * Unset all session-variables.
    */
    $_SESSION = [];

    /**
    * Delete the session cookie.
    */
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    /**
    * Destroy session-
    */
    session_destroy();
    //echo "Session destroyed.";
}
