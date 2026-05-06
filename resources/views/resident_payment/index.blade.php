@extends('template.master')

@section('laporan_active', 'active')
@section('resident_payment_active', 'active')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1 class="h3 mb-3"><strong>Pembayaran Warga</strong></h1>

        {{-- FILTER --}}
        <div class="card mb-3">
            <div class="card-body">

                <div class="row g-3">

                    <form action="{{ route('resident_payment.process') }}" method="POST">@csrf

                    <div class="col-md-4 mb-2">
                        <label class="form-label">Warga</label>
                        <select name="resident_id" class="form-select select2" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($residents as $resident)
                                <option value="{{ $resident->id }}">
                                    {{ $resident->name }} - {{ $resident->address }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100" id="btn-process" type="submit">
                            Proses
                        </button>
                    </div>

                    </form>

                </div>

            </div>
        </div>

    </div>
@endsection
