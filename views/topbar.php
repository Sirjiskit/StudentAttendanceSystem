<div id="app">
    <div id="main" class='layout-navbar'>
        <header class='mb-3'>
            <nav class="navbar navbar-expand navbar-light ">
                <div class="container-fluid">
                    <a href="#" class="burger-btn d-block d-md-none d-xl-none d-lg-none d-sm-none">
                        <i class="bi bi-justify fs-3"></i>
                    </a>

                    <button class="navbar-toggler disabled" disabled="" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown me-1">
                                <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                   aria-expanded="false">
                                    <i class='bi bi-envelope bi-sub fs-4 text-gray-600'></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <h6 class="dropdown-header">Mail</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">No new mail</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown me-3">
                                <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                   aria-expanded="false">
                                    <i class='bi bi-bell bi-sub fs-4 text-gray-600'></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <h6 class="dropdown-header">Notifications</h6>
                                    </li>
                                    <li><a class="dropdown-item">No notification available</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-menu d-flex">
                                    <div class="user-name text-end me-3">
                                        <h6 class="mb-0 text-gray-600"><?php echo Session::get('fullname'); ?></h6>
                                        <p class="mb-0 text-sm text-gray-600"><?php echo ucfirst(Session::get('role')); ?></p>
                                    </div>
                                    <div class="user-img d-flex align-items-center">
                                        <div class="avatar avatar-md">
                                            <img src="<?php if (Session::get("image") != ""): ?><?php echo URL . "public" ?>/uploads/user/<?php echo Session::get('image'); ?><?php else: ?><?php echo URL . "public" ?>/assets/images/faces/contactpic.svg<?php endif; ?>">
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <h6 class="dropdown-header">Hello, <?php echo Session::get('fullname'); ?>!</h6>
                                </li>
                                <li><a class="dropdown-item" href="<?php echo URL; ?>profile"><i class="icon-mid bi bi-person me-2"></i> My
                                        Profile</a></li>
                                <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?php echo URL; ?>logout"><i
                                            class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <div id="main-content" style="margin-top: -40px">
            <div class="page-heading" style="min-height: calc(100vh - 220px)">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3><?php echo ucwords($this->title) ?></h3>
                        </div>
                    </div>
                </div>