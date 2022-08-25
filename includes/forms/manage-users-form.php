<?php

if (isset($_POST['del_user'])) {
    // Check data if none delete from table or Set as suspended

}

if (isset($_POST['save_user'])) {
    if (
        strlen($_POST['firstName']) > 0
        && strlen($_POST['email']) > 0
        && $_POST['role'] != ''

    ) {
        $user_ = dbf(dbq("select * from users_tbl where user_id='{$_POST['user_id']}'"));
        $chk_duplicate_email = dbq("select * from users_tbl where email='{$_POST['email']}' and email!='{$user_['email']}'");
        if (dbr($chk_duplicate_email) == 0) {
            $update_user = dbq("update users_tbl set 
                                    name='{$_POST['firstName']}',
                                    last_name='{$_POST['lastName']}',
                                    employee_number='{$_POST['employeeNumber']}',
                                    id_number='{$_POST['id_number']}',
                                    contact_number='{$_POST['contact_number']}',
                                    email='{$_POST['email']}',
                                    role='{$_POST['role']}'
                                    where user_id='{$_POST['user_id']}'
                                    ");
            if ($update_user) {
                msg("User saved {$_POST['firstName']}!");
            } else {
                sqlError();
            }
        } else {
            error("User with email address {$_POST['email']} already exists.");
        }
    } else {
        error("fill in name, email and passwords at least.");
    }
}

if (isset($_POST['add_user'])) {
    if (
        strlen($_POST['firstName']) > 0
        && strlen($_POST['email']) > 0
        && strlen($_POST['password']) > 0
        && strlen($_POST['confirmpassword']) > 0
        && $_POST['role'] != ''

    ) {
        if ($_POST['password'] == $_POST['confirmpassword']) {
            if (validPass($_POST['password'])) {
                $chk_duplicate_email = dbq("select * from users_tbl where email='{$_POST['email']}'");
                if (dbr($chk_duplicate_email) == 0) {
                    $insert_user = dbq("insert into users_tbl set
                                            name='{$_POST['firstName']}',
                                            last_name='{$_POST['lastName']}',
                                            employee_number='{$_POST['employeeNumber']}',
                                            id_number='{$_POST['id_number']}',
                                            contact_number='{$_POST['contact_number']}',
                                            email='{$_POST['email']}',
                                            role='{$_POST['role']}'
                                            ");
                    if ($insert_user) {
                        msg("User {$_POST['firstName']} was added!");
                    } else {
                        sqlError();
                    }
                } else {
                    error("User with email address {$_POST['email']} already exists.");
                }
            } else {
                error('Invalid password. Password must include: uppercase, lowercase, special characters, numbers and must be atleast 8 characters');
            }
        } else {
            error('passwords dont match.');
        }
    } else {
        error("fill in name, email and passwords at least.");
    }
}
