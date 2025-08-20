@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Daftar Dataset</h4>
                    <a href="{{ route('datasets.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Dataset
                    </a>
                </div>

                <div class="card-body">
                    <!-- Form Pencarian -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form action="{{ route('datasets.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari dataset..." value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                    @if(request('search'))
                                    <a href="{{ route('datasets.index') }}" class="btn btn-outline-danger">
                                        <i class="fas fa-times"></i> Reset
                                    </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Info Hasil Pencarian -->
                    @if(request('search'))
                    <div class="alert alert-info">
                        Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="datasets-table">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Topik</th>
                                    <th>Nama Dataset</th>
                                    <th>File</th>
                                    <th>Last Update</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($datasets as $dataset)
                                <tr>
                                    <td>{{ $dataset->id }}</td>
                                    <td>{{ $dataset->topik->topik }}</td>
                                    <td>{{ $dataset->nama_dataset }}</td>
                                    <td>
                                        @if($dataset->files)
                                            <a href="{{ asset('storage/' . $dataset->files) }}" class="btn btn-sm btn-info" download>
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        @else
                                            <span class="text-muted">No file</span>
                                        @endif
                                    </td>
                                    <td>{{ $dataset->updated_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('datasets.edit', $dataset->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('datasets.destroy', $dataset->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus dataset ini?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        @if(request('search'))
                                            Tidak ada dataset yang ditemukan untuk pencarian "{{ request('search') }}"
                                        @else
                                            Tidak ada dataset yang tersedia
                                        @endif
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($datasets->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $datasets->appends(['search' => request('search')])->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th, .table td {
        vertical-align: middle;
    }
    .input-group {
        max-width: 500px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('#datasets-table').DataTable({
            "pageLength": 10,
            "searching": false, // Nonaktifkan pencarian DataTables karena kita sudah punya form
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data yang ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data yang tersedia",
                "infoFiltered": "(disaring dari _MAX_ total data)",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>
@endpush   