@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">จัดการสิทธิ์การเข้าถึงแบบฟอร์ม {{ $form_data->title }}</p>
                            <a href="{{ route('form.table', ['form_category' => $form_data->formCategory->name ]) }}" class="btn btn-secondary btn-sm">กลับ</a>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif --}}

                        <div class="d-flex flex-wrap gap-md-3 px-md-4">
                            @foreach ($positions as $position)
                                <div class="form-check">
                                    <input class="form-check-input positionCheck" type="checkbox"
                                        posit-id="{{ $position->id }}" value="{{ $form_data->id }}" id="position{{ $position->id }}"
                                        {{ $position->hasThisForm($form_data->id) ? "checked" : '' }}
                                        {{session('org_status') == 2 ? 'disabled' : ''}}>
                                    <label class="form-check-label" for="position{{ $position->id }}">
                                        {{ $position->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.positionCheck').change(function() {
                var form_id = $(this).val();
                let positionId = $(this).attr('posit-id');
                var isChecked = $(this).is(':checked');
                fetch(`/forms/set-permission?position_id=${positionId}&form_id=${form_id}&is_checked=${isChecked ? 1 : 0}`)
                .then(response => {
                    // Check if the response was successful (status code 200)
                    // if (!response.ok) {
                    //     throw new Error(`Network response was not ok (status ${response.status})`);
                    // }
                    return response.json(); // Parse the JSON response
                    })
                .then(data => {
                    // Process the fetched data
                    console.log(data);
                    if (data.success) {
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "success",
                            title: "บันทึกข้อมูลสำเร็จ",
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                    } else {
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "error",
                            title: "บันทึกข้อมูลไม่สำเร็จ",
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                    }
                    // Update the DOM with the data (example)
                    // $('#result').text(data.message);
                })
                .catch(error => {
                    // Handle errors that occurred during the fetch process
                    console.log(error);
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "error",
                        title: "บันทึกข้อมูลไม่สำเร็จ",
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    console.error('Error fetching data:', error);
                    // Display an error message to the user (optional)
                    // $('#error').text('An error occurred while fetching data.');
                });
            });
        });
    </script>
    <style>
        #formManagePage {
            background-color: var(--main-color);
        }
    </style>
@endsection
