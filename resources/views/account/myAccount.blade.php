@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('บัญชีของฉัน') }}</p>
                            <div>
                                <a href="{{ route('users.editByOwn', ['user' => $user->user_id]) }}"
                                    class="btn btn-primary btn-sm">แก้ไขข้อมูล</a>

                                <input type="file" id="uploadProfileimg" accept="image/*" hidden
                                    onchange="storeProfileimg(this)">
                                <button class="btn btn-sm btn-info"
                                    onclick="document.getElementById('uploadProfileimg').click()">
                                    รูปโปรไฟล์ (ไม่เกิน 4 MB)
                                </button>

                                <input type="file" id="uploadSignimg" accept="image/*" hidden
                                    onchange="storeSignimg(this)">
                                <button class="btn btn-sm btn-info"
                                    onclick="document.getElementById('uploadSignimg').click()">
                                    ลายเซ็น (ไม่เกิน 4 MB)
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-sm-6 mb-3 ">
                                <div class="d-flex justify-content-center">
                                    @if (($user->userDetail->icon ?? false) && file_exists(public_path('uploads/userImages/' . $user->userDetail->icon)))
                                        <img src="/uploads/userImages/{{ $user->userDetail->icon }}" class="object-fit-contain" width="150" alt="">
                                    @else
                                        <img src="/images/icons/tsmc_logo.png" class="object-fit-contain" width="150" alt="">
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-sm-2">Username</div>
                                    <div class="col-sm-10">{{ $user->username }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">ชื่อ</div>
                                    <div class="col-sm-10">
                                        {{ optional($user->userDetail->getPrefix)->name . optional($user->userDetail)->fname }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">นามสกุล</div>
                                    <div class="col-sm-10">{{ optional($user->userDetail)->lname }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">ตำแหน่ง</div>
                                    <div class="col-sm-10">{!! optional($user->userDetail->getPosition)->name ?? '<span class="text-warning">-ไม่ทราบ-</span>' !!}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">ฝ่าย</div>
                                    <div class="col-sm-10">{!! optional($user->userDetail->getDpm)->name ?? '<span class="text-warning">-ไม่ทราบ-</span>' !!}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">สาขา</div>
                                    <div class="col-sm-10">{!! optional($user->userDetail->getBrn)->name ?? '<span class="text-warning">-ไม่ทราบ-</span>' !!}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">หน่วยงาน</div>
                                    <div class="col-sm-10">{!! optional($user->userDetail->getOrg)->name ?? '<span class="text-warning">-ไม่ทราบ-</span>' !!}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">ลายเซ็น</div>
                                    <div class="col-sm-10">
                                        @if (($user->userDetail->sign ?? false) && file_exists(public_path('uploads/userImages/' . $user->userDetail->sign)))
                                            <img src="/uploads/userImages/{{ $user->userDetail->sign }}" class="object-fit-contain" width="50" alt="">
                                        @else
                                            {!! optional($user->userDetail)->sign ?? '<span class="text-warning">-ไม่พบ-</span>' !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function storeProfileimg(input) {
            if (input.files.length === 0) {
                // No file selected
                alert("please select on image.")
                return;
            }

            const imgfile = input.files[0];

            // Create a FormData object
            const formData = new FormData();
            formData.append('file_type', "profile");
            formData.append('store_image', imgfile);
            formData.append('_token', '{{ csrf_token() }}');
            storeImage(formData);
        }

        function storeSignimg(input) {
            if (input.files.length === 0) {
                // No file selected
                alert("please select on image.")
                return;
            }

            const imgfile = input.files[0];

            // Create a FormData object
            const formData = new FormData();
            formData.append('file_type', "sign");
            formData.append('store_image', imgfile);
            formData.append('_token', '{{ csrf_token() }}');
            storeImage(formData);
        }

        function storeImage(formData) {
            // Send the form data to the controller using AJAX
            fetch('/users/store-image', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Handle successful upload
                    console.log('File uploaded successfully', data);
                    // Optionally, update the UI to show the uploaded image
                    window.location.reload()
                } else {
                    // Handle upload failure
                    console.error('Error uploading file');
                    alert('Error uploading file. Please try again.');
                }
            })
            .catch(error => {
                console.error(error);
                alert('An error occurred. Please try again.');  

            });
        }
    </script>
@endsection
