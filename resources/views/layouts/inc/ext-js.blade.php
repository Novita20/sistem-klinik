<!-- jQuery -->
<script src="{{ url('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ url('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ url('assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ url('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ url('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ url('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ url('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ url('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ url('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ url('assets/plugins/chart.js/Chart.min.js') }}"></script>


<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ url('assets/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ url('assets/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ url('assets/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
<script src="{{ url('assets/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('assets/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{ url('assets/dist/js/demo.js') }}"></script> --}}


<!-- Page specific script -->
<!-- Tambahkan script DataTables user -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(function() {
        /* ChartJS - Chart initialization scripts */

        // Data Tenaga Kerja PKWT & PKWTT untuk Bar Chart
        @if (isset($pkwtCount) && isset($pkwttCount))
            var barChartData = {
                labels: ['PKWT', 'PKWTT'],
                datasets: [{
                    label: 'Jumlah Tenaga Kerja',
                    backgroundColor: ['#133E87', '#3887BE'],
                    data: [{{ $pkwtCount }}, {{ $pkwttCount }}]
                }]
            };


            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            };

            // Render Bar Chart
            var barChartCanvas = $('#barChart').get(0).getContext('2d');
            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            });
        @endif
        //pie chart
        // Pie Chart Data dan Options
        @if (isset($vendorAktifCount) && isset($vendorNonAktifCount))
            // Pie Chart Data dan Options
            var pieData = {
                labels: ['Vendor Aktif', 'Vendor Non-Aktif'],
                datasets: [{
                    data: [{{ $vendorAktifCount }}, {{ $vendorNonAktifCount }}],
                    backgroundColor: ['#133E87', '#3887BE']
                }]
            };

            // Tooltip
            var pieOptions = {
                responsive: true,
                maintainAspectRatio: false,
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var currentValue = dataset.data[tooltipItem.index];
                            var label = data.labels[tooltipItem.index];
                            console.log('Tooltip - Label:', label, 'Value:',
                                currentValue); // Debugging Tooltip
                            return label + ': ' + currentValue;
                        }
                    }
                }
            };

            // Render Pie Chart
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            });
        @endif


        // AREA CHART
        var areaChartCanvas = $('#areaChart').get(0).getContext('2d');
        var areaChartData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                    label: 'Digital Goods',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    data: [28, 48, 40, 19, 86, 27, 90]
                },
                {
                    label: 'Electronics',
                    backgroundColor: 'rgba(210, 214, 222, 1)',
                    borderColor: 'rgba(210, 214, 222, 1)',
                    pointRadius: false,
                    data: [65, 59, 80, 81, 56, 55, 40]
                },
            ]
        };
        var areaChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display: false
                    }
                }]
            }
        };
        new Chart(areaChartCanvas, {
            type: 'line',
            data: areaChartData,
            options: areaChartOptions
        });

        // LINE CHART
        var lineChartCanvas = $('#lineChart').get(0).getContext('2d');
        var lineChartOptions = $.extend(true, {}, areaChartOptions);
        var lineChartData = $.extend(true, {}, areaChartData);
        lineChartData.datasets[0].fill = false;
        lineChartData.datasets[1].fill = false;
        lineChartOptions.datasetFill = false;

        new Chart(lineChartCanvas, {
            type: 'line',
            data: lineChartData,
            options: lineChartOptions
        });

        // DONUT CHART
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
        var donutData = {
            labels: ['Chrome', 'IE', 'FireFox', 'Safari', 'Opera', 'Navigator'],
            datasets: [{
                data: [700, 500, 400, 600, 300, 100],
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc',
                    '#d2d6de'
                ]
            }]
        };
        var donutOptions = {
            maintainAspectRatio: false,
            responsive: true
        };
        new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
        });

        // PIE CHART
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
        new Chart(pieChartCanvas, {
            type: 'pie',
            data: donutData,
            options: {
                maintainAspectRatio: false,
                responsive: true
            }
        });

        // BAR CHART
        var barChartCanvas = $('#barChart').get(0).getContext('2d');
        var barChartData = $.extend(true, {}, areaChartData);
        barChartData.datasets[0] = areaChartData.datasets[1];
        barChartData.datasets[1] = areaChartData.datasets[0];
        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false
        };
        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });

        // STACKED BAR CHART
        var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d');
        new Chart(stackedBarChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: true
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }
        });
    });

    $(document).ready(function() {
        $("#example1").DataTable({
            // "pagingType": "full_numbers",
            "responsive": false, // Mengaktifkan mode responsif
            "lengthChange": true, // Opsi untuk mengubah jumlah data yang ditampilkan
            "autoWidth": false, // Hindari lebar kolom otomatis
            "searching": true, // Fitur pencarian
            "paging": true, // Fitur pagination
            "scrollX": true // Aktifkan scroll horizontal jika diperlukan (hanya jika tabel sangat lebar)

        });

        // Inisialisasi DataTables untuk tabel example2
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true, // Pastikan responsif untuk tabel example2
        });

        $("#datavendor").DataTable({
            "scrollX": true,
            "responsive": false, // Responsif bisa diatur sesuai kebutuhan
            "lengthChange": true, // Mengizinkan pengubahan jumlah tampilan per halaman
            "paging": true, // Mengaktifkan pagination
            "searching": true, // Mengaktifkan pencarian
            "ordering": true, // Mengizinkan pengurutan
            "info": true, // Menampilkan informasi tabel
            "language": {
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>



<!-- Tambahkan script DataTables user -->
<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            lengthChange: true,
            autoWidth: false
        });
    });
</script>

@if (isset($tk_pkwt_percentage) && isset($tk_pkwtt_percentage))
    <script>
        $(document).ready(function() {
            // Prepare the context for the pie chart
            var ctx = document.getElementById('pieChart').getContext('2d');

            // Creating the pie chart using Chart.js
            var pieChart = new Chart(ctx, {
                type: 'pie', // Type of chart
                data: {
                    labels: ['PKWT', 'PKWTT'], // Labels for PKWT and PKWTT
                    datasets: [{
                        data: [
                            {{ round($tk_pkwt_percentage, 2) }}, // Dynamic data for PKWT percentage
                            {{ round($tk_pkwtt_percentage, 2) }} // Dynamic data for PKWTT percentage
                        ],
                        backgroundColor: ['#3f4170', '#a2c2e9'], // Modern colors: pink and blue
                        borderColor: ['#ffffff', '#ffffff'], // White borders for a clean look
                        borderWidth: 2 // Border width
                    }]
                },
                options: {
                    responsive: true, // Make chart responsive
                    maintainAspectRatio: false, // Maintain the aspect ratio
                    plugins: {
                        legend: {
                            display: false // Disable the legend to hide the squares and labels
                        },
                        tooltip: {
                            enabled: true, // Enable tooltips when hovering over the chart
                            callbacks: {
                                label: function(tooltipItem) {
                                    let value = tooltipItem.raw;
                                    return value.toFixed(2) +
                                        '%'; // Display percentage with 2 decimal places
                                }
                            }
                        }
                    },
                    layout: {
                        padding: 10 // Add padding around the chart for breathing space
                    },
                    animation: {
                        animateScale: true, // Smooth animation
                        animateRotate: true // Smooth rotation animation
                    }
                }
            });
        });
    </script>
@endif
