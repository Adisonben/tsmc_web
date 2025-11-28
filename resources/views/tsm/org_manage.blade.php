@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ข้อมูลบริษัทที่รับผิดชอบ') }}</p>
                            {{-- <a href="/organizations/create" class="btn btn-success btn-sm">สร้าง</a> --}}
                            <!-- Button trigger modal -->
                            @if (count($tsm_has_orgs ?? []) < 5)
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#createOrg">
                                    เพิ่ม
                                </button>
                            @endif

                            <!-- Modal -->
                            <div class="modal fade" id="createOrg" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="createOrgLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="createOrgLabel">เพิ่มบริษัท</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('tsm.org.store', ['user_id' => Auth()->user()->id]) }}"
                                            method="post" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                @csrf

                                                <div class="mb-3">
                                                    <label for="orgName" class="form-label">ชื่อบริษัท</label>
                                                    <input type="text" maxlength="150" class="form-control"
                                                        id="orgName" name="orgName" placeholder="กรุณากรอกชื่อบริษัท"
                                                        required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="orgLogo" class="form-label">โลโก้บริษัท (ขนาดไม่เกิน 2
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
                                @if ($tsm_has_orgs && count($tsm_has_orgs ?? []) > 0)
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
                                            @if (optional($tsm_has_org->getOrg)->status == 2)
                                                <td class="table-info text-center">ข้อมูลตัวอย่าง</td>
                                            @else
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#updateOrg{{ $index }}">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    {{-- <a href="{{ route('tsm.org.delete', ['org_id' => optional($tsm_has_org->getOrg)->id ]) }}" class="btn btn-danger btn-sm delete-data-btn"
                                                        data-bs-toggle="tooltip" data-bs-title="ลบ">
                                                        <i class="bi bi-trash"></i>
                                                    </a> --}}
                                                    <button type="button" class="btn btn-danger btn-sm delete-org-btn"
                                                        del-id="{{ optional($tsm_has_org->getOrg)->id }}"
                                                        data-bs-toggle="tooltip" data-bs-title="ลบ"><i
                                                            class="bi bi-trash"></i></button>
                                                </td>
                                            @endif
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="updateOrg{{ $index }}" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="updateOrgLabel{{ $index }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="updateOrgLabel{{ $index }}">
                                                            แก้ไขบริษัท
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
                                                                <label for="orgName" class="form-label">ชื่อบริษัท</label>
                                                                <input type="text" maxlength="150" class="form-control"
                                                                    id="orgName" name="orgName"
                                                                    value="{{ $tsm_has_org?->getOrg?->name }}"
                                                                    placeholder="กรุณากรอกชื่อบริษัท" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="orgLogo" class="form-label">โลโก้บริษัท
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
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">ไม่พบข้อมูล</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Delete function
        const deleteBtns = document.querySelectorAll(".delete-org-btn");
        deleteBtns.forEach((delBtn) => {
            delBtn.addEventListener("click", () => {
                const idToDelete = delBtn.getAttribute("del-id");

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .delete(`/tsm/org/${idToDelete}`)
                            .then((res) => {
                                console.log(res.data);
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success",
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                            })
                            .catch((error) => {
                                console.log("Error deleting data: ", error);
                                Swal.fire({
                                    title: "Sorry!",
                                    text: "Something went wrong!",
                                    icon: "error",
                                });
                            });
                    }
                });
            });
        });
    </script>
    <style>
        #MyOrgListPage {
            background-color: var(--main-color);
        }
    </style>
@endsection
