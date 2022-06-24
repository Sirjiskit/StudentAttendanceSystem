<div id="auth">

    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo d-flex justify-content-center">
                   <a href="#"><img src="<?php echo URL . "public" ?>/assets/images/logo/logo.png" alt="Logo" style="width:100px!important; height: 100px !important "></a>
                </div>
                <h5 class="auth-title">Enter your email and we will send you reset password link</h5>
                <form action="<?php echo URL ?>login/sendpassword" method="post" id="forgot-password-form">
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="email" class="form-control form-control-xl" name="email" placeholder="Email">
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-2 btn-forgot-password">Send</button>
                    <?php if(isset($_GET['hasError'])): ?><div class="alert alert-danger py-1 mt-2">Email address do not match any account!</div><?php endif; ?>
                    <?php if(isset($_GET['hasSuccess'])): ?><div class="alert alert-success py-1 mt-2">New password sent to your email address!</div><?php endif; ?>
                </form>
                <div class="text-center mt-5">
                    <p class='text-gray-600'>Remember your account? <a href="<?php echo URL ?>" class="font-bold">Log
                            in</a>.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">

            </div>
        </div>
    </div>

</div>