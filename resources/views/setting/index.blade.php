@extends('template.master')

@section('master_active', 'active')
@section('setting_active', 'active')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h1 class="h3 mb-3"><strong>Setting</strong></h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('setting.process') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Biaya</label>
                    <input type="number" name="fee" class="form-control"
                        value="{{ old('fee', $setting->fee) }}" required>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('setting.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
