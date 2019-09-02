$(document).ready(function () {
    // swal confirm
    $('.btn-del').on('submit', function (e) {
        let url = $(this).attr('action')
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'delete',
                    url: url,
                    data: $(this).serialize(),
                    success: function (data) {
                        document.location.href = data;
                    }
                })
            }
        });
    });

    // datatable
    $('.basic-datatables').DataTable();

    // flash-data
    const flashData = $('.flash-data').data('flashdata');
    if (flashData) {
        let content = {};
        content.message = flashData;
        content.title = 'Success :';
        content.icon = "fa fa-check";
        $.notify(content, {
            type: 'primary',
            placement: {
                from: 'top',
                align: 'center'
            },
            time: 1000,
            delay: 0,
        });
    }

    $('.btnSiswaModal').on('click', function () {
        let url = $(this).data('url')
        let id = $(this).data('id')
        let action = $(this).data('action')

        if (action == 'add') {
            $('#nis').prop("readonly", false)
            $('#nis').val('')
            $('#nama').val('')
            $('#tglLahir').val('')
            $('#tempatLahir').val('')
            $('#jkl').prop("checked", false)
            $('#jkp').prop("checked", false)
            $('#alamat').val('')
            $('#agama').val('');
            $('#siswaForm').attr('action', '/siswa')
            $('#siswaModalMethod').html('')
            $('#siswaModalTitle').html('Tambah Siswa')
        } else {
            $.get(url, function (data) {
                let jk = data.jk
                if (jk == 'l') {
                    $('#jkl').prop("checked", true)
                } else {
                    $('#jkp').prop("checked", true)
                }
                $('#nis').prop("readonly", true)
                $('#nis').val(data.nis)
                $('#nama').val(data.nama)
                $('#tglLahir').val(data.tgl_lahir)
                $('#tempatLahir').val(data.tempat_lahir)
                $('#alamat').val(data.alamat)
                $('#agama').val(data.agama);
            })
            $('#siswaForm').attr('action', '/siswa/' + id + '/update')
            $('#siswaModalMethod').html($(this).data('method'))
            $('#siswaModalTitle').html('Edit Siswa')
        }
        $('#exampleModalCenter').modal('show')
    })
})
