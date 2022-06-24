<div class="modal center fade modal-borderless" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
            </div>
            <div class="modal-body">
                <div id="delete_content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id='confirm' onclick="">Delete</button>
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-borderless" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()"></button>
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-borderless" id="viewer_modal2" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span class="bi bi-x"></span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-borderless uni_modal_right" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="fa fa-arrow-right"></span>
                </button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<script src="<?php echo URL . "public" ?>/assets/vendors/jquery/jquery.min.js"></script>
<script src="<?php echo URL . "public" ?>/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?php echo URL . "public" ?>/assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo URL . "public" ?>/assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?php echo URL . "public" ?>/assets/js/main.js"></script>
<?php
if (isset($this->jslibrary)) {
    echo "\n";
    foreach ($this->jslibrary as $js) {
        echo "\t<script type='text/javascript' src='" . URL . "public/assets/" . $js . ".js'></script>\n";
    }
}
?>
<?php
if (isset($this->customlibrary)) {
    echo "\n";
    foreach ($this->customlibrary as $js) {
        echo "\t<script type='text/javascript' src='" . URL . "views/" . $js . ".js'></script>\n";
    }
}
?>
</html>