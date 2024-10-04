@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('รายการแบบแผน') }}</p>
                        </div>
                    </div>

                    <div class="card-body px-md-5">
                        <div>
                            {{-- @if ($error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endif --}}
                            <form id="createPlanList" method="post">
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
                                <div class="mb-2 planListContainer">
                                    <p>รายการแผน</p>
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="d-flex gap-2 mb-2">
                                                <input type="text" class="form-control planListName" placeholder="ชื่อรายการ">
                                                <input type="text" class="form-control planListComment" placeholder="หมายเหตุ">
                                            </div>
                                            <div class="mb-2">
                                                <p class="mb-0">columnGroupName</p>
                                                @foreach ($formPlan->getColumns ?? [] as $index => $column)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="option{{ $index }}"
                                                            value="{{ $column->id }}">
                                                        <label class="form-check-label" for="option{{ $index }}">{{ $column->title }}</label>
                                                    </div>
                                                @endforeach
                                                {{-- <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="option1"
                                                        value="option1">
                                                    <label class="form-check-label" for="option1">1</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="option2"
                                                        value="option2">
                                                    <label class="form-check-label" for="option2">2</label>
                                                </div> --}}
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="delListBtn(this)">ลบรายการ</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success mb-3" onclick="addListCard(this)">เพิ่มรายการ</button>
                                <button type="submit" class="btn btn-primary mb-3">บันทึก</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function addListCard(element) {
            let count = $('.planListContainer').children().length;
            console.log(count);
            $('.planListContainer').append(`
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex gap-2 mb-2">
                            <input type="text" class="form-control planListName" placeholder="ชื่อรายการ">
                            <input type="text" class="form-control planListComment" placeholder="หมายเหตุ">
                        </div>
                        <div class="mb-2">
                            <p class="mb-0">columnGroupName</p>
                            @foreach ($formPlan->getColumns ?? [] as $index => $column)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="option${count}{{ $index }}"
                                        value="{{ $column->id }}">
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
        }

        function delListBtn(element) {
            const optionItem = element.closest('.card');
            optionItem.remove();
        }
    </script>
    <style>
        li {
            counter-increment: list-item;
            list-style: none;
        }
    </style>
@endsection
