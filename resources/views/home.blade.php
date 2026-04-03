@extends('layouts.app')
@push('scripts')
    @vite(['resources/js/post.js'])
@endpush
@section('content')
    <div class="">
        <div class="container px-3 px-md-5">
            <div class="h3 mt-4 mb-5 text-center fw-bold">
                Transport <span class="text-warning">Safety</span> Manager Communication
            </div>

            {{-- Card --}}
            <div class="d-flex justify-content-center">
                <div class="card rounded-4 shadow-sm mb-3" style="width: 800px;">
                    <div class="card-body">
                        <div class="row g-0">
                            <!-- รูปภาพ (คอลัมน์ซ้าย) -->
                            <div class="col-md-4 justify-content-center d-flex align-items-center mb-4">
                                @if (
                                    (Auth::user()->userDetail->icon ?? false) &&
                                        file_exists(public_path('uploads/userImages/' . Auth::user()->userDetail->icon)))
                                    <img src="/uploads/userImages/{{ Auth::user()->userDetail->icon }}" alt="..."
                                        style="width: 100px; height: 100px;" class="object-fit-fill">
                                @else
                                    <img src="/images/icons/tsmc_logo.png" alt="..."
                                        style="width: 100px; height: 100px;" class="object-fit-fill">
                                @endif
                            </div>

                            <!-- ข้อมูลผู้ใช้ (คอลัมน์ขวา) -->
                            <div class="col-md-8 info-column">
                                <h3 class="card-title mb-2 text-center text-md-start">{{ Auth::user()->full_name }}</h3>
                                <div class="row">
                                    <p class="mb-0 col-4"><strong>หมายเลขประชาชน:</strong></p>
                                    <p class="mb-0 col-8">{{ Auth::user()->userDetail->citizen_id ?? '-' }}</p>
                                    <p class="mb-0 col-4"><strong>ตำแหน่ง:</strong></p>
                                    <p class="mb-0 col-8">{{ Auth::user()->userDetail->getPosition->name ?? '-' }}</p>
                                    <p class="mb-0 col-4"><strong>ฝ่าย:</strong></p>
                                    <p class="mb-0 col-8">{{ Auth::user()->userDetail->getDpm->name ?? '-' }}</p>
                                    <p class="mb-0 col-4"><strong>สาขา:</strong></p>
                                    <p class="mb-0 col-8">{{ Auth::user()->userDetail->getBrn->name ?? '-' }}</p>
                                    <p class="mb-0 col-4"><strong>บริษัท:</strong></p>
                                    <p class="mb-0 col-8">{{ Auth::user()->userDetail->getOrg->name ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- บันทึกเวลาทำงาน --}}
            @if (
                (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_record_work', Auth::user()->userDetail->org) ??
                    false) || Auth::user()->username === 'tsmcadmin')
                <div class="d-flex justify-content-center">
                    <!-- การ์ดบันทึกเวลาทำงาน -->
                    <div class="card shadow-sm rounded-4" style="width: 800px;">
                        <div class="card-header bg-white">
                            <h5 class="card-title mb-0">บันทึกเวลาทำงาน</h5>
                        </div>
                        <div class="card-body">
                            <!-- แสดงตัวนับเวลา -->
                            <div class="bg-light rounded p-3 mb-2 text-center">
                                <p class="timer mb-1" id="timer">
                                    <span id="timer-text" class="timer-inactive">00:00:00:00</span>
                                </p>
                                <div class="timer-label text-secondary small">
                                    <span>วัน</span>
                                    <span>ชั่วโมง</span>
                                    <span>นาที</span>
                                    <span>วินาที</span>
                                </div>
                            </div>

                            <!-- ปุ่มควบคุมการทำงาน -->
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <button id="start-button"
                                        class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2">
                                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polygon points="10 8 16 12 10 16 10 8"></polygon>
                                        </svg>
                                        เริ่มงาน
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button id="checkin-button"
                                        class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2"
                                        disabled>
                                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M20 6L9 17l-5-5"></path>
                                        </svg>
                                        เช็คอิน
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button id="stop-button"
                                        class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2"
                                        disabled>
                                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <rect x="9" y="9" width="6" height="6"></rect>
                                        </svg>
                                        จบงาน
                                    </button>
                                </div>
                            </div>

                            <!-- บันทึกกิจกรรม -->
                            {{-- <div class="mt-4">
                            <h6 class="mb-3">บันทึกกิจกรรมวันนี้</h6>
                            <div class="activity-log" id="log-container">
                                <!-- กิจกรรมจะถูกเพิ่มที่นี่ด้วย JavaScript -->
                            </div>
                        </div> --}}

                            <div class="mt-4">
                                <h6 class="mb-0 fw-bold">ตำแหน่งปัจจุบัน</h6>
                                <p class="p-0 mb-2" style="font-size: smaller">*กรุณาใช้อุปกรณ์ที่รองรับ GPS เช่น โทรศัพท์มือถือ เพื่อความแม่นยำในการระบุตำแหน่ง</p>
                                <div class="weather-box" id="weather-box">
                                    <p>กดปุ่มเพื่อโหลดข้อมูล</p>
                                </div>
                                <div id="map" style="height: 300px; min-width: 180px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="d-flex align-items-center my-4">
                <div class="flex-grow-1 border-top border-dark"></div>
                <span class="mx-3 text-muted fs-5">เมนูลัดสำหรับคุณ</span>
                <div class="flex-grow-1 border-top border-dark"></div>
            </div>


            <div class="d-flex flex-wrap justify-content-center mb-5 gap-2 gap-md-4">
                @if (
                    (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_post', Auth::user()->userDetail->org) ??
                        false) || Auth::user()->username === 'tsmcadmin')
                    <div class="card shortcut-card" style="width: 10rem; background-color: #F8C8DC;">
                        <a href="{{ route('posts.index') }}">
                            <div class="card-body text-center text-dark">
                                <i class="bi bi-pencil-square fs-1"></i>
                                <h5 class="card-title">โพส / ประกาศ</h5>
                            </div>
                        </a>
                    </div>
                @endif

                @if (
                    (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_check', Auth::user()->userDetail->org) ??
                        false) || Auth::user()->username === 'tsmcadmin')
                    <div class="card shortcut-card" style="width: 10rem;  background-color: #A7C7E7;">
                        <a href="{{ route('document.fill-out.selectform') }}">
                            <div class="card-body text-center text-dark">
                                <i class="bi bi-ui-checks fs-1"></i>
                                <h5 class="card-title">กรอกแบบฟอร์ม</h5>
                            </div>
                        </a>
                    </div>
                @endif


                @if (
                    (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                        'can_access_table',
                        Auth::user()->userDetail->org) ?? false) || Auth::user()->username === 'tsmcadmin')
                    <div class="card shortcut-card" style="width: 10rem;  background-color: #B5EAD7;">
                        <a href="{{ route('document.table.selectform') }}">
                            <div class="card-body text-center text-dark">
                                <i class="bi bi-table fs-1"></i>
                                <h5 class="card-title">ทะเบียนเอกสาร</h5>
                            </div>
                        </a>
                    </div>
                @endif


                @if (
                    (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                        'can_export',
                        optional(Auth::user()->userDetail)->org) ?? false) || Auth::user()->username === 'tsmcadmin')
                    <div class="card shortcut-card" style="width: 10rem;  background-color: #FFF5BA;">
                        <a href="{{ route('document.export.filter') }}">
                            <div class="card-body text-center text-dark">
                                <i class="bi bi-file-earmark-text fs-1"></i>
                                <h5 class="card-title">ออกรายงาน</h5>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-sA+e2l9...=="
        crossorigin="" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-QVdV6...==" crossorigin=""></script>

    <script>
        // ตัวแปรสำหรับการทำงาน
        let startTime = null;
        let timerInterval = null;
        let isWorking = false;
        var working_id = null;

        var latitude = null;
        var longitude = null;
        var radius = null;
        var weathercode = null;
        var temperature = null;
        var windspeed = null;
        var recordtime = null;

        const weatherDescriptions = {
            0: {
                text: "ท้องฟ้าแจ่มใส",
                icon: "☀️"
            },
            1: {
                text: "มีเมฆเล็กน้อย",
                icon: "🌤️"
            },
            2: {
                text: "มีเมฆปานกลาง",
                icon: "⛅"
            },
            3: {
                text: "มีเมฆมาก",
                icon: "☁️"
            },
            45: {
                text: "หมอก",
                icon: "🌫️"
            },
            48: {
                text: "หมอกน้ำแข็ง",
                icon: "🌫️❄️"
            },
            51: {
                text: "ฝนปรอยเบา",
                icon: "🌦️"
            },
            53: {
                text: "ฝนปานกลาง",
                icon: "🌧️"
            },
            55: {
                text: "ฝนตกหนัก",
                icon: "🌧️☔"
            },
            61: {
                text: "ฝนเล็กน้อย",
                icon: "🌦️"
            },
            63: {
                text: "ฝนปานกลาง",
                icon: "🌧️"
            },
            65: {
                text: "ฝนหนัก",
                icon: "🌧️🌧️"
            },
            80: {
                text: "ฝนตกเป็นช่วง ๆ เล็กน้อย",
                icon: "🌦️"
            },
            81: {
                text: "ฝนตกเป็นช่วง ๆ ปานกลาง",
                icon: "🌧️🌦️"
            },
            82: {
                text: "ฝนตกเป็นช่วง ๆ หนัก",
                icon: "🌧️🌧️🌩️"
            },
            95: {
                text: "พายุฝนฟ้าคะนอง",
                icon: "⛈️"
            },
            96: {
                text: "พายุพร้อมลูกเห็บเล็ก",
                icon: "⛈️❄️"
            },
            99: {
                text: "พายุพร้อมลูกเห็บหนัก",
                icon: "⛈️🧊"
            }
        };

        document.addEventListener('DOMContentLoaded', function () {
            const workRecord = @json($work_record ?? []);
            if (workRecord && workRecord.id) {
                startTime = workRecord.start_at ? new Date(workRecord.start_at) : null;
                working_id = workRecord.id;
                startWork();
            }
            // Put any script here that should run when this view is loaded
        });

        // ปุ่มควบคุม
        const startButton = document.getElementById('start-button');
        const checkinButton = document.getElementById('checkin-button');
        const stopButton = document.getElementById('stop-button');
        const logContainer = document.getElementById('log-container');
        const timerText = document.getElementById('timer-text');

        // ฟังก์ชันสำหรับการนับเวลา
        function updateTimer() {
            if (!startTime) return;

            const now = new Date();
            const elapsedMilliseconds = now - startTime;

            // คำนวณวัน ชั่วโมง นาที วินาที
            const days = Math.floor(elapsedMilliseconds / (1000 * 60 * 60 * 24));
            const hours = Math.floor((elapsedMilliseconds % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((elapsedMilliseconds % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((elapsedMilliseconds % (1000 * 60)) / 1000);

            // แสดงผล
            timerText.textContent =
                `${String(days).padStart(2, '0')}:${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        // ฟังก์ชันรับเวลาปัจจุบัน
        function getCurrentTimeString() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            return `${hours}:${minutes}:${seconds}`;
        }

        // เพิ่มการบันทึกใหม่
        async function addLogEntry(action) {
            const actionMapping = {
                start: 'เริ่มงาน',
                checkin: 'เช็คอิน',
                stop: 'จบงาน'
            };

            var fetchStatus = false;

            // ส่งข้อมูลไปยังเซิร์ฟเวอร์
            await fetch('/work-record/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        action: action,
                        work_id: working_id,
                        latitude: latitude,
                        longitude: longitude,
                        radius: radius,
                        weathercode: weathercode,
                        temperature: temperature,
                        windspeed: windspeed,
                        recordtime: recordtime,
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // console.log('Log saved: ', data);
                    if (data.status === 'error') {
                        throw new Error(data.message);
                    }
                    if (action !== 'checkin') {
                        startTime = new Date();
                        fetchStatus = true;
                        working_id = data.work_id;
                    }

                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "success",
                        title: `บันทึกการ ${actionMapping[action]} เรียบร้อย`,
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                })
                .catch(error => {
                    // console.error('Error saving.', error);
                    fetchStatus = false;
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "error",
                        title: "เกิดข้อผิดพลาด",
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                });

            return fetchStatus;
        }

        // เริ่มงาน
        function startWork() {
            isWorking = true;
            // startTime = new Date();
            console.log('startTime:', startTime);
            startButton.disabled = true;
            if (latitude && longitude) {
                checkinButton.disabled = false;
            }
            stopButton.disabled = false;


            // เริ่มการนับเวลา
            timerText.classList.remove('timer-inactive');
            if (timerInterval) clearInterval(timerInterval);
            timerInterval = setInterval(updateTimer, 1000);
            updateTimer(); // เรียกครั้งแรกทันที
        }

        startButton.addEventListener('click', async () => {
            const addLogStatus = await addLogEntry('start');
            console.log('addLogStatus:', addLogStatus);
            if (!addLogStatus) {
                return;
            }
            startWork();
        });

        // เช็คอิน
        checkinButton.addEventListener('click', async () => {
            const addLogStatus = await addLogEntry('checkin');
            console.log('addLogStatus:', addLogStatus);
        });

        // หยุดงาน
        function endWork() {
            isWorking = false;
            startButton.disabled = false;
            checkinButton.disabled = true;
            stopButton.disabled = true;

            // หยุดการนับเวลา
            if (timerInterval) {
                clearInterval(timerInterval);
                timerInterval = null;
            }
        }

        stopButton.addEventListener('click', async () => {
            const addLogStatus = await addLogEntry('stop');
            console.log('addLogStatus:', addLogStatus);
            if (!addLogStatus) {
                return;
            }
            endWork();
        });

        // ฟังก์ชันสำหรับการดึงข้อมูลสภาพอากาศ
        var map, marker;

        function getWeatherAndMap() {
            const box = document.getElementById('weather-box');
            box.innerHTML = "⏳ กำลังโหลด...";

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(async (position) => {
                    latitude = position.coords.latitude.toFixed(6);
                    longitude = position.coords.longitude.toFixed(6);
                    radius = position.coords.accuracy.toFixed(0);
                    const url =
                        `https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&current_weather=true&timezone=auto`;

                    try {
                        const res = await fetch(url);
                        const data = await res.json();
                        const weather = data.current_weather;

                        weathercode = weather.weathercode;
                        temperature = weather.temperature;
                        windspeed = weather.windspeed;
                        recordtime = weather.time;

                        const desc = weatherDescriptions[weather.weathercode] || {
                            text: "ไม่ทราบสภาพอากาศ",
                            icon: "❓"
                        };
                        box.innerHTML = ``;
                        // box.innerHTML = `
                    //     <div class="desc"><span class="icon">${desc.icon}</span> ${desc.text}</div>
                    //     <div class="data">🌡️ อุณหภูมิ: ${weather.temperature}°C</div>
                    //     <div class="data">💨 ลม: ${weather.windspeed} km/h</div>
                    //     <div class="data">🕒 เวลา: ${weather.time}</div>
                    //     <div class="data">📍 พิกัด: ${lat}, ${lon}</div>
                    // `;

                        // Initialize or update map
                        if (!map) {
                            map = L.map('map').setView([latitude, longitude], 14);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; OpenStreetMap contributors'
                            }).addTo(map);
                            marker = L.marker([latitude, longitude]).addTo(map)
                                .bindPopup(`
                                    <div class="desc"><span class="icon">${desc.icon}</span> ${desc.text}</div>
                                    <div class="data">🌡️ อุณหภูมิ: ${weather.temperature}°C</div>
                                    <div class="data">💨 ลม: ${weather.windspeed} km/h</div>
                                    <div class="data">🕒 เวลา: ${weather.time}</div>
                                    <div class="data">📍 พิกัด: ${latitude}, ${longitude}</div>
                                    <div class="data">📍 รัศมี: ${radius} m</div>
                                `).openPopup();
                            // Add a radius circle to the map
                            L.circle([latitude, longitude], {
                                color: '#add8e6',
                                fillColor: '#add8e6',
                                fillOpacity: 0.5,
                                radius: radius
                            }).addTo(map);
                        } else {
                            map.setView([latitude, longitude], 13);
                            marker.setLatLng([latitude, longitude])
                                .setPopupContent(`${desc.icon} ${desc.text}`).openPopup();
                        }

                    } catch (err) {
                        box.innerHTML = "❌ ไม่สามารถโหลดข้อมูลอากาศได้";
                        console.error(err);
                    }

                }, () => {
                    box.innerHTML = "❌ ไม่สามารถเข้าถึงตำแหน่งของคุณได้";
                }, {
                    enableHighAccuracy: true,
                    maximumAge: 0,
                    timeout: 5000
                });
            } else {
                box.innerHTML = "❌ เบราว์เซอร์ไม่รองรับ Geolocation";
            }
        }

        // ✅ เรียกเมื่อโหลดหน้า
        window.onload = getWeatherAndMap;
    </script>

    <style>
        #document-frame {
            width: 100%;
            height: 60vh;
            /* Set height to 60% of viewport height */
        }

        .shortcut-card {
            transition: all 0.3s ease;
        }

        .shortcut-card:hover {
            /* transform: translateY(-5px); */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .shortcut-card:hover {
            transform: scale(1.05);
        }

        .timer {
            font-size: 2rem;
            font-weight: bold;
        }

        .timer-inactive {
            color: #adb5bd;
        }

        .timer-label span {
            width: 65px;
            display: inline-block;
            text-align: center;
        }

        .activity-log {
            max-height: 200px;
            overflow-y: auto;
        }

        .icon {
            width: 18px;
            height: 18px;
        }
    </style>
@endsection
