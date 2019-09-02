$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // number field
    $('#stock, #price, #weight').number(true, 0, ',', '.')

    // data table
    $('.basic-datatables').DataTable();

    // crud product
    // cancel product
    $('#divDtlProduct').on('click', '.btl-product', function (e) {
        e.preventDefault();
        $(this).parents('tr').remove();
    });

    // add detail product
    $('#btnDtlProduct').on('click', function () {
        let size = $('#size').val()
        let color = $('#color').val()
        let stock = $('#stock').val()

        if (size && color && stock) {
            $('#divDtlProduct').append(`
                <tr>
                    <td class="uppercase">
                        ` + size + `
                        <input type="hidden" name="sizee[]" value="` + size + `">
                    </td>
                    <td class="capitalize">
                        ` + color + `
                        <input type="hidden" name="colorr[]" value="` + color + `">
                    </td>
                    <td>
                        ` + stock + `
                        <input type="hidden" name="stockk[]" value="` + stock + `">
                    </td>
                    <td>
                        <div class="row">
                            <button type="button" class="btn btn-link btn-danger btl-product" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-times"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `)
            $('#size, #color, #stock').removeClass('is-invalid')
            $('#size, #color, #stock').val('')
            $('#size').focus()
        } else {
            let invEls = {
                'size': size,
                'color': color,
                'stock': stock
            }

            $.each(invEls, function (key, value) {
                if (!value) {
                    $('#' + key).addClass('is-invalid')
                }
            })
        }
    })

    // crud utility
    // utility modal
    $('.btnUtilityModal, .utilityEdit').on('click', function () {
        let content = $(this).data('content')
        let action = $(this).data('action')
        if (content == 'color') {
            switch (action) {
                case 'edit':
                    let idClr = $(this).data('id')
                    $.get($(this).data('href'), function (data) {
                        $('#utilityNameInput').val(data)
                    })
                    $('#utilityModalTitle').html('Edit color')
                    $('#utilityForm').attr('action', '/color/update/' + idClr)
                    $('#utilityMethod').html($(this).data('method'))
                    break;

                default:
                    $('#utilityModalTitle').html('Add new color')
                    $('#utilityMethod').html('')
                    $('#utilityForm').attr('action', '/color/store')
                    break;
            }
            $('#utilityNameLabel').html('Color Name')
            $('#utilityNameInput').attr('name', 'color_name')
            $('#utilityNameInput').val('')
            $('#utilityModal').modal('show')
        } else {
            switch (action) {
                case 'edit':
                    let idCtg = $(this).data('id')
                    $.get($(this).data('href'), function (data) {
                        $('#utilityNameInput').val(data)
                    })
                    $('#utilityModalTitle').html('Edit category')
                    $('#utilityForm').attr('action', '/category/update/' + idCtg)
                    $('#utilityMethod').html($(this).data('method'))
                    break;

                default:
                    $('#utilityModalTitle').html('Add new category')
                    $('#utilityMethod').html('')
                    $('#utilityForm').attr('action', '/category/store')
                    break;
            }
            $('#utilityNameLabel').html('Category Name')
            $('#utilityNameInput').attr('name', 'category_name')
            $('#utilityNameInput').val('')
            $('#utilityModal').modal('show')
        }
    })

    // crud product
    // file-input
    $('.custom-file-input').on('change', function () {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass('selected').html(fileName);
    })

    // multiple-file-input
    $("#customFile").change(function () {
        let total_file = document.getElementById("customFile").files.length;
        for (let i = 0; i < total_file; i++) {
            $('#image_preview').append(`
                <div class="col-md-4 mb-3">
                    <img src="` + URL.createObjectURL(event.target.files[i]) + `" width="100%" height="100%" class="img-fluid">
                </div>
            `);
        }
    });

    $('.btnProductModal').on('click', function () {
        $('#productModalTitle').html('Add new product')
        $('#productModal').modal('show')
    })

    // swal success
    const flashMessage = $('.flash-data').data('flashdata');
    if (flashMessage) {
        Swal.fire(
            'Success!',
            flashMessage,
            'success'
        )
    }

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

})
