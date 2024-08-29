@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ทะเบียน') }} หมายเลขโทรศัพท์ฉุกเฉิน</p>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addPhoneNum">เพิ่ม</button>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="addPhoneNum" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="addPhoneNumLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="addPhoneNumLabel">แบบฟอร์มบันทึกหมายเลขโทรศัพท์ฉุกเฉิน
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('form.store.phonenum') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <label for="personName" class="col-sm-4 col-form-label">ชื่อบุคคล</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="personName" name="personName"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="position" class="col-sm-4 col-form-label">ตำแหน่ง</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="position" name="position">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="officePhone" class="col-sm-4 col-form-label">เบอร์สำนักงาน</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="officePhone"
                                                    name="officePhone">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="homePhone" class="col-sm-4 col-form-label">เบอร์บ้าน</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="homePhone" name="homePhone">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="cellPhone" class="col-sm-4 col-form-label">เบอร์มือถือ</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="cellPhone" name="cellPhone">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">ปิด</button>
                                        <button type="submit" class="btn btn-success">บันทึก</button>
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

                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ชื่อบุคคล</th>
                                    <th scope="col">ตำแหน่ง</th>
                                    <th scope="col">เบอร์สำนักงาน</th>
                                    <th scope="col">เบอร์บ้าน</th>
                                    <th scope="col">เบอร์มือถือ</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($phonenum_lists as $index => $phonenum_list)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $phonenum_list->person_name }}</td>
                                        <td>{{ $phonenum_list->position ?? '-' }}</td>
                                        <td>{{ $phonenum_list->office_num ?? '-' }}</td>
                                        <td>{{ $phonenum_list->home_num ?? '-' }}</td>
                                        <td>{{ $phonenum_list->cellphone ?? '-' }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editPhoneNum{{ $phonenum_list->id }}">แก้ไข</button>
                                            <button class="btn btn-danger btn-sm delete-phonenum-btn" del-id="{{ $phonenum_list->id }}">ลบ</button>
                                        </td>
                                    </tr>

                                    <!-- Modal -->
                                    <div class="modal fade" id="editPhoneNum{{ $phonenum_list->id }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="editPhoneNum{{ $phonenum_list->id }}Label"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="editPhoneNum{{ $phonenum_list->id }}Label">
                                                        แบบฟอร์มบันทึกหมายเลขโทรศัพท์ฉุกเฉิน</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('form.update.phonenum', ['phonenumid' => $phonenum_list->id]) }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row mb-3">
                                                            <label for="personName"
                                                                class="col-sm-4 col-form-label">ชื่อบุคคล</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" value="{{ $phonenum_list->person_name }}"
                                                                    id="personName" name="personName" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="position"
                                                                class="col-sm-4 col-form-label">ตำแหน่ง</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="position" value="{{ $phonenum_list->position }}"
                                                                    name="position">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="officePhone"
                                                                class="col-sm-4 col-form-label">เบอร์สำนักงาน</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" value="{{ $phonenum_list->office_num }}"
                                                                    id="officePhone" name="officePhone">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="homePhone"
                                                                class="col-sm-4 col-form-label">เบอร์บ้าน</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="homePhone" value="{{ $phonenum_list->home_num }}"
                                                                    name="homePhone">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="cellPhone"
                                                                class="col-sm-4 col-form-label">เบอร์มือถือ</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="cellPhone" value="{{ $phonenum_list->cellphone }}"
                                                                    name="cellPhone">
                                                            </div>
                                                        </div>

                                                        <input type="hidden" name="phonenum_id" value="{{ $phonenum_list->id }}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">ปิด</button>
                                                        <button type="submit" class="btn btn-success">บันทึก</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
