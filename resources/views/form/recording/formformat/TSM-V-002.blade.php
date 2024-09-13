@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-body px-md-5">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <p class="text-center fs-5 fw-bold">เพิ่มประวัติการบำรุงรักษาและซ่อมรถ</p>
                        <form action="{{ route('form.store.repair.history') }}" method="post">
                            @csrf

                            <div class="row mb-3 gap-2">
                                <div class="col-12 col-md-5 d-flex gap-2 align-items-center">
                                    <label for="driverName" class="col-form-label text-nowrap">ชื่อพนักงานขับรถ</label>
                                    <input type="text" id="driverName" name="driverName" class="form-control" value="" required>
                                </div>
                                <div class="col-12 col-md-5 d-flex gap-2 align-items-center">
                                    <label for="carPlate" class="col-form-label text-nowrap">ทะเบียนรถ</label>
                                    {{-- <input type="text" id="carPlate" name="carPlate" class="form-control" value="" required> --}}
                                    <select class="form-select" aria-label="Default select example" id="carPlate" name="carId">
                                        <option selected value="">เลือกทะเบียนรถ</option>
                                        @foreach ($cars as $car)
                                            <option value="{{ $car->id }}">{{ $car->plate_num }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-5 d-flex gap-2 align-items-center">
                                    <label for="carModel" class="col-form-label text-nowrap">ยี่ห้อ/รุ่น</label>
                                    <input type="text" id="carModel" name="carModel" class="form-control" value="" required readonly>
                                </div>
                                <div class="col-12 col-md-5 d-flex gap-2 align-items-center">
                                    <label for="carType" class="col-form-label text-nowrap">ประเภทรถ</label>
                                    <input type="text" id="carType" name="carType" class="form-control" value="" required readonly>
                                </div>
                                <div class="col-12 col-md-5 d-flex gap-2 align-items-center">
                                    <label for="repairNum" class="col-form-label text-nowrap">เลขที่ใบสั่งซ่อม</label>
                                    <input type="text" id="repairNum" name="repairNum" class="form-control" value="" required>
                                </div>
                                {{-- <div class="col-12 col-md-5 d-flex gap-2 align-items-center">
                                    <label for="carType" class="col-form-label text-nowrap">ประเภทการซ่อม</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option value="ซ่อม">ซ่อม</option>
                                        <option value="เปลี่ยน">เปลี่ยน</option>
                                    </select>
                                </div> --}}
                                <div class="col-12 col-md-5 d-flex gap-2 align-items-center">
                                    <label for="mileage" class="col-form-label text-nowrap">เลขไมล์</label>
                                    <input type="number" id="mileage" name="mileage" class="form-control" value="" required>
                                </div>
                            </div>
                            <hr>
                            <p>รายการซ่อม</p>
                            <div class="mb-3">
                                <ol class="list-group-numbered p-0 ps-md-3" id="repairListContainer">
                                    {{-- <li class="rounded list-group-item d-flex flex-wrap align-items-center px-2 repairList">
                                        <div class="flex-fill m-2 d-flex gap-2 align-items-center">
                                            <label for="repairBy" class="col-form-label text-nowrap">ชื่อ/หน่วยงาน ผู้ซ่อม</label>
                                            <input type="text" name="repairBy[]" class="form-control" value="" required>
                                        </div>
                                        <div class="flex-fill m-2 d-flex gap-2 align-items-center">
                                            <label for="repairPart" class="col-form-label text-nowrap">อะไหล่ที่ใช้</label>
                                            <input type="text" name="repairPart[]" class="form-control" value="" required>
                                        </div>
                                        <div class="flex-fill m-2 d-flex gap-2 align-items-center">
                                            <label for="repairCost" class="col-form-label text-nowrap">จำนวนเงิน</label>
                                            <input type="number" name="repairCost[]" class="form-control" value="" required>
                                        </div>
                                        <div class="flex-fill m-2 d-flex gap-2 align-items-center">
                                            <label for="repairCost" class="col-form-label text-nowrap">ประเภท</label>
                                            <select class="form-select" aria-label="Default select example" name="repairType[]">
                                                <option value="ซ่อมภายใน">ซ่อมภายใน</option>
                                                <option value="ซ่อมภายนอก">ซ่อมภายนอก</option>
                                            </select>
                                        </div>
                                    </li> --}}
                                </ol>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary" onclick="addGroupList(this)">เพิ่มรายการซ่อม</button>
                                <button type="button" class="btn btn-danger" onclick="delGroupList()">ลบรายการซ่อม</button>
                                <button class="btn btn-success" type="submit">บันทึก</button>
                                <a href="/formtable/TSM-V-002" class="btn btn-secondary" >กลับ</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        function addGroupList(button) {
            const ol = document.getElementById('repairListContainer');
            const newListItem = document.createElement('li');
            newListItem.classList.add('rounded', 'list-group-item', 'd-flex', 'align-items-center', 'px-2', 'repairList', 'flex-wrap');
            newListItem.innerHTML = `
                <div class="flex-fill m-2 d-flex gap-2 align-items-center">
                    <label for="repairBy" class="col-form-label text-nowrap">ชื่อ/หน่วยงาน ผู้ซ่อม</label>
                    <input type="text" name="repairBy[]" class="form-control" value="" required>
                </div>
                <div class="flex-fill m-2 d-flex gap-2 align-items-center">
                    <label for="repairPart" class="col-form-label text-nowrap">อะไหล่ที่ใช้</label>
                    <input type="text" name="repairPart[]" class="form-control" value="" required>
                </div>
                <div class="flex-fill m-2 d-flex gap-2 align-items-center">
                    <label for="repairCost" class="col-form-label text-nowrap">จำนวนเงิน</label>
                    <input type="number" name="repairCost[]" class="form-control" value="" step="0.01" required>
                </div>
                <div class="flex-fill m-2 d-flex gap-2 align-items-center">
                    <label for="repairType" class="col-form-label text-nowrap">ประเภท</label>
                    <select class="form-select" aria-label="Default select example" name="repairType[]">
                        <option value="ซ่อมภายใน">ซ่อมภายใน</option>
                        <option value="ซ่อมภายนอก">ซ่อมภายนอก</option>
                    </select>
                </div>
                `;
            ol.appendChild(newListItem);
        }

        function delGroupList() {
            const ol = document.getElementById('repairListContainer');
            const lastChild = ol.lastChild;
            lastChild.remove();
        }

        $(document).ready(function() {
            $("#carPlate").change(function() {
                var selectedCarId = $(this).val();
                // Assuming you have a way to fetch car details based on ID using AJAX
                if (selectedCarId) {
                    $.ajax({
                        url: `/get-car-details/${selectedCarId}`,
                        type: "GET",
                        success: function(data) {
                            // console.log(data)
                            $("#carModel").val(data.carModel);
                            $("#carType").val(data.carType);
                        },
                        error: function(error) {
                            $("#carModel").val("");
                            $("#carType").val("");
                            console.error("Error fetching car details:", error);
                        }
                    });
                } else {
                    $("#carModel").val("");
                    $("#carType").val("");
                }
            });
        });
    </script>
    <style>
        .repairList {
            background-color: rgb(230, 230, 230);
            margin-bottom: 5px;
        }
    </style>
@endsection
