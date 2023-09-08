 <!-- Footer -->
 <footer class="sticky-footer bg-light">
     <div class="container my-auto">
         <div class="copyright text-center my-auto">
             <span>Copyright &copy; Aplikasi Tes <?php echo date('Y'); ?> &bull; by <a
                     href="https://instagram.com/muhalfian_27" target="_blank">Muhammad Alfian</a></span>

         </div>
     </div>
 </footer>

 </footer>
 <!-- End of Footer -->

 </div>
 <!-- End of Content Wrapper -->

 </div>
 <!-- End of Page Wrapper -->

 <!-- Scroll to Top Button-->
 <a class="scroll-to-top rounded" href="#page-top">
     <i class="fas fa-angle-up"></i>
 </a>

 <!-- Logout Modal-->
 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Yakin ingin logout?</h5>
                 <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                 </button>
             </div>
             <div class="modal-body">Klik "Logout" dibawah ini jika anda yakin ingin logout.</div>
             <div class="modal-footer">
                 <button class="btn btn-secondary" type="button" data-dismiss="modal">Batalkan</button>
                 <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
             </div>
         </div>
     </div>
 </div>

 <!-- Bootstrap core JavaScript-->
 <script src="<?= base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

 <!-- Core plugin JavaScript-->
 <script src="<?= base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

 <!-- Custom scripts for all pages-->
 <script src="<?= base_url(); ?>assets/js/sb-admin-2.min.js"></script>

 <!-- Datepicker -->
 <script src="<?= base_url(); ?>assets/vendor/daterangepicker/moment.min.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/daterangepicker/daterangepicker.min.js"></script>

 <!-- Page level plugins -->
 <script src="<?= base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/datatables/buttons/js/dataTables.buttons.min.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/datatables/buttons/js/buttons.bootstrap4.min.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/datatables/jszip/jszip.min.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/datatables/pdfmake/pdfmake.min.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/datatables/pdfmake/vfs_fonts.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/datatables/buttons/js/buttons.html5.min.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/datatables/buttons/js/buttons.print.min.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/datatables/buttons/js/buttons.colVis.min.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/datatables/responsive/js/dataTables.responsive.min.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/datatables/responsive/js/responsive.bootstrap4.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/gijgo/js/gijgo.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 <!-- <script src="<?= base_url('assets'); ?>js/script.js"></script> -->

 <script>
$(document).ready(function() {
    $("#check-all").click(function() {
        if ($(this).is(":checked"))
            $(".check-item").prop("checked",
                true);
        else
            $(".check-item").prop("checked",
                false);
    });
});
 </script>

 <script>
$(document).ready(function() {
    var provinsiWrapper = $('#provinsiWrapper');
    var kotaWrapper = $('#kotaWrapper');
    var kecamatanWrapper = $('#kecamatanWrapper');
    var idProvinsi = $('#id_provinsi');
    var idKota = $('#id_kota');
    var idKecamatan = $('#id_kecamatan');
    const curentProvince = <?= $user['id_provinsi'] ?>;
    const curentCity = <?= $user['id_kota'] ?>;
    const curentDistrict = <?= $user['id_kecamatan'] ?>;

    idProvinsi.change(function() {
        var selectedProvinsi = $(this).val();
        if (selectedProvinsi === "") {
            kotaWrapper.hide();
            kecamatanWrapper.hide();
            idKota.empty();
            idKecamatan.empty();
        } else {
            loadKota(selectedProvinsi);
        }
    });

    function loadKota(provinsiId) {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: '<?= base_url('admin/profile/getdatakota') ?>',
            data: {
                provinsi: provinsiId
            },
            success: function(response) {
                if (response.length > 0) {
                    var html = response.map(function(item) {
                        if (curentCity == item.id_kota) {
                            return '<option value="' + item.id_kota + '" selected>' + item
                                .kota +
                                '</option>';
                        } else {
                            return '<option value="' + item.id_kota + '">' + item.kota +
                                '</option>';
                        }
                    }).join('');

                    idKota.html(html);
                    kotaWrapper.show();
                    idKota.show();

                    // Load Kecamatan jika data tidak kosong
                    if (curentCity !== "") {
                        loadKecamatan(curentCity);
                    }
                } else {
                    kotaWrapper.hide();
                    kecamatanWrapper.hide();
                    idKota.empty();
                    idKecamatan.empty();
                }
            }
        });
    }

    idKota.change(function() {
        var selectedKota = $(this).val();
        if (selectedKota === "") {
            kecamatanWrapper.hide();
            idKecamatan.empty();
        } else {
            loadKecamatan(selectedKota);
        }
    });

    function loadKecamatan(kotaId) {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: '<?= base_url('admin/profile/getdatakecamatan') ?>',
            data: {
                kota: kotaId
            },
            success: function(response) {
                if (response.length > 0) {
                    var html = response.map(function(item) {
                        if (curentDistrict == item.id_kecamatan) {
                            return '<option value="' + item.id_kecamatan + '" selected>' +
                                item
                                .kecamatan +
                                '</option>';
                        } else {
                            return '<option value="' + item.id_kecamatan + '">' + item
                                .kecamatan +
                                '</option>';
                        }
                    }).join('');

                    idKecamatan.html(html);
                    kecamatanWrapper.show();
                    idKecamatan.show();
                } else {
                    kecamatanWrapper.hide();
                    idKecamatan.empty();
                }
            }
        });
    }

    // Inisialisasi tampilan berdasarkan data yang sudah ada
    if (idProvinsi.val() !== "") {
        loadKota(idProvinsi.val());
    }
    if (idKota.val() !== "") {
        loadKecamatan(idKota.val());
    }
});
 </script>


 <script>
