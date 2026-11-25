<?php

namespace App\Services\AI;

use App\Models\KonsultasiAI;
use App\Services\Contracts\AIServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class AIService implements AIServiceInterface
{
    /**
     * Mengirim percakapan pasien ke Gemini.
     *
     * Gemini mengembalikan response dalam bentuk
     * JSON terstruktur agar mudah diproses controller.
     */
    public function chat(
        KonsultasiAI $konsultasi
    ): array {

        /*
        |--------------------------------------------------------------------------
        | Pastikan pesan tersedia
        |--------------------------------------------------------------------------
        */

        $konsultasi->load('pesan');


        /*
        |--------------------------------------------------------------------------
        | Bangun history percakapan
        |--------------------------------------------------------------------------
        */

        $messages = $this->buildConversation(
            $konsultasi
        );


        /*
        |--------------------------------------------------------------------------
        | API Configuration
        |--------------------------------------------------------------------------
        */

        $apiKey = config(
            'services.gemini.api_key'
        );

        $model = config(
            'services.gemini.model',
            'gemini-3.6-flash'
        );


        if (!$apiKey) {

            throw new RuntimeException(
                'GEMINI_API_KEY belum dikonfigurasi.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | URL Gemini
        |--------------------------------------------------------------------------
        */

        $url =
            "https://generativelanguage.googleapis.com/v1beta/models/"
            . $model
            . ":generateContent";


        /*
        |--------------------------------------------------------------------------
        | Jumlah maksimum percobaan
        |--------------------------------------------------------------------------
        */

        $maxAttempts = 4;


        /*
        |--------------------------------------------------------------------------
        | Retry Request
        |--------------------------------------------------------------------------
        */

        for (
            $attempt = 1;
            $attempt <= $maxAttempts;
            $attempt++
        ) {

            try {

                /*
                |--------------------------------------------------------------------------
                | Request ke Gemini
                |--------------------------------------------------------------------------
                */

                $response = Http::withHeaders([

                    'x-goog-api-key' => $apiKey,

                    'Content-Type' =>
                        'application/json',

                ])
                ->connectTimeout(10)
                ->timeout(60)
                ->post(
                    $url,
                    [

                        /*
                        |--------------------------------------------------------------------------
                        | System Instruction
                        |--------------------------------------------------------------------------
                        */

                        'systemInstruction' => [

                            'parts' => [

                                [
                                    'text' =>
                                        $this->systemPrompt()
                                ]

                            ]

                        ],


                        /*
                        |--------------------------------------------------------------------------
                        | History Percakapan
                        |--------------------------------------------------------------------------
                        */

                        'contents' => $messages,


                        /*
                        |--------------------------------------------------------------------------
                        | Meminta Gemini menghasilkan JSON
                        |--------------------------------------------------------------------------
                        */

                        'generationConfig' => [

                            'responseMimeType' =>
                                'application/json',

                            'temperature' => 0.2,

                        ],

                    ]
                );


                /*
                |--------------------------------------------------------------------------
                | Berhasil
                |--------------------------------------------------------------------------
                */

                if ($response->successful()) {

                    $data = $response->json();


                    /*
                    |--------------------------------------------------------------------------
                    | Ambil teks JSON dari Gemini
                    |--------------------------------------------------------------------------
                    */

                    $text = data_get(
                        $data,
                        'candidates.0.content.parts.0.text'
                    );


                    if (!$text) {

                        Log::warning(
                            'GEMINI API EMPTY RESPONSE',
                            [
                                'model' =>
                                    $model,

                                'attempt' =>
                                    $attempt,

                                'response' =>
                                    $data,
                            ]
                        );

                        throw new RuntimeException(
                            'Gemini tidak memberikan teks respons.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Decode JSON
                    |--------------------------------------------------------------------------
                    */

                    $result = json_decode(
                        $text,
                        true
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Validasi JSON
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !is_array($result)
                        ||
                        !isset($result['response'])
                    ) {

                        Log::warning(
                            'GEMINI INVALID JSON RESPONSE',
                            [
                                'model' =>
                                    $model,

                                'attempt' =>
                                    $attempt,

                                'raw_response' =>
                                    $text,
                            ]
                        );

                        throw new RuntimeException(
                            'Format respons Gemini tidak valid.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Normalisasi data
                    |--------------------------------------------------------------------------
                    */

                    $result = [

                        'response' =>
                            $result['response']
                            ?? '',

                        'selesai' =>
                            (bool) (
                                $result['selesai']
                                ?? false
                            ),

                        'diagnosa_awal' =>
                            $result['diagnosa_awal']
                            ?? null,

                        'skor_urgensi' =>
                            isset(
                                $result['skor_urgensi']
                            )
                                ? (int) $result[
                                    'skor_urgensi'
                                ]
                                : null,

                        'kategori_urgensi' =>
                            $result[
                                'kategori_urgensi'
                            ]
                            ?? null,

                        'rekomendasi_poli' =>
                            $result[
                                'rekomendasi_poli'
                            ]
                            ?? null,

                    ];


                    /*
                    |--------------------------------------------------------------------------
                    | Batasi skor urgensi 0-100
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $result['skor_urgensi']
                        !== null
                    ) {

                        $result[
                            'skor_urgensi'
                        ] = max(
                            0,
                            min(
                                100,
                                $result[
                                    'skor_urgensi'
                                ]
                            )
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Log berhasil
                    |--------------------------------------------------------------------------
                    */

                    Log::info(
                        'GEMINI API SUCCESS',
                        [
                            'model' =>
                                $model,

                            'attempt' =>
                                $attempt,

                            'message_count' =>
                                count($messages),

                            'user_id' =>
                                auth()->id(),

                            'skor_urgensi' =>
                                $result[
                                    'skor_urgensi'
                                ],

                            'rekomendasi_poli' =>
                                $result[
                                    'rekomendasi_poli'
                                ],
                        ]
                    );


                    return $result;
                }


                /*
                |--------------------------------------------------------------------------
                | Status HTTP
                |--------------------------------------------------------------------------
                */

                $status = $response->status();


                /*
                |--------------------------------------------------------------------------
                | Error yang bisa di-retry
                |--------------------------------------------------------------------------
                */

                $retryableStatuses = [

                    408,

                    429,

                    500,

                    502,

                    503,

                    504,

                ];


                if (
                    in_array(
                        $status,
                        $retryableStatuses,
                        true
                    )
                    &&
                    $attempt < $maxAttempts
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Exponential Backoff
                    |--------------------------------------------------------------------------
                    */

                    $baseDelay =
                        2 ** $attempt;


                    /*
                    |--------------------------------------------------------------------------
                    | Random Jitter
                    |--------------------------------------------------------------------------
                    */

                    $jitter =
                        random_int(
                            0,
                            1000
                        ) / 1000;


                    $delay =
                        $baseDelay
                        + $jitter;


                    Log::warning(
                        'GEMINI API RETRY',
                        [

                            'status' =>
                                $status,

                            'attempt' =>
                                $attempt,

                            'next_attempt' =>
                                $attempt + 1,

                            'delay_seconds' =>
                                $delay,

                            'model' =>
                                $model,

                            'message_count' =>
                                count($messages),

                            'user_id' =>
                                auth()->id(),

                        ]
                    );


                    usleep(
                        (int) (
                            $delay
                            * 1_000_000
                        )
                    );


                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | Error terakhir
                |--------------------------------------------------------------------------
                */

                Log::error(
                    'GEMINI API ERROR',
                    [

                        'status' =>
                            $status,

                        'attempt' =>
                            $attempt,

                        'model' =>
                            $model,

                        'message_count' =>
                            count($messages),

                        'body' =>
                            $response->body(),

                        'user_id' =>
                            auth()->id(),

                    ]
                );


                throw new RuntimeException(

                    'Gemini API Error [' .
                    $status .
                    ']: ' .
                    $response->body()

                );
            }


            /*
            |--------------------------------------------------------------------------
            | Error koneksi / timeout
            |--------------------------------------------------------------------------
            */

            catch (\Throwable $e) {

                /*
                |--------------------------------------------------------------------------
                | Jangan retry error format JSON
                |--------------------------------------------------------------------------
                */

                if (
                    str_contains(
                        $e->getMessage(),
                        'Format respons Gemini tidak valid'
                    )
                ) {

                    throw $e;
                }


                if (
                    str_contains(
                        $e->getMessage(),
                        'Gemini tidak memberikan teks respons'
                    )
                ) {

                    throw $e;
                }


                /*
                |--------------------------------------------------------------------------
                | Retry koneksi
                |--------------------------------------------------------------------------
                */

                if (
                    $attempt < $maxAttempts
                ) {

                    $delay =
                        (2 ** $attempt)
                        +
                        (
                            random_int(
                                0,
                                1000
                            ) / 1000
                        );


                    Log::warning(
                        'GEMINI CONNECTION RETRY',
                        [

                            'attempt' =>
                                $attempt,

                            'next_attempt' =>
                                $attempt + 1,

                            'delay_seconds' =>
                                $delay,

                            'error' =>
                                $e->getMessage(),

                            'model' =>
                                $model,

                        ]
                    );


                    usleep(
                        (int) (
                            $delay
                            * 1_000_000
                        )
                    );


                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | Error koneksi terakhir
                |--------------------------------------------------------------------------
                */

                Log::error(
                    'GEMINI CONNECTION ERROR',
                    [

                        'attempt' =>
                            $attempt,

                        'error' =>
                            $e->getMessage(),

                        'model' =>
                            $model,

                    ]
                );


                throw $e;
            }
        }


        throw new RuntimeException(
            'Gemini tidak dapat memberikan respons.'
        );
    }


    /**
     * Membentuk history percakapan
     * menjadi format Gemini.
     */
    protected function buildConversation(
        KonsultasiAI $konsultasi
    ): array {

        $messages = [];


        /*
        |--------------------------------------------------------------------------
        | Ambil history konsultasi
        |--------------------------------------------------------------------------
        */

        foreach (
            $konsultasi->pesan
            as $pesan
        ) {

            $messages[] = [

                'role' =>
                    $pesan->pengirim === 'pasien'
                        ? 'user'
                        : 'model',

                'parts' => [

                    [
                        'text' =>
                            $pesan->pesan
                    ]

                ],

            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Pastikan role bergantian
        |--------------------------------------------------------------------------
        |
        | Gemini mengharapkan percakapan yang valid.
        |
        */

        $messages =
            $this->normalizeConversation(
                $messages
            );


        /*
        |--------------------------------------------------------------------------
        | Batasi history
        |--------------------------------------------------------------------------
        |
        | 12 pesan terakhir tetap dipertahankan
        | agar context tidak terus membesar.
        |
        */

        if (
            count($messages) > 12
        ) {

            $messages =
                array_slice(
                    $messages,
                    -12
                );
        }


        return $messages;
    }


    /**
     * Memastikan history percakapan
     * memiliki struktur role yang valid.
     */
    protected function normalizeConversation(
        array $messages
    ): array {

        $normalized = [];


        foreach (
            $messages
            as $message
        ) {

            /*
            |--------------------------------------------------------------------------
            | Abaikan pesan kosong
            |--------------------------------------------------------------------------
            */

            if (
                empty(
                    $message['parts'][0]['text']
                    ?? null
                )
            ) {

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Jika role sama dengan sebelumnya,
            | gabungkan menjadi satu message.
            |--------------------------------------------------------------------------
            */

            $lastIndex =
                count($normalized) - 1;


            if (
                $lastIndex >= 0
                &&
                $normalized[
                    $lastIndex
                ]['role']
                ===
                $message['role']
            ) {

                $normalized[
                    $lastIndex
                ]['parts'][0]['text']
                    .= "\n"
                    . $message[
                        'parts'
                    ][0]['text'];

            } else {

                $normalized[] =
                    $message;
            }
        }


        return $normalized;
    }


    /**
     * Instruksi AI Agent.
     */
    protected function systemPrompt(): string
    {
        return <<<'PROMPT'

Anda adalah AI Agent Asisten Konsultasi
pada Sistem Informasi Puskesmas Tiku.

Tugas Anda adalah membantu pasien melakukan
konsultasi kesehatan awal.

Anda bukan dokter dan tidak boleh mengaku
sebagai dokter.

HASIL RESPONS WAJIB DALAM FORMAT JSON.

Jangan menambahkan Markdown.
Jangan menggunakan ```json.
Jangan menggunakan ``` sama sekali.
Jangan menambahkan teks sebelum atau sesudah JSON.

Gunakan struktur JSON berikut:

{
    "response": "jawaban AI kepada pasien",
    "selesai": false,
    "diagnosa_awal": null,
    "skor_urgensi": null,
    "kategori_urgensi": null,
    "rekomendasi_poli": null
}

ATURAN FIELD:

1. response

Berisi jawaban yang akan ditampilkan
kepada pasien.

Gunakan bahasa Indonesia yang mudah dipahami
dan bertutur ramah seperti tenaga kesehatan.

Jangan menggunakan Markdown.

Jangan menggunakan:

###
**
---
*
>
emoji

Gunakan teks biasa.

Jika perlu membuat beberapa bagian,
gunakan format sederhana seperti:

Ringkasan Keluhan:
...

Kemungkinan Analisis Awal:
1. ...
2. ...

Tingkat Urgensi:
...

Rekomendasi Layanan:
...

Saran:
- ...
- ...

Catatan:
...

2. selesai

Gunakan:

false

Jika informasi pasien masih belum cukup
dan konsultasi masih membutuhkan
pertanyaan lanjutan.

Gunakan:

true

Jika informasi sudah cukup untuk membuat
analisis awal.

3. diagnosa_awal

Berisi kemungkinan kondisi medis
berdasarkan informasi pasien.

Jangan memberikan diagnosis pasti.

Jika informasi belum cukup:

null

Jika sudah cukup:

contoh:

"Kemungkinan karies gigi"

atau:

"Kemungkinan migrain ringan"

4. skor_urgensi

Gunakan angka 0 sampai 100.

0-25   = rendah
26-60  = sedang
61-100 = tinggi

Jika informasi belum cukup:

null

Jangan memberikan skor secara sembarangan.

5. kategori_urgensi

Gunakan salah satu:

"Rendah"
"Sedang"
"Tinggi"

Jika skor urgensi null:

null

6. rekomendasi_poli

Berikan rekomendasi poli yang paling
sesuai berdasarkan keluhan pasien.

Contoh:

"Poli Umum"

"Poli Gigi"

"Poli KIA"

"Poli Mata"

Jika informasi belum cukup:

null

ATURAN KONSULTASI:

1. Gunakan percakapan multi-turn.

2. Jangan langsung memberikan kesimpulan
hanya berdasarkan satu keluhan.

3. Ajukan pertanyaan lanjutan jika informasi
belum cukup.

4. Jangan mengulang pertanyaan yang sudah
dijawab pasien.

5. Pertanyaan harus relevan dengan keluhan.

6. Perhatikan:

- keluhan utama
- lama keluhan
- tingkat keparahan
- gejala penyerta
- kondisi yang memburuk
- riwayat yang relevan
- tanda bahaya

7. Jika terdapat tanda bahaya,
arahkan pasien segera mendapatkan
pertolongan medis.

8. Jangan memberikan resep atau dosis obat
secara sembarangan.

9. Jangan membuat informasi medis yang
tidak diberikan pasien.

10. Jika informasi sudah cukup,
berikan analisis awal.

11. Hasil konsultasi merupakan analisis awal
dan bukan pengganti pemeriksaan dokter.

12. Pasien dapat mengakhiri konsultasi
kapan saja.

CONTOH SAAT INFORMASI BELUM CUKUP:

{
    "response": "Baik, saya memahami keluhan Anda. Agar saya dapat membantu melakukan analisis awal dengan lebih tepat, sejak kapan keluhan tersebut Anda rasakan?",
    "selesai": false,
    "diagnosa_awal": null,
    "skor_urgensi": null,
    "kategori_urgensi": null,
    "rekomendasi_poli": null
}

CONTOH SAAT INFORMASI SUDAH CUKUP:

{
    "response": "Ringkasan Keluhan:\nSakit gigi terasa ngilu saat mengunyah dan sudah berlangsung selama 2 hari.\n\nKemungkinan Analisis Awal:\n1. Kemungkinan karies gigi.\n2. Kemungkinan makanan sering terselip di antara gigi.\n\nTingkat Urgensi:\n30% - Sedang\n\nRekomendasi Layanan:\nPoli Gigi\n\nSaran:\nJaga kebersihan gigi dan hindari mengunyah makanan keras pada sisi gigi yang terasa sakit.\n\nCatatan:\nHasil konsultasi merupakan analisis awal dan bukan pengganti pemeriksaan dokter.",
    "selesai": true,
    "diagnosa_awal": "Kemungkinan karies gigi",
    "skor_urgensi": 30,
    "kategori_urgensi": "Sedang",
    "rekomendasi_poli": "Poli Gigi"
}

PROMPT;
    }
}
