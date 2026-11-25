@extends('layouts.home.pasien.app')

@section('page-title', 'Konsultasi AI')

@section(
    'page-description',
    'Sampaikan keluhan Anda kepada AI Agent'
)

@section('content')

<div class="row justify-content-center">

    <div class="col-md-9">

        <div class="card card-round">

            {{-- ============================= --}}
            {{-- HEADER --}}
            {{-- ============================= --}}

            <div class="card-header">

                <div class="card-title">

                    <i class="fas fa-robot me-2 text-primary"></i>

                    AI Agent Puskesmas Tiku

                </div>

            </div>


            <div class="card-body">

                {{-- ============================= --}}
                {{-- INFORMASI --}}
                {{-- ============================= --}}

                <div class="alert alert-info">

                    <i class="fas fa-info-circle me-2"></i>

                    AI Agent digunakan sebagai asisten konsultasi awal.
                    Hasil konsultasi bukan merupakan diagnosis dokter.

                </div>


                {{-- ============================= --}}
                {{-- AREA CHAT --}}
                {{-- ============================= --}}

                <div
                    id="chatContainer"
                    class="border rounded p-3 mb-3"
                    style="
                        height: 450px;
                        overflow-y: auto;
                        background-color: #f8f9fa;
                    "
                >

                    {{-- Pesan pembuka AI --}}

                    <div class="d-flex mb-3">

                        <div class="me-2">

                            <span class="badge bg-primary">
                                AI
                            </span>

                        </div>

                        <div
                            class="bg-white rounded p-3 shadow-sm"
                            style="max-width: 85%;"
                        >

                            <div class="markdown-body">

                                Halo, Selamat datang di layanan konsultasi Sehatiku...

                                <br><br>

                                Silakan ceritakan keluhan kesehatan
                                yang sedang Anda alami.

                            </div>

                        </div>

                    </div>


                    {{-- ============================= --}}
                    {{-- RIWAYAT PESAN --}}
                    {{-- ============================= --}}

                    @if(isset($konsultasi) && $konsultasi->pesan->count())

                        @foreach($konsultasi->pesan as $pesan)

                            @if($pesan->pengirim === 'pasien')

                                {{-- ============================= --}}
                                {{-- PESAN PASIEN --}}
                                {{-- ============================= --}}

                                <div class="d-flex justify-content-end mb-3">

                                    <div
                                        class="bg-primary text-white rounded p-3"
                                        style="max-width: 80%;"
                                    >

                                        {{ $pesan->pesan }}

                                    </div>

                                </div>

                            @else

                                {{-- ============================= --}}
                                {{-- PESAN AI --}}
                                {{-- ============================= --}}

                                <div class="d-flex mb-3">

                                    <div class="me-2">

                                        <span class="badge bg-primary">
                                            AI
                                        </span>

                                    </div>

                                    <div
                                        class="bg-white rounded p-3 shadow-sm"
                                        style="max-width: 85%;"
                                    >
                                    <div class="ai-response">
                                        {!! nl2br(e($pesan->pesan)) !!}
                                    </div>

                                </div>

                            @endif

                        @endforeach

                    @endif

                </div>


                {{-- ============================= --}}
                {{-- INPUT KONSULTASI --}}
                {{-- ============================= --}}

                <form
                    action="{{ route('pasien.pasien.konsultasi.store') }}"
                    method="POST"
                >

                    @csrf


                    <div class="mb-3">

                        <label class="form-label fw-bold">

                            Keluhan Anda

                        </label>

                        <textarea
                            name="keluhan"
                            class="form-control"
                            rows="4"
                            placeholder="Contoh: Saya mengalami demam dan batuk sejak kemarin..."
                            required
                        >{{ old('keluhan') }}</textarea>

                    </div>


                    <div class="d-flex justify-content-between">

                        <a
                            href="{{ route('pasien.pasien.konsultasi.index') }}"
                            class="btn btn-light"
                        >

                            <i class="fas fa-arrow-left me-1"></i>

                            Kembali

                        </a>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >

                            <i class="fas fa-paper-plane me-1"></i>

                            Kirim Konsultasi

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


@endsection

<script>

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.ai-response').forEach(function (element) {

        try {

            const encoded = element.dataset.content;

            const markdown = atob(encoded);

            element.innerHTML = marked.parse(markdown);

        } catch (error) {

            console.error(
                'Gagal merender Markdown AI:',
                error
            );

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Scroll ke pesan terakhir
    |--------------------------------------------------------------------------
    */

    const chatContainer =
        document.getElementById('chatContainer');

    if (chatContainer) {

        chatContainer.scrollTop =
            chatContainer.scrollHeight;

    }

});

</script>


{{-- ================================================= --}}
{{-- STYLE --}}
{{-- ================================================= --}}

<style>

    .markdown-body {
        line-height: 1.7;
        font-size: 15px;
    }


    .markdown-body h1,
    .markdown-body h2,
    .markdown-body h3 {

        margin-top: 18px;
        margin-bottom: 10px;
        font-weight: 600;

    }


    .markdown-body p {

        margin-bottom: 10px;

    }


    .markdown-body ul,
    .markdown-body ol {

        padding-left: 25px;
        margin-bottom: 15px;

    }


    .markdown-body li {

        margin-bottom: 5px;

    }


    .markdown-body blockquote {

        border-left: 4px solid #0d6efd;

        padding-left: 15px;

        margin: 15px 0;

        color: #6c757d;

    }


    .markdown-body hr {

        margin: 15px 0;

    }


    .markdown-body strong {

        font-weight: 700;

    }

</style>