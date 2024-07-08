<div class="row">
    <?php foreach ($count_data as $data) { ?>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0"><?= $data->total; ?></h3>
                                <p class="text-danger ms-2 mb-0 font-weight-medium">- <?= $data->tdk_hadir; ?> <p class="text-success ms-2 mb-0 font-weight-medium">Undangan</p></span>

                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success ">
                                <span class="mdi mdi-database icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <!-- <h6 class="text-muted font-weight-normal">Potential growth</h6> -->
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0"><?= $data->processing; ?> </h3>
                                <p class="text-warning ms-2 mb-0 font-weight-medium">Delivery process</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon delivery-process">
                                <span class="mdi mdi-clock icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <!-- <h6 class="text-muted font-weight-normal">Revenue current</h6> -->
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0"><?= $data->sent; ?></h3>
                                <p class="text-success ms-2 mb-0 font-weight-medium">Sent</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success">
                                <span class="mdi mdi-check icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <!-- <h6 class="text-muted font-weight-normal">Revenue current</h6> -->
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0"><?= $data->delivered; ?></h3>
                                <p class="text-success ms-2 mb-0 font-weight-medium">Delivered</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success">
                                <span class="mdi mdi-check-all icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <!-- <h6 class="text-muted font-weight-normal">Revenue current</h6> -->
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0"><?= $data->hadir; ?></h3>
                                <p class="text-success ms-2 mb-0 font-weight-medium">+<?= $data->total_hadir; ?> Present</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success">
                                <span class="mdi mdi-check-all icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <!-- <h6 class="text-muted font-weight-normal"></h6> -->
                </div>
            </div>
        </div>
    <?php } ?>
</div>