function previewImage(event) {
    var imagePreview = document.getElementById('imagePreview');
    var imagePreviewContainer = document.getElementById('imagePreviewContainer');
    var file = event.target.files[0];

    if (file) {
        var reader = new FileReader();
        reader.onload = function() {
            imagePreview.src = reader.result;
            imagePreview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        imagePreview.src = '#';
        imagePreview.style.display = 'none';
    }
}
 </script>

 <script>
function previewEditImage(event) {
    var imagePreview = document.getElementById('imageEditPreview');
    var imagePreviewContainer = document.getElementById('imageEditPreviewContainer');
    var file = event.target.files[0];

    if (file) {
        var reader = new FileReader();
        reader.onload = function() {
            imagePreview.src = reader.result;
            imagePreview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        imagePreview.src = '#';
        imagePreview.style.display = 'none';
    };
}
 </script>

 <script>
$(document).ready(function() {
    $('#searchBtn').click(function() {
        var searchValue = $('#searchInput').val().trim().toLowerCase();

        // Loop through each row in the table body
        $('tbody tr').each(function() {
            var name = $(this).find('td:nth-child(2)').text().toLowerCase();
            var description = $(this).find('td:nth-child(3)').text().toLowerCase();
            var price = $(this).find('td:nth-child(4)').text().toLowerCase();

            // Check if the searchValue matches any column
            if (name.includes(searchValue) || description.includes(searchValue) || price
                .includes(searchValue)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
 </script>

 <script type="text/javascript">
$(document).ready(function() {
    // Add Product
    $('#addBtn').click(function() {
        var form = new FormData($('#addForm')[0]);
        $.ajax({
            url: '<?= base_url('admin/product/create') ?>',
            method: 'POST',
            data: form,
            processData: false,
            contentType: false,
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        html: 'Produk berhasil ditambahkan!'
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        html: result.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: 'An error occurred while processing the request.'
                });
            }
        });
    });

    // Edit Product
    $('.edit-btn').click(function() {
        var id = $(this).data('id');
        $.ajax({
            url: '<?= base_url('admin/product/get_product') ?>',
            method: 'POST',
            data: {
                id: id
            },
            success: function(response) {
                var product = JSON.parse(response);
                $('#editId').val(product.id);
                $('#editName').val(product.name);
                $('#editDescription').val(product.description);
                $('#editPrice').val(product.price);
                // Display the selected file name in a separate element
                var imageFileName = product.image ? product.image : 'No file selected';
                $('#selectedImageName').text(imageFileName);
            }
        });
    });

    $('#updateBtn').click(function() {
        var form = new FormData($('#editForm')[0]);
        $.ajax({
            url: '<?= base_url('admin/product/update') ?>',
            method: 'POST',
            data: form,
            processData: false, // prevent jQuery from automatically processing data
            contentType: false, // prevent jQuery from setting content type
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        html: 'Produk berhasil ditambahkan!'
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        html: result.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: 'An error occurred while processing the request.'
                });
            }
        });
    });

    // Delete Product
    $('.delete-btn').click(function() {
        var id = $(this).data('id');
        Swal.fire({
            title: '<small><b>Apakah kamu yakin ingin menghapus data ini?</b></small>',
            html: "<small>Anda tidak akan dapat mengembalikan data ini setelah terhapus!</small>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus data!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('admin/product/delete') ?>',
                    method: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                html: 'Product berhasil dihapus!'
                            }).then(function() {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                html: result.message
                            });
                        }
                    }
                });
            }
        });
    });

});
 </script>


 <script type="text/javascript">
