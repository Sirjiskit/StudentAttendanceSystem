<form id="frmUploadRegisteredCourse" method="post" action="<?php echo URL; ?>courses/add">
    <div class="box-body row">        
        <div class="form-group col-12">
            <label class="control-label">Level</label>
            <select class="form-control" name="level" required="">
                <option value="">Select Level</option>
                <option value="1">Level 1</option>
                <option value="2">Level 2</option>
                <option value="3">Level 3</option>
                <option value="4">Level 4</option>
                <option value="5">Spill over I</option>
                <option value="6">Spill over II</option>
            </select>
        </div>
        <div class="form-group col-12">
            <label class="control-label">Select File</label>
            <input type="file" class="form-control" required="" name="csv" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
        </div>
        <div class="col-12" id="uploadReport">
        </div>
    </div>
</form>