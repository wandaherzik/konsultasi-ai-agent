@extends('layouts.home.admin.app')

@section('page-title', 'Data Pasien')

@section('page-description', 'Pengelolaan data pasien Puskesmas')

@section('content')

<div class="page-inner">

    {{-- HEADER --}}

    <div class="d-flex
                align-items-center
                justify-content-between
                mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Data Pasien
            </h3>

            <p class="text-muted mb-0">
                Kelola data pasien yang terdaftar
                pada sistem.
            </p>

        </div>

        <div>

            <span class="badge bg-primary px-3 py-2">

                <i class="fas fa-users me-1"></i>

                {{ $pasiens->total() }} Pasien

            </span>

        </div>

    </div>


    {{-- SUCCESS --}}

    @if(session('success'))

        <div class="alert alert-success">

            <i class="fas fa-check-circle me-2"></i>

            {{ session('success') }}

        </div>

    @endif


    {{-- CARD --}}

    <div class="card card-round">

        <div class="card-header">

            <div class="card-head-row">

                <div>

                    <h4 class="card-title mb-1">

                        <i
                            class="fas fa-user-injured
                                   text-primary me-2"
                        ></i>

                        Daftar Pasien

                    </h4>

                    <p class="text-muted mb-0">

                        Data pasien yang terdaftar
                        dalam sistem.

                    </p>

                </div>

            </div>

        </div>


        <div class="card-body">


            {{-- SEARCH --}}

            <form
                action="{{ route('admin.pasien.index') }}"
                method="GET"
                class="mb-4"
            >

                <div class="row">

                    <div class="col-md-8">

                        <div class="input-group">

                            <span class="input-group-text">

                                <i class="fas fa-search"></i>

                            </span>

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Cari nama atau ID pasien..."
                                value="{{ request('search') }}"
                            >

                        </div>

                    </div>


                    <div class="col-md-4 mt-2 mt-md-0">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >

                            <i class="fas fa-search me-1"></i>

                            Cari

                        </button>


                        @if(request('search'))

                            <a
                                href="{{ route('admin.pasien.index') }}"
                                class="btn btn-secondary"
                            >

                                <i class="fas fa-times me-1"></i>

                                Reset

                            </a>

                        @endif

                    </div>

                </div>

            </form>


            {{-- TABLE --}}

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th width="60">
                                No
                            </th>

                            <th>
                                ID Pasien
                            </th>

                            <th>
                                Nama Pasien
                            </th>

                            <th>
                                Jenis Kelamin
                            </th>

                            <th>
                                No. HP
                            </th>

                            <th width="180">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse(
                            $pasiens as $pasien
                        )

                            <tr>

                                <td>
                                    {{
                                        $pasiens
                                            ->firstItem()
                                        + $loop->index
                                    }}
                                </td>


                                <td>

                                    <span
                                        class="badge bg-light
                                               text-dark"
                                    >

                                        {{ $pasien->id_pasien }}

                                    </span>

                                </td>


                                <td>

                                    <div
                                        class="d-flex
                                               align-items-center"
                                    >

                                        <div
                                            class="
                                                rounded-circle
                                                bg-primary
                                                text-white
                                                d-flex
                                                align-items-center
                                                justify-content-center
                                                me-2
                                            "
                                            style="
                                                width: 38px;
                                                height: 38px;
                                            "
                                        >

                                            <i
                                                class="fas fa-user"
                                            ></i>

                                        </div>


                                        <strong>

                                            {{
                                                $pasien->nama_pasien
                                            }}

                                        </strong>

                                    </div>

                                </td>

                                <td>

                                    {{
                                        $pasien->jenis_kelamin ?? '-'
                                    }}

                                </td>


                                <td>

                                    {{
                                        $pasien->no_telepon ?? '-'
                                    }}

                                </td>


                                <td>

                                    <div class="d-flex gap-1">

                                        {{-- DETAIL --}}

                                        <a
                                            href="{{
                                                route(
                                                    'admin.pasien.show',
                                                    $pasien->id_pasien
                                                )
                                            }}"
                                            class="btn btn-sm
                                                   btn-info"
                                            title="Detail"
                                        >

                                            <i
                                                class="fas fa-eye"
                                            ></i>

                                        </a>


                                        {{-- EDIT --}}

                                        <a
                                            href="{{
                                                route(
                                                    'admin.pasien.edit',
                                                    $pasien->id_pasien
                                                )
                                            }}"
                                            class="btn btn-sm
                                                   btn-warning"
                                            title="Edit"
                                        >

                                            <i
                                                class="fas fa-edit"
                                            ></i>

                                        </a>


                                        {{-- DELETE --}}

                                        <form
                                            action="{{
                                                route(
                                                    'admin.pasien.destroy',
                                                    $pasien->id_pasien
                                                )
                                            }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="
                                                return confirm(
                                                    'Yakin ingin menghapus pasien ini?'
                                                )
                                            "
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm
                                                       btn-danger"
                                                title="Hapus"
                                            >

                                                <i
                                                    class="fas fa-trash"
                                                ></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center py-5"
                                >

                                    <i
                                        class="
                                            fas fa-user-slash
                                            fa-3x
                                            text-muted
                                            mb-3
                                        "
                                    ></i>

                                    <h5>
                                        Belum Ada Data Pasien
                                    </h5>

                                    <p class="text-muted mb-0">

                                        Belum terdapat pasien
                                        yang terdaftar.

                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}

            @if($pasiens->hasPages())

                <div
                    class="d-flex
                           justify-content-end
                           mt-3"
                >

                    {{ $pasiens->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection