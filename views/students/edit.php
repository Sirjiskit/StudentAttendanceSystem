<form id="frmUpdateStudent" method="post" action="<?php echo URL; ?>students/update/<?php echo $this->student['studentid']; ?>">
    <input type="hidden" name="image" value="" />
    <div class="box-body row">
        <div class="form-group col-12">
            <label class="control-label">JAMB No</label>
            <input type="text" class="form-control" name="jambNo" value="<?php echo $this->student['jambNo']; ?>" />
        </div>
        <div class="form-group col-12">
            <label class="control-label">Matric. No</label>
            <input type="text" class="form-control" name="regNo" value="<?php echo $this->student['regNo']; ?>" />
        </div>
        <div class="form-group col-12">
            <label class="control-label">Fullname</label>
            <input type="text" class="form-control" name="fullname" value="<?php echo $this->student['fullname']; ?>" />
        </div>
        <div class="form-group col-12">
            <label class="control-label">Or Select a File</label>
            <input type="file" class="form-control"  id="selectFile" accept="image/png,image/jpeg,image/jpg" />
        </div>
        <?php if ($this->student['image'] != ""): ?>
            <div class="form-group col-12 currentImagePreview">
                <label class="control-label">Current Image</label>
                <img class="img-responsive img-bordered" style="margin: 0 auto" src="<?php echo URL; ?>public/uploads/student/<?php echo $this->student['image']; ?>" />
            </div>			
        <?php endif; ?>
        <div class="form-group col-12 imagePreview hidden" style="max-height: 120px">
            <label class="control-label">Preview Image</label>
        </div>
    </div>
</form>