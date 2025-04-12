@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">

                {{-- Cars table Card --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ข้อมูลรถ') }}</p>
                            <div>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#createCarModal">
                                    <i class="bi bi-plus"></i> เพิ่ม
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#importCarModal">
                                    <i class="bi bi-arrow-down"></i> นำเข้าข้อมูล
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Create Modal -->
                    <div class="modal fade" id="createCarModal" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="createCarModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="createCarModalLabel">เพิ่มข้อมูลรถ</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('vehicles.store') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="license_category" class="form-label">หมวดทะเบียนรถ</label>
                                            <input type="text" class="form-control" maxlength="150" id="license_category"
                                                name="license_category" placeholder="เช่น กก, 10-99" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="license_plate" class="form-label">หมายเลขทะเบียนรถ</label>
                                            <input type="text" class="form-control" maxlength="150" id="license_plate"
                                                name="license_plate" placeholder="เช่น กข-1111, 98-9559" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="registration_province"
                                                class="form-label">จังหวัดที่จดทะเบียนรถ</label>
                                            <input type="text" class="form-control" maxlength="150"
                                                id="registration_province" name="registration_province"
                                                placeholder="กรุณากรอก จังหวัดที่จดทะเบียนรถ" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="brand" class="form-label">ยี่ห้อรถ</label>
                                            <input type="text" class="form-control" maxlength="150" id="brand"
                                                name="brand" placeholder="เช่น Benz, ISUZU" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="standard" class="form-label">ลักษณะ/มาตรฐาน (หากไม่มีกรอก -)</label>
                                            <input type="text" class="form-control" maxlength="150" id="standard"
                                                name="standard" placeholder="เช่น 2ข, 3ก" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="type" class="form-label">ประเภทรถ</label>
                                            <input type="text" class="form-control" maxlength="150" id="type"
                                                name="type" placeholder="เช่น รถ 6 ล้อ, รถบรรทุกวัสดุอันตราย" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="ins_company" class="form-label">บริษัทประกันภัย</label>
                                            <input type="text" class="form-control" maxlength="150" id="ins_company"
                                                name="ins_company" placeholder="กรุณากรอก บริษัทประกันภัย รถ" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="ins_type" class="form-label">ประเภทประกันภัย</label>
                                            <input type="text" class="form-control" maxlength="150" id="ins_type"
                                                name="ins_type" placeholder="เช่น ชั้น1" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">ปิด</button>
                                        <button type="submit" class="btn btn-primary">บันทึก</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Import Modal -->
                    <div class="modal fade" id="importCarModal" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="importCarModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="importCarModalLabel">นำเข้าข้อมูลรถ</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form enctype="multipart/form-data" id="importForm">
                                    <div class="modal-body">
                                        <div class="border-l-4 border-blue-500 p-2 mb-2 rounded" style="background-color: rgb(160, 255, 255)">
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                  <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        <i class="bi bi-exclamation-circle"></i> &nbsp; คำแนะนำการนำเข้าข้อมูล
                                                    </button>
                                                  </h2>
                                                  <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="m-0">
                                                            <p class="mb-0">- ข้อมูลจะต้องอยู่ในรูปแบบไฟล์ Excel (.xlsx หรือ .xls)</p>
                                                            <p class="mb-0">- ข้อมูลจะต้องมีหัวตารางตรงตาม template</p>
                                                            <p class="mb-0">- ห้ามลบหรือเพิ่มคอลัมน์ในไฟล์ template</p>
                                                            <p class="mb-0">- ห้ามมีช่องว่างในข้อมูลที่จำเป็นต้องกรอก</p>
                                                        </div>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                            {{-- <div>
                                                <h5 class="flex items-center text-blue-800 mb-2">
                                                    <i class="bi bi-exclamation-circle"></i>
                                                    คำแนะนำการนำเข้าข้อมูล
                                                </h5>
                                                <p class="text-blue-700 mb-2">กรุณาจัดทำข้อมูลให้ตรงตาม template ที่กำหนด
                                                    เพื่อป้องกันความผิดพลาดในการนำเข้าข้อมูล</p>
                                                <ul>
                                                    <li>- ข้อมูลจะต้องอยู่ในรูปแบบไฟล์ Excel (.xlsx หรือ .xls)</li>
                                                    <li>- ข้อมูลจะต้องมีหัวตารางตรงตาม template</li>
                                                    <li>- ห้ามลบหรือเพิ่มคอลัมน์ในไฟล์ template</li>
                                                    <li>- ห้ามมีช่องว่างในข้อมูลที่จำเป็นต้องกรอก</li>
                                                </ul>
                                            </div> --}}
                                            <p class="text-blue-700 mt-2 px-2">กรุณาจัดทำข้อมูลให้ตรงตาม template ที่กำหนด
                                                เพื่อป้องกันความผิดพลาดในการนำเข้าข้อมูล</p>
                                            <hr>
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <p class="mb-0">ดาวน์โหลด Template สำหรับกรอกข้อมูล</p>
                                                <a href="/templates/tsmc_vehicle_template.xlsx" class="btn btn-primary btn-sm text-white px-4 py-2 rounded inline-flex items-center">
                                                    <i class="bi bi-file-earmark-spreadsheet"></i>
                                                    ดาวน์โหลด Excel Template
                                                </a>
                                            </div>
                                        </div>

                                        {{-- Section อัพโหลดไฟล์ --}}
                                        <div class="mb-3">
                                            <label for="importFile" class="form-label">อัพโหลดไฟล์ Excel</label>
                                            <input class="form-control" type="file" id="importFile" accept=".xlsx, .xls" required>
                                            <div class="form-text text-danger" id="alert_text"></div>
                                        </div>
                                        <div>
                                            <p class="mb-0">ข้อมูลรถที่พบ <span id="vehicle_count">0</span> คัน</p>
                                            <div class="d-flex gap-2 flex-wrap">
                                                <p class="mb-0">นำเข้าข้อมูลสำเร็จ <span class="text-success" id="successCount">0</span> คัน</p>
                                                <p class="mb-0">นำเข้าข้อมูลล้มเหลว <span class="text-danger" id="failCount">0</span> คัน</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="closeBtn" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        <button type="submit" id="submitBtn" class="btn btn-primary">บันทึก</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <div class="card-body overflow-auto">
                        @if (session('vehicleSuccess'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @elseif (session('vehicleError'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @elseif ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">หมวดทะเบียน</th>
                                    <th scope="col">หมายเลขทะเบียน</th>
                                    <th scope="col">จังหวัดที่จดทะเบียน</th>
                                    <th scope="col">ยี่ห้อรถ</th>
                                    <th scope="col">ประเภทรถ</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($vehicles ?? []) == 0)
                                    <tr>
                                        <td colspan="6" class="text-center">ไม่มีข้อมูล</td>
                                    </tr>
                                @else
                                    @foreach ($vehicles as $index => $vehicle)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $vehicle->license_category }}</td>
                                            <td>{{ $vehicle->license_plate }}</td>
                                            <td>{{ $vehicle->registration_province }}</td>
                                            <td>{{ $vehicle->brand }}</td>
                                            <td>{{ $vehicle->type }}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#updateCarModal{{ $index }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm delete-data-btn"
                                                    del-id="{{ $vehicle->id }}" del-target="vehicles"
                                                    data-bs-toggle="tooltip" data-bs-title="ลบ"><i
                                                        class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Update Modal -->
                                        <div class="modal fade" id="updateCarModal{{ $index }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="updateCarModalLabel{{ $index }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5"
                                                            id="updateCarModalLabel{{ $index }}">แก้ไขตำแหน่ง
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('vehicle.update', ['id' => $vehicle->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="license_category"
                                                                    class="form-label">หมวดทะเบียนรถ</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $vehicle->license_category }}"
                                                                    maxlength="150" id="license_category"
                                                                    name="license_category"
                                                                    placeholder="กรุณากรอก หมวดทะเบียนรถ" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="license_plate"
                                                                    class="form-label">หมายเลขทะเบียนรถ</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $vehicle->license_plate }}" maxlength="150"
                                                                    id="license_plate" name="license_plate"
                                                                    placeholder="กรุณากรอก หมายเลขทะเบียนรถ" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="registration_province"
                                                                    class="form-label">จังหวัดที่จดทะเบียนรถ</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $vehicle->registration_province }}"
                                                                    maxlength="150" id="registration_province"
                                                                    name="registration_province"
                                                                    placeholder="กรุณากรอก จังหวัดที่จดทะเบียนรถ" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="brand" class="form-label">ยี่ห้อรถ</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $vehicle->brand }}" maxlength="150"
                                                                    id="brand" name="brand"
                                                                    placeholder="กรุณากรอก ยี่ห้อ รถ" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="standard"
                                                                    class="form-label">ลักษณะ/มาตรฐาน</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $vehicle->standard }}" maxlength="150"
                                                                    id="standard" name="standard"
                                                                    placeholder="กรุณากรอก ลักษณะ/มาตรฐาน รถ" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="type" class="form-label">ประเภทรถ</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $vehicle->type }}" maxlength="150"
                                                                    id="type" name="type"
                                                                    placeholder="กรุณากรอก ประเภทรถ" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="ins_company"
                                                                    class="form-label">บริษัทประกันภัย</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $vehicle->ins_company }}" maxlength="150"
                                                                    id="ins_company" name="ins_company"
                                                                    placeholder="กรุณากรอก บริษัทประกันภัย รถ" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="ins_type"
                                                                    class="form-label">ประเภทประกันภัย</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $vehicle->ins_type }}" maxlength="150"
                                                                    id="ins_type" name="ins_type"
                                                                    placeholder="กรุณากรอก ประเภทประกันภัย รถ" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">ปิด</button>
                                                            <button type="submit" class="btn btn-primary">บันทึก</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div> {{-- End Department Card --}}
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script>
        let uploaded_data = [];
        document.getElementById('importFile').addEventListener('change', function (event) {
            document.getElementById('alert_text').textContent = '';
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, { type: 'array' });
                    const firstSheetName = workbook.SheetNames[0];
                    const worksheet = workbook.Sheets[firstSheetName];
                    const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

                    // Validate columns length = 9
                    if (jsonData[0].length !== 9) {
                        document.getElementById('alert_text').textContent = 'คอลัมน์ไม่ถูกต้อง';
                        return;
                    }

                    jsonData.shift(); // Remove header row

                    // Validate required rows
                    if (jsonData.length < 1) {
                        document.getElementById('alert_text').textContent = 'ไม่มีข้อมูลในไฟล์';
                        return;
                    }

                    // Display the number of vehicles found
                    const vehicleCount = jsonData.length; // Exclude header row
                    document.getElementById('vehicle_count').textContent = vehicleCount;
                    uploaded_data = jsonData.map(row => ({
                        license_category: row[1] || '-',
                        license_plate: row[2] || '-',
                        registration_province: row[3] || '-',
                        brand: row[4] || '-',
                        standard: row[5] || '-',
                        type: row[6] || '-',
                        ins_company: row[7] || '-',
                        ins_type: row[8] || '-',
                    }));
                };
                reader.readAsArrayBuffer(file);
            }
        });

        function chunkArray(array, chunkSize) {
            const chunks = [];
            for (let i = 0; i < array.length; i += chunkSize) {
                chunks.push(array.slice(i, i + chunkSize));
            }
            return chunks;
        }

        function updateImportStatus(successCount, failCount) {
            document.getElementById('successCount').textContent = successCount;
            document.getElementById('failCount').textContent = failCount;
        }

        function uploadingBtnStatus(status) {
            if (status) {
                document.getElementById('submitBtn').setAttribute('disabled', 'disabled');
                document.getElementById('closeBtn').setAttribute('disabled', 'disabled');
                document.getElementById('submitBtn').innerHTML = `
                    <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    <span role="status">กำลังนำเข้า...</span>
                `;
            } else {
                document.getElementById('submitBtn').removeAttribute('disabled');
                document.getElementById('closeBtn').removeAttribute('disabled');
                document.getElementById('submitBtn').innerHTML = 'บันทึก';
            }
        }

        document.getElementById('importForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let successCount = 0;
            let failCount = 0;


            if (uploaded_data.length === 0) {
                return;
            }

            const chunks = chunkArray(uploaded_data, 100);

            try {
                uploadingBtnStatus(true);
                chunks.forEach((chunk, index) => {
                    const chunkSize = chunk.length;
                    var formData = new FormData();
                    formData.append('vehicle_datas', JSON.stringify(chunk));
                    fetch('/vehicles/import', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);
                        if (data.success) {
                            successCount += chunkSize;
                            updateImportStatus(successCount, failCount);
                        } else {
                            failCount += chunkSize;
                            updateImportStatus(successCount, failCount);
                        }
                    })
                    .catch(error => {
                        console.log('Error:', error);
                        console.log(`Failed to import chunk ${index} count : ${failCount}`);
                        failCount += chunkSize;
                        updateImportStatus(successCount, failCount);
                        // if (index === chunks.length - 1) {
                        //     alert(`นำเข้าข้อมูลสำเร็จ: ${successCount} รายการ, ล้มเหลว: ${failCount} รายการ`);
                        //     location.reload();
                        // }
                    });
                })
            } catch (error) {
                console.error('Error:', error);
                failCount += uploaded_data.length;
                updateImportStatus(successCount, failCount);
            } finally {
                uploadingBtnStatus(false);
                document.getElementById('importFile').value = '';
                successCount = 0;
                failCount = 0;
            }
        });
    </script>
@endsection
