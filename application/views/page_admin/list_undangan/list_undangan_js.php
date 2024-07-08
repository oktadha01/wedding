<script>
    $(document).ready(function() {

        // load_datateble();
        var table;

        table = $('#example').DataTable({
            "pageLength": 10, // Default number of rows to display
            "paging": true,
            "autoWidth": false, // Fixed typo here
            "search": true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ordering": false, // Disable sorting
            "ajax": {
                "url": "<?= site_url('List_undangan/get_dataundangan/'); ?>",
                "type": "POST",
                "data": function(d) {
                    d.fil_status_send = $('#fil-status-send').val();
                }
            },
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ] // Added lengthMenu option
        });
        $('#fil-status-send').on('change', function() {
            // debugging apakah nilai select muncul
            // console.log('Nilai select: ' + $(this).val());
            table.draw();
        });
        var val_category = '';
        load_category(val_category);

    });
    $('.input-category').removeAttr('id');
    $('#category').change(function(e) {
        // alert($(this).val());
        if ($(this).val() == 'add category') {
            $('.select-category').removeAttr('id');
            $('.input-category').attr('id', 'category');
            $('.col-in-category').removeAttr('hidden', true).show();
            $('#category').on('input', function() {
                var input = 'category';
                var action = '';
                valid_form(input, action);
                // alert(input);
            });
        } else {
            $('.select-category').attr('id', 'category');
            $('.col-in-category').hide().removeAttr('id');
        }
        var selectedOption = $(this).find('option:selected');

        // Get the value of the data-color attribute of the selected option
        var dataColor = selectedOption.data('color');

        // Output the value to the console
        console.log($(this).find('option:selected').data('color'));

        var input = $(this).attr('id');
        var action = '';
        valid_form(input, action);
    });
    $('#name,#contact').on('input', function() {
        var input = $(this).attr('id');
        var action = '';
        valid_form(input, action);
    });

    $('.btn-add-list').click(function() {
        var input = '';
        var action = $(this).data('action');
        valid_form(input, action);
    });

    function edit_list_undangan(item) {
        // alert('ready');
        $('#category').val('')
        $('.select-category').attr('id', 'category');
        $('.col-in-category').hide().removeAttr('id');

        $('#name').val($(item).data('name'));
        $('#contact').val($(item).data('contact'))
        $('#category').val($(item).data('category'))
        $('.btn-add-list').attr('data-action', 'edit_data').val($(item).data('id-undangan'));
        $('.btn-cencel').removeAttr('hidden', true).show();
        $('.tittle-form-list').text('Edit List Undangan');
    }

    function delete_list_undangan(item) {
        // alert($(item).val());

        var el = this;
        var confirmalert = confirm("Are you sure?");
        if (confirmalert == true) {
            let formData = new FormData();
            formData.append('id-undangan', $(item).val());
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('List_undangan/delete_list_undangan'); ?>",
                data: formData,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    var text = response.text;
                    var resp = response.resp;
                    resp_alert(text, resp);
                    var table = $('#example').DataTable();
                    table.ajax.reload(null, false);
                },
                error: function() {
                    alert("Data Gagal Diupload");
                }
            });
        }
    }

    $('.btn-cencel').click(function() {
        $('#name').val('');
        $('#contact').val('');
        $('#category').val('');
        $('.btn-add-list').attr('data-action', 'add').val('');
        $('.btn-cencel').hide();
        $('.tittle-form-list').text('Add List Undangan');
    });


    function valid_form(input, action) {
        var isValid = true;

        if (input == 'name' || input == '') {
            if ($('#name').val() == '') {
                $('.valid-name').text('The column cannot be empty!');
                isValid = false;
            } else {
                $('.valid-name').text('');
            }
        }

        if (input == 'contact' || input == '') {
            if ($('#contact').val() == '') {
                $('.valid-contact').text('The column cannot be empty!');
                isValid = false;
            } else {
                $('.valid-contact').text('');
            }
        }

        if (input == 'category' || input == '') {
            if ($('#category').val() == '') {
                $('.valid-category').text('The column cannot be empty!');
                isValid = false;
            } else {
                $('.valid-category').text('');
            }
        }

        if (action == 'add' || action == 'edit_data') {

            // Additional check for complete form validation
            if (isValid) {
                // Proceed with form submission or other desired actions
                // Example: $('#myForm').submit(); or any other logic
                // alert('Form is completely filled!' + action);
                postdata(action);
            }
        }
    }

    function postdata(action) {
        let formData = new FormData();
        formData.append('name', $('#name').val());
        formData.append('contact', $('#contact').val());
        formData.append('category', $('#category').val());
        formData.append('col-category', $('#category').find('option:selected').data('color'));
        if (action == 'add') {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('List_undangan/'); ?>" + action + '_undangan',
                data: formData,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    var text = response.text;
                    var resp = response.resp;
                    if (resp == 'success') {
                        $('#name').val('');
                        $('#contact').val('');
                        var table = $('#example').DataTable();
                        table.ajax.reload(null, false);
                        var val_category = $('#category').val();
                    } else {
                        var val_category = '';
                    }
                    load_category(val_category);
                    resp_alert(text, resp);
                },
                error: function() {
                    alert("Data Gagal Diupload123");
                }
            });
        }


        if (action == 'edit_data') {
            // var el = this;
            var confirmalert = confirm("Are you sure?");
            if (confirmalert == true) {
                formData.append('id-undangan', $('.btn-add-list').val());

                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url('List_undangan/'); ?>" + action + '_undangan',
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var text = response.text;
                        var resp = response.resp;
                        if (resp == 'success') {
                            resp_alert(text, resp);
                            $('.btn-cencel').click();
                            var table = $('#example').DataTable();
                            table.ajax.reload(null, false);
                            var val_category = $('#category').val();
                        } else {
                            var val_category = '';
                        }
                        load_category(val_category);
                        resp_alert(text, resp);
                    },
                    error: function() {
                        alert("Data Gagal Diupload");
                    }
                });
            }
        }
    }

    function cheklis_sent(item) {
        if ($(item).is(":checked")) {
            $('#btn-send-' + $(item).val()).removeClass('btn-inverse-secondary').addClass('btn-inverse-success');
        } else {
            $('#btn-send-' + $(item).val()).removeClass('btn-inverse-success').addClass('btn-inverse-secondary');
        }
        $('#id-undangan').val($('.cheklis-send:checked').val())
        var checkboxes = $('.cheklis-send');
        var result = "";
        var countChecked = 0;
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                result += checkboxes[i].value + ",";
            }
            // console.log(i++);
        }
        checkboxes.each(function() {
            if (this.checked) {
                countChecked++;
            }
        });
        $('.span-num-send').text(countChecked)
        $('#id-undangan').val(result)
    };

    $('#cheklis-all').click(function() {
        // alert('yaa');
        if ($(this).is(":checked")) {
            // alert('yaa')
            $('.btn-send').removeClass('btn-inverse-secondary').addClass('btn-inverse-success');
            $('.cheklis-send').prop('checked', true);
        } else {
            $('.btn-send').removeClass('btn-inverse-success').addClass('btn-inverse-secondary');
            $('.cheklis-send').prop('checked', false);

        }
        $('#id-undangan').val($('.cheklis-send:checked').val())
        var checkboxes = $('.cheklis-send');
        var result = "";
        var countChecked = 0;
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                result += checkboxes[i].value + ",";
            }
        }
        checkboxes.each(function() {
            if (this.checked) {
                countChecked++;
            }
        });
        $('.span-num-send').text(countChecked)

        $('#id-undangan').val(result)

    });
    $('.btn-chat').click(function() {
        if ($('.span-num-send').text() == '0') {
            var text = 'No recipient !';
            var resp = 'error';
            resp_alert(text, resp);
        } else {
            var confirmalert = confirm("Are you sure?");
            if (confirmalert == true) {
                let formData = new FormData();
                formData.append('id-undangan', $('#id-undangan').val());
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url('List_undangan/chat_wa'); ?>",
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var text = response.text;
                        var resp = response.resp;
                        resp_alert(text, resp);
                        var table = $('#example').DataTable();
                        table.ajax.reload(null, false);
                        $('#cheklis-all').prop('checked', false);
                        $('.span-num-send').text('0');
                        $('#id-undangan').val('');
                    },
                    error: function() {
                        alert("Data Gagal Diupload");
                    }
                });
            }
        }
    });

    function load_category(val_category) {
        $.ajax({
            url: "<?php echo site_url('List_undangan/select_category'); ?>",
            cache: false,
            processData: false,
            contentType: false,
            success: function(data) {
                $('.select-category').attr('id', 'category');
                $('.col-in-category').hide().removeAttr('id');
                $('#category').html(data);
                $('#category').val(val_category);
            },
            error: function() {
                alert("Data Gagal Diupload");
            }
        });
        $.ajax({
            url: "<?php echo site_url('List_undangan/count_category_und'); ?>",
            cache: false,
            processData: false,
            contentType: false,
            success: function(data) {
                $('#progress').html(data);
            },
            error: function() {
                alert("Data Gagal Diupload");
            }
        });
    }


    function load_datateble() {}

    var toastMixin = Swal.mixin({
        toast: true,
        title: "General Title",
        animation: false,
        position: "top-right",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        }
    });

    function resp_alert(text, resp) {

        toastMixin.fire({
            animation: true,
            title: text,
            icon: resp,
        });
    }

    function alert_error() {

        toastMixin.fire({
            animation: true,
            title: "Wrong Password",
            icon: "error"
        });
    }

    // $("#category").select2({
    //     placeholder: "Pilih category",
    //     allowClear: true
    // });
    // document.querySelector(".first").addEventListener("click", function() {
    //     Swal.fire({
    //         toast: true,
    //         icon: "success",
    //         title: "Posted successfully",
    //         animation: false,
    //         position: "bottom",
    //         showConfirmButton: false,
    //         timer: 3000,
    //         timerProgressBar: true,
    //         didOpen: (toast) => {
    //             toast.addEventListener("mouseenter", Swal.stopTimer);
    //             toast.addEventListener("mouseleave", Swal.resumeTimer);
    //         }
    //     });
    // });
</script>