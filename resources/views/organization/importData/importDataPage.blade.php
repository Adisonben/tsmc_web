@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">

                {{-- Position table Card --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('นำเข้าข้อมูล') }}</p>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#createPositModal">
                                เพิ่ม
                            </button>
                        </div>
                    </div>
                    <!-- Create Modal -->
                    <div class="modal fade" id="createPositModal" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="createPositModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="createPositModalLabel">เพิ่มตำแหน่ง</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('positions.store') }}" method="post">
                                    @csrf
                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label for="positName" class="form-label">ชื่อตำแหน่ง</label>
                                            <input type="text" class="form-control" maxlength="150" id="positName"
                                                name="positName" placeholder="กรุณากรอกชื่อตำแหน่ง" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="parent" class="form-label">อยู่ภายใต้ตำแหน่ง</label>
                                            <select class="form-select" aria-label="Default select example" id="parent"
                                                name="parent" required>
                                                <option selected value="-">ไม่มี</option>
                                                {{-- @foreach ($positions as $position)
                                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">ปิด</button>
                                        <button type="submit" class="btn btn-primary" {{ session('org_status') == 2 ? 'disabled' : '' }}>บันทึก</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <div class="card-body">
                        @if (session('positSuccess'))
                            <div class="alert alert-success" role="alert">
                                {{ session('positSuccess') }}
                            </div>
                        @elseif (session('positError'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('positError') }}
                            </div>
                        @endif

                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ชื่อตำแหน่ง</th>
                                    <th scope="col">อยู่ภายใต้ตำแหน่ง</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div> {{-- End Department Card --}}
            </div>
        </div>
    </div>
@endsection
