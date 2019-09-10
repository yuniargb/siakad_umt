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

    $('.detail-bukti').on('click', function () {
        let gambar = $(this).data('image')

        $('#datagambar').attr('src', gambar)
    });
    $('#showpass').hide()
    $('#password1').on('keyup', function () {
        $p1 = $(this).val();
        $p = $('#password').val();

        if ($p1 != $p) {
            $('#save').attr('disabled', true)
            $('#showpass').show()
        } else {
            $('#showpass').hide()
            $('#save').attr('disabled', false)
        }
    })
    // swal confirm
    $('.kon').on('click', function (e) {
        let url = $(this).data('url')
        let text = $(this).data('original-title')
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: text
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'get',
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

    // crud siswa
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
            $('#angkatan').val('');
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
                $('#kelas').val(data.kelas_id);
                $('#angkatan').val(data.angkatan_id);
            })
            $('#siswaForm').attr('action', '/siswa/' + id + '/update')
            $('#siswaModalMethod').html($(this).data('method'))
            $('#siswaModalTitle').html('Edit Siswa')
        }
        $('#exampleModalCenter').modal('show')
    })

    // crud admin
    $('.btnAdminModal').on('click', function () {
        let url = $(this).data('url')
        let id = $(this).data('id')
        let action = $(this).data('action')

        if (action == 'add') {
            $('#nama').val('')
            $('#username').val('')
            $('#adminForm').attr('action', '/admin')
            $('#adminModalMethod').html('')
            $('#adminModalTitle').html('Tambah Admin')
        } else {
            $.get(url, function (data) {
                $('#nama').val(data.name)
                $('#username').val(data.username)
            })
            $('#adminForm').attr('action', '/admin/' + id + '/update')
            $('#adminModalMethod').html($(this).data('method'))
            $('#adminModalTitle').html('Edit Admin')
        }
        $('#exampleModalCenter').modal('show')
    })

    // udit user
    $('.btnEditUser').on('click', function () {
        let url = $(this).data('url')
        $.get(url, function (data) {
            $('#nama').val(data.name)
            $('#username').val(data.username)
        })
        $('#editModalUser').modal('show')
    })

    // crud spp
    $('.btnSppModal').on('click', function () {
        let url = $(this).data('url')
        let id = $(this).data('id')
        let action = $(this).data('action')

        if (action == 'add') {
            $('#tahunMasuk').val('')
            $('#tarif').val('')
            $('#sppForm').attr('action', '/spp')
            $('#sppModalMethod').html('')
            $('#sppModalTitle').html('Tambah Spp')
        } else {
            $.get(url, function (data) {
                $('#tahunMasuk').val(data.angkatan)
                $('#tarif').val(data.tarifspp)
            })
            $('#sppForm').attr('action', '/spp/' + id + '/update')
            $('#sppModalMethod').html($(this).data('method'))
            $('#sppModalTitle').html('Edit Spp')
        }
        $('#exampleModalCenter').modal('show')
    })

    // crud spp
    $(document).on('click', '.btnKelasModal', function () {
        let url = $(this).data('url')
        let id = $(this).data('id')
        let action = $(this).data('action')

        if (action == 'add') {
            $('#kelas').val('')
            $('#kelasForm').attr('action', '/kelas')
            $('#kelasModalMethod').html('')
            $('#kelasModalTitle').html('Tambah Kelas')
        } else {
            $.get(url, function (data) {
                $('#kelas').val(data.namaKelas)
            })
            $('#kelasForm').attr('action', '/kelas/' + id + '/update')
            $('#kelasModalMethod').html($(this).data('method'))
            $('#kelasModalTitle').html('Edit Kelas')
        }
        $('#exampleModalCenter').modal('show')
    })

    $(document).on('click', '.btnPembayaranModal', function () {
        let url = $(this).data('url')
        let id = $(this).data('id')
        let action = $(this).data('action')

        if (action == 'add') {
            $('#atm').val('')
            $('#jumlah').val('')
            $('#tgl').val('')
            $('#bukti').val('')
            $('#pembayaranForm').attr('action', '/pembayaran')
            $('#pembayaranModalMethod').html('')
            $('#pembayaranModalTitle').html('Tambah Pembayaran')
        } else {
            $.get(url, function (data) {
                $('#nis').val('')
                $('#atm').val('')
                $('#jumlah').val('')
                $('#tgl').val('')
                $('#bukti').val('')
            })
            $('#pembayaranForm').attr('action', '/pembayaran/' + id + '/update')
            $('#pembayaranModalMethod').html($(this).data('method'))
            $('#pembayaranModalTitle').html('Edit Pembayaran')
        }
        $('#exampleModalCenter').modal('show')
    })
})
