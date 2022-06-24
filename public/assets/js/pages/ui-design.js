/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
isSubmitted = false;
window.alert_toast = function ($msg = 'TEST', $bg = 'success', $pos = '') {
    var Toast = Swal.mixin({
        toast: true,
        position: $pos || 'top-end',
        showConfirmButton: false,
        timer: 5000
    });
    Toast.fire({
        icon: $bg,
        title: $msg
    });
};
window.start_load = function () {
    $('body').prepend('<div id="preloader2"></div>');
};
window.end_load = function () {
    $('#preloader2').fadeOut('fast', function () {
        $(this).remove();
    });
};
window.uni_modal = function ($title = '', $url = '', $btnTitle = "Save", $size = "") {
    start_load();
    $.ajax({
        url: $url,
        error: function (err) {
            console.log(err);
            alert("An error occured");
        },
        success: function (resp) {
            if (resp) {
                $('#uni_modal .modal-title').html($title);
                $('#uni_modal .modal-body').html(resp);
                if ($size != '') {
                    $('#uni_modal .modal-dialog').addClass($size);
                } else {
                    $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md");
                }
                $("#uni_modal #submit").html($btnTitle);
                $('#uni_modal').modal('show');
                end_load();
            }
        }
    });
};
window.viewer_modal = function ($title = '', $url = '', $size = '') {
    start_load();
    $.ajax({
        url: $url,
        error: function (err) {
            console.log(err);
            alert("An error occured");
        },
        success: function (resp) {
            if (resp) {
                $('#viewer_modal2 .modal-title').html($title);
                $('#viewer_modal2 .modal-body').html(resp);
                if ($size !== '') {
                    $('#viewer_modal2 .modal-dialog').addClass($size);
                } else {
                    $('#viewer_modal2 .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md");
                }
                $('#viewer_modal2').modal('show');
                end_load();
            }
        }
    });
};
window._conf = function ($msg = '', $func = '', $params = [], $btnTitle = "Delete") {
    $('#confirm_modal #confirm').attr('onclick', $func + "(" + $params.join(',') + ")");
    $('#confirm_modal .modal-body').html($msg);
    $("#confirm_modal #confirm").html($btnTitle);
    $('#confirm_modal').modal('show');
};
function closeModal(id) {
    $(id).modal('hide');
}
var ajaxCall;
class CreateRecord {
    create(options) {
        var opt = $.extend({
            data: {},
            url: ''
        }, options);
        var $this = this;
        return new Promise((resolve, reject) => {
            $.ajax({
                url: opt.url,
                data: opt.data,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                    resolve(data);
                }, error: function (err) {
                    alert_toast(`Error: ${err.statusText}`, "error");
                    reject(true);
                }
            });
        });
    }
}
class ReadData {
    readData(options) {
        var opt = $.extend({
            data: {},
            url: ''
        }, options);
        var $this = this;
        return new Promise((resolve, reject) => {
            $.ajax({
                url: opt.url,
                data: opt.data,
                type: 'POST',
                success: function (data) {
                    resolve(data);
                }, error: function (err) {
                    alert_toast(`Error: ${err.statusText}`, "error");
                    reject(true);
                }
            });
        });
    }
    deleteData(options) {
        var opt = $.extend({
            data: {},
            url: ''
        }, options);
        var $this = this;
        return new Promise((resolve, reject) => {
            $.ajax({
                url: opt.url,
                data: opt.data,
                method: 'POST',
                success: function (data) {
                    resolve(data);
                }, error: function (err) {
                    alert_toast(`Error: ${err.statusText}`, "error");
                    reject(true);
                }
            });
        });
    }

}

