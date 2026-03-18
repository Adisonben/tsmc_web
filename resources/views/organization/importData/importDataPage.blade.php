@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="px-3 px-md-5">

            {{-- Download Template --}}
            <div class="card mb-4">
                <div class="card-header">
                    <p class="mb-0 fs-4">นำเข้าข้อมูลผู้ใช้</p>
                </div>
                <div class="card-body">
                    <p class="mb-2">ขั้นตอนที่ 1: ดาวน์โหลด template แล้วกรอกข้อมูลผู้ใช้ที่ต้องการนำเข้า</p>
                    <ul class="mb-3 ps-3">
                        <li>- กรอกข้อมูลในคอลัมน์ <strong>username, password, prefix_id, first_name, last_name, department_id, position_id</strong> <span class="text-danger">ให้ครบทุกแถว</span></li>
                        <li>- คอลัมน์ <strong>citizen_id</strong> <u>ไม่จำเป็นต้องกรอก</u> หากไม่มีข้อมูลสามารถเว้นว่างได้</li>
                        <li>- ตรวจสอบให้แน่ใจว่าเลือก <strong>department_id, position_id, prefix_id</strong> ที่ถูกต้อง โดยให้อ้างอิงจากหน้า Department, Position และ Prefix ที่อยู่ในไฟล์ template</li>
                    </ul>
                    <a href="{{ route('importdata.template') }}" class="btn btn-success">
                        <i class="bi bi-file-earmark-arrow-down me-1"></i> ดาวน์โหลด Template
                    </a>
                </div>
            </div>

            {{-- Upload File --}}
            <div class="card mb-4">
                <div class="card-header">
                    <p class="mb-0 fs-5">ขั้นตอนที่ 2: อัปโหลดไฟล์ Excel</p>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('info'))
                        <div class="alert alert-info">{{ session('info') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (session('import_errors'))
                        <div class="alert alert-warning">
                            <p class="mb-1">บันทึกรายการบางส่วนไม่สำเร็จ:</p>
                            <ul class="mb-0 ps-3">
                                @foreach (session('import_errors') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('importdata.preview') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="import_file" class="form-label">เลือกไฟล์ Excel (.xlsx, .xls)</label>
                            <input type="file" class="form-control @error('import_file') is-invalid @enderror"
                                id="import_file" name="import_file" accept=".xlsx,.xls">
                            @error('import_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload me-1"></i> อัปโหลดและดูตัวอย่าง
                        </button>
                    </form>
                </div>
            </div>

            {{-- Preview Table --}}
            @if (count($previewData) > 0)
                @php
                    $requiredHeaders = ['username', 'password', 'prefix_id', 'first_name', 'last_name', 'department_id', 'position_id'];
                    $processedPreview = [];
                    $hasIncompleteRows = false;
                    foreach ($previewData as $idx => $previewRow) {
                        $missing = [];
                        foreach ($requiredHeaders as $requiredHeader) {
                            $value = $previewRow[$requiredHeader] ?? null;
                            if (is_string($value)) {
                                $value = trim($value);
                            }
                            if ($value === '' || $value === null) {
                                $missing[] = $requiredHeader;
                            }
                        }
                        if (!empty($missing)) {
                            $hasIncompleteRows = true;
                        }
                        $processedPreview[$idx] = [
                            'row' => $previewRow,
                            'missing' => $missing,
                        ];
                    }
                @endphp

                <form action="{{ route('importdata.save') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <p class="mb-0 fs-5">ตัวอย่างข้อมูลที่นำเข้า ({{ count($previewData) }} แถว)</p>
                            <button type="submit" class="btn btn-success" {{ $hasIncompleteRows ? 'disabled' : '' }}
                                @if ($hasIncompleteRows) title="กรุณาเติมข้อมูลให้ครบทุกคอลัมน์ที่จำเป็นก่อน" @endif>
                                <i class="bi bi-save me-1"></i> Save
                            </button>
                        </div>
                        <div class="card-body">
                            @if (session('import_errors'))
                                <div class="alert alert-warning">
                                    <p class="mb-1">บันทึกรายการบางส่วนไม่สำเร็จ:</p>
                                    <ul class="mb-0 ps-3">
                                        @foreach (session('import_errors') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if ($hasIncompleteRows)
                                <div class="alert alert-warning">
                                    พบแถวที่มีข้อมูลไม่ครบถ้วน (ยกเว้น citizen_id) กรุณาตรวจสอบและแก้ไขก่อนบันทึก
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            @foreach ($previewHeaders as $header)
                                                <th>{{ $header }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($processedPreview as $index => $rowInfo)
                                            @php
                                                $rowNumber = $index + 1;
                                                $rowData = $rowInfo['row'];
                                                $missingHeaders = $rowInfo['missing'];
                                            @endphp
                                            <tr class="{{ empty($missingHeaders) ? '' : 'table-warning' }}">
                                                <td>{{ $rowNumber }}</td>
                                                @foreach ($previewHeaders as $header)
                                                    @php
                                                        $cellValue = $rowData[$header] ?? '';
                                                        $isMissing = in_array($header, $missingHeaders, true);
                                                    @endphp
                                                    <td class="{{ $isMissing ? 'table-danger' : '' }}">{{ $cellValue }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            @endif

        </div>
    </div>
@endsection
