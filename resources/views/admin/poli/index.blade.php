@extends('layouts.home.admin.app')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h3 class="fw-bold mb-1">Data Poli</h3>
        <p class="text-muted mb-0">
            Kelola data poli Puskesmas.
        </p>
    </div>

    <a href="{{ route('admin.poli.create') }}"
       class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>
        Tambah Poli
    </a>
</div>


<div class="card card-round">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Poli</th>
                        <th>Nama Poli</th>
                        <th>Kapasitas</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($polis as $index => $poli)

                        <tr>

                            <td>
                                {{ $polis->firstItem() + $index }}
                            </td>

                            <td>
                                {{ $poli->id_poli }}
                            </td>

                            <td>
                                {{ $poli->nama_poli }}
                            </td>
                            <td>
                                {{ $poli->kapasitas_harian }}
                            </td>

                            <td class="text-center">

                                <a href="{{ route('admin.poli.edit', $poli->id_poli) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.poli.destroy', $poli->id_poli) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus poli ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4"
                                class="text-center text-muted">
                                Belum ada data poli.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">
            {{ $polis->links() }}
        </div>

    </div>

</div>

@endsection



