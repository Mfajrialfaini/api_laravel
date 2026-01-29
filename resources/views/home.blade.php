<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pixel Dashboard - Arcade Mode</title>

    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">

    <style>
        /* --- 1. RESET & CORE STYLES --- */
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #2c3e50;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            font-family: 'Press Start 2P', cursive;
            margin: 0;
            padding: 20px;
            color: #ecf0f1;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        /* --- 2. LAYOUT GRID --- */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            width: 100%;
            max-width: 1400px;
            margin-top: 20px;
        }

        .header-section {
            width: 100%;
            max-width: 1400px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 4px dashed #7f8c8d;
        }

        /* --- 3. PIXEL COMPONENT STYLES --- */
        .pixel-card {
            background: #fff;
            color: #2d3436;
            padding: 1.5rem;
            position: relative;
            box-shadow:
                -4px 0 0 0 black, 4px 0 0 0 black, 0 -4px 0 0 black, 0 4px 0 0 black,
                -4px -4px 0 0 black, 4px -4px 0 0 black, 4px 4px 0 0 black, -4px 4px 0 0 black,
                8px 8px 0 0 rgba(0, 0, 0, 0.5);
        }

        .pixel-btn {
            background: #00b894;
            border: none;
            padding: 10px 15px;
            color: white;
            font-family: inherit;
            font-size: 0.7rem;
            cursor: pointer;
            text-transform: uppercase;
            box-shadow: inset -3px -3px 0 0 rgba(0, 0, 0, 0.2), -3px 0 0 0 black, 3px 0 0 0 black, 0 -3px 0 0 black, 0 3px 0 0 black;
            transition: all 0.1s;
        }

        .pixel-btn:active {
            transform: translateY(3px);
        }

        .pixel-btn:disabled {
            background: #b2bec3;
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
        }

        .btn-red {
            background: #d63031;
        }

        .btn-blue {
            background: #0984e3;
        }

        h2 {
            font-size: 1rem;
            margin-top: 0;
            text-transform: uppercase;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        /* --- 4. GAME 1: ULAR TANGGA STYLES --- */
        #game-board {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            width: 100%;
            aspect-ratio: 1/1;
            border: 4px solid black;
            background: #dfe6e9;
            font-size: 0.4rem;
        }

        .cell {
            border: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .cell:nth-child(odd) {
            background: #ffeaa7;
        }

        .cell:nth-child(even) {
            background: #fab1a0;
        }

        .snake-marker {
            background: #ff7675 !important;
            color: white;
        }

        .ladder-marker {
            background: #55efc4 !important;
        }

        .token {
            width: 70%;
            height: 70%;
            position: absolute;
            z-index: 2;
            box-shadow: 2px 2px 0 black;
            transition: all 0.3s ease;
        }

        .p1-token {
            background: #0984e3;
        }

        .cpu-token {
            background: #d63031;
            right: 0;
            bottom: 0;
            width: 50%;
            height: 50%;
        }

        /* --- 5. GAME 2: WHACK-A-MOLE STYLES --- */
        .mole-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .mole-hole {
            background: #636e72;
            aspect-ratio: 1/1;
            border: 4px solid black;
            cursor: pointer;
            position: relative;
        }

        .mole {
            width: 80%;
            height: 80%;
            background: #fdcb6e;
            position: absolute;
            top: 10%;
            left: 10%;
            display: none;
            box-shadow: inset -4px -4px 0 rgba(0, 0, 0, 0.2);
        }

        .mole.active {
            display: block;
        }

        .score-board {
            font-size: 0.8rem;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }

        /* --- 6. PHOTOBOOTH STYLES --- */
        .booth-container {
            position: relative;
            width: 100%;
            background: #000;
            border: 4px solid #2d3436;
            margin-bottom: 15px;
            display: flex;
            justify-content: center;
            overflow: hidden;
        }

        /* Canvas ini yang akan menampilkan efek pixel */
        #pixelCanvas {
            width: 100%;
            image-rendering: pixelated;
            /* KUNCI EFEK PIXEL */
        }

        /* Video asli disembunyikan, kita hanya ambil datanya */
        #webcamVideo {
            display: none;
        }
    </style>
</head>

