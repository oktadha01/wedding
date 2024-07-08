<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('temp_admin/header'); ?>
<body>
    <div class="container-scroller">
        <?php $this->load->view('temp_admin/sidebar'); ?>
        <div class="container-fluid page-body-wrapper">
            <?php $this->load->view('temp_admin/navbar'); ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <?php $this->load->view($content); ?>
                </div>
            </div>
        </div>
        <?php $this->load->view('temp_admin/footer'); ?>
        <?php $this->load->view($script); ?>
    </div>
</body>

</html>