@extends('layouts.app')
@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="d-md-flex justify-content-center overflow-x-auto">
                    <div id="exportPaper">
                        @if (Auth()->user()->userDetail->org)
                            <p class="text-center fs-5 mb-0 fw-bold">{{ optional(Auth()->user()->userDetail->getOrg)->name }}</p>
                        @endif
                        <p class="text-center fs-5 fw-bold">รายงาน ทะเบียนบัญชีผู้ใช้ในระบบ TSMC</p>
                        <div id="dataTable">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ลำดับ</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Password</th>
                                        <th scope="col">ชื่อ</th>
                                        <th scope="col">สาขา</th>
                                        <th scope="col">แผนก</th>
                                        <th scope="col">ตำแหน่ง</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $index => $user)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->pass_text ?? '-' }}</td>
                                            <td>{{ $user->full_name }}</td>
                                            <td>{{ optional($user->userDetail->getBrn)->name }}</td>
                                            <td>{{ optional($user->userDetail->getDpm)->name }}</td>
                                            <td>{{ optional($user->userDetail->getPosition)->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <p class="text-end" style="font-size: 10px">print on TSMC at {{ (new Carbon\Carbon())->format('d/m/Y G:i:s') }}</p>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
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
