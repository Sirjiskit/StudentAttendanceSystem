

<?php
$currentTime = time();
$totalPresent = 0;
$totalAbsent = 0;
?>


<div class="col-12">
    <div class="card">
        <div class="card-header">
            <span class="bi bi-calendar2-check"></span>  Attendance Result
            <a class="btn btn-primary float-end btn-sm" target="_blank" href="<?php echo URL; ?>students/printAttendance/<?php echo $this->studentInfo['studentid']; ?>"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="card-body table-responsive">
            <h4 class="box-title">Matric. No: <?php echo $this->studentInfo['regNo']; ?>;&nbsp;&nbsp;Name: <?php echo ucwords($this->studentInfo['fullname']); ?></h4>
            <table class="table table-striped table-responsive no-margin">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th class="text-center">Class Held</th>
                        <th class="text-center">Attended</th>
                        <th class="text-center">Absent</th>
                        <th class="text-center">Attendance(%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->student_class as $res):
                        $totaPresent = 0;
                        $totalAbsent = (int) $res["class"];
                        $classes = (int) $res["class"];
                        foreach ($this->attended_class as $attend):
                            if ($attend["courseAllocationId"] == $res["courseAllocationId"]):
                                $totaPresent++;
                                $totalAbsent--;
                            endif;
                        endforeach;
                        ?>
                        <tr>
                            <td><?php echo $res['code']; ?></td>
                            <td class="text-center">
                                <?php echo $classes; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $totaPresent; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $totalAbsent; ?>
                            </td>
                            <td class="text-center">
                                <?php echo number_format((($totaPresent / $classes) * 100), 2); ?>%
                            </td>
                        </tr>
                        <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>




