@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ทะเบียน') }} บันทึกประวัติการบำรุงรักษาและซ่อมรถ</p>
                            <div>
                                <a href="{{ route('form.create.repair.history') }}" class="btn btn-primary btn-sm">
                                    เพิ่ม
                                </a>
                                <a href="{{ route('form.export', ['formCode' => "TSM-V-002"]) }}" class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" data-bs-title="ออกรายงาน"><i class="bi bi-file-pdf"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">วันที่</th>
                                        <th scope="col">เลขที่ใบสั่งซ่อม</th>
                                        <th scope="col">ทะเบียนรถ</th>
                                        <th scope="col">รายการซ่อม</th>
                                        <th scope="col">ราคาค่าซ่อมรวม</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($repairHistories ?? []) > 0)
                                        @foreach ($repairHistories as $index => $repairHistorie)
                                            @php
                                                $createdDate = new Carbon\Carbon($repairHistorie->created_at);
                                            @endphp
                                            <tr>
                                                <td>{{ $createdDate->thaidate('j M Y') }}</td>
                                                <td>{{ $repairHistorie->order_num }}</td>
                                                <td>{{ $repairHistorie->car_plate }}</td>
                                                <td>{{ count($repairHistorie->getRepairList ?? []) }} รายการ</td>
                                                <td>{{ number_format($repairHistorie->cost_amount, 0, '.', ',') }} บาท</td>
                                                {{-- @php
                                                    $receiveDate = new Carbon\Carbon($dailywork->receive_date);
                                                    $dropDate = new Carbon\Carbon($dailywork->drop_date);
                                                    // dd($receiveDate->format('j M Y H:i:s'));
                                                @endphp
                                                <td>{{ $receiveDate->thaidate('j M Y \\เวลา H:i') }}</td>
                                                <td>{{ $dropDate->thaidate('j M Y \\เวลา H:i') }}</td> --}}
                                                {{-- <td>
                                                    @if ($dailywork->status)
                                                        <span class="badge text-bg-success">ดำเนินการสำเร็จ</span>
                                                    @else
                                                        <span class="badge text-bg-warning">กำลังดำเนินการ</span>
                                                    @endif
                                                </td> --}}
                                                <td>
                                                    <a href="{{ route('form.delete.repair.history', ['fid' => $repairHistorie->id]) }}" class="btn btn-danger btn-sm">ลบ</a>
                                                    <a href="{{ route('form.detail.repair.history', ['fid' => $repairHistorie->id]) }}" class="btn btn-primary btn-sm" >รายละเอียด</a>
                                                    {{-- <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#editDailywork{{ $dailywork->id }}">
                                                        @if ($dailywork->status)
                                                            รายละเอียด
                                                        @else
                                                            จัดการ
                                                        @endif
                                                    </button>
                                                    @if (!$dailywork->status)
                                                        <a href="{{ route('form.delete.dailywork', ['fid' => $dailywork->id]) }}" class="btn btn-danger btn-sm">ลบ</a>
                                                    @endif --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6"><div class="text-center">ไม่พบเอกสาร</div></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
