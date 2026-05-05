@extends('template.master')

@section('master_active', 'active')
@section('resident_active', 'active')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h1 class="h3 mb-3"><strong>Daftar Warga</strong></h1>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('resident.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="residentTable" class="table table-bordered table-hover table-striped table-sm w-100 text-center">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Blok</th>
                            <th>WhatsApp</th>
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
    $(function() {
        $('#residentTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('resident.index') }}",
            order: [[0, 'asc']],
            columns: [
                { data: 'name', name: 'name' },
                { data: 'address', name: 'address' },
                { data: 'whatsapp', name: 'whatsapp' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
