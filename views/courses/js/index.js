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
        uni_modal("Upload courses", window.siteurl + "courses/upload", "Upload");
    });
    $("#uni_modal").on("shown.bs.modal", function () {
        setTimeout(function () {
            $('[name="csv"]').change(function () {
                $("#uploadReport").html("");
            });
            var form = $("#form-upload-course");
            if ("undefined" !== typeof form) {
                importCourse(form);
            }
            var form2 = $("#frmUpdateCourse");
            if ("undefined" !== typeof form) {
                update(form2);
            }
        }, 1500);
    });
});
function initData() {
    table = $('#tblLists').DataTable({
        serverSide: true,
        ajax: {
            url: window.siteurl + "courses/tableLists",
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
                "targets": [5],
                "sortable": false,
                "searchable": false
            }
        ]
    });
}
function edit(id) {
    uni_modal("Edit courses", window.siteurl + "courses/edit/" + id, "Update");
}
function importCourse(form) {
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