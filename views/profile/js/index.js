$(function () {
    $("#frmUpdateProfile").on('submit', function (evt) {
        evt.preventDefault();

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
    function loadImage(input)
    {
        if (input.files && input.files[0])
        {
            var reader = new FileReader();

            reader.onload = function (e)
            {
                $("#frmUpdateProfile").find('.imagePreview img').remove();
                $("#frmUpdateProfile").find('.imagePreview').removeClass('hidden');
                $("#frmUpdateProfile").find('.imagePreview').append("<img style='margin: 0 auto;; width: 100px;' class='img-responsive img-bordered' src='" + e.target.result + "' />");
                $("#frmUpdateProfile").find('input[name="image"]').val(e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#selectFile").on('change', function () {
        if ($(this).val() !== "") {
            loadImage(this);
        }
    });
});