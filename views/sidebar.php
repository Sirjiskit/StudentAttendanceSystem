<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="<?php echo URL ?>">
                        <img src="<?php echo URL . "public" ?>/assets/images/logo/banner.png" style="width:100%!important; height: 100% !important " alt="Logo" srcset="">
                    </a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item <?php echo ($this->menu == "dashboard") ? 'active' : ""; ?>">
                    <a href="<?php echo URL ?>" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item  has-sub <?php echo ($this->menu == "courses") ? 'active' : ""; ?>">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-book-fill"></i>
                        <span>Courses</span>
                    </a>
                    <ul class="submenu <?php echo ($this->menu == "courses") ? 'active' : ""; ?>">
                        <li class="submenu-item <?php echo ($this->menu == "courses" && $this->submenu == "list") ? 'active' : ""; ?>">
                            <a href="<?php echo URL; ?>courses">List</a>
                        </li>
                        <?php if (Session::get('role') == "admin"): ?>
                        <li class="submenu-item <?php echo ($this->menu == "courses" && $this->submenu == "assigned") ? 'active' : ""; ?>">
                            <a href="<?php echo URL; ?>courses/assigned">Assigned</a>
                        </li>
                        <li class="submenu-item <?php echo ($this->menu == "courses" && $this->submenu == "registered") ? 'active' : ""; ?>">
                            <a href="<?php echo URL; ?>courses/registered">Registered</a>
                        </li>
                         <?php endif; ?>
                    </ul>
                </li>
                <li class="sidebar-item <?php echo ($this->menu == "students") ? 'active' : ""; ?>">
                    <a href="<?php echo URL; ?>students" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>Students</span>
                    </a>
                </li>
                <?php if (Session::get('role') == "admin"): ?>
                <li class="sidebar-item <?php echo ($this->menu == "staff") ? 'active' : ""; ?>">
                    <a href="<?php echo URL; ?>staff" class='sidebar-link'>
                        <i class="bi bi-people"></i>
                        <span>Staff</span>
                    </a>
                </li>
                <?php endif; ?>
                <li class="sidebar-item  has-sub <?php echo ($this->menu == "attendance") ? 'active' : ""; ?>">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-stack"></i>
                        <span>Attendance</span>
                    </a>
                    <ul class="submenu <?php echo ($this->menu == "attendance") ? 'active' : ""; ?>">
                        <li class="submenu-item <?php echo ($this->menu == "attendance" && $this->submenu == "class") ? 'active' : ""; ?>">
                            <a href="<?php echo URL; ?>attendance">Class</a>
                        </li>
                        <li class="submenu-item <?php echo ($this->menu == "attendance" && $this->submenu == "report") ? 'active' : ""; ?>">
                            <a href="<?php echo URL; ?>attendance/report">Report</a>
                        </li>
                    </ul>
                </li>
                <!--                <li class="sidebar-title">Support</li>
                
                                <li class="sidebar-item  ">
                                    <a href="#" class='sidebar-link'>
                                        <i class="bi bi-life-preserver"></i>
                                        <span>Support</span>
                                    </a>
                                </li>-->

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>