@extends('template.master')

@section('transaksi_active', 'active')
@section('payment_create_active', 'active')

@section('content')
    <div class="container-xxl container-p-y">
        <h1 class="h3 mb-3"><strong>Catat Pembayaran</strong></h1>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('payment.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Periode</label>
                        <input type="month" name="month" class="form-control" value="" required>
                    </div>

                    <div class="mb-3">
                        <label>Warga</label>
                        <select name="resident_id" class="form-select select2" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($residents as $o)
                                <option value="{{ $o->id }}">
                                    {{ $o->name }} {{ $o->address }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Pembayaran lewat</label>
                        <select name="gateway_id" class="form-control select2" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($gateways as $o)
                                <option value="{{ $o->id }}">
                                    {{ $o->name }} {{ $o->description ?? "" }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID').format(angka || 0);
        }

        function parseRupiah(str) {
            return parseFloat((str || '').replace(/\./g, '')) || 0;
        }

        $(document).on('keyup', '#total', function() {
            let value = parseRupiah($(this).val());
            $(this).val(formatRupiah(value));
        });
    </script>
@endsection
