<div class="col-12">
    <div class="card">
        <div class="card-header">
            <span class="bi bi-people"></span> Staff List
            <?php if (Session::get('role') == "admin"): ?>
                <button class="btn btn-primary btn-sm float-end id-add-new mr-1" type="button">
                    <i class="bi bi-plus-circle-fill"></i> Add new
                </button>
            <?php endif; ?>
        </div>
        <div class="card-body table-responsive">
            <table id="tblLists" class="table table-striped" style="width: 99.5%">
                <thead>
                    <tr>
                        <th>Jamb No</th>
                        <th>Matric. No</th>
                        <th>Fullname</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
