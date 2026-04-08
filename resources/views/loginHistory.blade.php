@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ประวัติการเข้าใช้ระบบ') }} {{ Auth::user()->full_name }}</p>
                        </div>
                    </div>

                    <div class="card-body overflow-auto">
                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ชื่อ</th>
                                    <th scope="col">วันที่</th>
                                    <th scope="col">Ip</th>
                                    <th scope="col">Agent</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($histories && $histories->count() > 0)

                                    @foreach ($histories as $index => $history)
                                        @php
                                            $createdDate = new Carbon\Carbon($history->created_at);
                                        @endphp
                                        <tr>
                                            <td>{{ (($histories->currentPage()-1) * 10) + ($index+1) }}</td>
                                            <td>{{ $history->getUser->full_name }}</td>
                                            <td>{{ $createdDate->thaidate('j F Y \\เวลา H:i:s') }}</td>
                                            <td>{{ $history->ip_address }}</td>
                                            <td>{{ $history->agent }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">ไม่พบข้อมูล</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{ $histories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        #loginHistoryPage {
            background-color: var(--main-color);
        }
    </style>
@endsection
