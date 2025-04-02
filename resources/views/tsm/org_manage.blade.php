@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ข้อมูลองค์กรที่รับผิดชอบ') }}</p>
                            {{-- <a href="/organizations/create" class="btn btn-success btn-sm">สร้าง</a> --}}
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createOrg">
                                เพิ่ม
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="createOrg" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="createOrgLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="createOrgLabel">เพิ่มองค์กร</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('tsm.org.store', ['user_id' => Auth()->user()->id]) }}"
                                            method="post" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                @csrf

                                                <div class="mb-3">
                                                    <label for="orgName" class="form-label">ชื่อหน่วยงาน</label>
                                                    <input type="text" maxlength="150" class="form-control"
                                                        id="orgName" name="orgName" placeholder="กรุณากรอกชื่อหน่วยงาน"
                                                        required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="orgLogo" class="form-label">โลโก้หน่วยงาน (ขนาดไม่เกิน 2
                                                        MB)</label>
                                                    <input class="form-control" type="file" id="orgLogo"
                                                        name="orgLogo">
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
                        @elseif ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                {{ $errors->first() }}
                            </div>
                        @endif


                        {{-- @error('orgName')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        @error('orgLogo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror --}}

                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Logo</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tsm_has_orgs as $index => $tsm_has_org)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>
                                            @if (optional($tsm_has_org->getOrg)->logo_img ?? false)
                                                <img src="/uploads/orglogoes/{{ optional($tsm_has_org->getOrg)->logo_img }}"
                                                    width="35" alt="">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ optional($tsm_has_org->getOrg)->name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#updateOrg{{ $index }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm delete-data-btn"
                                                del-id="{{ optional($tsm_has_org->getOrg)->id }}" del-target="organizations"
                                                data-bs-toggle="tooltip" data-bs-title="ลบ"><i
                                                    class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="updateOrg{{ $index }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="updateOrgLabel{{ $index }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="updateOrgLabel{{ $index }}">
                                                        แก้ไของค์กร
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form
                                                    action="{{ route('tsm.org.update', ['org_id' => $tsm_has_org?->getOrg?->id]) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        @csrf

                                                        <div class="mb-3">
                                                            <label for="orgName" class="form-label">ชื่อหน่วยงาน</label>
                                                            <input type="text" maxlength="150" class="form-control"
                                                                id="orgName" name="orgName"
                                                                value="{{ $tsm_has_org?->getOrg?->name }}"
                                                                placeholder="กรุณากรอกชื่อหน่วยงาน" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="orgLogo" class="form-label">โลโก้หน่วยงาน
                                                                (ขนาดไม่เกิน 2 MB)
                                                            </label>
                                                            <input class="form-control" type="file" id="orgLogo"
                                                                name="orgLogo">
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        #MyOrgListPage {
            background-color: var(--main-color);
        }
    </style>
@endsection
