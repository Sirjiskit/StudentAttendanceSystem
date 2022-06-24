var table;
$(function () {
    table = $("#tblLists").DataTable({
        "ajax": window.siteurl + "students/tableLists",
        "order": [[0, "desc"]],
        "columnDefs": [
            {
                "targets": [3],
                "sortable": false,
                "searchable": false,
                "width": "13%"
            }
        ]
    });
    $(".id-add-new").click(function (e) {
        e.preventDefault();
        uni_modal("Upload students", window.siteurl + "students/new", "Upload");
    });
    $("#uni_modal").on("shown.bs.modal", function () {
        setTimeout(function () {
            $('[name="csv"]').change(function () {
                $("#uploadReport").html("");
            });
            var form = $("#frmImportStudent");
            if ("undefined" !== typeof form) {
                importStudent(form);
            }
            var form2 = $("#frmUpdateStudent");
            if ("undefined" !== typeof form2) {
                update(form2);
            }
            $("#selectFile").on('change', function () {
                if ($(this).val() !== "")
                {
                    loadImage(this);
                }
            });
        }, 1500);
    });
});
function importStudent(form) {
    form.submit(function (e) {
        e.preventDefault();
        var _this = $(this);
        var formData = _this.serialize();// new FormData(this);
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
function view(id) {
    viewer_modal("Student Info", window.siteurl + "students/view/" + id);
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
function edit(id) {
    uni_modal("Edit Student", window.siteurl + "students/edit/" + id, "Update");
}
function loadImage(input)
{
    if (input.files && input.files[0])
    {
      
        var reader = new FileReader();

        reader.onload = function (e)
        {
            $("#frmUpdateStudent").find('.imagePreview img').remove();
            $("#frmUpdateStudent").find('.imagePreview').removeClass('hidden');
            $("#frmUpdateStudent").find('.imagePreview').append("<img style='margin: 0 auto;height:100px' class='img-responsive img-bordered' src='" + e.target.result + "' />");
            $("#frmUpdateStudent").find('input[name="image"]').val(e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}