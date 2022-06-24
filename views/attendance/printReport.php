<?php
$model = new Model();
?>

<table style="width: 100%; margin-bottom: 20px;">
    <tbody>
        <tr>
            <td class="text-right" style="width: 25%"><img style="width: 150px" src="<?php echo URL; ?>public/assets/images/logo/logo.png" /></td>
            <td style="width: 75%">
                <h2 class="text-center text-bold">Taraba State University Jalingo</h2>
                <h3 class="text-center text-bold"><?php echo $model->getCurrentAcademicYear(); ?> Academic Session</h3>
                <h3 class="text-center text-bold"><?php echo $this->class['code']; ?> <?php echo $this->class['level']; ?> Attendance</h3>
            </td>
        </tr>
    </tbody>
</table>
<?php if ($this->students != null): ?>
    <table class="table table-striped table-responsive table-bordered no-margin">
        <thead>
            <tr>
<!--                <th>Jamb No</th>-->
                <th>Reg No</th>
                <th>Fullname</th>
                <th>present</th>
                <th>Absent</th>
                <th>Attended</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($this->students as $row):
                ?>
                <tr>
<!--                    <td><?php //echo $row["jambNo"] ?></td>-->
                    <td><?php echo $row["regNo"] ?></td>
                    <td><?php echo $row["fullname"] ?></td>
                    <td><?php echo $row["count"] ?></td>
                    <td><?php echo $this->class["count"] - $row["count"] ?></td>
                    <td><?php echo (int) $this->class["count"] > 0 ? number_format((($row["count"] / $this->class["count"]) * 100), 0) : 0 ?>%</td>
                </tr>
                <?php
            endforeach;
            ?>
        </tbody>
    </table>
    <table style="width: 100%; margin-top: 40px;">
        <tbody>
            <tr>
                <td class="text-bold">Course Lecturer:</td>
                <td class="text-bold text-right"><?php echo $this->class["staff"] ?></td>
            </tr>
        </tbody>
    </table>
<?php else: ?>
    <p>No Students</p>
<?php endif;