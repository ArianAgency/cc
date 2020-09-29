<?php

function checkRolesAccessLevel($user_role_id_as_access_level, $valid_access_level)
{
    if ($user_role_id_as_access_level <= $valid_access_level) {
        return true;
    } else {
        return false;
    }
}




//composer dump-autoload
