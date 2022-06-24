<div class="col-12">
    <div class="card">
        <div class="card-header">
            General Report Report
        </div>
        <div class="card-body">
            <form id="frmPrintReport" target="_blank" class="row" method="post" action="<?php echo URL; ?>attendance/printReport">
                <div class="box-body offset-lg-3 offset-md-3 offset-sm-2 col-12 col-md-4 col-lg-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Select Academic Session:</label>
                        <select id="academicyear" name="academicyear" required class="form-control">
                            <option value="2020/2021" selected="">2020/2021</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Select semester:</label>
                        <select id="semester" name="semester" required class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Select Course:</label>
                        <select id="selectLecture" name="courseid" class="form-control"<?php echo ($this->courses == null) ? " disabled" : ""; ?>>
                            <?php foreach ($this->courses as $row): ?>
                                <option  value="<?php echo $row['courseId']; ?>"><?php echo $row['code']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary float-end">Print</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>