<body>

    <div class="header-section">
        <div>
            <h1>PIXEL DASHBOARD</h1>
            <span style="font-size: 0.7rem; color: #bdc3c7;">Selamat Datang, {{ Auth::user()->name ?? 'Player 1' }}</span>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="pixel-btn btn-red">LOGOUT</button>
        </form>
    </div>

    <div class="dashboard-grid">

        <div class="pixel-card">
            <h2>🎲 Ular Tangga</h2>
            <div id="game-board"></div>

            <div style="margin-top:15px; display:flex; justify-content:space-between; align-items:center;">
                <div id="sn-status" style="font-size:0.6rem;">Giliran: KAMU</div>
                <button class="pixel-btn" id="rollBtn" onclick="snRoll()">KOCOK DADU</button>
                <button class="pixel-btn btn-red" id="resetBtn" onclick="snInit()" style="display:none;">RESET</button>
            </div>
            <div style="font-size:0.5rem; margin-top:5px; color:#636e72;">Biru: Kamu | Merah: CPU</div>
        </div>

        <div class="pixel-card">
            <h2>🔨 Pukul Tikus</h2>
            <div class="score-board">
                <span>Skor: <span id="wm-score">0</span></span>
                <span>Waktu: <span id="wm-time">15</span>s</span>
            </div>

            <div class="mole-grid">
                <div class="mole-hole" onmousedown="wmHit(0)">
                    <div class="mole" id="mole-0"></div>
                </div>
                <div class="mole-hole" onmousedown="wmHit(1)">
                    <div class="mole" id="mole-1"></div>
                </div>
                <div class="mole-hole" onmousedown="wmHit(2)">
                    <div class="mole" id="mole-2"></div>
                </div>
                <div class="mole-hole" onmousedown="wmHit(3)">
                    <div class="mole" id="mole-3"></div>
                </div>
                <div class="mole-hole" onmousedown="wmHit(4)">
                    <div class="mole" id="mole-4"></div>
                </div>
                <div class="mole-hole" onmousedown="wmHit(5)">
                    <div class="mole" id="mole-5"></div>
                </div>
                <div class="mole-hole" onmousedown="wmHit(6)">
                    <div class="mole" id="mole-6"></div>
                </div>
                <div class="mole-hole" onmousedown="wmHit(7)">
                    <div class="mole" id="mole-7"></div>
                </div>
                <div class="mole-hole" onmousedown="wmHit(8)">
                    <div class="mole" id="mole-8"></div>
                </div>
            </div>

            <center>
                <button id="wmStartBtn" class="pixel-btn btn-blue" onclick="wmStart()">MULAI GAME</button>
            </center>
        </div>

        <div class="pixel-card">
            <h2>📸 Pixel Photobooth</h2>

            <div class="booth-container">
                <canvas id="pixelCanvas" width="64" height="48"></canvas>
            </div>
            <video id="webcamVideo" autoplay playsinline></video>

            <div style="display:flex; gap:10px; justify-content: center;">
                <button id="camBtn" class="pixel-btn" onclick="camStart()">Kamera On</button>
                <button id="dlBtn" class="pixel-btn btn-blue" onclick="camSnap()" disabled>Download</button>
            </div>
            <p style="font-size:0.5rem; margin-top:10px; text-align:center; color:#b2bec3;">
                Pastikan izinkan akses kamera. Hasil foto resolusi HD dengan gaya 8-bit.
            </p>
        </div>

    </div>

    <script>
        /* =========================================
           1. LOGIKA ULAR TANGGA
           ========================================= */
        const snBoard = document.getElementById('game-board');
        const rollBtn = document.getElementById('rollBtn');
        const resetBtn = document.getElementById('resetBtn');
        const snStatus = document.getElementById('sn-status');

        let snP1 = 1,
            snCpu = 1;
        let snGameOver = false;
        const snMap = {
            4: 14,
            9: 31,
            20: 38,
            28: 84,
            40: 59,
            51: 67,
            63: 81,
            17: 7,
            54: 34,
            62: 19,
            64: 60,
            87: 24,
            93: 73,
            95: 75,
            99: 78
        };

        function snInit() {
            snP1 = 1;
            snCpu = 1;
            snGameOver = false;
            rollBtn.style.display = 'block';
            resetBtn.style.display = 'none';
            snStatus.innerText = "Giliran: KAMU";

            snBoard.innerHTML = '';
            // Render Papan
            for (let r = 9; r >= 0; r--) {
                let rowArr = [];
                for (let c = 0; c < 10; c++) rowArr.push((r % 2 == 0) ? (r * 10 + c + 1) : (r * 10 + (10 - c)));
                if (r % 2 != 0) rowArr.reverse();
                rowArr.forEach(n => {
                    let d = document.createElement('div');
                    d.className = 'cell';
                    d.id = 'c-' + n;
                    d.innerText = n;
                    if (snMap[n] > n) d.classList.add('ladder-marker'); // Tangga
                    if (snMap[n] < n) d.classList.add('snake-marker'); // Ular
                    snBoard.appendChild(d);
                });
            }
            snRender();
        }

        function snRender() {
            document.querySelectorAll('.token').forEach(e => e.remove());
            // Render Token Player
            let cellP1 = document.getElementById('c-' + snP1);
            if (cellP1) cellP1.innerHTML += '<div class="token p1-token"></div>';
            // Render Token CPU
            let cellCpu = document.getElementById('c-' + snCpu);
            if (cellCpu) cellCpu.innerHTML += '<div class="token cpu-token"></div>';
        }

        function snRoll() {
            if (snGameOver) return;

            // Player Turn
            let dice = Math.ceil(Math.random() * 6);
            snStatus.innerText = "Dadu Kamu: " + dice;
            snMove(dice, 'p1');

            if (!snGameOver) {
                // CPU Turn (Delay 1 detik)
                rollBtn.disabled = true;
                setTimeout(() => {
                    let cpuDice = Math.ceil(Math.random() * 6);
                    snStatus.innerText = "Dadu CPU: " + cpuDice;
                    snMove(cpuDice, 'cpu');
                    if (!snGameOver) {
                        rollBtn.disabled = false;
                        setTimeout(() => snStatus.innerText = "Giliran: KAMU", 1000);
                    }
                }, 1000);
            }
        }

        function snMove(steps, who) {
            let pos = (who == 'p1') ? snP1 : snCpu;
            pos += steps;
            if (pos > 100) pos = 100 - (pos - 100); // Pantul balik

            // Cek Ular/Tangga
            if (snMap[pos]) {
                // Update dulu visual langkah awal, baru pindah efek
                pos = snMap[pos];
            }

            if (who == 'p1') snP1 = pos;
            else snCpu = pos;
            snRender();

            if (pos == 100) {
                snGameOver = true;
                rollBtn.style.display = 'none';
                resetBtn.style.display = 'block';
                snStatus.innerText = (who == 'p1' ? "KAMU" : "CPU") + " MENANG!";
                alert((who == 'p1' ? "KAMU" : "CPU") + " MENANG!");
            }
        }

        // Mulai game saat load
        snInit();


        /* =========================================
           2. LOGIKA WHACK-A-MOLE
           ========================================= */
        let wmScore = 0;
        let wmTimer = null;
        let wmActivePos = null;
        let wmTimeLeft = 15;
        const wmStartBtn = document.getElementById('wmStartBtn');

        function wmStart() {
            if (wmTimer) clearInterval(wmTimer);

            wmScore = 0;
            wmTimeLeft = 15;
            document.getElementById('wm-score').innerText = 0;
            wmStartBtn.disabled = true;
            wmStartBtn.innerText = "MAIN...";

            wmTimer = setInterval(() => {
                wmTimeLeft--;
                document.getElementById('wm-time').innerText = wmTimeLeft;

                // Reset semua lubang
                document.querySelectorAll('.mole').forEach(m => m.classList.remove('active'));

                if (wmTimeLeft <= 0) {
                    // Game Over
                    clearInterval(wmTimer);
                    wmActivePos = null;
                    wmStartBtn.disabled = false;
                    wmStartBtn.innerText = "MAIN LAGI";
                    alert("Waktu Habis! Skor Akhir: " + wmScore);
                } else {
                    // Munculkan Tikus Baru
                    let randomPos = Math.floor(Math.random() * 9);
                    wmActivePos = randomPos;
                    document.getElementById('mole-' + randomPos).classList.add('active');
                }
            }, 700); // Kecepatan tikus (700ms)
        }

        function wmHit(pos) {
            if (pos === wmActivePos && wmTimeLeft > 0) {
                wmScore++;
                document.getElementById('wm-score').innerText = wmScore;
                document.getElementById('mole-' + pos).classList.remove('active');
                wmActivePos = null; // Cegah double click di tikus yang sama
            }
        }


        /* =========================================
           3. LOGIKA PIXEL PHOTOBOOTH
           ========================================= */
        const video = document.getElementById('webcamVideo');
        const canvas = document.getElementById('pixelCanvas');
        const ctx = canvas.getContext('2d');
        const dlBtn = document.getElementById('dlBtn');
        const camBtn = document.getElementById('camBtn');

        ctx.imageSmoothingEnabled = false;

        function camStart() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(function(stream) {
                        video.srcObject = stream;
                        video.play();
                        camBtn.disabled = true;
                        camBtn.innerText = "Aktif";
                        dlBtn.disabled = false;
                        renderPixelCam();
                    })
                    .catch(function(err) {
                        console.log(err);
                        alert("Gagal mengakses kamera. Pastikan browser diizinkan atau gunakan HTTPS.");
                    });
            } else {
                alert("Browser tidak mendukung akses kamera.");
            }
        }

        function renderPixelCam() {
            if (!video.paused && !video.ended) {
                // Gambar video ke kanvas KECIL (64x48)
                ctx.drawImage(video, 0, 0, 64, 48);
            }
            requestAnimationFrame(renderPixelCam);
        }

        function camSnap() {
            // TRIK AGAR HASIL DOWNLOAD TIDAK BURAM/KEKECILAN:
            // Kita buat canvas sementara yang besar (misal 640x480)
            let tempCanvas = document.createElement('canvas');
            tempCanvas.width = 640;
            tempCanvas.height = 480;
            let tempCtx = tempCanvas.getContext('2d');

            // Matikan smoothing di canvas besar agar tetap kotak-kotak
            tempCtx.imageSmoothingEnabled = false;

            // Gambar canvas kecil ke canvas besar
            tempCtx.drawImage(canvas, 0, 0, 640, 480);

            // Download canvas besar
            let link = document.createElement('a');
            link.download = 'pixel-me-' + Date.now() + '.png';
            link.href = tempCanvas.toDataURL();
            link.click();
        }
    </script>
</body>

</html>