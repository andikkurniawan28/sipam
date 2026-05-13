@extends('template.master')

@section('home_active', 'active')

@section('content')
    <style>
        /* #payment-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        #payment-table th,
        #payment-table td {
            border: 1px solid #000;
            padding: 4px;
        } */

        /* Hindari row terpotong */
        #payment-table tr {
            page-break-inside: avoid !important;
        }

        #payment-table td,
        #payment-table th {
            page-break-inside: avoid !important;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">

        <h1 class="h3 mb-3"><strong>Home</strong></h1>

        {{-- ===================== --}}
        {{-- SUMMARY --}}
        {{-- ===================== --}}
        <div class="row mb-4">

            <div class="col-md-3 mb-2">
                <div class="card">
                    <div class="card-body">
                        <span class="text-muted">Total Warga</span>
                        <h4 id="total_resident">0</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-2">
                <div class="card">
                    <div class="card-body">
                        <span class="text-muted">Pembayaran Bulan Ini</span>
                        <h4 id="payment_this_month">Rp 0</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-2">
                <div class="card">
                    <div class="card-body">
                        <span class="text-muted">Sudah Bayar</span>
                        <h4 id="paid_resident">0</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-2">
                <div class="card border-danger">
                    <div class="card-body">
                        <span class="text-muted">Belum Bayar</span>
                        <h4 id="unpaid_resident" class="text-danger">0</h4>
                    </div>
                </div>
            </div>

        </div>

        {{-- ===================== --}}
        {{-- MATRIX TABLE --}}
        {{-- ===================== --}}
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        Status Pembayaran Tahun <span id="year">-</span>
                    </h5>
                    {{-- BUTTON DOWNLOAD PDF --}}
                    <button class="btn btn-danger btn-sm" id="download-pdf">
                        <i class="bi bi-file-earmark-pdf"></i>
                        Download PDF
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm text-center text-dark align-middle" id="payment-table">
                        <thead class="table-light">
                            <tr>
                                <th class="text-start">Warga</th>
                                <th>Blok</th>
                                <th>Jan</th>
                                <th>Feb</th>
                                <th>Mar</th>
                                <th>Apr</th>
                                <th>Mei</th>
                                <th>Jun</th>
                                <th>Jul</th>
                                <th>Agu</th>
                                <th>Sep</th>
                                <th>Okt</th>
                                <th>Nov</th>
                                <th>Des</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="14" class="text-center text-muted">
                                    Loading data...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection


@section('script')

    {{-- html2pdf --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        $(function() {

            function rupiah(val) {
                return new Intl.NumberFormat('id-ID').format(val || 0);
            }

            function renderTable(data) {

                if (!data.length) {
                    return `<tr>
                        <td colspan="14" class="text-center text-muted">
                            Tidak ada data
                        </td>
                    </tr>`;
                }

                let rows = '';

                data.forEach(r => {

                    let cols = `
                        <td class="text-start">${r.name}</td>
                        <td>${r.address ?? '-'}</td>
                    `;

                    r.months.forEach((m, index) => {

                        if (m === 1) {
                            cols += `
                                <td class="bg-success-subtle text-success fw-bold"
                                    title="Sudah bayar bulan ${index + 1}">
                                    ✔
                                </td>
                            `;
                        } else {
                            cols += `
                                <td class="bg-danger-subtle text-danger fw-bold"
                                    title="Belum bayar bulan ${index + 1}">
                                </td>
                            `;
                        }

                    });

                    rows += `<tr>${cols}</tr>`;
                });

                return rows;
            }

            function loadData() {

                $('#payment-table tbody').html(`
                    <tr>
                        <td colspan="14" class="text-center text-muted">
                            Memuat data...
                        </td>
                    </tr>
                `);

                $.get("{{ route('home_api') }}")
                    .done(function(res) {

                        $('#year').text(res.year);

                        $('#total_resident').text(res.summary?.total_resident ?? 0);
                        $('#payment_this_month').text('Rp ' + rupiah(res.summary?.payment_this_month));
                        $('#paid_resident').text(res.summary?.paid_resident ?? 0);
                        $('#unpaid_resident').text(res.summary?.unpaid_resident ?? 0);

                        const html = renderTable(res.data || []);
                        $('#payment-table tbody').html(html);

                    })
                    .fail(function() {

                        $('#payment-table tbody').html(`
                            <tr>
                                <td colspan="14" class="text-danger text-center">
                                    Gagal memuat data
                                </td>
                            </tr>
                        `);

                    });
            }

            // =====================
            // DOWNLOAD PDF
            // =====================
            $('#download-pdf').on('click', function() {

                const element = document.createElement('div');

                element.innerHTML = `
                    <h3 style="text-align:center; margin-bottom:15px;">
                        Status Pembayaran Tahun ${$('#year').text()}
                    </h3>

                    ${document.getElementById('payment-table').outerHTML}
                `;

                const opt = {
                    margin: 0.2,
                    filename: 'status-pembayaran-' + $('#year').text() + '.pdf',

                    image: {
                        type: 'jpeg',
                        quality: 1
                    },

                    html2canvas: {
                        scale: 2,
                        scrollX: 0,
                        scrollY: 0
                    },

                    jsPDF: {
                        unit: 'in',
                        format: 'a4',
                        orientation: 'landscape'
                    },

                    // INI PENTING
                    pagebreak: {
                        mode: ['avoid-all', 'css', 'legacy']
                    }
                };

                html2pdf().set(opt).from(element).save();

            });

            loadData();

        });
    </script>
@endsection
