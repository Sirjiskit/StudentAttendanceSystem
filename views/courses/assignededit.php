<form id="frmUpadteAssignedCourse" method="post" action="<?php echo URL; ?>courses/assignedupdate/<?php echo $this->assigned["courseAllocationId"] ?>">
    <div class="modal-body">
        <div class="form-group">
            <label class="control-label">Course</label>
            <select name="courseId" class="form-control">
                <option value="">Choose....</option>
                <?php foreach ($this->dropDownCourses as $res):
                    ?>
                    <option <?php echo $this->assigned["courseId"] == $res["id"] ? 'selected' : ''; ?> value="<?php echo $res["id"] ?>"><?php echo $res["text"] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">Course Lecturer</label>
            <select name="staffId" class="form-control">
                <option value="">Choose....</option>
                <?php foreach ($this->dropDownStaff as $res):
                    ?>
                    <option <?php echo $this->assigned["staffid"] == $res["id"] ? 'selected' : ''; ?> value="<?php echo $res["id"] ?>"><?php echo $res["text"] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</form>