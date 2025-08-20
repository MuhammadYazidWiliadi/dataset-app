@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Edit Dataset</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('datasets.update', $dataset->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="id_topik" class="form-label">Topik</label>
                            <select class="form-select @error('id_topik') is-invalid @enderror" id="id_topik" name="id_topik" required>
                                <option value="">Pilih Topik</option>
                                @foreach($topiks as $topik)
                                    <option value="{{ $topik->id }}" {{ $dataset->id_topik == $topik->id ? 'selected' : '' }}>
                                        {{ $topik->topik }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_topik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_dataset" class="form-label">Nama Dataset</label>
                            <input type="text" class="form-control @error('nama_dataset') is-invalid @enderror" 
                                   id="nama_dataset" name="nama_dataset" value="{{ old('nama_dataset', $dataset->nama_dataset) }}" required>
                            @error('nama_dataset')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label">File Excel (Biarkan kosong jika tidak ingin mengubah)</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                   id="file" name="file" accept=".xlsx,.xls">
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                @if($dataset->files)
                                    File saat ini: 
                                    <a href="{{ asset('storage/' . $dataset->files) }}" download>
                                        {{ basename($dataset->files) }}
                                    </a>
                                @else
                                    Tidak ada file yang diupload
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="metadata_info" class="form-label">Informasi Metadata</label>
                            <textarea class="form-control @error('metadata_info') is-invalid @enderror" 
                                      id="metadata_info" name="metadata_info" rows="3">{{ old('metadata_info', $dataset->metadata_info) }}</textarea>
                            @error('metadata_info')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('datasets.index') }}" class="btn btn-secondary me-md-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection