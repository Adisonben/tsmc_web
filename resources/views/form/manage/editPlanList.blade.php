@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('แก้ไขรายการแบบแผน') }}</p>
                        </div>
                    </div>

                    <div class="card-body px-md-5">
                        <div>
                            {{-- @if ($error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endif --}}
                            <form id="editPlanList" method="post">
                                @csrf
                                <h5 class="text-center mb-4">ข้อมูลแผน</h5>
                                <input type="hidden" value="{{ $formPlan->id }}" name="planId">
                                <div class="d-flex flex-wrap gap-3 mb-2">
                                    <div class="flex-fill">
                                        <p class="mb-0"><b>ชื่อแบบแผน:</b> <u>{{ $formPlan->title }}</u></p>
                                    </div>
                                    <div class="flex-fill">
                                        <p class="mb-0"><b>หมวดหมู่แบบแผน:</b> <u>{{ optional($formPlan->getType)->type_code }}:{{ optional($formPlan->getType)->name }}</u></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-2 planListContainer" plan-id="{{ $formPlan->id }}">
                                    <p>รายการแผน</p>
                                    @foreach ($formPlan->getLists ?? [] as $planList)
                                        <div class="card mb-2">
                                            <div class="card-body">
                                                <div class="d-flex gap-2 mb-2">
                                                    <input type="text" class="form-control planListName" placeholder="ชื่อรายการ" planList-id="{{ $planList->id }}" value="{{ $planList->title }}" required>
                                                    <input type="text" class="form-control planListComment" placeholder="หมายเหตุ" planList-id="{{ $planList->id }}" value="{{ $planList->comment }}" required>
                                                    <input type="hidden" name="planListId" value="{{ $planList->id }}">
                                                </div>
                                                <div class="mb-2">
                                                    <p class="mb-0">{{ optional($formPlan->firstColumn($formPlan->id))->group_name }}</p>
                                                    @foreach ($formPlan->getColumns ?? [] as $index => $column)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="option{{ $index }}" planList-id="{{ $planList->id }}" column-id="{{ $column->id }}"
                                                                {{ optional(optional($planList->hasColumn($column->id))->pivot)->status ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="option{{ $index }}">{{ $column->title }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="delListBtn(this)">ลบรายการ</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-success mb-3" onclick="addListCard(this)">เพิ่มรายการ</button>
                                {{-- <button type="submit" class="btn btn-primary mb-3">บันทึก</button> --}}
                                <a href="{{ route('forms.tables', ['formtype' => $formPlan->getType->name]) }}" class="btn btn-secondary mb-3">กลับไปยังตาราง</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('keyup', '.planListName', function(){
                const planListId = $(this).attr('planList-id');
                const content = $(this).val();
                fetch(`/forms/plan/list/${planListId}/update/title/${content}`)
                .then(response => {
                    // Check if the response was successful (status code 200)
                    if (!response.ok) {
                        throw new Error(`Network response was not ok (status ${response.status})`);
                    }
                    return response.json(); // Parse the JSON response
                    })
                .then(data => {
                    // Process the fetched data
                    // console.log(data);
                    console.log("Update planlist success.")
                    // Update the DOM with the data (example)
                    // $('#result').text(data.message);
                })
                .catch(error => {
                    // Handle errors that occurred during the fetch process
                    console.error('Error update data');
                    // Display an error message to the user (optional)
                    // $('#error').text('An error occurred while fetching data.');
                });
            });

            $(document).on('keyup', '.planListComment', function(){
                const planListId = $(this).attr('planList-id');
                const content = $(this).val();
                fetch(`/forms/plan/list/${planListId}/update/comment/${content}`)
                .then(response => {
                    // Check if the response was successful (status code 200)
                    if (!response.ok) {
                        throw new Error(`Network response was not ok (status ${response.status})`);
                    }
                    return response.json(); // Parse the JSON response
                    })
                .then(data => {
                    // Process the fetched data
                    // console.log(data);
                    console.log("Update planlist success.")
                    // Update the DOM with the data (example)
                    // $('#result').text(data.message);
                })
                .catch(error => {
                    // Handle errors that occurred during the fetch process
                    console.error('Error update data');
                    // Display an error message to the user (optional)
                    // $('#error').text('An error occurred while fetching data.');
                });
            });

            $(document).on('change', '.form-check-input', function(){
                const planListId = $(this).attr('planList-id');
                const columnId = $(this).attr('column-id');
                const checkStatus = $(this).is(":checked");
                console.log(planListId, columnId, checkStatus);
                fetch(`/forms/plan/list/${planListId}/update/check-column/${columnId}/${checkStatus ? 1 : 0}`)
                .then(response => {
                    // Check if the response was successful (status code 200)
                    if (!response.ok) {
                        throw new Error(`Network response was not ok (status ${response.status})`);
                    }
                    return response.json(); // Parse the JSON response
                    })
                .then(data => {
                    // Process the fetched data
                    // console.log(data);
                    console.log("Update planlist success.")
                    // Update the DOM with the data (example)
                    // $('#result').text(data.message);
                })
                .catch(error => {
                    // Handle errors that occurred during the fetch process
                    console.error('Error update data');
                    // Display an error message to the user (optional)
                    // $('#error').text('An error occurred while fetching data.');
                });
            });
        })
        function addListCard(element) {
            let count = $('.planListContainer').children().length;
            const planlistId = $('.planListContainer').attr('plan-id');
            fetch(`/forms/plan/${planlistId}/list/create/each`)
            .then(response => {
                // Check if the response was successful (status code 200)
                if (!response.ok) {
                    throw new Error(`Network response was not ok (status ${response.status})`);
                }
                return response.json(); // Parse the JSON response
                })
            .then(data => {
                // Process the fetched data
                // console.log(data);
                console.log("Created success.")
                // Update the DOM with the data (example)
                // $('#result').text(data.message);
                $('.planListContainer').append(`
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="d-flex gap-2 mb-2">
                                <input type="text" class="form-control planListName" planList-id="${data.planListId}" placeholder="ชื่อรายการ" value="${data.title}" required>
                                <input type="text" class="form-control planListComment" planList-id="${data.planListId}" placeholder="หมายเหตุ" required>
                                <input type="hidden" name="planListId" value="${data.planListId}">
                            </div>
                            <div class="mb-2">
                                <p class="mb-0">{{ optional($formPlan->firstColumn($formPlan->id))->group_name }}</p>
                                @foreach ($formPlan->getColumns ?? [] as $index => $column)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="option${count}{{ $index }}"
                                            value="{{ $column->id }}" {{ optional(optional($planList->hasColumn($column->id))->pivot)->status ? 'checked' : '' }}>
                                        <label class="form-check-label" for="option${count}{{ $index }}">{{ $column->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-danger" onclick="delListBtn(this)">ลบรายการ</button>
                            </div>
                        </div>
                    </div>
                `);
            })
            .catch(error => {
                // Handle errors that occurred during the fetch process
                console.error('Error creating data');
                // Display an error message to the user (optional)
                // $('#error').text('An error occurred while fetching data.');
            });
        }

        function delListBtn(element) {
            const planListItem = element.closest('.card');
            var planListId = $(planListItem).find("[name='planListId']").val();
            fetch(`/forms/plan/list/delete/${planListId}`)
            .then(response => {
                // Check if the response was successful (status code 200)
                if (!response.ok) {
                    throw new Error(`Network response was not ok (status ${response.status})`);
                }
                return response.json(); // Parse the JSON response
                })
            .then(data => {
                // Process the fetched data
                // console.log(data);
                console.log("Deleted success.", data)
                // Update the DOM with the data (example)
                // $('#result').text(data.message);
            })
            .catch(error => {
                // Handle errors that occurred during the fetch process
                console.error('Error Deleting data');
                // Display an error message to the user (optional)
                // $('#error').text('An error occurred while fetching data.');
            });
            planListItem.remove();
        }
    </script>
    <style>
        li {
            counter-increment: list-item;
            list-style: none;
        }
        #formManagePage {
            background-color: var(--main-color);
        }
    </style>
@endsection
