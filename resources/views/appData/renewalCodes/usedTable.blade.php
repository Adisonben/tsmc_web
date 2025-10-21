@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ประวัติการใช้งานรหัสต่ออายุ') }}</p>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">ผู้ใช้งาน</th>
                                    <th scope="col">วันที่ใช้งาน</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @php
                                    dd($renewalCode->usages);
                                @endphp --}}
                                @if (count($renewalCode->usages ?? []) > 0)
                                    @foreach ($renewalCode->usages as $index => $code_usage)
                                        @php
                                            $used_date = new Carbon\Carbon($code_usage->created_at);
                                            $diffDay = $used_date->diff(Carbon\Carbon::now());
                                        @endphp
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $code_usage->renewalCode->code }}</td>
                                            <td>{{ $code_usage->getTargetName() }}</td>
                                            <td> {{ $used_date->thaidate('j M Y เวลา H:m:s') }} (<span class="text-success">{{ $diffDay->d }} วันที่แล้ว</span>)
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
    </div>
@endsection
