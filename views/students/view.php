<div class="text-center">
    <p class="d-flex justify-content-between">
    <?php
    if ($this->student['biometric'] != ""):
       ?>
        <img style='height: 200px; margin-left: 50px!important;' src="<?php echo URL."public/uploads/biometric/".$this->student['biometric']; ?>"/>
        <?php
    else:
        ?>
        <img style='height: 200px;margin-left: 50px!important;' src="<?php echo URL; ?>public/not-enroll.png" />
    <?php
    endif;
    ?>
    <img style='height: 200px;margin-right: 50px!important;' src="<?php echo URL; ?>public/<?php echo ($this->student['image'] != "") ? "uploads/student/" . $this->student['image'] : "no-image.gif"; ?>" />
</p>
<h4 class="text-center"><?php echo ucwords($this->student['fullname']); ?></h4>
<p class="text-center">
</p>
<p class="text-center">Student Matric. No: <?php echo $this->student['regNo']; ?></p>
</div>
<?php

function base64_to_jpeg($base64_string, $output_file) {
    file_put_contents($output_file, $base64_string);
    return $output_file;
}
