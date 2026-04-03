@extends('layouts.app')

@section('content')
    @if ($is_show)
        {{-- ======== VIEW / PRINT MODE (original table layout) ======== --}}
        <div class="">
            <div class="row justify-content-center">
                <div class="px-3 px-md-5" x-data="formFillOut({{ $form_data->formFields }}, {{ $submission->getSubmissionValues }})">
                    <form @submit.prevent="handleSubmit">
                        @csrf
                        <div class="card mb-4" id="exportPaper" style="background-color: #fff; color: #000;">
                            <div class="card-body px-md-5" style="background-color: #fff; color: #000;">
                                <p class="text-center fs-5 mb-0 fw-bold">{{ Auth::user()->org_name }}</p>
                                <p class="text-center fs-5 mb-0 fw-bold">{{ $form_data->title }}</p>
                                @php
                                    $updatedDate = new Carbon\Carbon($submission->updated_at);
                                @endphp
                                <p class="text-center">{{ $updatedDate->thaidate('วันที่ j F พ.ศ.Y') }}</p>

                                <div class="row row-cols-1 row-cols-sm-2 mb-3">
                                    @if ($form_data->select_vehicle)
                                        <div class="col d-flex align-items-center">
                                            <label for="vehicle" class="col-form-label text-nowrap w-25 text-end">รถ</label>
                                            <input type="text" class="form-control ms-2" value="{{ optional($submission->getVehicle)->license_plate ?? '-' }}" disabled>
                                        </div>
                                    @endif
                                    @if ($form_data->select_user)
                                        <div class="col d-flex align-items-center">
                                            <label for="user_id" class="col-form-label text-nowrap w-25 text-end">พนักงาน</label>
                                            <input type="text" class="form-control ms-2" value="{{ optional($submission->getUser)->full_name ?? '-' }}" disabled>
                                        </div>
                                    @endif
                                </div>

                                <hr>

                                <div class="row mb-2">
                                    <template x-for="(field, index) in formFieldsAnswer" :key="field.id">
                                        <div class="mb-2 align-items-center px-4 fs-6 d-flex gap-2"
                                            :class="field.type === 'subform' ? 'col-12' : 'col-md-6 col-12 eachCheckList'">

                                            <template x-if="field.type !== 'subform'">
                                                <label class="col-form-label text-end" x-text="field.label"></label>
                                            </template>

                                            <template x-if="field.type === 'subform'">
                                                <table class="table table-bordered my-4">
                                                    <thead class="text-center table-secondary">
                                                        <tr>
                                                            <th colspan="3" x-text="field.label"></th>
                                                        </tr>
                                                        <tr>
                                                            <th>รายการ</th>
                                                            <th>ผลการตรวจ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <template x-for="(subfield, index) in field.subfields" :key="subfield.id">
                                                            <tr>
                                                                <td x-text="subfield.label"></td>
                                                                <td>
                                                                    <div x-text="subfield.answer"></div>
                                                                </td>
                                                            </tr>
                                                        </template>
                                                    </tbody>
                                                </table>
                                            </template>

                                            <div x-text="field.answer" class="text-decoration-underline"></div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-success" type="button" onclick="window.print()">Print</button>
                            <a href="{{ route('document.table', ['form_id' => $form_data->form_id]) }}" class="btn btn-secondary">กลับ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            function formFillOut(fieldData, ansData) {
                return {
                    formFieldsAnswer: fieldData.map((field) => ({
                        id: field.id,
                        label: field.label,
                        type: field.type,
                        options: field.options ? field.options.map(option => ({
                            value: option.value
                        })) : '',
                        subfields: field.type === 'subform' ? field.subform.subformfields.map(subfield => ({
                            id: subfield.id,
                            label: subfield.label,
                            type: subfield.type,
                            options: subfield.options ? subfield.options.map(option => ({
                                value: option.value
                            })) : '',
                            answer: ansData.find(ans => ans.field_id === subfield.id) ? ansData.find(ans => ans.field_id === subfield.id).value : ''
                        })) : '',
                        answer: ansData.find(ans => ans.field_id === field.id) ? ansData.find(ans => ans.field_id === field.id).value : ''
                    })),
                    handleSubmit() {}
                }
            }
        </script>
        <style>
            #exportPaper,
            #exportPaper *:not(.btn) {
                color: #000 !important;
                background-color: transparent;
            }
            #exportPaper {
                background-color: #fff !important;
                width: 210mm;
                min-height: 297mm;
                padding: 20mm;
                margin: 0 auto;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
            #exportPaper .card-body {
                padding: 0 !important;
            }
            #exportPaper .form-control:disabled {
                background-color: #e9ecef !important;
                color: #000 !important;
            }
            #exportPaper .table {
                border-collapse: collapse !important;
                border: 1px solid #000 !important;
            }
            #exportPaper .table th,
            #exportPaper .table td {
                border: 1px solid #000 !important;
                padding: 8px !important;
            }
            #exportPaper .table-secondary {
                background-color: #e2e3e5 !important;
            }
            #exportPaper .table-secondary th {
                background-color: #e2e3e5 !important;
            }
            @media print {
                body { visibility: hidden; }
                #exportPaper { 
                    visibility: visible; 
                    position: absolute; 
                    left: 0; 
                    top: 0;
                    width: 210mm;
                    min-height: 297mm;
                    box-shadow: none;
                    margin: 0;
                    padding: 20mm;
                }
                .eachCheckList { width: 50%; }
            }
        </style>
    @else
        {{-- ======== EDIT MODE (exam-style UI) ======== --}}
        <style>
            .exam-container {
                min-height: 80vh;
                color: #e5e5e5;
            }
            .exam-card {
                background: #1a1a2e;
                border: 1px solid rgba(255,255,255,0.08);
                border-radius: 16px;
                max-width: 700px;
                margin: 0 auto;
            }
            .exam-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 16px 20px;
                border-bottom: 1px solid rgba(255,255,255,0.06);
            }
            .exam-close-btn {
                background: none;
                border: none;
                color: rgba(255,255,255,0.4);
                font-size: 18px;
                cursor: pointer;
                padding: 4px 8px;
                border-radius: 8px;
                transition: all 0.2s;
            }
            .exam-close-btn:hover { color: #fff; background: rgba(255,255,255,0.08); }
            .exam-back-btn {
                background: none;
                border: none;
                color: #fbbf24;
                font-size: 14px;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 6px;
                transition: color 0.2s;
            }
            .exam-back-btn:hover { color: #fde68a; }
            .exam-counter {
                font-size: 14px;
                color: rgba(255,255,255,0.4);
            }
            .exam-progress-bar {
                display: flex;
                gap: 4px;
                padding: 0 20px 16px;
            }
            .exam-progress-segment {
                flex: 1;
                height: 8px;
                border-radius: 99px;
                cursor: pointer;
                transition: all 0.3s;
            }
            .exam-progress-done { background: #34d399; }
            .exam-progress-current { background: #fbbf24; }
            .exam-progress-upcoming { background: rgba(255,255,255,0.08); }
            .exam-title-card {
                background: rgba(255,255,255,0.03);
                border: 1px solid rgba(255,255,255,0.06);
                border-radius: 12px;
                padding: 16px 20px;
                margin: 0 20px 16px;
            }
            .exam-title-text {
                font-size: 16px;
                font-weight: 700;
                color: #fbbf24;
                margin: 0;
            }
            .exam-title-sub {
                font-size: 13px;
                color: rgba(255,255,255,0.4);
                margin: 2px 0 0;
            }
            .exam-group-label {
                font-size: 13px;
                color: rgba(255,255,255,0.4);
                margin-top: 4px;
            }
            .exam-question-card {
                background: rgba(251,191,36,0.03);
                border: 1px solid rgba(251,191,36,0.15);
                border-radius: 12px;
                padding: 24px 20px;
                margin: 0 20px 16px;
            }
            .exam-question-label {
                font-size: 18px;
                font-weight: 700;
                color: #fff;
                margin-bottom: 20px;
            }
            .exam-input {
                width: 100%;
                height: 48px;
                border-radius: 12px;
                border: 1px solid rgba(255,255,255,0.1);
                background: rgba(255,255,255,0.04);
                padding: 0 16px;
                font-size: 15px;
                color: #fff;
                outline: none;
                transition: border-color 0.2s;
            }
            .exam-input:focus { border-color: rgba(251,191,36,0.5); }
            .exam-input::placeholder { color: rgba(255,255,255,0.3); }
            .exam-select-option {
                width: 100%;
                text-align: left;
                border-radius: 12px;
                border: 1px solid rgba(255,255,255,0.06);
                background: rgba(255,255,255,0.02);
                padding: 14px 18px;
                font-size: 16px;
                color: #fff;
                cursor: pointer;
                transition: all 0.2s;
                margin-bottom: 8px;
                display: block;
            }
            .exam-select-option:hover {
                border-color: rgba(251,191,36,0.3);
                background: rgba(251,191,36,0.06);
            }
            .exam-select-option.active {
                border-color: rgba(251,191,36,0.4);
                background: rgba(251,191,36,0.1);
                color: #fbbf24;
            }
            .exam-radio-group {
                display: flex;
                gap: 8px;
                flex-wrap: wrap;
            }
            .exam-radio-btn {
                flex: 1;
                min-width: 80px;
                text-align: center;
                border-radius: 12px;
                border: 1px solid rgba(255,255,255,0.08);
                background: rgba(255,255,255,0.02);
                padding: 12px 14px;
                font-size: 15px;
                color: #fff;
                cursor: pointer;
                transition: all 0.2s;
            }
            .exam-radio-btn:hover {
                border-color: rgba(251,191,36,0.3);
                background: rgba(251,191,36,0.06);
            }
            .exam-radio-btn.active {
                border-color: rgba(251,191,36,0.4);
                background: rgba(251,191,36,0.12);
                color: #fbbf24;
                font-weight: 600;
            }
            .exam-next-btn {
                width: 100%;
                height: 48px;
                border-radius: 12px;
                background: #fbbf24;
                color: #1a1a2e;
                font-weight: 700;
                font-size: 15px;
                border: none;
                cursor: pointer;
                transition: background 0.2s;
                margin-top: 12px;
            }
            .exam-next-btn:hover { background: #fde68a; }
            .exam-next-btn:disabled { opacity: 0.4; cursor: not-allowed; }
            .exam-submit-btn {
                width: 100%;
                height: 48px;
                border-radius: 12px;
                background: linear-gradient(135deg, #34d399, #10b981);
                color: #fff;
                font-weight: 700;
                font-size: 15px;
                border: none;
                cursor: pointer;
                transition: opacity 0.2s;
                margin-top: 12px;
            }
            .exam-submit-btn:hover { opacity: 0.9; }
            .exam-footer {
                padding: 12px 20px 20px;
            }
            .exam-info-bar {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 8px 12px;
                margin: 0 20px 12px;
                border-radius: 8px;
                background: rgba(52,211,153,0.04);
                border: 1px solid rgba(52,211,153,0.1);
                font-size: 13px;
                color: rgba(255,255,255,0.4);
            }
            .exam-info-dot {
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: #34d399;
                flex-shrink: 0;
            }
            .exam-info-bar span { color: #34d399; }
            .exam-meta {
                max-width: 700px;
                margin: 0 auto 16px;
                display: flex;
                gap: 12px;
                flex-wrap: wrap;
            }
            .exam-meta-item {
                background: rgba(255,255,255,0.04);
                border: 1px solid rgba(255,255,255,0.08);
                border-radius: 10px;
                padding: 10px 16px;
                flex: 1;
                min-width: 200px;
            }
            .exam-meta-label {
                font-size: 12px;
                color: rgba(255,255,255,0.4);
                margin-bottom: 2px;
            }
            .exam-meta-value {
                font-size: 14px;
                color: #fff;
                font-weight: 600;
            }
        </style>

        @php
            $updatedDate = new Carbon\Carbon($submission->updated_at);
        @endphp

        <div class="exam-container px-3 py-4" x-data="formFillOut({{ $form_data->formFields }}, {{ $submission->getSubmissionValues }})">
            <form @submit.prevent="handleSubmit">
                @csrf

                {{-- Meta info (vehicle / user / date) --}}
                <div class="exam-meta">
                    @if ($form_data->select_vehicle)
                        <div class="exam-meta-item">
                            <div class="exam-meta-label">รถ</div>
                            <div class="exam-meta-value">{{ optional($submission->getVehicle)->license_plate ?? '-' }}</div>
                        </div>
                    @endif
                    @if ($form_data->select_user)
                        <div class="exam-meta-item">
                            <div class="exam-meta-label">พนักงาน</div>
                            <div class="exam-meta-value">{{ optional($submission->getUser)->full_name ?? '-' }}</div>
                        </div>
                    @endif
                    <div class="exam-meta-item">
                        <div class="exam-meta-label">วันที่บันทึก</div>
                        <div class="exam-meta-value">{{ $updatedDate->thaidate('j F พ.ศ.Y') }}</div>
                    </div>
                </div>

                <div class="exam-card">
                    {{-- Header --}}
                    <div class="exam-header">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <a href="{{ route('document.table', ['form_id' => $form_data->form_id]) }}" class="exam-close-btn" style="text-decoration:none;">✕</a>
                            <button type="button" class="exam-back-btn" x-show="activeQ > 0" @click="prevQuestion()">
                                <svg viewBox="0 0 12 12" style="width:14px;height:14px;"><path d="M7.5 2.5l-4 4 4 4" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                ข้อก่อนหน้า
                            </button>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span style="font-size:13px;color:#34d399;">บันทึกอัตโนมัติ</span>
                            <span class="exam-counter">ข้อ <span x-text="activeQ + 1"></span>/<span x-text="totalQuestions"></span></span>
                        </div>
                    </div>

                    {{-- Progress bar --}}
                    <div class="exam-progress-bar">
                        <template x-for="(q, i) in flatQuestions" :key="i">
                            <div class="exam-progress-segment"
                                 :class="{
                                    'exam-progress-done': i < activeQ,
                                    'exam-progress-current': i === activeQ,
                                    'exam-progress-upcoming': i > activeQ
                                 }"
                                 @click="jumpToQuestion(i)"
                                 :title="'ข้อ ' + (i+1) + ': ' + q.label">
                            </div>
                        </template>
                    </div>

                    {{-- Info bar --}}
                    <div class="exam-info-bar">
                        <div class="exam-info-dot"></div>
                        ตอบไปถึงไหน ระบบบันทึกไว้แล้ว — <span>กลับมาทำต่อได้ ไม่เริ่มใหม่</span>
                    </div>

                    {{-- Form title --}}
                    <div class="exam-title-card">
                        <p class="exam-title-text">{{ $form_data->title }}</p>
                        <p class="exam-title-sub">{{ Auth::user()->org_name }}</p>
                        <p class="exam-group-label" x-show="currentQuestion.groupLabel" x-text="currentQuestion.groupLabel"></p>
                    </div>

                    {{-- Current question --}}
                    <div class="exam-question-card">
                        <p class="exam-question-label" x-text="currentQuestion.label"></p>

                        {{-- Text input --}}
                        <template x-if="currentQuestion.type === 'text'">
                            <div>
                                <input type="text" class="exam-input"
                                       :value="currentQuestion.ref.answer"
                                       @input="currentQuestion.ref.answer = $event.target.value"
                                       placeholder="กรอกข้อมูล">
                            </div>
                        </template>

                        {{-- Number input --}}
                        <template x-if="currentQuestion.type === 'number'">
                            <div>
                                <input type="number" class="exam-input"
                                       :value="currentQuestion.ref.answer"
                                       @input="currentQuestion.ref.answer = $event.target.value"
                                       placeholder="กรอกตัวเลข">
                            </div>
                        </template>

                        {{-- Date input --}}
                        <template x-if="currentQuestion.type === 'date'">
                            <div>
                                <input type="date" class="exam-input"
                                       :value="currentQuestion.ref.answer"
                                       @input="currentQuestion.ref.answer = $event.target.value">
                            </div>
                        </template>

                        {{-- Select (stacked buttons for > 4 options) --}}
                        <template x-if="currentQuestion.type === 'select' && currentQuestion.options.length > 4">
                            <div>
                                <template x-for="(opt, oi) in currentQuestion.options" :key="oi">
                                    <button type="button" class="exam-select-option"
                                            :class="{ 'active': currentQuestion.ref.answer === opt.value }"
                                            @click="currentQuestion.ref.answer = opt.value; if(!isLast) { $nextTick(() => setTimeout(() => nextQuestion(), 300)); }"
                                            x-text="opt.value">
                                    </button>
                                </template>
                            </div>
                        </template>

                        {{-- Select (radio-style for <= 4 options) --}}
                        <template x-if="currentQuestion.type === 'select' && currentQuestion.options.length <= 4">
                            <div class="exam-radio-group">
                                <template x-for="(opt, oi) in currentQuestion.options" :key="oi">
                                    <button type="button" class="exam-radio-btn"
                                            :class="{ 'active': currentQuestion.ref.answer === opt.value }"
                                            @click="currentQuestion.ref.answer = opt.value; if(!isLast) { $nextTick(() => setTimeout(() => nextQuestion(), 300)); }"
                                            x-text="opt.value">
                                    </button>
                                </template>
                            </div>
                        </template>
                    </div>

                    {{-- Footer buttons --}}
                    <div class="exam-footer">
                        <template x-if="!isLast">
                            <button type="button" class="exam-next-btn" @click="nextQuestion()">
                                ถัดไป →
                            </button>
                        </template>
                        <template x-if="isLast">
                            <button type="submit" class="exam-submit-btn" {{ session('org_status') == 2 ? 'disabled' : '' }}>
                                บันทึก
                            </button>
                        </template>
                    </div>
                </div>
            </form>
        </div>

        <script>
            function formFillOut(fieldData, ansData) {
                console.log('Field Data: ', fieldData);
                console.log('Answer Data: ', ansData);
                return {
                    formFieldsAnswer: fieldData.map((field) => ({
                        id: field.id,
                        label: field.label,
                        type: field.type,
                        options: field.options ? field.options.map(option => ({
                            value: option.value
                        })) : '',
                        subfields: field.type === 'subform' ? field.subform.subformfields.map(subfield => ({
                            id: subfield.id,
                            label: subfield.label,
                            type: subfield.type,
                            options: subfield.options ? subfield.options.map(option => ({
                                value: option.value
                            })) : '',
                            answer: ansData.find(ans => ans.field_id === subfield.id) ? ansData.find(ans => ans.field_id === subfield.id).value : ''
                        })) : '',
                        answer: ansData.find(ans => ans.field_id === field.id) ? ansData.find(ans => ans.field_id === field.id).value : ''
                    })),

                    activeQ: 0,

                    get flatQuestions() {
                        const flat = [];
                        this.formFieldsAnswer.forEach(field => {
                            if (field.type === 'subform' && Array.isArray(field.subfields)) {
                                field.subfields.forEach(sub => {
                                    flat.push({
                                        label: sub.label,
                                        type: sub.type,
                                        options: sub.options || [],
                                        groupLabel: field.label,
                                        ref: sub
                                    });
                                });
                            } else {
                                flat.push({
                                    label: field.label,
                                    type: field.type,
                                    options: field.options || [],
                                    groupLabel: null,
                                    ref: field
                                });
                            }
                        });
                        return flat;
                    },

                    get totalQuestions() {
                        return this.flatQuestions.length;
                    },

                    get currentQuestion() {
                        return this.flatQuestions[this.activeQ] || { label: '', type: 'text', options: [], groupLabel: null, ref: { answer: '' } };
                    },

                    get isLast() {
                        return this.activeQ >= this.totalQuestions - 1;
                    },

                    nextQuestion() {
                        if (this.activeQ < this.totalQuestions - 1) {
                            this.activeQ++;
                        }
                    },

                    prevQuestion() {
                        if (this.activeQ > 0) {
                            this.activeQ--;
                        }
                    },

                    jumpToQuestion(i) {
                        if (i <= this.activeQ || this.flatQuestions[i]?.ref?.answer) {
                            this.activeQ = i;
                        }
                    },

                    handleSubmit() {
                        const allFields = this.formFieldsAnswer.flatMap(field =>
                            field.type === "subform" ? field.subfields : field
                        );

                        const fieldsWithAns = allFields.map((field, index) => ({
                            field_id: field.id,
                            answer: field.answer,
                        }));

                        const formData = {
                            fieldsAns: fieldsWithAns
                        };

                        fetch(`/document/{{ $submission->id}}/update`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify(formData)
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Data: ', data);
                                if (data.errors) {
                                    Swal.fire({
                                        toast: true,
                                        position: "top-end",
                                        icon: "error",
                                        title: data.errors,
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.onmouseenter = Swal.stopTimer;
                                            toast.onmouseleave = Swal.resumeTimer;
                                        }
                                    });
                                } else {
                                    Swal.fire(data.success ? data.success :"บันทึกสำเร็จ", "", "success").then(() => {
                                        window.location.reload();
                                    });
                                }
                            })
                            .catch(error => {
                                Swal.fire({
                                    toast: true,
                                    position: "top-end",
                                    icon: "error",
                                    title: "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                            });
                    }
                }
            }
        </script>
    @endif
@endsection
