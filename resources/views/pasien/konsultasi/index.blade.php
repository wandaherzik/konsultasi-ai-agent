@extends('layouts.home.pasien.app')

@section('page-title', 'Riwayat Konsultasi')

@section(
    'page-description',
    'Riwayat konsultasi Anda dengan AI Agent'
)

@section('content')

<div class="row">

    <div class="col-md-12">

        <div class="card card-round">

            <div class="card-header">

                <div class="card-head-row">

                    <div>

                        <h4 class="card-title mb-1">
                            Riwayat Konsultasi
                        </h4>

                        <p class="text-muted mb-0">
                            Lihat kembali konsultasi yang pernah dilakukan.
                        </p>

                    </div>

                    <div class="card-tools">

                        <a
                            href="{{ route('pasien.pasien.konsultasi.create') }}"
                            class="btn btn-primary btn-round"
                        >

                            <i class="fas fa-plus me-1"></i>

                            Konsultasi Baru

                        </a>

                    </div>

                </div>

            </div>


            <div class="card-body">

                @if(session('success'))

                    <div class="alert alert-success">

                        <i class="fas fa-check-circle me-1"></i>

                        {{ session('success') }}

                    </div>

                @endif


                <div class="table-responsive">

                    <table class="table table-hover">

                        <thead>

                            <tr>

                                <th>No</th>

                                <th>ID Konsultasi</th>

                                <th>Tanggal</th>

                                <th>Keluhan</th>

                                <th>Status</th>

                                <th>Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse(
                                $konsultasis as $konsultasi
                            )

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $konsultasi->id_konsultasi_ai }}
                                    </td>

                                    <td>

                                        {{ $konsultasi->created_at
                                            ->format('d/m/Y H:i') }}

                                    </td>

                                    <td>

                                        <div
                                            style="max-width: 300px;"
                                        >

                                            {{ Str::limit(
                                                $konsultasi->keluhan_pasien,
                                                80
                                            ) }}

                                        </div>

                                    </td>

                                    <td>

                                        @if(
                                            $konsultasi->status_konsultasi
                                            === 'berlangsung'
                                        )

                                            <span
                                                class="badge bg-warning"
                                            >
                                                Berlangsung
                                            </span>

                                        @elseif(
                                            $konsultasi->status_konsultasi
                                            === 'selesai'
                                        )

                                            <span
                                                class="badge bg-success"
                                            >
                                                Selesai
                                            </span>

                                        @else

                                            <span
                                                class="badge bg-danger"
                                            >
                                                Batal
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <a
                                            href="{{ route(
                                                'pasien.pasien.konsultasi.show',
                                                $konsultasi->id_konsultasi_ai
                                            ) }}"
                                            class="btn btn-sm btn-info"
                                            title="Lihat Detail"
                                        >

                                            <i class="fas fa-eye"></i>

                                            Detail

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="text-center py-5"
                                    >

                                        <i
                                            class="fas fa-comments fa-3x text-muted mb-3"
                                        ></i>

                                        <p class="text-muted mb-3">

                                            Belum ada riwayat konsultasi.

                                        </p>

                                        <a
                                            href="{{ route(
                                                'pasien.pasien.konsultasi.create'
                                            ) }}"
                                            class="btn btn-primary"
                                        >

                                            <i
                                                class="fas fa-robot me-1"
                                            ></i>

                                            Mulai Konsultasi

                                        </a>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>



@if($konsultasis->hasPages())

    <div class="row mt-3">

        {{-- Pagination --}}
        <div class="col-sm-12 col-md-7 ms-auto">

            <div
                class="dataTables_paginate paging_simple_numbers"
                id="basic-datatables_paginate"
            >

                <ul class="pagination justify-content-end">

                    {{-- Previous --}}
                    <li
                        class="paginate_button page-item previous
                        {{ $konsultasis->onFirstPage() ? 'disabled' : '' }}"
                    >

                        @if($konsultasis->onFirstPage())

                            <span class="page-link">
                                sebelumnya
                            </span>

                        @else

                            <a
                                href="{{ $konsultasis->previousPageUrl() }}"
                                class="page-link"
                            >
                                Previous
                            </a>

                        @endif

                    </li>


                    {{-- Nomor Halaman --}}
                    @foreach($konsultasis->getUrlRange(
                        max(1, $konsultasis->currentPage() - 2),
                        min($konsultasis->lastPage(), $konsultasis->currentPage() + 2)
                    ) as $page => $url)

                        <li
                            class="paginate_button page-item
                            {{ $page == $konsultasis->currentPage() ? 'active' : '' }}"
                        >

                            @if($page == $konsultasis->currentPage())

                                <span class="page-link">
                                    {{ $page }}
                                </span>

                            @else

                                <a
                                    href="{{ $url }}"
                                    class="page-link"
                                >
                                    {{ $page }}
                                </a>

                            @endif

                        </li>

                    @endforeach


                    {{-- Next --}}
                    <li
                        class="paginate_button page-item next
                        {{ $konsultasis->hasMorePages() ? '' : 'disabled' }}"
                    >

                        @if($konsultasis->hasMorePages())

                            <a
                                href="{{ $konsultasis->nextPageUrl() }}"
                                class="page-link"
                            >
                                selanjutnya
                            </a>

                        @else

                            <span class="page-link">
                                selanjutnya
                            </span>

                        @endif

                    </li>

                </ul>

            </div>

        </div>

    </div>

@endif
            </div>

        </div>

    </div>

</div>

@endsection