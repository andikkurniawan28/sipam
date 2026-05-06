@extends('template.master')

@section('laporan_active', 'active')
@section('monthly_gateway_active', 'active')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1 class="h3 mb-3"><strong>Rekap Pembayaran Lewat</strong></h1>

        {{-- FILTER --}}
        <div class="card mb-3">
            <div class="card-body">
                <form action="{{ route('monthly_gateway.process') }}" method="POST">
                    @csrf

                    <div class="row g-3 align-items-end">

                        <div class="col-md-4">
                            <label class="form-label">Periode</label>
                            <input type="month" name="month" class="form-control" value="{{ date('Y-m') }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Pembayaran Lewat</label>
                            <select class="form-select select2" name="gateway_id" required>
                                <option value="">-- Pilih --</option>
                                @foreach ($gateways as $g)
                                    <option value="{{ $g->id }}">
                                        {{ $g->name }} {{ $g->description ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 d-grid">
                            <button class="btn btn-primary" id="btn-process" type="submit">
                                Proses
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>

    </div>
@endsection
