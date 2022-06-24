<div class="col-12">
    <div class="card">
        <div class="card-header">
            <span class="bi bi-grid-fill"></span> Dashboard
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-4">
                            <a href="<?php echo URL; ?>students">
                                <div class="card bg-primary bg-gradient text-white">
                                    <div class="card-body d-flex flex-column">
                                        <h3 class="text-light">Students</h3>
                                        <div class="d-flex justify-content-between">
                                            <span style="font-size: 40px"><?php echo htmlentities($this->total_student);?></span>
                                            <span style="font-size: 40px"><i class="bi bi-people-fill"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php if (Session::get('role') == "admin"): ?>
                        <div class="col-4">
                            <a href="<?php echo URL; ?>staff">
                                <div class="card bg-danger bg-gradient text-white">
                                    <div class="card-body d-flex flex-column">
                                        <h3 class="text-light">Staff</h3>
                                        <div class="d-flex justify-content-between">
                                            <span style="font-size: 40px"><?php echo htmlentities($this->total_staff);?></span>
                                            <span style="font-size: 40px"><i class="bi bi-person-fill"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                         <?php endif; ?>
                        <div class="col-4">
                            <a href="<?php echo URL; ?>courses">
                                <div class="card bg-secondary bg-gradient text-white">
                                    <div class="card-body d-flex flex-column">
                                        <h3 class="text-light">Courses</h3>
                                        <div class="d-flex justify-content-between">
                                            <span style="font-size: 40px"><?php echo htmlentities($this->total_courses);?></span>
                                            <span style="font-size: 40px"><i class="bi bi-book"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

