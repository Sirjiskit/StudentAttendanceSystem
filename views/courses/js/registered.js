/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var table;
$(function () {
    table = $("#tblLists").DataTable({
        "ajax": window.siteurl + "courses/registeredTableLists",
        "order": [[0, "desc"]]
    });
    $(".id-upload").click(function (e) {
        e.preventDefault();
        uni_modal("Upload Students Courses", window.siteurl + "courses/new", "Upload");
    });
    $("#uni_modal").on("shown.bs.modal", function () {
        setTimeout(function () {
            $('[name="csv"]').change(function () {
                $("#uploadReport").html("");
            });
            var form = $("#frmUploadRegisteredCourse");
            if ("undefined" !== typeof form) {
                importRegistered(form);
            }
        }, 1500);
    });
});

function importRegistered(form) {
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
                        $("#uploadReport").html(res.data);
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