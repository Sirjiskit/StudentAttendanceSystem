<div class="col-12">
    <div class="card">
        <div class="card-header">
            <?php echo (Session::get('role') == "admin" ? "List of available courses" : "My Course(s)") ?>
            <?php if (Session::get('role') == "admin"): ?>
            <button class="btn btn-secondary float-end id-upload mr-1" type="button">
                <i class="bi bi-upload"></i>
            </button>
            <?php endif; ?>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped" id="tblLists" border="0">
                <colgroup>
                    <col width="6%">
                    <col width="10%">
                    <col width="48%">
                    <col width="15%">
                    <col width="11%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Title</th>
                        <th>Level</th>
                        <th>Semester</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>