@extends('layouts.app')
@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="d-md-flex justify-content-center overflow-x-auto">
                    <div id="exportPaper">
                        <p class="text-center fs-5 fw-bold mb-0">รายงาน ประวัติการเข้าใช้ระบบทั้งหมด</p>
                        <p class="text-center">
                            @if (request()->filled('date_from') || request()->filled('date_to'))
                                วันที่
                                {{ request('date_from') ? (new Carbon\Carbon(request('date_from')))->thaidate('j F Y') : '-' }}
                                ถึง
                                {{ request('date_to') ? (new Carbon\Carbon(request('date_to')))->thaidate('j F Y') : '-' }}
                            @else
                                วันที่ {{ (new Carbon\Carbon())->subDays(30)->thaidate('j F Y') }} ถึง
                                {{ (new Carbon\Carbon())->thaidate('j F Y') }}
                            @endif
                        </p>
                        @if (request()->filled('username'))
                            <p class="text-center">ชื่อผู้ใช้: {{ request('username') }}</p>
                        @endif
                        <div id="dataTable">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ลำดับ</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">ชื่อ</th>
                                        <th scope="col">วันที่</th>
                                        <th scope="col">Ip</th>
                                        <th scope="col">Agent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($histories as $index => $history)
                                        @php
                                            $createdDate = new Carbon\Carbon($history->created_at);
                                        @endphp
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $history->getUser->username ?? '-' }}</td>
                                            <td>{{ $history->getUser->full_name ?? '-' }}</td>
                                            <td>{{ $createdDate->thaidate('j F Y \\เวลา H:i:s') }}</td>
                                            <td>{{ $history->ip_address }}</td>
                                            <td>{{ $history->agent }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <p class="text-end" style="font-size: 10px">print on TSMC at
                            {{ (new Carbon\Carbon())->format('d/m/Y G:i:s') }}</p>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4 d-print-none">
                    <button class="btn btn-primary" onclick="window.print()">Print</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        #exportPaper {
            background-color: white;
            padding: 1cm;
            width: 297mm;
        }

        @media print {
            body {
                visibility: hidden;
            }

            #exportPaper {
                visibility: visible;
                position: absolute;
                left: 0;
                top: 0;
                color: black;
            }
        }
    </style>
@endsection
