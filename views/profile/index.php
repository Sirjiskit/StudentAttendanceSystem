<div class="col-12">
    <div class="card">
        <div class="card-header">
            <span class="bi bi-person"></span> My profile
        </div>
        <div class="card-body">
            <form id="frmUpdateProfile" method="post" action="<?php echo URL; ?>profile/update/<?php echo $this->user['userid']; ?>">
                <div class="row">
                    <div class="form-group col-6">
                        <label class="control-label">Email</label>
                        <input type="text" class="form-control" readonly="" name="email" value="<?php echo $this->user['email']; ?>" />
                    </div>
                    <div class="form-group col-6">
                        <label class="control-label">Password</label>
                        <input type="password" class="form-control" name="password" />
                    </div>
                    <div class="form-group col-6">
                        <label class="control-label col-6">Fullname</label>
                        <input type="text" class="form-control" name="fullname" value="<?php echo $this->user['fullname']; ?>" />
                    </div>

                    <div class="form-group col-6">
                        <label class="control-label">Mobile Number</label>
                        <input type="text" class="form-control" name="phone" value="<?php echo $this->user['phone']; ?>" />
                    </div>
                    <div class="form-group col-6">
                        <label class="control-label">Or Select a File</label>
                        <input type="file" class="form-control" id="selectFile" accept="image/png,image/jpeg,image/jpg" />
                    </div>
                    <?php if ($this->user['image'] != ""): ?>
                        <div class="form-group imagePreview col-6">
                            <label class="control-label">Current Image</label>
                            <img class="img-responsive img-bordered"  style="margin: 0 auto; width: 100px;" src="<?php echo URL; ?>public/uploads/user/<?php echo $this->user['image']; ?>" />
                        </div>
                    <?php else: ?>
                        <div class="form-group imagePreview hidden col-6">
                            <label class="control-label">Preview Image</label>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="box-footer text-right">
                    <input type="hidden" name="image" value="" />
                    <button class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>