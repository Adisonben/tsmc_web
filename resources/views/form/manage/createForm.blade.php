@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('สร้างแบบฟอร์ม') }}</p>
                        </div>
                    </div>

                    <div class="card-body px-md-5">
                        <div>
                            {{-- @if ($error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endif --}}
                            <form id="createCheckForm" method="post" enctype="multipart/form-data">
                                @csrf
                                <h5 class="text-center">ข้อมูลฟอร์ม</h5>

                                <div class="mb-3">
                                    <label for="formName" class="form-label">ชื่อแบบฟอร์ม</label>
                                    <input type="text" class="form-control" maxlength="200" id="formName" name="formName" required value=""
                                        placeholder="กรอกชื่อแบบฟอร์ม">
                                </div>

                                <div class="d-flex flex-wrap gap-3">
                                    <div>
                                        <label class="form-label">หมวดหมู่แบบฟอร์ม</label>
                                        <select class="form-select" aria-label="Default select example" name="formType" required>
                                            <option disabled>เลือกหมวดหมู่แบบฟอร์ม</option>
                                            @foreach ($form_types as $form_type)
                                                <option value="{{ $form_type->id }}">{{ $form_type->type_code ?? '' }} : {{ $form_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div>
                                        <label class="form-label">ประเภทตัวเลือก</label>
                                        <select class="form-select" aria-label="Default select example" name="opt_type">
                                            <option selected disabled>เลือกประเภทตัวเลือก</option>
                                            @foreach ($opt_types as $opt_type)
                                                <option value="{{ $opt_type->id }}">{{ $opt_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div>
                                        <label class="form-label">คุณสมบัติฟอร์ม</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="commentCheck" name="commentCheck">
                                                <label class="form-check-label" for="commentCheck">
                                                    แสดง Comment
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" disabled
                                                    id="scoreCheck" name="scoreCheck">
                                                <label class="form-check-label" for="scoreCheck">
                                                    แสดงคะแนน
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
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
                                    <div class="card my-3 checkCard">
                                        {{-- <div class="card-body">
                                            <div class="d-flex gap-2 flex-wrap flex-md-nowrap">
                                                <input type="text" class="form-control mb-3 groupName" placeholder="ชื่อภาพ">
                                                <input type="file" class="form-control mb-3 groupContent" onchange="addExImg(this)" placeholder="ภาพ" accept="image/*">
                                            </div>
                                            <input type="hidden" class="form-control mb-3 groupType" value="image">
                                            <img class="image-preview" src="" alt="ตัวอย่างภาพ" height="250" style="display: none">
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-sm btn-danger delete-card-btn">ลบหมวดหมู่</button>
                                        </div> --}}
                                    </div>
                                    {{-- <div class="card my-3 checkCard">
                                        <div class="card-body">
                                            <input type="text" class="form-control mb-3 groupName"
                                                placeholder="ชื่อหมวดหมู่">
                                            <input type="hidden" class="form-control mb-3 groupType" value="check">
                                            <ol class="list-group-numbered">
                                            </ol>
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="addGroupList(this)">เพิ่มรายการตรวจประเมิน</button>
                                            <button type="button"
                                                class="btn btn-sm btn-danger delete-card-btn">ลบหมวดหมู่</button>
                                        </div>
                                    </div> --}}
                                </div>

                                <button type="button" class="btn btn-success mb-3"
                                    id="addFormGroupBtn">เพิ่มหมวดหมู่</button>
                                <button type="button" class="btn btn-info mb-3"
                                    id="addImgGroupBtn">เพิ่มรูปภาพ</button>
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
        // $('.addOptionBtn').on('click', function() {
        //     console.log('addOptionBtn');
        //     $(this).prev('ol.optionContainer').append(`
        //         <li class="list-group-item d-flex gap-2 mb-2">
        //             <input type="text" class="form-control optTitle" placeholder="กรอกตัวเลือก">
        //             <input type="text" class="form-control optScore" placeholder="คะแนน(ไม่จำเป็น)">
        //             <button type="button" class="btn btn-sm btn-danger" onclick="delOptionBtn(this)"><i class="bi bi-x"></i></button>
        //         </li>
        //     `);
        // });
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

        function addExImg(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var closestPreview = $(input).closest('.checkCard').find('.image-preview');
                reader.onload = function(e) {
                    closestPreview.attr('src', e.target.result);
                    closestPreview.show();
                };
                reader.readAsDataURL(input.files[0]);
            }
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
        // $(document).ready(function() {
        //     $('.selectOptType').on('change', function () {
        //         const selected = $(this).val();
        //         console.log("selectOptType ", selected)
        //         if (selected == "custom") {
        //             $(this).closest('div').next().children('div').children('ol').show();
        //             $(this).closest('div').next().children('div').children('button').show();
        //             $(this).closest('div').next().children('div').children('input').hide();
        //         } else if (selected == "text"){
        //             $(this).closest('div').next().children('div').children('ol').hide();
        //             $(this).closest('div').next().children('div').children('button').hide();
        //             $(this).closest('div').next().children('div').children('input').show();
        //         } else {
        //             $(this).closest('div').next().children('div').children('ol').hide();
        //             $(this).closest('div').next().children('div').children('button').hide();
        //             $(this).closest('div').next().children('div').children('input').hide();
        //         }
        //     })
        // });
    </script>
    <style>
        li {
            counter-increment: list-item;
            list-style: none;
        }
    </style>
@endsection
