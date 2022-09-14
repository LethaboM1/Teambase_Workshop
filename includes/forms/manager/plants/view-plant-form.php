<?php
if (isset($_POST['remove_user'])) {
    $remove_user = dbq("delete from plant_user_tbl where user_id='{$_POST['user_id']}' and plant_id='{$_POST['plant_id']}'");
    if ($remove_user) {
        msg('User removed!');
    } else {
        sqlError();
    }
}

if (isset($_POST['add_users'])) {
    if (is_array($_POST['user_id'])) {
        if (count($_POST['user_id']) > 0) {
            foreach ($_POST['user_id'] as $user_id) {
                $chkadded = dbq("select * from plant_user_tbl where plant_id='{$_GET['id']}' and user_id='{$user_id}'");
                if (dbr($chkadded) == 0) {
                    $query = "insert into plant_user_tbl set user_id='{$user_id}' , plant_id='{$_GET['id']}'";
                    $add_user = dbq($query);
                    if (!$add_user) {
                        $err = true;
                        $user_ = dbf(dbq("select concat(name,' ', last_name) as name from users_tbl where user_id={$user_id}"));
                    }
                }

                if (!$err) {
                    if (count($_POST['user_id']) > 1) {
                        msg("Users added!");
                    } else {
                        msg('User added!');
                    }
                    go("page=view-plant&id={$_GET['id']}");
                }
            }
        }
    }
}
