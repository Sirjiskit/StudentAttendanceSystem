
<form id="frmImportStudent" method="post" action="<?php echo URL; ?>students/import">
    <div class="row">
        <div class="form-group col-12">
            <label class="control-label">Select File</label>
            <input type="file" class="form-control" name="csv" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
        </div>
        <div class="col-12" id="uploadReport"></div>
    </div>
</form>
