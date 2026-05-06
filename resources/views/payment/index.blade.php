@extends('template.master')

@section('transaksi_active', 'active')
@section('payment_active', 'active')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h1 class="h3 mb-3"><strong>Daftar Pembayaran</strong></h1>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('payment.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Catat
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="paymentTable" class="table table-bordered table-hover table-striped table-sm w-100 text-center" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode</th>
                            <th>Periode</th>
                            <th>Timestamp</th>
                            <th>Warga</th>
                            <th>Blok</th>
                            <th>Admin</th>
                            <th>Total</th>
                            <th>Via</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(angka || 0);
    }

    $(function() {
        $('#paymentTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('payment.index') }}",
            order: [[0, 'desc']],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'code', name: 'code' },
                { data: 'period', name: 'period' },
                { data: 'created_at', name: 'created_at' },
                { data: 'resident', name: 'resident' },
                { data: 'address', name: 'address' },
                { data: 'user', name: 'user' },
                { data: 'total', name: 'total', render: function(data) { return formatRupiah(data); } },
                { data: 'gateway', name: 'gateway' },
                { data: 'action', name: 'action', paymentable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
