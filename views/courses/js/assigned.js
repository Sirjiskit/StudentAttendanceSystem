/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var table;
$(function () {
    $(".id-add-new").click(function (e) {
        e.preventDefault();
        uni_modal("Assign Course", window.siteurl + "courses/assignNew", "Assign");
    });
    $("#uni_modal").on("shown.bs.modal", function () {
        setTimeout(function () {
            var form = $("#frmAllocateCourse");
            if ("undefined" !== typeof form) {
                AssignCourse(form);
            }
            var form2 = $("#frmUpadteAssignedCourse");
            if ("undefined" !== typeof form2) {
                EditAssignCourse(form2);
            }
        });
    });
    initData();
});
function initData() {
    table = $('#tblLists').DataTable({
        serverSide: true,
        ajax: {
            url: window.siteurl + "courses/assignedtableLists",
            type: 'POST'
        },
        "processing": true,
        "order": [[1, "asc"]],
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
                "targets": [4],
                "sortable": false,
                "searchable": false
            }
        ]
    });
}
function edit(id) {
    uni_modal("Edit Assigned Course", window.siteurl + "courses/assignededit/" + id, "Update");
}
function AssignCourse(form) {
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
                        table.ajax.reload();
                        _this.trigger('reset');
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

function EditAssignCourse(form) {
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
                        table.ajax.reload();
                        //_this.trigger('reset');
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
