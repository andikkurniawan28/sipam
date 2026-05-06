@extends('template.master')

@section('laporan_active', 'active')
@section('monthly_recap_active', 'active')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1 class="h3 mb-3"><strong>Rekap Bulanan</strong></h1>

        {{-- FILTER --}}
        <div class="card mb-3">
            <div class="card-body">

                <div class="row g-3">

                    <form action="{{ route('monthly_recap.process') }}" method="POST">@csrf

                    <div class="col-md-4 mb-2">
                        <label class="form-label">Periode</label>
                        <input type="month" name="month" class="form-control" value="{{ date('Y-m') }}" required>
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