$(function() {
    $('.date').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#tangal').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    }

    $('#tanggal').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Hari ini': [moment(), moment()],
            'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '7 hari terakhir': [moment().subtract(6, 'days'), moment()],
            '30 hari terakhir': [moment().subtract(29, 'days'), moment()],
            'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
            'Bulan lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                .endOf('month')
            ],
            'Tahun ini': [moment().startOf('year'), moment().endOf('year')],
            'Tahun lalu': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year')
                .endOf('year')
            ]
        }
    }, cb);

    cb(start, end);
});

$(document).ready(function() {
    var table = $('#dataTable').DataTable({
        buttons: ['copy', 'csv', 'print', 'excel', 'pdf'],
        dom: "<'row px-2 px-md-4 pt-2'<'col-md-3'l><'col-md-5 text-center'B><'col-md-4'f>>" +
            "<'row'<'col-md-12'tr>>" +
            "<'row px-2 px-md-4 py-3'<'col-md-5'i><'col-md-7'p>>",
        lengthMenu: [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "All"]
        ],
        columnDefs: [{
            targets: -1,
            orderable: false,
            searchable: false
        }]
    });

    table.buttons().container().appendTo('#dataTable_wrapper .col-md-5:eq(0)');
});
 </script>
 <script type="text/javascript">
let hal = '<?= $this->uri->segment(1); ?>';

let satuan = $('#satuan');
let stok = $('#stok');
let total = $('#total_stok');
let jumlah = hal == 'barangmasuk' ? $('#jumlah_masuk') : $('#jumlah_keluar');

$(document).on('change', '#barang_id', function() {
    let url = '<?= base_url('barang/getstok/'); ?>' + this.value;
    $.getJSON(url, function(data) {
        satuan.html(data.nama_satuan);
        stok.val(data.stok);
        total.val(data.stok);
        jumlah.focus();
    });
});

$(document).on('keyup', '#jumlah_masuk', function() {
    let totalStok = parseInt(stok.val()) + parseInt(this.value);
    total.val(Number(totalStok));
});

$(document).on('keyup', '#jumlah_keluar', function() {
    let totalStok = parseInt(stok.val()) - parseInt(this.value);
    total.val(Number(totalStok));
});
 </script>

 <?php if ($this->uri->segment(1) == 'dashboard') : ?>
 <!-- Chart -->
 <script src="<?= base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>

 <script type="text/javascript">
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito',
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

// Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [{
                label: "Total Barang Masuk",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "#5a5c69",
                pointHoverBorderColor: "#5a5c69",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: <?= json_encode($cbm); ?>,
            },
            {
                label: "Total Barang Keluar",
                lineTension: 0.3,
                backgroundColor: "rgba(231, 74, 59, 0.05)",
                borderColor: "#e74a3b",
                pointRadius: 3,
                pointBackgroundColor: "#e74a3b",
                pointBorderColor: "#e74a3b",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "#5a5c69",
                pointHoverBorderColor: "#5a5c69",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: <?= json_encode($cbk); ?>,
            }
        ],
    },
    options: {
        maintainAspectRatio: false,
        layout: {
            padding: 5
        },
        scales: {
            xAxes: [{
                time: {
                    unit: 'date'
                },
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    maxTicksLimit: 7
                }
            }],
            yAxes: [{
                ticks: {
                    maxTicksLimit: 5,
                    padding: 10,
                    // Include a dollar sign in the ticks
                    callback: function(value, index, values) {
                        return number_format(value);
                    }
                },
                gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }],
        },
        legend: {
            display: false
        },
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                }
            }
        }
    }
});

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ["Barang Masuk", "Barang Keluar"],
        datasets: [{
            data: [<?= $barang_masuk; ?>, <?= $barang_keluar; ?>],
            backgroundColor: ['#4e73df', '#e74a3b'],
            hoverBackgroundColor: ['#5a5c69', '#5a5c69'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: false
        },
        cutoutPercentage: 80,
    },
});
 </script>
 <?php endif; ?>

 </body>

 </html>