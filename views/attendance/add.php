
<form id="frmAddSchedule" method="post" action="<?php echo URL; ?>attendance/add">
    <div class="modal-body">
        <div class="form-group">
            <label class="control-label">Course</label>
            <select class="form-control" name="courseAllocationId">
                <option value="" selected="">Choose.....</option>
                <?php foreach ($this->dropDownAllocation as $row):
                    ?>
                    <option value="<?php echo $row["id"]; ?>"><?php echo $row["text"]; ?></option>
                    <?php
                endforeach;
                ?>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">Date</label>
            <input type="date" id="classDate" class="form-control" name="date" min="<?php echo date("Y-m-d"); ?>" value="<?php echo date("Y-m-d"); ?>" />
        </div>
        <div class="form-group">
            <label class="control-label">Attendance Time</label>
            <div class="row">
                <div class="col-md-6">
                    <div class="bootstrap-timepicker">
                        <div class="form-group">
                            <label class="control-label">Start Time</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                                <input placeholder="Start Time" type="time" class="form-control" name="startTime" value="08:00 AM"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bootstrap-timepicker">
                        <label class="control-label">End Time</label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                                <input placeholder="End Time" type="time" class="form-control" name="endTime" value="10:00 AM" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>