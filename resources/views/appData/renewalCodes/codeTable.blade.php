@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('รหัสต่ออายุ') }}</p>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#createCodeModal">
                                <i class="bi bi-plus"></i> เพิ่ม
                            </button>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="createCodeModal" tabindex="-1" aria-labelledby="createCodeModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="createCodeModalLabel">สร้าง Code</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('renewal_codes.store') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <ol class="bg-info text-white py-2 px-4 rounded">
                                                <li>- จำนวนวันที่เพิ่มหลังจากใช้ code คือ 30 วัน</li>
                                            </ol>
                                        </div>
                                        <div class="mb-3">
                                            <label for="code" class="form-label">Code</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="createInputCode" placeholder="กรอก code ที่ต้องการสร้าง" aria-label="กรอก code ที่ต้องการสร้าง" name="code" required aria-describedby="generateBtn">
                                                <button class="btn btn-outline-secondary" type="button" id="generateBtn">Generate</button>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="max_uses" class="form-label">จำนวนการใช้งาน (ครั้ง)</label>
                                            <input type="number" class="form-control" id="max_uses" placeholder="กรอกจำนวนการใช้งาน" name="max_uses" value="1" min="0" max="100" step="1" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="expires_at" class="form-label">วันหมดอายุ</label>
                                            <input type="date" class="form-control" id="expires_at" placeholder="กรอกวันหมดอายุ" name="expires_at" value="{{ \Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('vehicleSuccess'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @elseif (session('vehicleError'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @elseif ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">จำนวนการใช้</th>
                                    <th scope="col">วันหมดอายุ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($codes ?? []) > 0)
                                    @foreach ($codes as $index => $code)
                                        @php
                                            $expire_date = new Carbon\Carbon($code->expires_at);
                                            $diffDay = $expire_date->diff(Carbon\Carbon::now());
                                        @endphp
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $code->code }}</td>
                                            <td>{{ $code->usages()->count() }} / {{ $code->max_uses }}</td>
                                            <td> {{ $expire_date->thaidate('j M Y') }}
                                                (
                                                @if ($diffDay->invert === 1)
                                                    <span class="text-success">{{ $diffDay->d }} วัน</span>
                                                @else
                                                    <span class="text-danger">หมดอายุแล้ว</span>
                                                @endif
                                                )
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">ไม่มีข้อมูล</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('generateBtn').addEventListener('click', function () {
                // Function to generate a random code
                function generateRenewalCode(length = 10) {
                    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                    let code = '';
                    for (let i = 0; i < length; i++) {
                        code += chars.charAt(Math.floor(Math.random() * chars.length));
                    }
                    return code;
                }

                // Generate the code and insert into input
                const code = generateRenewalCode();
                document.getElementById('createInputCode').value = code;
            });
        </script>
    </div>
@endsection
