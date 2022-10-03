<?php

if (isset($_POST['del_user'])) {
    // Check data if none delete from table or Set as suspended

}

if (isset($_POST['save_user'])) {
    if (
        strlen($_POST['name']) > 0
        && strlen($_POST['email']) > 0
        && $_POST['role'] != ''

    ) {
        if (file_exists($_FILES['photo']['tmp_name'])) {
            $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            if ($ext == 'jpg' || $ext == 'jpeg') {
                $path = "images/users/{$_POST['user_id']}.jpg";
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $path)) {
                    msg('Photo saved!');
                } else {
                    error("Error saving photo.");
                }
            } else {
                error('Only JPG file types allowed');
            }
        }

        if (strlen($_POST['password']) > 0) {
            if ($_POST['password'] == $_POST['confirmpassword']) {
                if (validPass($_POST['password'])) {
                    $update_password = dbq("update users_tbl set
                                                password='" . password_hash($_POST['password'], PASSWORD_DEFAULT) . "'
                                                where user_id={$_POST['user_id']}");
                    if ($update_password) {
                        msg("Password changed!");
                    } else {
                        sqlError('Password change error', 'Password change error');
                    }
                } else {
                    $error[] = "Unsafe password. Password must have uppercase, lowercase, numbers, special characters and must be atleast 8 characters in length.";
                }
            } else {
                $error[] = "Could not change password. Passwords dont match.";
            }
        }

        $user_ = dbf(dbq("select * from users_tbl where user_id='{$_POST['user_id']}'"));
        $chk_duplicate_email = dbq("select * from users_tbl where email='{$_POST['email']}' and email!='{$user_['email']}'");
        if (dbr($chk_duplicate_email) == 0) {
            $update_user = dbq("update users_tbl set 
                                    name='{$_POST['name']}',
                                    last_name='{$_POST['last_name']}',
                                    employee_number='{$_POST['employee_number']}',
                                    id_number='{$_POST['id_number']}',
                                    company_number='{$_POST['company_number']}',
                                    contact_number='{$_POST['contact_number']}',
                                    email='{$_POST['email']}',
                                    role='{$_POST['role']}'
                                    where user_id='{$_POST['user_id']}'
                                    ");
            if ($update_user) {
                msg("User saved {$_POST['firstName']}!");
                go("dashboard.php?page=add-user");
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
        strlen($_POST['name']) > 0
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
                                            name='{$_POST['name']}',
                                            last_name='{$_POST['last_name']}',
                                            employee_number='{$_POST['employee_number']}',
                                            id_number='{$_POST['id_number']}',
                                            company_number='{$_POST['company_number']}',
                                            contact_number='{$_POST['contact_number']}',
                                            email='{$_POST['email']}',
                                            password='" . password_hash($_POST['password'], PASSWORD_DEFAULT) . "',
                                            role='{$_POST['role']}'
                                            ");
                    if ($insert_user) {
                        $user_id = mysqli_insert_id($db);

                        if (file_exists($_FILES['photo']['tmp_name'])) {
                            $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
                            if ($ext == 'jpg' || $ext == 'jpeg') {
                                $path = "images/users/{$user_id}.jpg";
                                if (move_uploaded_file($_FILES['photo']['tmp_name'], $path)) {
                                    msg('Photo saved!');
                                } else {
                                    error("Error saving photo.");
                                }
                            } else {
                                error('Only JPG file types allowed');
                            }
                        }
                        msg("User {$_POST['firstName']} was added!");
                        go("dashboard.php?page=add-user");
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
