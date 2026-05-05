@extends('template.invoice')

@section('transaksi_active', 'active')
@section('resident_payment_active', 'active')

@section('content')
<div class="container-xxl container-p-y">

    <div class="card">
        <div class="card-body">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <h3 class="mb-1"><strong>SiPAM</strong></h3>
                    <p class="mb-0">Laporan Pembayaran oleh Warga</p>
                </div>
                <div class="text-end">
                    <h5 class="mb-1">Nama Warga : {{ $resident->name }}</h5>
                    <p class="mb-0">Blok : {{ $resident->address }}</p>
                </div>
            </div>

            {{-- DETAIL --}}
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-stripped table-sm">
                    <tr>
                        <th>Periode</th>
                        <th>Kode</th>
                        <th>Timestamp</th>
                        <th>Total</th>
                        <th>Admin</th>
                    </tr>
                    @foreach ($payments as $p)
                    <tr>
                        <td>{{ \Carbon\Carbon::createFromDate($p->year, $p->month, 1)->translatedFormat('F Y') }}</td>
                        <td>{{ $p->code }}</td>
                        <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ number_format($p->total, 0, ',', '.') }}</td>
                        <td>{{ $p->user->name ?? '-' }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>

            {{-- TERBILANG --}}
            {{-- <div class="mb-4">
                <p class="mb-1"><strong>Terbilang:</strong></p>
                <p class="text-muted" id="terbilang-text"></p>
            </div> --}}

            {{-- ACTION --}}
            <div class="text-end mt-4">
                <button onclick="window.print()" class="btn btn-primary">
                    Print
                </button>
                <a href="{{ route('resident_payment.index') }}" class="btn btn-secondary">
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
