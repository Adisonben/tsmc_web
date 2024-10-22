@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ทะเบียน') }} {{ $mainForms->title }}</p>
                            <div>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#addFormModal">
                                    เพิ่ม
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="addFormModal" tabindex="-1" data-bs-backdrop="static"
                        data-bs-keyboard="false" aria-labelledby="addFormModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="addFormModalLabel">เพิ่ม {{ $mainForms->title }}</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('formplan.store') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="formId" value="{{ $mainForms->id }}">
                                        <div class="mb-3">
                                            <label for="driverName" class="form-label">พนักงานขับรถ</label>
                                            <input type="text" class="form-control" id="driverName"
                                                value="{{ Auth::user()->full_name }}" name="driverName"
                                                placeholder="ชื่อพนักงานขับรถ" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="carPlate" class="form-label">หมายเลขทะเบียนรถ</label>
                                            <input type="text" class="form-control" id="carPlate" name="carPlate"
                                                placeholder="กรุณากรอกหมายเลขทะเบียนรถ" required>
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
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">พนักงานขับรถ</th>
                                        <th scope="col">ทะเบียนรถ</th>
                                        <th scope="col">สถานะ</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($planForms) > 0)
                                        @foreach ($planForms as $index => $planForm)
                                            @php
                                                $header = json_decode($planForm->header_data);
                                            @endphp
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $header->driverName }}</td>
                                            <td>{{ $header->carPlate }}</td>
                                            <td>-</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editPlanForm{{ $index }}">แก้ไข</button>
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#delPlanForm{{ $index }}">ลบ</button>
                                                <a href="{{ route('formplan.detail', ['fpId' => $planForm->id]) }}" class="btn btn-info btn-sm"><i class="bi bi-table"></i></a>
                                            </td>
                                            <!-- Modal -->
                                            <div class="modal fade" id="editPlanForm{{ $index }}" tabindex="-1"
                                                data-bs-backdrop="static" data-bs-keyboard="false"
                                                aria-labelledby="editPlanForm{{ $index }}Label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="editPlanForm{{ $index }}Label">แก้ไข
                                                                {{ $mainForms->title }}</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('formplan.update') }}" method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="hidden" name="formPlanId"
                                                                    value="{{ $planForm->id }}">
                                                                <div class="mb-3">
                                                                    <label for="driverName"
                                                                        class="form-label">พนักงานขับรถ</label>
                                                                    <input type="text" class="form-control"
                                                                        id="driverName"
                                                                        value="{{ Auth::user()->full_name }}"
                                                                        name="driverName" placeholder="ชื่อพนักงานขับรถ"
                                                                        readonly>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="carPlate"
                                                                        class="form-label">หมายเลขทะเบียนรถ</label>
                                                                    <input type="text" class="form-control"
                                                                        id="carPlate" name="carPlate" value="{{ $header->carPlate }}"
                                                                        placeholder="กรุณากรอกหมายเลขทะเบียนรถ" required>
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

                                            <div class="modal fade" id="delPlanForm{{ $index }}" tabindex="-1"
                                                data-bs-backdrop="static" data-bs-keyboard="false"
                                                aria-labelledby="delPlanForm{{ $index }}Label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('formplan.delete', ['fpId' => $planForm->id]) }}" method="get">
                                                            @csrf
                                                            <div class="modal-body text-center">
                                                                <p class="fw-bold text-center fs-4">ยืนยันการลบแบบฟอร์ม {{ $mainForms->title }}</p>
                                                                <p><b>พนักงานขับรถ:</b> {{ $header->driverName }}</p>
                                                                <p><b>หมายเลขทะเบียนรถ:</b> {{ $header->carPlate }}</p>
                                                                <p class="text-warning">*หากลบแล้ว จะไม่สามารถนำกลับมาได้</p>
                                                                <div class="d-flex justify-content-center gap-2">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">ปิด</button>
                                                                    <button type="submit" class="btn btn-danger">ลบ</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6">
                                                <div class="text-center">ไม่พบเอกสาร</div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        #formCheckTablePage {
            background-color: var(--main-color);
        }
    </style>
@endsection
