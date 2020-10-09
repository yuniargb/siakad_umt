$(document).ready(function () {
    $('.select2').select2({
        theme: 'bootstrap4',
    });
    // swal confirm
    $('.btn-del').on('submit', function (e) {
        let url = $(this).attr('action')
        e.preventDefault();
        Swal.fire({
            title: 'Anda yakin ingin menghapus data ini??',
            text: "Data akan terhapus secara permanen!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
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


    $('.btn-logout').on('click', function (e) {
        let url = $(this).attr('href')
        e.preventDefault();
        Swal.fire({
            title: 'Apakah anda yakin ingin keluar?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                document.location.href = url;
            }
        });
    });

    $('.btn-passs').on('click', function (e) {
        console.log('ok')
        // let url = $(this).data('url')
        // let text = $(this).data('original-title')
        e.preventDefault();
        // Swal.fire({
        //     title: 'Are you sure?',
        //     text: "You won't be able to revert this!",
        //     type: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: text
        // }).then((result) => {
        //     if (result.value) {
        //         $.ajax({
        //             type: 'get',
        //             url: url,
        //             data: $(this).serialize(),
        //             success: function (data) {
        //                 document.location.href = data;
        //             }
        //         })
        //     }
        // });
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
            title: 'Kamu yakin ingin merubah data ini?',
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


    // 
    // flash-data
    // const flashData = $('.flash-data').data('flashdata');
    // if (flashData) {
    //     let content = {};
    //     content.message = flashData;
    //     content.title = 'Sukses :';
    //     content.icon = "fa fa-check";
    //     $.notify(content, {
    //         type: 'primary',
    //         placement: {
    //             from: 'top',
    //             align: 'center'
    //         },
    //         time: 1000,
    //         delay: 0,
    //     });
    // }

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
            $('#email').val('');
            $('#angkatan').val('');
            $('#kelas').val('');


            $('#nama_panggilan').val('');
            $('#nama_ayah').val('');
            $('#agama_ayah').val('');
            $('#nama_ibu').val('');
            $('#agama_ibu').val('');
            $('#pekerjaan_ayah').val('');
            $('#pekerjaan_ibu').val('');
            $('#penghasilan_ayah').val('');
            $('#penghasilan_ibu').val('');
            $('#no_telp').val('');
            $('#no_telp_ayah').val('');
            $('#no_telp_ibu').val('');
            $('#anak_ke').val('');
            $('#alamat_wali').val('');
            $('#no_kartu').val('');

            $('.siswa-form').attr('id', 'siswaForm')
            $('#siswaForm').attr('action', '/siswa')
            $('#siswaModalMethod').html('')
            $('#siswaModalTitle').html('Tambah Siswa')
        } else {
            $.get(url, function (data) {
                data = JSON.parse(data)
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
                $('#email').val(data.email);

                $('#nama_panggilan').val(data.nama_panggilan);
                $('#nama_ayah').val(data.nama_ayah);
                $('#agama_ayah').val(data.agama_ayah);
                $('#nama_ibu').val(data.nama_ibu);
                $('#agama_ibu').val(data.agama_ibu);
                $('#pekerjaan_ayah').val(data.pekerjaan_ayah);
                $('#pekerjaan_ibu').val(data.pekerjaan_ibu);
                $('#penghasilan_ayah').val(data.penghasilan_ayah);
                $('#penghasilan_ibu').val(data.penghasilan_ibu);
                $('#no_telp').val(data.no_telp);
                $('#no_telp_ayah').val(data.no_telp_ayah);
                $('#no_telp_ibu').val(data.no_telp_ibu);
                $('#anak_ke').val(data.anak_ke);
                $('#alamat_wali').val(data.alamat_wali);
                $('#no_kartu').val(data.no_kartu);
            })
            $('.siswa-form').attr('id', 'siswaEditForm')
            $('#siswaEditForm').attr('action', '/siswa/' + id + '/update')
            $('#siswaModalMethod').html($(this).data('method'))
            $('#siswaModalTitle').html('Edit Siswa')
        }
        $('#exampleModalCenter').modal('show')
    })

    // $('#rfid-page').children().off('click');
    // $('#no_kartu_auto').focus();

    // $('#rfid-page').click(function (e) {
    //     e.preventDefault();
    // });

    $('.btnGuruModal').on('click', function () {
        let url = $(this).data('url')
        let id = $(this).data('id')
        let action = $(this).data('action')

        if (action == 'add') {
            $('#nip').prop("readonly", false)
            $('#nip').val('')
            $('#nama').val('')
            $('#tglLahir').val('')
            $('#tempatLahir').val('')
            $('#jkl').prop("checked", false)
            $('#jkp').prop("checked", false)
            $('#alamat').val('')
            $('#agama').val('');
            $('#email').val('');
            $('#no_kartu').val('');
            $('.guru-form').attr('id', 'guruForm')
            $('#guruForm').attr('action', '/guru')
            $('#guruModalMethod').html('')
            $('#guruModalTitle').html('Tambah Guru')
        } else {
            $.get(url, function (data) {
                data = JSON.parse(data)
                let jk = data.jk
                if (jk == 'l') {
                    $('#jkl').prop("checked", true)
                } else {
                    $('#jkp').prop("checked", true)
                }

                $('#nip').prop("readonly", true)
                $('#nip').val(data.nip)
                $('#nama').val(data.nama)
                $('#no_kartu').val(data.no_kartu)
                $('#tglLahir').val(data.tgl_lahir)
                $('#tempatLahir').val(data.tempat_lahir)
                $('#alamat').val(data.alamat)
                $('#agama').val(data.agama);
                $('#email').val(data.email);
            })
            $('.guru-form').attr('id', 'guruEditForm')
            $('#guruEditForm').attr('action', '/guru/' + id + '/update')
            $('#guruModalMethod').html($(this).data('method'))
            $('#guruModalTitle').html('Edit Guru')
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
            $('#no_kartu').val('')
            $('#email').val('')
            $('#adminForm').attr('action', '/admin')
            $('#password1').attr('required', true)
            $('#password').attr('required', true)
            $('#showpassedit').hide()
            $('#adminModalMethod').html('')
            $('#username').prop("readonly", false)
<<<<<<< HEAD
            $('#adminModalTitle').html('Tambah user')
=======
            $('#adminModalTitle').html('Tambah User')
>>>>>>> 23af50071349d76bdd009e33b54d57ab21aa5028
        } else {
            $.get(url, function (data) {
                $('#nama').val(data.name)
                $('#username').val(data.username)
                $('#email').val(data.email)
                $('#role').val(data.role)
                $('#no_kartu').val(data.no_kartu)
            })
            $('#adminForm').attr('action', '/admin/' + id + '/update')
            $('#adminModalMethod').html($(this).data('method'))
            $('#showpassedit').show()
            $('#password1').attr('required', false)
            $('#password').attr('required', false)
            $('#username').prop("readonly", true)
            $('#adminModalTitle').html('Edit user')
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
            $('.password-hide').show()
            $('#tahunMasuk').val('')
            $('#tarif').val('')
            $('#sppForm').attr('action', '/spp')
            $('#sppModalMethod').html('')
            $('#sppModalTitle').html('Tambah Pembayaran')
        } else {
            $.get(url, function (data) {
                $('#tahunMasuk').val(data.angkatan)
                $('#tarif').val(data.tarifspp)
            })
            $('#sppForm').attr('action', '/spp/' + id + '/update')
            $('#sppModalMethod').html($(this).data('method'))
            $('#sppModalTitle').html('Edit Pembayaran')
            $('#pass-toggle').addClass("d-none");
        }
        $('#exampleModalCenter').modal('show')
    })
    $('.btnAbsenDetailModal').on('click', function () {
        let url = $(this).data('url')
        let kelas = $(this).data('kelas')
        $('#kelasName').text(kelas)
        $.get(url, function (data) {
            console.log(data)
            var html = '';
            for (x in data) {
                html += `
                    <tr>
                        <td>${data[x].nis}</td>
                        <td>${data[x].nama}</td>
                        <td>${data[x].tagihan_id == null ? '<p class="text-danger">Belum Bayar</p>' : 'Sudah Bayar'}</td>
                    </tr>
                `
            }
            $('#detailBodys').html(html)
        })
        $('#DetailModal').modal('show')
    })
    $('.btnDetailSiswa').on('click', function () {
        let url = $(this).data('url')
        $.get(url, function (data) {
            data = JSON.parse(data)
            var html = '';
            $.each(data, function (key, value) {
                if (
                    key != "remember_token" &&
                    key != "password" &&
                    key != "email_verified_at" &&
                    key != "name" &&
                    key != "role" &&
                    key != "updated_at" &&
                    key != "created_at" &&
                    key != "user_id" &&
                    key != "kelas_id" &&
                    key != "angkatan_id" &&
                    key != "username" &&
                    key != "id"
                ) {

                    if (key === "jk") {
                        key = "jenis_kelamin"
                        if (value == "l")
                            value = "laki-laki"
                        else
                            value = "perempuan"
                    } else {
                        value = value
                    }
                    html += `
                    <tr>
                        <th>${key.replaceAll("_", " ").replaceAll("tgl", "tanggal").replaceAll("no", "nomor")}</th>
                        <th>:</th>
                        <td>${value}</td>
                    </tr>
                `
                }
            });
            $('#detailSiswa').html(html)
        })
        $('#DetailModal').modal('show')
    })
    $('#no_kartu_auto').on('input', function (e) {
        var val = $('#no_kartu_auto').val();
        if (val.length >= 11) {
            $(this).val("")
        }
        // $("#no_kartu_auto").on("keydown", false);
        console.log(val);
    })
    $('.btnBayarSiswa').on('click', function () {
        let url = $(this).data('url')
        let nis = $(this).data('nis')
        let nama = $(this).data('nama')

        $('#nisBayar').text(nis)
        $('#namaBayar').text(nama)
        $.get(url, function (data) {

            var html = '';
            for (x in data) {
                var status = '';
                if (data[x].status == 0) {
                    status = '<span class="badge badge-danger">Tunggu</span>';
                } else if (data[x].status == 3) {
                    status = '<span class="badge badge-danger">Di Tolak</span>';
                } else {
                    status = '<span class="badge badge-success">Konfirmasi</span>';
                }
                html += `
                    <tr>
                        <td>${data[x].namatipe}</td>
                        <td>${data[x].bulan}</td>
                        <td>${data[x].tahun}</td>
                        <td>${data[x].tipe_pembayaran_id == 1 ? data[x].tarifspp : data[x].biaya}</td>
                        <td>${data[x].jumlah}</td>
                        <td>${status}</td>
                    </tr>
                `
            }
            $('#bayarSiswa').html(html)
        })
        $('#BayarModal').modal('show')
    })
    $('.btnTagihanModal').on('click', function () {
        let url = $(this).data('url')
        let id = $(this).data('id')
        let action = $(this).data('action')

        if (action == 'add') {
            $('.password-hide').show()
            $('#bulan').val('')
            $('#tahun').val('')
            $('#kelas_id').val('')
            $('#tipe_pembayaran_id').val('')
            $('#tagihanForm').attr('action', '/daftartagihan')
            $('#tagihanModalMethod').html('')
            $('#tagihanModalTitle').html('Tambah Tagihan')
        } else {
            $.get(url, function (data) {
                $('#bulan').val(data.bulan)
                $('#tahun').val(data.tahun)
                $('#kelas_id').val(data.kelas_id)
                $('#tipe_pembayaran_id').val(data.tipe_pembayaran_id)
            })
            $('#tagihanForm').attr('action', '/daftartagihan/' + id + '/update')
            $('#tagihanModalMethod').html($(this).data('method'))
            $('#tagihanModalTitle').html('Edit Tagihan')
            $('#pass-toggle').addClass("d-none");
        }
        $('#exampleModalCenter').modal('show')
    })

    // crud tipe pembayaran
    $('.btnTipePembayaranModal').on('click', function () {
        let url = $(this).data('url')
        let id = $(this).data('id')
        let action = $(this).data('action')

        if (action == 'add') {
            $('#namatipe').val('')
            $('#biaya').val('')
            $('#tipepembayaranForm').attr('action', '/tipepembayaran')
            $('#tipepembayaranModalMethod').html('')
            $('#tipepembayaranModalTitle').html('Tambah Tipe Pembayaran')
        } else {
            $.get(url, function (data) {
                $('#namatipe').val(data.namatipe)
                $('#biaya').val(data.biaya)
            })
            $('#tipepembayaranForm').attr('action', '/tipepembayaran/' + id + '/update')
            $('#tipepembayaranModalMethod').html($(this).data('method'))
            $('#tipepembayaranModalTitle').html('Edit Tipe Pembayaran')
        }
        $('#exampleModalCenter').modal('show')
    })

    // crud nilai
    $('.btnNilaiModal').on('click', function () {
        let url = $(this).data('url')
        let id = $(this).data('id')
        let action = $(this).data('action')
        let type = $(this).data('type')
        if (type == "harian") {
            var act = "/nilaiharian"
            var titles = "Nilai Harian"
        }
        else if (type == "ujian") {
            var act = "/nilaiujian"
            var titles = "Nilai Ujian"
        }
        else if (type == "uts") {
            var act = "/nilaiuts"
            var titles = "Nilai UTS"
        }
        else if (type == "uas") {
            var act = "/nilaiuas"
            var titles = "Nilai UAS"
        }
        else {
            var act = "/nilairaport"
            var titles = "Nilai Raport"
        }
        if (action == 'add') {
            $('#siswa_id').val('')
            $('#type').val(type)
            $('#mata_pelajaran_id').val('')
            $('#nilai').val('')
            $('#tahun_ajaran').val('')
            $('#semester').val('')
            $('#nilaiForm').attr('action', 'nilai')
            $('#nilaiModalMethod').html('')
            $('#nilaiModalTitle').html('Tambah ' + titles)
        } else {
            $.get(url, function (data) {
                $('#siswa_id').val(data.siswa_id)
                $('#type').val(data.tipe)
                $('#mata_pelajaran_id').val(data.jadwal_id)
                $('#nilai').val(data.nilai)
                $('#tahun_ajaran').val(data.tahun_ajaran)
                $('#semester').val(data.semester)
            })
            $('#nilaiForm').attr('action', '/nilai/' + id + '/update')
            $('#nilaiModalMethod').html($(this).data('method'))
            $('#nilaiModalTitle').html('Edit ' + titles)
        }
        $('#exampleModalCenter').modal('show')
    })

    // crud silabus
    $('.btnRppDanSilabusModal').on('click', function () {
        let url = $(this).data('url')
        let id = $(this).data('id')
        let action = $(this).data('action')

        if (action == 'add') {
            $('#mata_pelajaran_id').val('')
            $('#tahun_ajaran').val('')
            $('#kelas').val('')
            $('#semester').val('')
            $('#alokasi_waktu').val('')
            $('#kompetensi_dasar').val('')
            $('#indikator_pencapaian_kompetensi').val('')
            $('#materi_pembelajaran').val('')
            $('#kegiatan_pembelajaran').val('')
            $('#ppr').val('')
            $('#media').val('')
            $('#rppdansilabusForm').attr('action', '/rppdansilabus')
            $('#rppdansilabusModalMethod').html('')
            $('#rppdansilabusModalTitle').html('Tambah RPP')
        } else {
            $.get(url, function (data) {
                $('#mata_pelajaran_id').val(data.mata_pelajaran_id)
                $('#tahun_ajaran').val(data.tahun_ajaran)
                $('#kelas').val(data.kelas)
                $('#semester').val(data.semester)
                $('#alokasi_waktu').val(data.alokasi_waktu)
                $('#kompetensi_dasar').val(data.kompetensi_dasar)
                tinyMCE.get('kompetensi_dasar').setContent(data.kompetensi_dasar)
                $('#indikator_pencapaian_kompetensi').val(data.indikator_pencapaian_kompetensi)
                tinyMCE.get('indikator_pencapaian_kompetensi').setContent(data.indikator_pencapaian_kompetensi)
                $('#materi_pembelajaran').val(data.materi_pembelajaran)
                tinyMCE.get('materi_pembelajaran').setContent(data.materi_pembelajaran)
                $('#kegiatan_pembelajaran').val(data.kegiatan_pembelajaran)
                tinyMCE.get('kegiatan_pembelajaran').setContent(data.kegiatan_pembelajaran)
                $('#ppr').val(data.ppr)
                tinyMCE.get('ppr').setContent(data.ppr)
                $('#media').val(data.media)
                tinyMCE.get('media').setContent(data.media)
            })
            $('#rppdansilabusForm').attr('action', '/rppdansilabus/' + id + '/update')
            $('#rppdansilabusModalMethod').html($(this).data('method'))
            $('#rppdansilabusModalTitle').html('Edit RPP')
        }
        $('#exampleModalCenter').modal('show')
    })

    // crud kelas
    $(document).on('click', '.btnKelasModal', function () {
        let url = $(this).data('url')
        let id = $(this).data('id')
        let action = $(this).data('action')

        if (action == 'add') {
            $('#kelas').val('')
            $('#guru_id').val('')
            $('#kelasForm').attr('action', '/kelas')
            $('#kelasModalMethod').html('')
            $('#kelasModalTitle').html('Tambah Kelas')
        } else {
            $.get(url, function (data) {
                $('#kelas').val(data.namaKelas)
                $('#guru_id').val(data.guru_id)
            })
            $('#kelasForm').attr('action', '/kelas/' + id + '/update')
            $('#kelasModalMethod').html($(this).data('method'))
            $('#kelasModalTitle').html('Edit Kelas')
        }
        $('#exampleModalCenter').modal('show')
    })

    // crud Mapel
    $(document).on('click', '.btnMapelModal', function () {
        let url = $(this).data('url')
        let id = $(this).data('id')
        let action = $(this).data('action')

        if (action == 'add') {
            $('#namamapel').val('')
            $('#jumlahjam').val('')
            $('#mapelForm').attr('action', '/matapelajaran')
            $('#mapelModalMethod').html('')
            $('#mapelModalTitle').html('Tambah Mata Pelajaran')
        } else {
            $.get(url, function (data) {
                $('#namamapel').val(data.namamapel)
                $('#jumlahjam').val(data.jumlahjam)
            })
            $('#mapelForm').attr('action', '/matapelajaran/' + id + '/update')
            $('#mapelModalMethod').html($(this).data('method'))
            $('#mapelModalTitle').html('Edit Mata Pelajaran')
        }
        $('#exampleModalCenter').modal('show')
    })

    // crud Jadwal
    $(document).on('click', '.btnJadwalModal', function () {
        let url = $(this).data('url')
        let id = $(this).data('id')
        let action = $(this).data('action')

        if (action == 'add') {
            $('#jam').val('')
            $('#hari').val('')
            $('#semester').val('')
            $('#guru_id').val('')
            $('#kelas_id').val('')
            $('#mata_pelajaran_id').val('')
            $('#tahun_ajaran').val('')
            $('#jadwalForm').attr('action', '/jadwal')
            $('#jadwalModalMethod').html('')
            $('#jadwalModalTitle').html('Tambah Jadwal')
        } else {
            $.get(url, function (data) {
                $('#jam').val(data.jam)
                $('#hari').val(data.hari)
                $('#semester').val(data.semester)
                $('#guru_id').val(data.guru_id)
                $('#kelas_id').val(data.kelas_id)
                $('#mata_pelajaran_id').val(data.mata_pelajaran_id)
                $('#tahun_ajaran').val(data.tahun_ajaran)
            })
            $('#jadwalForm').attr('action', '/jadwal/' + id + '/update')
            $('#jadwalModalMethod').html($(this).data('method'))
            $('#jadwalModalTitle').html('Edit jadwal')
        }
        $('#exampleModalCenter').modal('show')
    })

    // crud Absen
    $(document).on('click', '.btnAbsenEditModal', function () {
        let url = $(this).data('url')
        let id = $(this).data('id')
        let nama = $(this).data('nama')
        editData(url, id, nama)
    })
    $(document).on('change', '#kelas', function () {
        let id = $(this).val()
        $.get(`/siswa/${id}/kelas`, function (data) {
            console.log(data)
            var html = '';

            for (x in data) {
                html += `
                     <tr>
                        <td>${x}</td>
                        <td><input type="hidden" name="id[]" value="${data[x].id}">${data[x].nis}</td>
                        <td>${data[x].nama}</td>
                        <td>
                            <select class="form-control" name="keterangan[]" id="keterangan[]" required>
                                <option value="Hadir" selected>Hadir</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Izin">Izin</option>
                                <option value="Alfa">Alfa</option>
                                <option value="Dispensasi">Dispensasi</option>
                            </select>
                        </td>
                    </tr>
                `
            }
            $('#tambahBody').html(html)
        })
    })
    $(document).on('click', '.btnAbsenDetailModal', function () {
        let url = $(this).data('url')
        let id = $(this).data('id')
        let nama = $(this).data('nama')
        $('#detailID').text(id)
        $('#detailNama').text(nama)
        $.get(url, function (data) {

            var html = '';

            for (x in data) {
                html += `
                    <tr>
                        <td>${data[x].tgl_absen}</td>
                        <td>${data[x].jam_masuk}</td>
                        <td>${data[x].jam_pulang}</td>
                        <td>${data[x].keterangan}</td>
                    </tr>
                `
            }
            $('#detailBody').html(html)
        })
        $('#DetailModal').modal('show')
    })

    function editData(url, id, nama) {
        $('#editID').text(id)
        $('#editNama').text(nama)
        $.get(url, function (data) {

            var html = '';

            for (x in data) {
                html += `
                    <tr>
                        <td><input type="hidden" name="id[]" value="${data[x].id}">${data[x].tgl_absen}</td>
                        <td>
                            <select class="form-control" name="keterangan[]" id="keterangan[]" required>
                                <option value="Hadir" ${data[x].keterangan == "Hadir" ? "selected" : ''}>Hadir</option>
                                <option value="Sakit" ${data[x].keterangan == "Sakit" ? "selected" : ''}>Sakit</option>
                                <option value="Izin" ${data[x].keterangan == "Izin" ? "selected" : ''}>Izin</option>
                                <option value="Alfa" ${data[x].keterangan == "Alfa" ? "selected" : ''}>Alfa</option>
                                <option value="Dispensasi" ${data[x].keterangan == "Dispensasi" ? "selected" : ''}>Dispensasi</option>
                            </select>
                        </td>
                    </tr>
                `
            }
            $('#dataBody').html(html)
        })
        $('#EditModal').modal('show')
    }

    $('.basic-datatables').DataTable();
    $(document).on('click', '.btnPembayaranModal', function () {
        let url = $(this).data('url')
        let id = $(this).data('id')
        let tipe = $(this).data('tipe')
        let jumlah = $(this).data('jumlah')
        let action = $(this).data('action')

        if (action == 'add') {
            $('#atm').val('')
            $('#jumlah').val('')
            $('#tgl').val('')
            $('#bukti').val('')
            $('#tagihan_id').val(id)
            $('#jumlahd').val(jumlah)
            $('#pembayaranForm').attr('action', '/pembayaran')
            $('#pembayaranModalMethod').html('')
            $('#pembayaranModalTitle').html('Tambah Pembayaran ' + tipe)
        } else {
            $.get(url, function (data) {
                $('#nis').val('')
                $('#atm').val('')
                $('#jumlah').val('')
                $('#tgl').val('')
                $('#bukti').val('')
                $('#tipepembayaran').val('')
            })
            $('#pembayaranForm').attr('action', '/pembayaran/' + id + '/update')
            $('#pembayaranModalMethod').html($(this).data('method'))
            $('#pembayaranModalTitle').html('Edit Pembayaran')
        }
        $('#exampleModalCenter').modal('show')
    })
})
