@extends('layouts.app')

@section('content')
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
        .exam-next-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }
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
        .exam-start-card {
            background: #1a1a2e;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            max-width: 550px;
            margin: 0 auto;
            padding: 40px 32px;
            text-align: center;
        }
        .exam-start-title {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
        }
        .exam-start-subtitle {
            font-size: 14px;
            color: rgba(255,255,255,0.4);
            margin-bottom: 28px;
        }
        .exam-start-select-group {
            text-align: left;
            margin-bottom: 16px;
        }
        .exam-start-label {
            font-size: 14px;
            color: rgba(255,255,255,0.6);
            margin-bottom: 6px;
            display: block;
        }
        .exam-start-select {
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
            -webkit-appearance: none;
        }
        .exam-start-select:focus { border-color: rgba(251,191,36,0.5); }
        .exam-start-select option { background: #1a1a2e; color: #fff; }
        .exam-start-btn {
            width: 100%;
            height: 48px;
            border-radius: 12px;
            background: #fbbf24;
            color: #1a1a2e;
            font-weight: 700;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 24px;
        }
        .exam-start-btn:hover { background: #fde68a; }
        .exam-start-btn:disabled { opacity: 0.4; cursor: not-allowed; }
        .exam-autosave-notice {
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
        .exam-autosave-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #34d399;
            flex-shrink: 0;
        }
        .exam-autosave-notice span { color: #34d399; }
    </style>

    <div class="exam-container px-3 py-4" x-data="formFillOut({{ $form_data->formFields }}, {{ $vehicles }})">

        {{-- ======== START SCREEN (vehicle/user selection) ======== --}}
        <div x-show="!examStarted" x-cloak>
            <div class="exam-start-card">
                <div class="exam-start-title">{{ $form_data->title }}</div>
                <div class="exam-start-subtitle">
                    <span x-text="totalQuestions + ' ข้อ'"></span>
                </div>

                @if ($form_data->select_vehicle)
                    <div class="exam-start-select-group">
                        <label class="exam-start-label">รถ</label>
                        <select class="exam-start-select" x-model="selectVehicleId" @change="updateUser()">
                            <option value="">เลือกรถ</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">{{ $vehicle->license_plate }} : {{ $vehicle->brand }}</option>
                            @endforeach
                        </select>
                        <div x-show="showVehicleError" style="color:#f87171;font-size:13px;margin-top:4px;">กรุณาเลือกรถ</div>
                    </div>
                @endif

                @if ($form_data->select_user)
                    <div class="exam-start-select-group">
                        <label class="exam-start-label">ผู้ประจำรถ</label>
                        <select class="exam-start-select" x-model="selectUserId" @change="updateError()">
                            <option value="">ไม่พบผู้ประจำรถ</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->user_id }}">{{ $user->fname }} {{ $user->lname }}</option>
                            @endforeach
                        </select>
                        <div x-show="showUserError" style="color:#f87171;font-size:13px;margin-top:4px;">กรุณาเลือกผู้ประจำรถ</div>
                    </div>
                @endif

                <button class="exam-start-btn" @click="startExam()"
                    :disabled="needsVehicle && !selectVehicleId || needsUser && !selectUserId">
                    เริ่มทำแบบฟอร์ม
                </button>
                <a href="{{ route('document.fill-out.selectform') }}"
                   style="display:inline-block;margin-top:12px;font-size:14px;color:rgba(255,255,255,0.4);text-decoration:none;">
                    กลับ
                </a>
            </div>
        </div>

        {{-- ======== EXAM MODE (one question at a time) ======== --}}
        <div x-show="examStarted" x-cloak>
            <form @submit.prevent="handleSubmit">
                @csrf

                <div class="exam-card">
                    {{-- Header --}}
                    <div class="exam-header">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <button type="button" class="exam-close-btn" @click="exitExam()">✕</button>
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

                    {{-- Auto-save notice --}}
                    <div class="exam-autosave-notice">
                        <div class="exam-autosave-dot"></div>
                        ตอบไปถึงไหน ระบบบันทึกไว้แล้ว — <span>กลับมาทำต่อได้ ไม่เริ่มใหม่</span>
                    </div>

                    {{-- Form title --}}
                    <div class="exam-title-card">
                        <p class="exam-title-text">{{ $form_data->title }}</p>
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

                        {{-- Select (options as clickable buttons) --}}
                        <template x-if="currentQuestion.type === 'select' && currentQuestion.options.length > 4">
                            <div>
                                <template x-for="(opt, oi) in currentQuestion.options" :key="oi">
                                    <button type="button" class="exam-select-option"
                                            :class="{ 'active': currentQuestion.ref.answer === opt.value }"
                                            @click="currentQuestion.ref.answer = opt.value; if(isLast) {} else { $nextTick(() => setTimeout(() => nextQuestion(), 300)); }"
                                            x-text="opt.value">
                                    </button>
                                </template>
                            </div>
                        </template>

                        {{-- Select (radio-style buttons for <= 4 options) --}}
                        <template x-if="currentQuestion.type === 'select' && currentQuestion.options.length <= 4">
                            <div class="exam-radio-group">
                                <template x-for="(opt, oi) in currentQuestion.options" :key="oi">
                                    <button type="button" class="exam-radio-btn"
                                            :class="{ 'active': currentQuestion.ref.answer === opt.value }"
                                            @click="currentQuestion.ref.answer = opt.value; if(isLast) {} else { $nextTick(() => setTimeout(() => nextQuestion(), 300)); }"
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
                            <button type="submit" class="exam-submit-btn">
                                ส่งแบบฟอร์ม
                            </button>
                        </template>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function formFillOut(fieldData, vehicles) {
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
                        answer: ''
                    })) : '',
                    answer: ''
                })),

                selectUserId: '',
                selectVehicleId: '',
                showVehicleError: false,
                showUserError: false,
                examStarted: false,
                activeQ: 0,

                needsVehicle: {{ $form_data->select_vehicle ? 'true' : 'false' }},
                needsUser: {{ $form_data->select_user ? 'true' : 'false' }},

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

                startExam() {
                    if (this.needsVehicle && !this.selectVehicleId) {
                        this.showVehicleError = true;
                        return;
                    }
                    if (this.needsUser && !this.selectUserId) {
                        this.showUserError = true;
                        return;
                    }
                    this.examStarted = true;
                },

                exitExam() {
                    this.examStarted = false;
                    this.activeQ = 0;
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

                updateError() {
                    this.showVehicleError = !this.selectVehicleId;
                    this.showUserError = !this.selectUserId;
                },

                updateUser() {
                    let selectedVehicle = vehicles.find(v => v.id == this.selectVehicleId);
                    this.selectUserId = selectedVehicle ? selectedVehicle.driver_id : '';
                    this.updateError();
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
                        selected_user_id: this.selectUserId,
                        selected_vehicle_id: this.selectVehicleId,
                        fieldsAns: fieldsWithAns
                    };

                    fetch(`/document/{{ $form_data->form_id }}/submit`, {
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
                                    window.location.href = "/document/fill-out/select-form";
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
@endsection
