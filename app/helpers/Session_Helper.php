<?php
//start session
    session_start()   ;

    //flash message helper
    function flash($name = '', $message = '', $class = 'msg-flash'){
        if(!empty($name)){
            if(!empty($message) && empty($_SESSION[$name])){
                //check if session is empty
                if(!empty($_SESSION[$name])){
                    unset($_SESSION[$name]);
                }
                //check if session class is empty
                if(!empty($_SESSION[$name. '_class'])){
                    unset($_SESSION[$name. '_class']);
                }
                //set session
                $_SESSION[$name] = $message;
                $_SESSION[$name. '_class'] = $class;
            }elseif(empty($message) && !empty($_SESSION[$name])){
                $class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name. '_class'] : '';
                echo '<div class="'.$class.'" id="'.$class.'">'.$_SESSION[$name].'</div>';
                unset($_SESSION[$name]);
                unset($_SESSION[$name. '_class']);
            }
        }
    }
?>