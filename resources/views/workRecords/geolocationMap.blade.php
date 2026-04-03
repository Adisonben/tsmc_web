@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('แผนที่การทำงาน') }}</p>
                            <a href="{{ route('work-records.table') }}" class="btn btn-secondary btn-sm">กลับ</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            @php
                                $startDate = new Carbon\Carbon($workRecord->start_at);
                                $endDate = new Carbon\Carbon($workRecord->end_at);

                                $duration = $startDate->diff($endDate);
                                $humanReadableDuration = '';

                                if ($duration->m > 0) {
                                    $humanReadableDuration .= $duration->m . ' เดือน ';
                                }
                                if ($duration->d > 0) {
                                    $humanReadableDuration .= $duration->d . ' วัน ';
                                }
                                if ($duration->h > 0) {
                                    $humanReadableDuration .= $duration->h . ' ชั่วโมง ';
                                }
                                if ($duration->i > 0) {
                                    $humanReadableDuration .= $duration->i . ' นาที';
                                }
                                if ($startDate->diffInMinutes($endDate) < 1) {
                                    $humanReadableDuration = 'น้อยกว่า 1 นาที';
                                }
                            @endphp
                            <p class="mb-0"><strong>ชื่อ</strong> {{ $workRecord->getUser->full_name }}</p>
                            <p><strong>วันที่</strong> {{ $startDate->thaidate('j M Y \\เวลา H:i:s') }} -
                                {{ $endDate->thaidate('j M Y \\เวลา H:i:s') }} ({{ $humanReadableDuration }})</p>
                        </div>
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-sA+e2l9...=="
        crossorigin="" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-QVdV6...==" crossorigin=""></script>
    <script>
        var map, marker, startLat, startLng;
        var geolocation_records = null;
        var startLatLng = [16.422855, 102.859045];

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

        document.addEventListener('DOMContentLoaded', function() {
            geolocation_records = @json($geolocationRecords ?? []);
            if (geolocation_records.length > 0 && geolocation_records[0] && geolocation_records[0].latitude &&
                geolocation_records[0].longitude) {
                startLatLng = [geolocation_records[0].latitude, geolocation_records[0].longitude];
            } else {
                startLatLng = [16.422855, 102.859045];

            }
            // Put any script here that should run when this view is loaded
        });

        function getWeatherAndMap() {
            if (!map) {
                map = L.map('map').setView(startLatLng, 10);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                if (geolocation_records.length > 0) {
                    geolocation_records.forEach((record, index) => {
                        // console.log(record, index);
                        var latitude = record.latitude;
                        var longitude = record.longitude;
                        var radius = record.radius || 100; // Default radius if not provided
                        const desc = weatherDescriptions[record.weather_code] || {
                            text: "ไม่ทราบสภาพอากาศ",
                            icon: "❓"
                        };
                        var weather = {
                            temperature: record.temperature || 0,
                            windspeed: record.windspeed || 0,
                            time: record.recorded_at || "ไม่ทราบเวลา"
                        };

                        marker = L.marker([latitude, longitude]).addTo(map)
                            .bindPopup(`
                                <div class="desc"><span class="icon">${desc.icon}</span> ${desc.text}</div>
                                <div class="data">🌡️ อุณหภูมิ: ${weather.temperature}°C</div>
                                <div class="data">💨 ลม: ${weather.windspeed} km/h</div>
                                <div class="data">🕒 เวลา: ${weather.time}</div>
                                <div class="data">📍 พิกัด: ${latitude}, ${longitude}</div>
                                <div class="data">📍 รัศมี: ${radius} m</div>
                            `);

                        // Add a radius circle to the map
                        // L.circle([latitude, longitude], {
                        //     color: '#add8e6',
                        //     fillColor: '#add8e6',
                        //     fillOpacity: 0.5,
                        //     radius: radius
                        // }).addTo(map);
                    });
                }
            } else {
                map.setView(startLatLng, 13);
                marker.setLatLng(startLatLng)
                    .setPopupContent(`test test`).openPopup();
            }
        }
        // ✅ เรียกเมื่อโหลดหน้า
        window.onload = getWeatherAndMap;
    </script>
    <style>

        #map {
            height: 500px;
            width: 100%;
        }
    </style>
@endsection
