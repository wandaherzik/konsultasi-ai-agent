@extends('layouts.home.admin.app')

@section('content')

<div class="page-inner">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-1">Data Dokter</h3>
            <p class="text-muted mb-0">
                Kelola data dokter Puskesmas
            </p>
        </div>

        <div>
            <a href="{{ route('admin.dokter.create') }}"
               class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Tambah Dokter
            </a>
        </div>
    </div>

    {{-- Card --}}
    <div class="card card-round">

        <div class="card-header">
            <div class="card-title">
                Daftar Dokter
            </div>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>ID Dokter</th>
                            <th>Nama Dokter</th>
                            <th>Username</th>
                            <th>Spesialisasi</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($dokters as $dokter)

                            <tr>

                                <td>
                                    {{ $dokters->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $dokter->id_dokter }}
                                    </span>
                                </td>

                                <td>
                                    <strong>
                                        {{ $dokter->nama_dokter }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $dokter->user->username ?? '-' }}
                                </td>

                                <td>
                                    {{ $dokter->spesialisasi_dokter }}
                                </td>

                                <td>

                                    <a href="{{ route('admin.dokter.show', $dokter->id_dokter) }}"
                                       class="btn btn-info btn-sm"
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.dokter.edit', $dokter->id_dokter) }}"
                                       class="btn btn-warning btn-sm"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.dokter.destroy', $dokter->id_dokter) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus data dokter ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6"
                                    class="text-center py-4">

                                    <i class="fas fa-user-md fa-2x text-muted mb-2"></i>

                                    <p class="text-muted mb-0">
                                        Belum ada data dokter.
                                    </p>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if($dokters->hasPages())

            <div class="card-footer">
                <div class="d-flex justify-content-center">

                    {{ $dokters->links() }}

                </div>
            </div>

        @endif

    </div>

</div>

@endsection