@extends('layouts.home.admin.app')

@section('content')

<div class="page-inner">

    <div class="d-flex align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Detail Dokter
            </h3>

            <p class="text-muted mb-0">
                Informasi lengkap dokter
            </p>
        </div>

    </div>

    <div class="card card-round">

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="text-muted">
                        ID Dokter
                    </label>

                    <h5 class="fw-bold">
                        {{ $dokter->id_dokter }}
                    </h5>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="text-muted">
                        Nama Dokter
                    </label>

                    <h5 class="fw-bold">
                        {{ $dokter->nama_dokter }}
                    </h5>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="text-muted">
                        Username
                    </label>

                    <h5>
                        {{ $dokter->user->username ?? '-' }}
                    </h5>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="text-muted">
                        Spesialisasi
                    </label>

                    <h5>
                        {{ $dokter->spesialisasi_dokter }}
                    </h5>

                </div>

            </div>

        </div>

        <div class="card-footer">

            <div class="d-flex justify-content-end gap-2">

                <a href="{{ route('admin.dokter.index') }}"
                   class="btn btn-secondary">

                    <i class="fas fa-arrow-left me-1"></i>
                    Kembali

                </a>

                <a href="{{ route('admin.dokter.edit', $dokter->id_dokter) }}"
                   class="btn btn-warning">

                    <i class="fas fa-edit me-1"></i>
                    Edit

                </a>

            </div>

        </div>

    </div>

</div>

@endsection