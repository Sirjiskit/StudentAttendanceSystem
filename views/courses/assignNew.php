<form id="frmAllocateCourse" method="post" action="<?php echo URL; ?>courses/allocate">
    <div class="modal-body">
        <div class="form-group">
            <label class="control-label">Course</label>
            <select name="courseId" class="form-control">
                <option value="">Choose....</option>
                <?php foreach ($this->dropDownCourses as $res):
                    ?>
                    <option value="<?php echo $res["id"] ?>"><?php echo $res["text"] ?></option>
                <?php endforeach; ?>
            </select>

        </div>
        <div class="form-group">
            <label class="control-label">Course Lecturer</label>
            <select name="staffId" class="form-control">
                <option value="">Choose....</option>
                <?php foreach ($this->dropDownStaff as $res):
                    ?>
                    <option value="<?php echo $res["id"] ?>"><?php echo $res["text"] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</form>