@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('แก้ไขแบบฟอร์ม') }}</p>
                            <a class="btn btn-sm btn-secondary" href="{{ route('forms.tables', ['formtype' => $form_edit->getType->name]) }}">กลับ</a>
                        </div>
                    </div>

                    <div class="card-body px-md-5">
                        <div>
                            {{-- @if ($error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endif --}}
                            <form id="updateCheckForm" form-id="{{ $form_edit->id }}" method="post">
                                @csrf
                                <h5 class="text-center">ข้อมูลฟอร์ม</h5>

                                <div class="mb-3">
                                    <label for="formName" class="form-label">ชื่อแบบฟอร์ม</label>
                                    <input type="text" class="form-control" maxlength="200" id="formName" name="formName" required value="{{ $form_edit->title }}"
                                        placeholder="กรอกชื่อแบบฟอร์ม">
                                </div>

                                <div class="d-flex gap-3">
                                    <div>
                                        <label class="form-label">หมวดหมู่แบบฟอร์ม</label>
                                        <select class="form-select" aria-label="Default select example" name="formType" required>
                                            <option disabled>เลือกหมวดหมู่แบบฟอร์ม</option>
                                            @foreach ($form_types as $form_type)
                                                <option value="{{ $form_type->id }}" {{ $form_type->id == $form_edit->type ? 'selected' : '' }}>{{ $form_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div>
                                        <label class="form-label">ประเภทตัวเลือก</label>
                                        <select class="form-select" aria-label="Default select example" name="opt_type">
                                            <option selected disabled>เลือกประเภทตัวเลือก</option>
                                            @foreach ($opt_types as $opt_type)
                                                <option value="{{ $opt_type->id }}" {{ $opt_type->id == $sopt_type ? 'selected' : '' }}>{{ $opt_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div>
                                        <label class="form-label">คุณสมบัติฟอร์ม</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" {{ $form_edit->has_comment ? 'checked' : '' }}
                                                    id="commentCheck" name="commentCheck">
                                                <label class="form-check-label" for="commentCheck">
                                                    แสดง Comment
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" {{ $form_edit->has_score ? 'checked' : '' }}
                                                    id="scoreCheck" name="scoreCheck">
                                                <label class="form-check-label" for="scoreCheck">
                                                    แสดงคะแนน
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" {{ $form_edit->has_approve ? 'checked' : '' }}
                                                    id="approveCheck" name="approveCheck">
                                                <label class="form-check-label" for="approveCheck">
                                                    การตรวจสอบ
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <h5 class="text-center">รายการตรวจประเมิน</h5>
                                <div id="groupCardContainer">
                                    @foreach ($quest_groups ?? [] as $qgroup)
                                        <div class="card my-3 checkCard">
                                            <div class="card-body">
                                                <input type="text" maxlength="200" class="form-control mb-3 groupName"
                                                    placeholder="ชื่อหมวดหมู่" value="{{ $qgroup->title }}">
                                                <ol class="list-group-numbered">
                                                    @foreach ($qgroup->questions as $quest)
                                                        <li class="list-group-item gap-3 border checkLi p-2" style="background-color: rgb(240, 240, 240)">
                                                            <div class="d-flex flex-fill mb-2 gap-2">
                                                                <input type="text" maxlength="200" class="form-control groupSubText"
                                                                    placeholder="รายการตรวจประเมิน 1" value="{{ $quest->title }}">
                                                                <select class="form-select selectOptType" aria-label="Default select example" onchange="changeSelected(this)">
                                                                    <option selected disabled>เลือกประเภทตัวเลือก</option>
                                                                    @foreach ($opt_types as $opt_type)
                                                                        <option value="{{ $opt_type->id }}" {{ $quest->option_type == $opt_type->id ? 'selected' : '' }}>{{ $opt_type->name }}</option>
                                                                    @endforeach
                                                                    <option value="text" {{ $quest->option_type == "text" ? 'selected' : '' }}>ข้อความ</option>
                                                                    <option value="custom" {{ $quest->option_type == "custom" ? 'selected' : '' }}>หลายตัวเลือก</option>
                                                                </select>
                                                                <button type="button" class="btn btn-sm btn-danger" onclick="delGroupList(this)"><i class="bi bi-x"></i></button>
                                                            </div>
                                                            <div class="optionSection">
                                                                <p class="mb-0">รายการตัวเลือก / คำตอบ</p>
                                                                <div class="px-3">
                                                                    <input type="text" maxlength="200" class="form-control mb-2" placeholder="ตัวอย่างช่องคำตอบ" aria-label="ตัวอย่างช่องคำตอบ" readonly style="display: {{ $quest->option_type == "text" ? 'blog' : 'none' }}">
                                                                    <ol class="list-group-numbered optionContainer" style="display: {{ $quest->option_type == "custom" ? 'blog' : 'none' }}">
                                                                        @if ($quest->option_type == "custom")
                                                                            @foreach ($quest->options as $each_option)
                                                                                <li class="list-group-item d-flex gap-2 mb-2 optionLi">
                                                                                    <input type="text" maxlength="200" class="form-control optTitle" placeholder="กรอกตัวเลือก" value="{{ $each_option->opt_text }}">
                                                                                    <input type="number" class="form-control optScore" placeholder="คะแนน(ไม่จำเป็น)" value="{{ $each_option->score }}">
                                                                                    <button type="button" class="btn btn-sm btn-danger" onclick="delOptionBtn(this)"><i class="bi bi-x"></i></button>
                                                                                </li>
                                                                            @endforeach
                                                                        @endif
                                                                    </ol>
                                                                    <button class="btn btn-success btn-sm text-nowrap" onClick="addOption(this)" type="button" style="display: {{ $quest->option_type == "custom" ? 'blog' : 'none' }}">เพิ่มตัวเลือก</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </div>
                                            <div class="card-footer">
                                                <button type="button" class="btn btn-sm btn-success"
                                                    onclick="addGroupList(this)">เพิ่มรายการตรวจประเมิน</button>
                                                <button type="button"
                                                    class="btn btn-sm btn-danger delete-card-btn">ลบหมวดหมู่</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="button" class="btn btn-success mb-3"
                                    id="addFormGroupBtn">เพิ่มหมวดหมู่</button>
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
        function addGroupList(button) {
            const ol = button.closest('.card').querySelector('ol');
            const newListItem = document.createElement('li');
            newListItem.classList.add('list-group-item', 'gap-3', 'border', 'p-2', 'checkLi');
            newListItem.innerHTML = `
                <div class="d-flex flex-fill mb-2 gap-2">
                    <input type="text" class="form-control groupSubText"
                        placeholder="รายการตรวจประเมิน 1">
                    <select class="form-select selectOptType" aria-label="Default select example" onchange="changeSelected(this)">
                        <option selected disabled>เลือกประเภทตัวเลือก</option>
                        @foreach ($opt_types as $opt_type)
                            <option value="{{ $opt_type->id }}">{{ $opt_type->name }}</option>
                        @endforeach
                        <option value="text">ข้อความ</option>
                        <option value="custom">หลายตัวเลือก</option>
                    </select>
                    <button type="button" class="btn btn-sm btn-danger" onclick="delGroupList(this)"><i class="bi bi-x"></i></button>
                </div>
                <div class="optionSection">
                    <p class="mb-0">รายการตัวเลือก / คำตอบ</p>
                    <div class="px-3">
                        <input type="text" class="form-control mb-2" placeholder="ตัวอย่างช่องคำตอบ" aria-label="ตัวอย่างช่องคำตอบ" readonly style="display: none">
                        <ol class="list-group-numbered optionContainer" style="display: none"></ol>
                        <button class="btn btn-success btn-sm text-nowrap" onClick="addOption(this)" type="button" style="display: none">เพิ่มตัวเลือก</button>
                    </div>
                </div>
            `;
            ol.appendChild(newListItem);
        }

        function delGroupList(element) {
            // Find the parent list item
            const listItem = element.closest('li');

            // Remove the list item from its parent list
            listItem.remove();

            // Reorder the remaining list items
            const listItems = listItem.parentElement.querySelectorAll('li');
            listItems.forEach((item, index) => {
                item.setAttribute('data-order', index + 1);
            });
        }

        function addOption(element){
            console.log('addOptionBtn');
            $(element).prev('ol.optionContainer').append(`
                <li class="list-group-item d-flex gap-2 mb-2 optionLi">
                    <input type="text" class="form-control optTitle" placeholder="กรอกตัวเลือก">
                    <input type="number" class="form-control optScore" placeholder="คะแนน(ไม่จำเป็น)">
                    <button type="button" class="btn btn-sm btn-danger" onclick="delOptionBtn(this)"><i class="bi bi-x"></i></button>
                </li>
            `);
        }

        function delOptionBtn(element) {
            console.log("removeBtn");
            const optionItem = element.closest('li');
            optionItem.remove();
        }

        function changeSelected(element) {
            const selected = $(element).val();
            console.log("selectOptType ", selected)
            if (selected == "custom") {
                $(element).closest('div').next().children('div').children('ol').show();
                $(element).closest('div').next().children('div').children('button').show();
                $(element).closest('div').next().children('div').children('input').hide();
            } else if (selected == "text"){
                $(element).closest('div').next().children('div').children('ol').hide();
                $(element).closest('div').next().children('div').children('button').hide();
                $(element).closest('div').next().children('div').children('input').show();
            } else {
                $(element).closest('div').next().children('div').children('ol').hide();
                $(element).closest('div').next().children('div').children('button').hide();
                $(element).closest('div').next().children('div').children('input').hide();
            }
        }
    </script>
    <style>
        li {
            counter-increment: list-item;
            list-style: none;
        }
    </style>
@endsection
