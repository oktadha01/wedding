<script>
    $(document).ready(function() {
        load_ucapan();
    });

    $('#hadir').change(function() {
        if ($(this).val() == 'No') {
            $('#select-jumlah').hide();
        } else {
            $('#select-jumlah').show();
        }
    })
    $('#gform_submit_button_1').click(function() {
        let formData = new FormData();
        formData.append('name', $('#name').val());
        formData.append('hadir', $('#hadir').val());
        formData.append('jumlah', $('#jumlah').val());
        formData.append('ucapan', $('#ucapan').val());
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url('Invitation/add_ucapan'); ?>",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function(data) {
                // alert(data);
                alert_success();
                load_ucapan();
                remmove_form_ucapan();

            },
            error: function() {
                alert("Data Gagal Diupload");
            }
        });
    });

    function remmove_form_ucapan() {
        $('#name').val('');
        $('#hadir').val('1');
        $('#hadir').val('Yes');
        $('#ucapan').val('');
    }

    function load_ucapan() {
        $.ajax({
            url: "<?php echo site_url('Invitation/load_ucapan'); ?>",
            cache: false,
            processData: false,
            contentType: false,
            success: function(data) {
                // alert(data);
                $('#load-ucapan').html(data);

            },
            error: function() {
                alert("Data Gagal Diupload");
            }
        });
    }

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

    function alert_success() {

        toastMixin.fire({
            animation: true,
            title: "Invitation saved successfully",
            icon: "success",
        });
    }
</script>