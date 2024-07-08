<style>
    .paginate_button {
        padding: 0px 10px;
        border: 1px solid;
        margin: 0px 3px;
        border-radius: 4px;
    }

    .paginate_button.active,
    .paginate_button:hover {
        color: chartreuse;
        border: 3px solid;
    }

    .paginate_button.active>a,
    .paginate_button>a:hover {
        color: white;
    }

    .table,
    .odd,
    .even {
        --bs-table-striped-color: white;
        color: white;
    }

    input,
    select {
        --bs-table-striped-color: white;
        color: white !important;
    }
</style>
<div class="card mb-4">
    <div class="card-header">
        <h4 class="tittle-form-list">Add List Undangan</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-12">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="name">
                    <span class="small text-danger valid-name"></span>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <div class="form-group">
                    <label for="contact">Contact</label>
                    <input type="number" class="form-control" id="contact" placeholder="Whatsapp">
                    <span class="small text-danger valid-contact"></span>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-12">
                <div class="form-group">
                    <label for="category">Select category</label>
                    <div class="row">
                        <div class="col">
                            <select class="form-control form-control select-category category" id="category">
                            </select>
                        </div>
                        <div class="col col-in-category" hidden>
                            <input type="text" class="form-control input-category category" placeholder="Add category">
                        </div>
                        <span class="small text-danger valid-category"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <button class="btn btn-inverse-danger btn-cencel" hidden>Cencel edit data</button>
            </div>
            <div class="col-6">
                <button class="btn btn-inverse-primary float-right btn-add-list" data-action="add">Save data</button>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h4>List Undangan</h4>
    </div>
    <div class="card-body">
        <ul style="display: flex;list-style: none;justify-content: flex-start;padding-left: 0;">
            <li>
                <button class="btn btn-inverse-success btn-chat">Send Whatsapp <span class="span-num-send">0</span></button>
            </li>
            <li>
                <div class="form-group">
                    <select class="form-control form-control" id="fil-status-send" style="height: fit-content;width: 9rem;margin-left: 14px;">
                        <option value="">Select status</option>
                        <option value="send">Send</option>
                        <option value="resending">Resending</option>
                    </select>
                </div>
            </li>
        </ul>
        <hr>
        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>name</th>
                    <th>Whatsapp</th>
                    <th style="display: ruby-text;">
                        <div class="form-check form-check-success">
                            <label class="form-check-label">
                                <input type="checkbox" id="cheklis-all" class="form-check-input"> <i class="input-helper"></i></label>
                        </div>
                        Cheklis All
                    </th>
                    <th>Sent Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<div id="progress"></div>
<input type="text" id="id-undangan" value="" style="
    color: black !important;
" hidden>

<!-- <span class="text-success">text success</span>
<span class="text-behance">text behance</span>
<span class="text-youtube">text youtube</span>
<span class="text-warning">text warning</span>
<span class="text-dribbble">text dribbble</span>
<span class="text-burlywood">text burlywood</span>
<span class="text-blueviolet">text blueviolet</span>
<span class="text-tomato">text tomato</span>
<span class="text-darkcyan">text darkcyan</span>
<span class="text-powderblue">text powderblue</span> -->