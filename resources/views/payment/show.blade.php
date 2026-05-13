@extends('template.invoice')

@section('transaksi_active', 'active')
@section('payment_active', 'active')

@section('content')

    <style>
        @media print {

            /* Hilangkan tombol saat print */
            .no-print {
                display: none !important;
            }

            /* Hilangkan margin/card shadow biar rapi */
            body {
                background: #fff !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }

            .container-xxl {
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
            }
        }
    </style>

    <div class="container-xxl container-p-y">

        <div class="card">
            <div class="card-body">

                {{-- HEADER --}}
                <div class="d-flex justify-content-between mb-4">
                    <div>
                        <h3 class="mb-1"><strong>SiPAM</strong></h3>
                        <p class="mb-0">Bukti Pembayaran</p>
                    </div>
                    <div class="text-end">
                        <h5 class="mb-1">#{{ $payment->code }}</h5>
                        <p class="mb-0">Tanggal: {{ $payment->created_at }}</p>
                    </div>
                </div>

                <hr>

                {{-- INFO --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6><strong>Dari:</strong></h6>
                        <p class="mb-0">{{ $payment->resident->name }} ({{ $payment->resident->address }})</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <h6><strong>Diterima oleh:</strong></h6>
                        <p class="mb-0">{{ $payment->user->name }}</p>
                    </div>
                </div>

                {{-- DETAIL --}}
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <tr>
                            <th>Periode</th>
                            <td>
                                {{ \Carbon\Carbon::create()->month($payment->month)->translatedFormat('F') }}
                                {{ $payment->year }}
                            </td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td><strong>{{ number_format($payment->total, 0, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <th>Via</th>
                            <td>{{ $payment->gateway->name ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                {{-- FOOTER --}}
                <div class="row mt-5">
                    <div class="col-md-6">
                        <p class="text-muted">Terima kasih atas pembayaran Anda.</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <p>{{ $payment->date }}</p>
                        <br><br>
                        <p><strong>{{ $payment->user->name }}</strong></p>
                    </div>
                </div>

                {{-- ACTION --}}
                <div class="text-end mt-4 no-print">
                    <button onclick="window.print()" class="btn btn-primary">
                        Print
                    </button>

                    <a href="{{ route('payment.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

            </div>
        </div>

    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/terbilang@1.0.0/terbilang.min.js"></script>
@endsection
