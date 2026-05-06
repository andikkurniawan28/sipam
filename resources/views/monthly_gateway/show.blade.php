@extends('template.invoice')

@section('transaksi_active', 'active')
@section('monthly_gateway_active', 'active')

@section('content')
<div class="container-xxl container-p-y">

    <div class="card">
        <div class="card-body">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <h3 class="mb-1"><strong>SiPAM</strong></h3>
                    <p class="mb-0">Laporan Rekap Pembayaran Lewat</p>
                </div>
                <div class="text-end">
                    <h5 class="mb-1">Periode : {{ date('F Y', strtotime($request->month)) }}</h5>
                    <p class="mb-0">Via : {{ $gateway->name }} {{ $gateway->description ?? "" }}</p>
                </div>
            </div>

            {{-- DETAIL --}}
            @php $total = 0; @endphp
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-stripped table-sm">
                    <tr>
                        <th>Timestamp</th>
                        <th>Kode</th>
                        <th>Warga</th>
                        <th>Blok</th>
                        <th>Periode</th>
                        <th>Admin</th>
                        <th>Via</th>
                        <th>Total</th>
                    </tr>
                    @foreach ($payments as $p)
                    <tr>
                        <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $p->code }}</td>
                        <td>{{ $p->resident->name }}</td>
                        <td>{{ $p->resident->address }}</td>
                        <td>{{ \Carbon\Carbon::create()->month($p->month)->translatedFormat('F') }} {{ $p->year }}</td>
                        <td>{{ $p->user->name ?? '-' }}</td>
                        <td>{{ $p->gateway->name ?? '-' }} {{ $p->gateway->description ?? '' }}</td>
                        <td>{{ number_format($p->total, 0, ',', '.') }}</td>
                    </tr>
                    @php $total += $p->total; @endphp
                    @endforeach
                    <tr>
                        <th colspan="7">Total</th>
                        <th>{{ number_format($total, 0, ',', '.') }}</th>
                    </tr>
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
                <a href="{{ route('monthly_gateway.index') }}" class="btn btn-secondary">
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
