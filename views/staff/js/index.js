/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    var table;
    initData();
    $('.id-upload').click(function (e) {
        e.preventDefault();
        uni_modal("Upload Staff", window.siteurl + "staff/upload", "Upload");
    });

    $("#uni_modal").on("shown.bs.modal", function () {
        setTimeout(function () {
            $('[name="csv"]').change(function () {
                $("#uploadReport").html("");
            });
            var form = $("#form-upload-staff");
            if ("undefined" !== typeof form) {
                importStaff(form);
            }
            var form2 = $("#frmUpdateStaff");
            if ("undefined" !== typeof form2) {
                update(form2);
            }
        }, 1500);
    });
});
function initData() {
    table = $('#tblLists').DataTable({
        serverSide: true,
        ajax: {
            url: window.siteurl + "staff/tableLists",
            type: 'POST'
        },
        "processing": true,
        "order": [[2, "asc"]],
        select: true,
        "columnDefs": [
            [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
            {
                "targets": [0],
                "sortable": false,
                "searchable": false
            },
            {
                "targets": [5],
                "sortable": false,
                "searchable": false
            }
        ]
    });
}
function edit(id) {
    uni_modal("Edit Staff", window.siteurl + "staff/edit/" + id, "Update");
}
function update(form) {
    form.submit(function (e) {
        e.preventDefault();
        var _this = $(this);
        var formData = new FormData(this);
        const upload = new CreateRecord();
        const url = _this.attr('action');
        start_load();
        upload.create({url: url, data: formData}).then(data => {
            end_load();
            try {
                var res = jQuery.parseJSON(data);
                if (typeof res === 'object') {
                    if (res.result === 1) {
                        alert_toast(res.reason, "success");
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    } else {
                        alert_toast(res.reason, "error");
                    }
                } else {
                    alert_toast(`Unknown error occurred please try again later`, "error");
                }
            } catch (e) {
                console.log(e);
            }

        }).catch(error => {
            end_load();
            console.log(error);
        });
    });
}
function importStaff(form) {
    form.submit(function (e) {
        e.preventDefault();
        var _this = $(this);
        var formData = new FormData(this);
        const upload = new CreateRecord();
        const url = _this.attr('action');
        start_load();
        $("#uploadReport").html("");
        upload.create({url: url, data: formData}).then(data => {
            end_load();
            try {
                var res = jQuery.parseJSON(data);
                if (typeof res === 'object') {
                    if (res.result === 1) {
                        console.log(res.data);
                        $("#uploadReport").html(res.data);
                        alert_toast(res.reason, "success");
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    } else {
                        alert_toast(res.reason, "error");
                    }
                } else {
                    alert_toast(`Unknown error occurred please try again later`, "error");
                }
            } catch (e) {
                console.log(e);
            }

        }).catch(error => {
            end_load();
            console.log(error);
        });
    });
}
