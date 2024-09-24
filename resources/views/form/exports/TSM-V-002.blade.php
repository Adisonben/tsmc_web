@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">ออกรายงาน ประวัติการบำรุงรักษาและซ่อมรถ</p>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="carSelect" class="form-label">ทะเบียนรถ</label>
                            <select class="form-select" id="carSelect" aria-label="Default select example">
                                <option selected disabled>เลือกทะเบียนรถ</option>
                                @foreach ($cars as $car)
                                    <option value="{{ $car->id }}">{{ $car->plate_num }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                              <label for="startDate" class="col-form-label">ตั้งแต่วันที่</label>
                            </div>
                            <div class="col-auto">
                              <input type="date" id="startDate" class="form-control" aria-describedby="passwordHelpInline">
                            </div>
                            <div class="col-auto">
                              <label for="endDate" class="col-form-label">ถึงวันที่</label>
                            </div>
                            <div class="col-auto">
                              <input type="date" id="endDate" class="form-control" aria-describedby="passwordHelpInline">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" onclick="window.print()">Print</button>
                        <button class="btn btn-success" id="searchBtn">ค้นหา</button>
                    </div>
                </div>
                <hr>
                <p class="text-center">ตัวอย่างเอกสาร</p>
                <hr>
                <div class="d-md-flex justify-content-center overflow-x-auto">
                    <div id="exportPaper">
                        <p class="text-center fs-5 mb-0 fw-bold">{{ Auth()->user()->userDetail->getOrg->name }}</p>
                        <p class="text-center fs-5 fw-bold">รายงานบันทึกประวัติการบำรุงรักษาและซ่อมรถ</p>
                        <div id="dataTable">

                        </div>
                        <div class="row px-3">
                            <div class="col-4 text-center border border-dark-subtle py-2">
                                <p>ผู้จัดทำ</p>
                                <p class="mb-2">................................................................................</p>
                                <p>(...................................................................)</p>
                                <p class="mb-0 text-start">วันที่ : </p>
                            </div>
                            <div class="col-4 text-center border border-dark-subtle py-2">
                                <p>ผู้ตรวจสอบ</p>
                                <p class="mb-2">................................................................................</p>
                                <p>(...................................................................)</p>
                                <p class="mb-0 text-start">วันที่ : </p>
                            </div>
                            <div class="col-4 text-center border border-dark-subtle py-2">
                                <p>ผู้อนุมัติ</p>
                                <p class="mb-2">................................................................................</p>
                                <p>(...................................................................)</p>
                                <p class="mb-0 text-start">วันที่ : </p>
                            </div>
                        </div>
                        <p class="text-end" style="font-size: 10px">print on TSMC at {{ (new Carbon\Carbon())->format('d/m/Y G:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            // Function to handle search and send data to the controller
            function searchData() {
                var carId = $('#carSelect').val();
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();

                // Check if any of the fields have values
                if (carId || startDate || endDate) {
                    $.ajax({
                        url: "/formtable/TSM-V-002/search",
                        type: "GET",
                        data: {
                            'carId': carId,
                            'startDate': startDate,
                            'endDate': endDate
                        },
                        success: function(data) {
                            $('#dataTable').html(data);
                        },
                        error: function(xhr, status, errorThrown) {
                            // Handle error
                            console.error('Error search TSM-RP-002 :', errorThrown);
                        }
                    });
                } else {
                    $('#dataTable').html("");
                }
            }

            // Event listeners for input changes
            $('#searchBtn').on('click', searchData);
        });
    </script>
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
