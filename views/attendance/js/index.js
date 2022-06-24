/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var table;
$(function () {
    table = $("#tblLists").DataTable({
        "ajax": window.siteurl + "attendance/tableLists",
        "order": [[0, "desc"]],
        "columnDefs": [
            {
                "targets": [5],
                "sortable": false,
                "searchable": false
            },
            {
                "targets": [0],
                "sortable": false,
                "searchable": false,
                "visible": false
            }
        ]
    });
    $(".id-create-new").click(function(e){
        e.preventDefault();
        uni_modal("Schedule class", window.siteurl + "attendance/new", "Create");
    });
    $("#uni_modal").on("shown.bs.modal", function () {
        setTimeout(function () {
            $('#classDate').change(function () {
                var date = new Date($(this).val());
                if (date.getDay() == 6 || date.getDay() == 0) {
                    $(this).val('');
                }
            });
            var form = $("#frmAddSchedule");
            if ("undefined" !== typeof form) {
                addOrEdit(form);
            }
            var form2 = $("#frmEditSchedule");
            if ("undefined" !== typeof form2) {
                addOrEdit(form2);
            }
        }, 1500);
    });
});

function frmDate(date) {
    var show = true;
    date = new Date(date);
    if (date.getDay() == 6 || date.getDay() == 0) {
        show = false;
    }

    return [show];
}

function addOrEdit(form) {
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
function edit(id){
    uni_modal("Edit Schedule", window.siteurl + "attendance/edit/" + id, "Update");
}