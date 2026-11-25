@extends('layouts.home.admin.app')

@section('content')

<div class="container">
    <div class="page-inner">

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">
            <div>
                <h3 class="fw-bold mb-1">Jadwal Dokter</h3>
                <p class="text-muted mb-0">
                    Kelola jadwal praktik dokter pada setiap poli.
                </p>
            </div>

            <div class="mt-3 mt-md-0">
                <a href="{{ route('admin.jadwal-dokter.create') }}"
                   class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Tambah Jadwal
                </a>
            </div>
        </div>

        {{-- Alert Error --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>
            </div>
        @endif

        {{-- Validation Error --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan:</strong>

                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Table --}}
        <div class="card card-round">
            <div class="card-header">
                <div class="card-title">
                    Daftar Jadwal Praktik Dokter
                </div>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th>Dokter</th>
                                <th>Poli</th>
                                <th>Hari</th>
                                <th>Jam Praktik</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                        @forelse($jadwalDokters as $jadwal)

                            <tr>

                                <td>
                                    {{ $jadwalDokters->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <div class="fw-bold">
                                        {{ $jadwal->dokter->nama_dokter ?? '-' }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $jadwal->dokter->spesialisasi_dokter ?? '-' }}
                                    </small>
                                </td>

                                <td>
                                    <span class="badge badge-info">
                                        {{ $jadwal->poli->nama_poli ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    {{ $jadwal->hari }}
                                </td>

                                <td>
                                    <i class="far fa-clock me-1"></i>

                                    {{ \Carbon\Carbon::parse($jadwal->jam_buka)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($jadwal->jam_tutup)->format('H:i') }}
                                </td>

                                <td>

                                    <div class="d-flex gap-1">

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.jadwal-dokter.edit', $jadwal->id_jadwaldokter) }}"
                                           class="btn btn-sm btn-warning"
                                           title="Edit">

                                            <i class="fas fa-edit"></i>

                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin.jadwal-dokter.destroy', $jadwal->id_jadwaldokter) }}"
                                              method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    title="Hapus">

                                                <i class="fas fa-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center py-5">

                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>

                                    <p class="text-muted mb-0">
                                        Belum ada jadwal dokter.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>
                </div>

                {{-- Pagination --}}
                @if($jadwalDokters->hasPages())

                    <div class="d-flex justify-content-center mt-4">

                        {{ $jadwalDokters->links() }}

                    </div>

                @endif

            </div>
        </div>

    </div>
</div>

@endsection