<form id="frmUpdateCourse" method="post" action="<?php echo URL; ?>courses/update/<?php echo $this->course['courseId']; ?>">
    <div class="box-body">
        <div class="form-group">
            <label class="control-label" for="add-code">Corse Code</label>
            <input type="text" class="form-control" value="<?php echo $this->course['code']; ?>" name="code" id="add-code" />
        </div>
        <div class="form-group">
            <label class="control-label" for="add-title">Course Title</label>
            <input type="text" class="form-control" value="<?php echo $this->course['title']; ?>" name="title" id="add-title"/>
        </div>
        <div class="form-group">
            <label class="control-label">Level</label>
            <select name="level" class="form-control">
                <option value="1" <?php echo (int) $this->course['level'] == 1 ? 'selected' : ''; ?>>Part 1</option>
                <option value="2" <?php echo (int) $this->course['level'] == 2 ? 'selected' : ''; ?>>Part 2</option>
                <option value="3" <?php echo (int) $this->course['level'] == 3 ? 'selected' : ''; ?>>Part 3</option>
                <option value="4" <?php echo (int) $this->course['level'] == 4 ? 'selected' : ''; ?>>Part 4</option>
                <option value="5" <?php echo (int) $this->course['level'] == 5 ? 'selected' : ''; ?>>Part 5</option>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">Semester</label>
            <select name="semester" class="form-control">
                <option value="1" <?php echo (int) $this->course['semester'] == 1 ? 'selected' : ''; ?>>Semester 1</option>
                <option value="2" <?php echo (int) $this->course['semester'] == 2 ? 'selected' : ''; ?>>Semester 2</option>
            </select>
        </div>
    </div>
</form>