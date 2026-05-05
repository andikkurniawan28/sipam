@extends('template.master')

@section('master_active', 'active')
@section('resident_active', 'active')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="mb-4"><strong>Tambah Warga</strong></h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('resident.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" autofocus required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Blok</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">WhatsApp</label>
                    <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp') }}" required>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('resident.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
