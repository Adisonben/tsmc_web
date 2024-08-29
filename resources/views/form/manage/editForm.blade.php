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
                                    <div>
                                        <label class="form-label">ประเภทตัวเลือก</label>
                                        <select class="form-select" aria-label="Default select example" name="opt_type">
                                            <option selected disabled>เลือกประเภทตัวเลือก</option>
                                            @foreach ($opt_types as $opt_type)
                                                <option value="{{ $opt_type->id }}" {{ $opt_type->id == $sopt_type ? 'selected' : '' }}>{{ $opt_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
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
                                                <input type="text" class="form-control mb-3 list-group-item groupName"
                                                    placeholder="ชื่อหมวดหมู่" value="{{ $qgroup->title }}">
                                                <ol class="list-group-numbered">
                                                    @foreach ($qgroup->questions as $quest)
                                                        <li class="list-group-item d-flex gap-3">
                                                            <input type="text" class="form-control list-group-item groupSubText"
                                                                placeholder="รายการตรวจประเมิน 1" value="{{ $quest->title }}">
                                                            <a type="button" onclick="delGroupList(this)"><i
                                                                    class="bi bi-x"></i></a>
                                                        </li>
                                                    @endforeach
                                                    {{-- <li class="list-group-item d-flex gap-3">
                                                        <input type="text" class="form-control list-group-item groupSubText"
                                                            placeholder="รายการตรวจประเมิน 1">
                                                        <a type="button" onclick="delGroupList(this)"><i
                                                                class="bi bi-x"></i></a>
                                                    </li> --}}
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
    <script>
        function addGroupList(button) {
            const ol = button.closest('.card').querySelector('ol');
            const newListItem = document.createElement('li');
            newListItem.classList.add('list-group-item', 'd-flex', 'gap-3');
            newListItem.innerHTML =
                `<input type="text" class="form-control list-group-item groupSubText" placeholder="ชื่อรายการตรวจประเมิน"><a type="button" onclick="delGroupList(this)"><i class="bi bi-x"></i></a>`;
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
    </script>
    <style>
        li {
            counter-increment: list-item;
            list-style: none;
        }
    </style>
@endsection
