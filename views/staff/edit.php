<form id="frmUpdateStaff" method="post" action="<?php echo URL; ?>staff/update/<?php echo $this->staff['userid']; ?>">
    <div class="box-body">
        <div class="form-group">
            <label class="control-label">Fullname</label>
            <input type="text" class="form-control" value="<?php echo $this->staff['fullname']; ?>" name="fullname" />
        </div>
        <div class="form-group">
            <label class="control-label">Email</label>
            <input type="text" class="form-control" value="<?php echo $this->staff['email']; ?>" name="email" />
        </div>
        <div class="form-group">
            <label class="control-label">Phone</label>
            <input type="text" class="form-control" value="<?php echo $this->staff['phone']; ?>" name="phone" placeholder="e.g 08012345678" />
        </div>
        <div class="form-group">
            <label class="control-label">Position</label>
            <select name="position" class="form-control">
                <option value="admin" <?php echo $this->staff['position'] == "admin" ? 'selected' : ''; ?>>Admin</option>
                <option value="lecturer" <?php echo $this->staff['position'] == "lecturer" ? 'selected' : ''; ?>>Lecturers</option>
            </select>
        </div>
    </div>
</form>