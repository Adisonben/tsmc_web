<div>
    @if ($error)
        <div class="alert alert-danger" role="alert">
            {{ $error }}
        </div>
    @endif
    <form wire:submit.prevent="updateUser">
        @csrf

        <div class="row mb-3">
            <div class="col">
                <label for="username" class="form-label">ชื่อผู้ใช้</label>
                <input type="text" maxlength="150" class="form-control" id="username" name="username" wire:model="username"
                    placeholder="กรุณากรอกชื่อผู้ใช้" required>
            </div>

            <div class="col">
                <label for="password" class="form-label">รหัสผ่าน (หากไม่กรอก จะใช้รหัสผ่านเดิม)</label>
                <input type="text" maxlength="20" minlength="8" class="form-control" id="password" name="password" wire:model="password"
                    placeholder="กรุณากรอกรหัสผ่าน">
                <div id="passwordHelpBlock" class="form-text">
                    รหัสผ่านต้องมีความยาว 8-20 ตัวอักษร ประกอบด้วยตัวอักษรและตัวเลข
                    และห้ามมีช่องว่าง หรืออักขระพิเศษ
                </div>
            </div>
        </div>

        <hr>

        <div class="row g-3 mb-3">
            <div class="col-md-2">
                <label for="prefix_id" class="form-label">คำนำหน้า</label>
                <select id="prefix_id" class="form-select" wire:model="prefix_id" required>
                    <option selected>เลือกคำนำหน้า</option>
                    @if ($prefixes)
                        @foreach ($prefixes as $pref)
                            <option value="{{ $pref->id }}">{{ $pref->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-5">
                <label for="fname" class="form-label">ชื่อ</label>
                <input type="text" class="form-control" maxlength="150" wire:model="fname" id="fname" required placeholder="กรุณากรอกชื่อ {{ $prefix_id }}">
            </div>
            <div class="col-md-5">
                <label for="lname" class="form-label">นามสกุล</label>
                <input type="text" class="form-control" maxlength="150" id="lname" wire:model="lname" required placeholder="กรุณากรอกนามสกุล">
            </div>

            <div class="col-md-4">
                <label for="userOrg" class="form-label">หน่วยงาน</label>
                <select id="userOrg" class="form-select" wire:model="org_id" wire:change="selectedOrgId" required>
                    <option selected>เลือกหน่วยงาน</option>
                    @foreach ($orgs as $org)
                        <option value="{{ $org->id }}">{{ $org->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="userBrn" class="form-label">สาขา</label>
                <select id="userBrn" class="form-select" wire:model="branch_id" wire:change="selectedBranchId" required
                    {{ $brns ? '' : 'disabled' }}>
                    <option selected>เลือกสาขา</option>
                    @if ($brns)
                        @foreach ($brns as $brn)
                            <option value="{{ $brn->id }}">{{ $brn->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-4">
                <label for="userDpm" class="form-label">ฝ่าย</label>
                <select id="userDpm" class="form-select" wire:model="department_id" required
                    {{ $dpms ? '' : 'disabled' }}>
                    <option selected>เลือกฝ่าย</option>
                    @if ($dpms)
                        @foreach ($dpms as $dpm)
                            <option value="{{ $dpm->id }}">{{ $dpm->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="col-md-12">
                <label for="userPosit" class="form-label">ตำแหน่ง</label>
                <select id="userPosit" class="form-select" wire:model="position_id" required>
                    <option selected>เลือกตำแหน่ง</option>
                    @if ($positions)
                        @foreach ($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mb-3">บันทึก</button>
    </form>
</div>
