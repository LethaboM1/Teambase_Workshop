<?php
?>

<div class="row">
    <form method="post" id="adduser" enctype="multipart/form-data">
        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Add New User</h2>
                <p class="card-subtitle">Add new users. Photo should be in .jpg or .png format and not larger than 2MB.</p>
            </header>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">First Name</label>
                        <input type="text" name="name" placeholder="First Name" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">Last Name</label>
                        <input type="text" name="last_name" placeholder="Last Name" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">ID Number</label>
                        <input name="id_number" id="fc_inputmask_1" data-plugin-masked-input data-input-mask="999999-9999-999" placeholder="______-____-___" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">Company Number</label>
                        <input name="company_number" id="company_number" class="form-control" placeholder="Company number">
                    </div>
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">Contact Number</label>
                        <input name="contact_number" id="fc_inputmask_2" data-plugin-masked-input data-input-mask="999-999-9999" placeholder="___-___-____" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">Employee Number</label>
                        <input type="text" name="emplyee_number" placeholder="Employee Number" class="form-control">
                    </div>
                </div>
                <?= inp('fake-creds', '', 'fake-creds') ?>
                <div class="row">
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">Username</label>
                        <input type="username" name="username" placeholder="Username" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">Password</label>
                        <input type="password" name="password" placeholder="Password" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">Confirm Password</label>
                        <input type="password" name="confirmpassword" placeholder="Confirm Password" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">Email Address</label>
                        <input type="email" name="email" placeholder="Email Address" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">User Roll</label>
                        <select name="role" class="form-control mb-3" id="roll">
                            <option value="">Select a User Roll</option>
                            <option value="manager">Manager</option>
                            <option value="clerk">Clerk</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="mechanic">Mechanic</option>
                            <option value="user">Driver / Opperator</option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4 pb-sm-12 pb-md-0">
                        <label class="col-form-label" for="photo">Photo</label>
                        <div class="input-group mb-3">
                            <input name="photo" id="photo" type="file" style="display:none">
                            <input id="photo-box" type='text' class="form-control">
                            <button id="photo-btn" type='button' class="input-group-text" id="basic-addon2"><i class="fa fa-image"></i></button>
                        </div>
                        <?php
                        $jscript .= "
								$('#photo-btn').click(function (){ 
									$('#photo').click();

								});
								
								$('#photo-box').click(function (){ 
									$('#photo').click();

								});
								
								"

                        ?>
                    </div>
                </div>
            </div>
            <footer class="card-footer text-end">
                <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
                <button class="btn btn-default modal-dismiss">Cancel</button>
            </footer>
        </section>
    </form>
</div>