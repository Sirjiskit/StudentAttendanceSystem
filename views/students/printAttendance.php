<p class="text-center"><img style="width: 150px" src="<?php echo URL; ?>public/assets/images/logo/logo.png" /></p>
<h3 class="text-bold text-center">BUK Student Attendance Result</h3>
<h4 class="text-bold">Name: <?php echo ucwords($this->studentInfo['fullname']); ?></h4>
<h4 class="text-bold">Matric. No: <?php echo $this->studentInfo['regNo']; ?></h4>
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