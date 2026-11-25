@extends('layouts.home.admin.app')

@section('page-title', 'Manajemen User')

@section(
    'page-description',
    'Kelola akun pengguna sistem Puskesmas Tiku'
)

@section('content')

<div class="col-md-12">

    <div class="card card-round">

        <div class="card-header">

            <div class="card-head-row d-flex justify-content-between align-items-center">

                {{-- Judul Card --}}
                <div>
                    <h4 class="card-title mb-0">
                        Daftar User
                    </h4>
                </div>

                {{-- Bagian kanan --}}
                <div class="d-flex align-items-center gap-2">

                    {{-- Tombol Tambah User --}}
    <a
        href="{{ route('admin.users.create') }}"
        class="btn btn-primary"
    >
        <i class="fas fa-plus me-1"></i>
        Tambah User
    </a>


                    {{-- Jumlah User --}}
                    <div class="card-tools">

                        <span class="badge bg-primary">
                            {{ $users->total() }} User
                        </span>

                    </div>

                </div>

            </div>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>ID User</th>

                            <th>Nama</th>

                            <th>Username</th>

                            <th>Role</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($users as $user)

                            <tr>

                                <td>
                                    {{ $users->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    {{ $user->id_user }}
                                </td>

                                <td>
                                    {{ $user->nama }}
                                </td>

                                <td>
                                    {{ $user->username }}
                                </td>

                                <td>

                                    @php
                                        $badge = match ($user->role) {
                                            'admin' => 'danger',
                                            'dokter' => 'primary',
                                            'pasien' => 'success',
                                            'kapus' => 'warning',
                                            default => 'secondary',
                                        };
                                    @endphp

                                    <span class="badge bg-{{ $badge }}">
                                        {{ ucfirst($user->role) }}
                                    </span>

                                </td>


                                <td>

                                    <div class="d-flex gap-1">

                                        {{-- Detail --}}
                                        <a
                                            href="{{ route('admin.users.show', $user->id_user) }}"
                                            class="btn btn-sm btn-info"
                                            title="Detail"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </a>


                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('admin.users.edit', $user->id_user) }}"
                                            class="btn btn-sm btn-warning"
                                            title="Edit"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>


                                        {{-- Hapus --}}
                                        @if($user->id_user !== auth()->user()->id_user)

                                            <form
                                                action="{{ route('admin.users.destroy', $user->id_user) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus user ini?')"
                                            >

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    title="Hapus"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center py-4"
                                >

                                    <i class="fas fa-users fa-2x text-muted mb-2"></i>

                                    <p class="mb-0 text-muted">
                                        Belum ada data user.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


@if($users->hasPages())

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
                        {{ $users->onFirstPage() ? 'disabled' : '' }}"
                    >

                        @if($users->onFirstPage())

                            <span class="page-link">
                                Sebelumnya
                            </span>

                        @else

                            <a
                                href="{{ $users->previousPageUrl() }}"
                                class="page-link"
                            >
                                Previous
                            </a>

                        @endif

                    </li>


                    {{-- Nomor Halaman --}}
                    @foreach($users->getUrlRange(
                        max(1, $users->currentPage() - 2),
                        min($users->lastPage(), $users->currentPage() + 2)
                    ) as $page => $url)

                        <li
                            class="paginate_button page-item
                            {{ $page == $users->currentPage() ? 'active' : '' }}"
                        >

                            @if($page == $users->currentPage())

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
                        {{ $users->hasMorePages() ? '' : 'disabled' }}"
                    >

                        @if($users->hasMorePages())

                            <a
                                href="{{ $users->nextPageUrl() }}"
                                class="page-link"
                            >
                                Selanjutnya
                            </a>

                        @else

                            <span class="page-link">
                                Selanjutnya
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

@endsection