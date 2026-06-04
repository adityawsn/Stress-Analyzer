@extends('layouts.app')

@section('title', 'Kuesioner')

@section('content')

    <style>
        .container-custom {
            max-width: 700px;
            /* sebelumnya 800px atau full */
            margin: auto;
        }

        .card-custom {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .progress {
            height: 7px;
            border-radius: 20px;
        }

        .progress-bar {
            background: #F9B2D7;
        }

        .progress-wrapper {
            width: 260px;
            margin-left: auto;
        }

        .form-control,
        .form-select {
            padding: 10px 14px;
            font-size: 0.9rem;
        }

        .likert-option input {
            display: none;
        }

        .likert-option label {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 2px solid #ddd;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .likert-option input:checked+label {
            background: #4facfe;
            border-color: #4facfe;
            box-shadow: 0 0 0 5px rgba(79, 172, 254, 0.2);
        }

        .hidden {
            display: none;
        }

        .btn-custom {
            border-radius: 50px;
            padding: 10px 25px;
        }

        .likert-modern {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
        }

        .scale {
            display: flex;
            align-items: center;
            gap: 40px;
        }

        .option input {
            display: none;
        }

        .circle {
            display: inline-block;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid;
            position: relative;
            transition: 0.25s ease;
        }

        /* SIZE (5 skala: besar → kecil → besar) */
        .circle-1 {
            width: 40px;
            height: 40px;
        }

        .circle-2 {
            width: 32px;
            height: 32px;
        }

        .circle-3 {
            width: 24px;
            height: 24px;
            border-color: #ccc;
        }

        .circle-4 {
            width: 32px;
            height: 32px;
        }

        .circle-5 {
            width: 40px;
            height: 40px;
        }

        /* WARNA */
        .circle-1,
        .circle-2 {
            border-color: #e53e3e;
            /* merah = tidak setuju */
        }

        .circle-4,
        .circle-5 {
            border-color: #3182ce;
            /* biru = setuju */
        }

        /* ACTIVE */
        .option input:checked+.circle-1,
        .option input:checked+.circle-2 {
            background: #e53e3e;
        }

        .option input:checked+.circle-3 {
            background: #ccc;
        }

        .option input:checked+.circle-4,
        .option input:checked+.circle-5 {
            background: #3182ce;
        }

        /* CEKLIS (default hidden) */
        .circle::after {
            content: "✔";
            opacity: 0;
            font-size: 14px;
            font-weight: bold;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            transition: 0.2s;
        }

        /* HOVER (belum dipilih) */
        .option:hover input:not(:checked)+.circle::after {
            opacity: 0.3;
            color: rgba(0, 0, 0, 0.4);
        }

        /* CHECKED */
        .option input:checked+.circle::after {
            opacity: 1;
            color: white;
        }

        /* HOVER BACKGROUND */
        /* 🔴 MERAH */
        .option:hover input:not(:checked)+.circle-1,
        .option:hover input:not(:checked)+.circle-2 {
            background: #e53e3e;
        }

        /* ⚪ NETRAL */
        .option:hover input:not(:checked)+.circle-3 {
            background: #ccc;
        }

        /* 🔵 BIRU */
        .option:hover input:not(:checked)+.circle-4,
        .option:hover input:not(:checked)+.circle-5 {
            background: #3182ce;
        }

        /* HOVER SCALE */
        .option:hover .circle {
            transform: scale(1.1);
        }

        /* LABEL */
        .label-left {
            color: #e53e3e;
            font-weight: 600;
            min-width: 110px;
        }

        .label-right {
            color: #3182ce;
            font-weight: 600;
            min-width: 80px;
            text-align: right;
        }

        #nextBtn {
            transition: all 0.2s ease;
        }

        .is-invalid {
            border: 2px solid #e53e3e !important;
            border-radius: 8px;
        }

        .error-text {
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }
    </style>

    <div class="container container-custom py-5">

        <!-- Progress -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">

            <!-- KIRI (Judul) -->
            <div>
                <h5 class="mb-1 fw-bold">
                    Survei Tingkat Stres Mahasiswa
                </h5>
                <small class="text-muted">
                    Dalam Proses Penyusunan Skripsi
                </small>
            </div>

            <!-- KANAN (Progress) -->
            <div class="progress-wrapper">
                <div class="progress mb-1">
                    <div id="progressBar" class="progress-bar" style="width: 0%"></div>
                </div>
                <small class="text-muted">
                    Langkah <span id="stepText">1</span> dari <span id="totalSteps">-</span>
                </small>
            </div>

        </div>

        <div class="card-custom">
            <form id="formKuesioner">
                @csrf

                <!-- STEP 1: IDENTITAS -->
                <div class="step">
                    <h5 class="mb-4">Data Pribadi</h5>

                    <div class="mb-3 position-relative">
                        <input type="text" id="nama" class="form-control" placeholder="Nama Lengkap" required>
                        <small class="text-danger error-text d-none">Nama wajib diisi</small>
                    </div>

                    <div class="mb-3 position-relative">
                        <input type="email" id="email" class="form-control" placeholder="Email" required>
                        <small class="text-danger error-text d-none">Email wajib diisi</small>
                    </div>

                    <div class="mb-3 position-relative">
                        <select id="gender" class="form-select" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        <small class="text-danger error-text d-none">Pilih jenis kelamin</small>
                    </div>

                    <div class="mb-3 position-relative">
                        <input type="number" id="umur" class="form-control"
                            placeholder="Umur saat mengerjakan skripsi" required>
                        <small class="text-danger error-text d-none">Umur wajib diisi</small>
                    </div>
                </div>

                <!-- STEP 2: AKADEMIK -->
                <div class="step hidden">
                    <h5 class="mb-4">Informasi Akademik</h5>

                    <div class="mb-3 position-relative">
                        <select id="jenjang" class="form-select" required>
                            <option value="">Pilih Jenjang</option>
                            <option value="D3">D3</option>
                            <option value="D4 / S1">D4 / S1</option>
                        </select>
                        <small class="text-danger error-text d-none">Pilih jenjang</small>
                    </div>

                    <div class="mb-3 position-relative">
                        <input type="text" id="kampus" class="form-control" placeholder="Nama Kampus" required>
                        <small class="text-danger error-text d-none">Nama kampus wajib diisi</small>
                    </div>

                    <div class="mb-3 position-relative">
                        <input type="text" id="jurusan" class="form-control" placeholder="Fakultas / Jurusan" required>
                        <small class="text-danger error-text d-none">Jurusan wajib diisi</small>
                    </div>

                    <div class="mb-3 position-relative">
                        <input type="text" id="prodi" class="form-control" placeholder="Program Studi" required>
                        <small class="text-danger error-text d-none">Program studi wajib diisi</small>
                    </div>
                </div>

                <!-- STEP 3: STATUS SKRIPSI -->
                <div class="step hidden">
                    <h5 class="mb-4">Status Penyusunan Skripsi</h5>

                    <div class="mb-3 position-relative">
                        <select id="status" class="form-select" required>
                            <option value="">Pilih Status</option>
                            <option value="Proses">Sedang Menyusun Skripsi</option>
                            <option value="Selesai">Sudah Menyelesaikan Skripsi</option>
                        </select>
                        <small class="text-danger error-text d-none">Pilih status skripsi</small>
                    </div>

                    <div class="mb-3 position-relative">
                        <input type="number" id="tahun" class="form-control" placeholder="Tahun mengerjakan skripsi"
                            min="2000" max="2030" required>
                        <small class="text-danger error-text d-none">Tahun wajib diisi</small>
                    </div>
                </div>

                <!-- STEP 2 - 5: PERTANYAAN DENGAN LOOP -->
                @php
                    $questions = [
                        'Saya mengalami kesulitan dalam menentukan judul skripsi yang sesuai dengan minat dan kemampuan saya.',
                        'Saya mengalami kesulitan dalam melakukan bimbingan skripsi dengan dosen pembimbing.',
                        'Banyaknya revisi skripsi yang harus saya kerjakan membuat saya merasa tertekan.',
                        'Tuntutan untuk lulus tepat waktu membuat saya merasa tertekan dalam menyelesaikan skripsi.',
                        'Saya merasa cemas terhadap hasil akhir skripsi yang sedang saya kerjakan.',
                        'Saya memiliki jadwal yang terencana dengan baik untuk mengerjakan skripsi.',
                        'Saya mengerjakan skripsi secara disiplin sesuai dengan jadwal yang telah saya buat.',
                        'Saya mampu menentukan prioritas antara pengerjaan skripsi dan aktivitas lainnya.',
                        'Saya mengerjakan skripsi secara konsisten meskipun menghadapi kesulitan.',
                        'Saya mampu mengendalikan kebiasaan menunda pengerjaan skripsi.',
                    ];
                @endphp

                @foreach (array_chunk($questions, 2) as $groupIndex => $group)
                    <div class="step {{ $groupIndex > 0 ? 'hidden' : '' }}">
                        @foreach ($group as $question)
                            @php
                                $questionIndex = array_search($question, $questions);
                            @endphp
                            <h5 class="{{ $questionIndex == 9 ? 'mb-1' : 'mb-4' }}">
                                {{ $question }}
                            </h5>

                            @if ($questionIndex == 9)
                                <small class="text-muted d-block mb-4">
                                    Contoh: Walaupun sedang malas atau ingin bermain HP, saya tetap memilih membuka laptop
                                    dan mengerjakan skripsi sesuai jadwal yang sudah saya buat.
                                </small>
                            @endif

                            <div class="likert-modern mb-5">
                                <span class="label-left">Tidak Setuju</span>

                                <div class="scale">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <div class="option">
                                            <input type="radio" name="q{{ $questionIndex + 1 }}"
                                                id="q{{ $questionIndex + 1 }}{{ $i }}"
                                                value="{{ $i }}" required>
                                            <label for="q{{ $questionIndex + 1 }}{{ $i }}"
                                                class="circle circle-{{ $i }} required"></label>
                                        </div>
                                    @endfor
                                </div>

                                <span class="label-right">Setuju</span>
                            </div>
                        @endforeach
                    </div>
                @endforeach

                <!-- Button -->
                <div class="d-flex mt-4">
                    <button type="button" id="prevBtn" class="btn btn-secondary btn-custom">
                        ← Sebelumnya
                    </button>

                    <button type="button" id="nextBtn" class="btn btn-primary btn-custom ms-auto">
                        Selanjutnya →
                    </button>
                </div>

            </form>
        </div>
    </div>


    <script id="multi-step-form">
        let currentStep = 0;
        const steps = document.querySelectorAll(".step");
        const progressBar = document.getElementById("progressBar");
        const stepText = document.getElementById("stepText");
        const totalSteps = document.getElementById("totalSteps");

        totalSteps.innerText = steps.length;

        function showStep() {
            steps.forEach((step, i) => {
                step.classList.toggle("hidden", i !== currentStep);
            });

            let percent = ((currentStep + 1) / steps.length) * 100;
            progressBar.style.width = percent + "%";
            stepText.innerText = currentStep + 1;

            const prevBtn = document.getElementById("prevBtn");
            const nextBtn = document.getElementById("nextBtn");

            // tombol sebelumnya
            prevBtn.style.display = currentStep === 0 ? "none" : "inline-block";

            // tombol next / kirim
            nextBtn.innerText = currentStep === steps.length - 1 ?
                "Lihat Hasil" :
                "Selanjutnya →";
        }

        // 🔹 VALIDASI STEP
        function validateStep(stepElement) {
            const inputs = stepElement.querySelectorAll("input, select");
            let isValid = true;

            inputs.forEach(input => {
                const errorText = input.parentElement.querySelector(".error-text");

                if (input.type !== "radio") {

                    // 🔹 VALIDASI DEFAULT
                    if (!input.checkValidity()) {
                        input.classList.add("is-invalid");

                        if (errorText) {
                            // errorText.innerText = "Field ini wajib diisi";
                            errorText.classList.remove("d-none");
                        }

                        if (isValid) input.focus();

                        isValid = false;
                    } else {
                        input.classList.remove("is-invalid");

                        if (errorText) errorText.classList.add("d-none");
                    }

                    // 🔥 VALIDASI KHUSUS TAHUN (SETELAH VALID DEFAULT)
                    if (input.id === "tahun" && input.value !== "") {
                        const value = parseInt(input.value);

                        if (value < 2000 || value > 2030) {
                            input.classList.add("is-invalid");

                            if (errorText) {
                                errorText.innerText = "Tahun harus antara 2000 - 2030";
                                errorText.classList.remove("d-none");
                            }

                            if (isValid) input.focus();

                            isValid = false;
                        }
                    }
                }
            });

            // 🔹 VALIDASI RADIO (LIKERT)
            const radioGroups = {};

            inputs.forEach(input => {
                if (input.type === "radio") {
                    radioGroups[input.name] = true;
                }
            });

            for (let name in radioGroups) {
                const checked = stepElement.querySelector(`input[name="${name}"]:checked`);

                if (!checked) {
                    // ❗ hanya alert untuk likert
                    Swal.fire({
                        icon: "warning",
                        title: "Jawaban belum lengkap",
                        text: "Silakan isi semua pertanyaan skala terlebih dahulu"
                    });

                    return false; // langsung stop
                }
            }

            return isValid;
        }

        // 🔹 NEXT BUTTON
        document.getElementById("nextBtn").addEventListener("click", () => {

    const currentStepElement = steps[currentStep];

    // 🔹 validasi dulu
    if (!validateStep(currentStepElement)) {
        return;
    }

    // 🔹 kalau belum step terakhir
    if (currentStep < steps.length - 1) {
        currentStep++;
        showStep();
        return;
    }

    // 🔹 STEP TERAKHIR → konfirmasi kirim
    Swal.fire({
        title: "Tampilkan hasil sekarang?",
        text: "Pastikan semua jawaban sudah benar.",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Ya, tampilkan!",
        cancelButtonText: "Periksa lagi",
        confirmButtonColor: "#4f46e5",
        cancelButtonColor: "#6b7280",
        reverseButtons: true
    }).then((result) => {

    if (!result.isConfirmed) return;

    const hasil = hitungHasil();

    const payload = {
        nama: document.getElementById('nama').value.trim(),
        email: document.getElementById('email').value.trim(),
        gender: document.getElementById('gender').value,
        umur: parseInt(document.getElementById('umur').value, 10),
        jenjang: document.getElementById('jenjang').value,
        kampus: document.getElementById('kampus').value.trim(),
        jurusan: document.getElementById('jurusan').value.trim(),
        prodi: document.getElementById('prodi').value.trim(),
        status: document.getElementById('status').value,
        tahun: parseInt(document.getElementById('tahun').value, 10),
        answers: hasil.answers,
        tps: hasil.tps,
        mw: hasil.mw,
    };

    const tokenInput = document.querySelector('input[name="_token"]');
    const csrfToken = tokenInput ? tokenInput.value : '';

    fetch('/kuesioner', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify(payload),
    })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.message || 'Gagal mengirim data kuesioner.');
            }
            sessionStorage.setItem('hasil', JSON.stringify(hasil));
            window.location.href = '/hasil';
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: error.message,
            });
        });

    });

});

        // 🔹 PREV BUTTON
        document.getElementById("prevBtn").addEventListener("click", () => {
            if (currentStep > 0) {
                currentStep--;
                showStep();
            }
        });

        document.querySelectorAll("input, select").forEach(input => {
            input.addEventListener("input", () => {
                input.classList.remove("is-invalid");

                const errorText = input.parentElement.querySelector(".error-text");
                if (errorText) errorText.classList.add("d-none");
            });
        });


        showStep();

        function hitungHasil() {
            // Ambil semua jawaban
            let answers = {};
            for (let i = 1; i <= 10; i++) {
                const selected = document.querySelector(`input[name="q${i}"]:checked`);
                answers[`q${i}`] = selected ? parseInt(selected.value) : 0;
            }

            // Hitung TPS (Pertanyaan 1-5: Tekanan Penyusunan Skripsi)
            let tpsSum = answers.q1 + answers.q2 + answers.q3 + answers.q4 + answers.q5;
            let tpsAvg = tpsSum / 5;
            let tps = tpsAvg * 20; // Scale ke 0-100

            // Hitung MW (Pertanyaan 6-10: Manajemen Waktu)
            let mwSum = answers.q6 + answers.q7 + answers.q8 + answers.q9 + answers.q10;
            let mwAvg = mwSum / 5;
            let mw = mwAvg * 20; // Scale ke 0-100

            return {
                answers: answers,
                tps: Math.round(tps * 100) / 100,
                mw: Math.round(mw * 100) / 100
            };
        }
    </script>

@endsection
