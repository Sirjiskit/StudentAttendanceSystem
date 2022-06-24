/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Authenticator {
    fd = new FormData();
    login() {
        var $this = this;
        return new Promise(resolve => {
            $.ajax({
                url: 'auth/login',
                data: $this.fd,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                    resolve(data);
                }, error: function (err) {
                    resolve({status: 201, msg: `Error: ${err.statusText}`});
                }
            });
        });
    }
    register() {
        var $this = this;
        return new Promise(resolve => {
            $.ajax({
                url: 'auth/signup',
                data: $this.fd,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                    resolve(data);
                }, error: function (err) {
                    resolve({status: 201, msg: `Error: ${err.statusText}`});
                }
            });
        });
    }
    lostPassword() {
        var $this = this;
        return new Promise((resolve, reject) => {
            $.ajax({
                url: 'auth/forgot-password',
                data: $this.fd,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                    resolve(data);
                }, error: function (err) {
                    resolve({status: 201, msg: `Error: ${err.statusText}`});
                }
            });
        });
    }
}

