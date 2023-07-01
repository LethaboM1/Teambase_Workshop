<?php

if (isset($_POST['del_site'])) {
    if ($_POST['id'] > 0) {
        $update_user = dbq("update sites_tbl set active=0 where id={$_POST['id']}");
        if ($update_user) {
            msg("Site has been removed!");
        } else {
            sqlError();
        }
    }
}

if (isset($_POST['save_site'])) {
    if (
        strlen($_POST['name']) > 0

    ) {
        $site_ = dbf(dbq("select * from sites_tbl where id='{$_POST['id']}'"));
        $chk_duplicate = dbq("select * from sites_tbl where name='{$_POST['name']}' and id!='{$_POST['id']}'");
        if (dbr($chk_duplicate) == 0) {


            $update_site = dbq("update sites_tbl set 
                                        name='{$_POST['name']}'
                                        where id='{$_POST['id']}'
                                        ");
            if ($update_site) {
                msg("site saved {$_POST['firstName']}!");
                go('dashboard.php?page=add-site');
            } else {
                sqlError();
            }
        } else {
            error("site with name {$_POST['name']} already exists.");
        }
    } else {
        error("Fill in a name.");
    }
}

if (isset($_POST['add_site'])) {
    if (
        strlen($_POST['name']) > 0

    ) {

        $chk_duplicate = dbq("select * from sites_tbl where name='{$_POST['name']}' and name!=''");
        if (dbr($chk_duplicate) == 0) {
            $insert_site = dbq("insert into sites_tbl set            
                                                name='{$_POST['name']}'
                                            ");
            if ($insert_site) {
                $id = mysqli_insert_id($db);
                msg("site {$_POST['name ']} was added!");
                go("dashboard.php?page=add");
            } else {
                sqlError();
            }
        } else {
            error("site with name {$_POST['name']} already exists.");
        }
    } else {
        error("name is a required fields.");
    }
}
