@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">ออกรายงาน ตรวจสอบและซ่อมบำรุงอุปกรณ์รับมือเหตุการณ์ฉุกเฉิน</p>
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

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="searchBox" placeholder="กรองข้อมูล (ชื่อพนักงานขับรถ , เบอร์โทรศัพท์ , หมายเลขทะเบียนรถ)">
                            <button class="btn btn-primary" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" onclick="window.print()">Print</button>
                    </div>
                </div>
                <hr>
                <p class="text-center">ตัวอย่างเอกสาร</p>
                <hr>
                <div class="d-md-flex justify-content-center overflow-x-auto">
                    <div id="exportPaper">
                        <p class="text-center fs-5 mb-0 fw-bold">{{ Auth()->user()->userDetail->getOrg->name }}</p>
                        <p class="text-center fs-5 fw-bold">รายงานการตรวจสอบและซ่อมบำรุง อุปกรณ์รับมือเหตุการณ์ฉุกเฉิน</p>
                        <div id="dataTable">

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
            $('#searchBox').on('keyup', function() {
                var queryText = $(this).val();
                if (queryText) {
                    $.ajax({
                        url:"/formtable/TSM-AI-005/search",
                        type:"GET",
                        data:{'search' : queryText},
                        success: function(data){
                            $('#dataTable').html(data);
                        },
                        error: function(xhr, status, errorThrown) {
                            // Handle error
                            console.error('Error search TSM-AI-005 :', errorThrown);
                        }
                    });
                }
            })
        });
    </script>
    <style>
        #exportPaper {
            background-color: white;
            padding: 1cm;
            width: 210mm;
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
