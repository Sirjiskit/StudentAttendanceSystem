<div id="auth">
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo d-flex justify-content-center">
                    <a href="#"><img src="<?php echo URL . "public" ?>/assets/images/logo/logo.png" alt="Logo" style="width:100px!important; height: 100px !important "></a>
                </div>
                <h5 class="auth-title">Login to Your SAS Account</h5>
                <form action="login/run" id="login-form" method="post">
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" name="username" class="form-control form-control-xl" placeholder="UserID or Emaill">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" name="password" class="form-control form-control-xl" placeholder="Password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <div class="form-check form-check-lg d-flex align-items-end">
                        <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label text-gray-600" for="flexCheckDefault">
                            Keep me logged in
                        </label>
                    </div>
                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-2 btn-login">Log in</button>
                    <?php if(isset($_GET['hasError'])): ?><div class="alert alert-danger py-1 mt-2">Invalid username or password!</div><?php endif; ?>
                    
                </form>
                <div class="mt-2 d-flex justify-content-between">
                    <p class="text-gray-600">I can't login? <a href="#" class="font-bold">Contact Admin</a>.</p>
                    <p><a class="font-bold" style="white-space: nowrap" href="<?php echo URL ?>staff/forgotpassword">Forgot password?</a>.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">

            </div>
        </div>
    </div>
</div>