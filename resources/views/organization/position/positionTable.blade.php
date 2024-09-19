@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">

                {{-- Position table Card --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ตำแหน่ง') }}</p>
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
                                                @foreach ($positions as $position)
                                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">ปิด</button>
                                        <button type="submit" class="btn btn-primary">บันทึก</button>
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
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($positions as $index => $position)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $position->name }}</td>
                                        <td>
                                            {{-- @php
                                                dd([Auth()->user()->userDetail->getPosition->id, ...$position->descendants()->pluck('id')]);
                                            @endphp --}}
                                            {{ $position->descendants()->pluck('id') }}
                                            @if ($position->org ?? false || Auth()->user()->userDetail->fname === "admin")
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#updatePositModal{{ $index }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm delete-data-btn" {{ $position->created_by ? '' : 'disabled' }}
                                                    del-id="{{ $position->id }}" del-target="positions"
                                                    data-bs-toggle="tooltip" data-bs-title="ลบ"><i
                                                        class="bi bi-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <!-- Update Modal -->
                                    <div class="modal fade" id="updatePositModal{{ $index }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="updatePositModalLabel{{ $index }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="updatePositModalLabel{{ $index }}">แก้ไขตำแหน่ง
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('positions.update.post', ['position' => $position->id]) }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        {{-- <div class="mb-3">
                                                            <label for="positDpm" class="form-label">แผนก</label>
                                                            <select class="form-select" aria-label="Default select example" id="positDpm"
                                                                name="positDpm" required>
                                                                <option selected disabled value="">เลือกแผนก</option>
                                                                @foreach ($dpms as $dpm)
                                                                    <option value="{{ $dpm->id }}" {{ $dpm->id == $position->dpm ? 'selected' : '' }}>{{ $dpm->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div> --}}
                                                        <div class="mb-3">
                                                            <label for="positName" class="form-label">ชื่อตำแหน่ง</label>
                                                            <input type="text" class="form-control" maxlength="150"
                                                                id="positName" name="positName" value="{{ $position->name }}"
                                                                placeholder="กรุณากรอกชื่อตำแหน่ง" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="parent"
                                                                class="form-label">อยู่ภายใต้ตำแหน่ง</label>
                                                            <select class="form-select"
                                                                aria-label="Default select example" id="parent"
                                                                name="parent" required>
                                                                <option selected value="-">ไม่มี</option>
                                                                @foreach ($positions as $positOp)
                                                                    <option value="{{ $positOp->id }}" {{ $position->parent_id == $positOp->id ? 'selected' : '' }}>
                                                                        {{ $positOp->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">ปิด</button>
                                                        <button type="submit" class="btn btn-primary">บันทึก</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> {{-- End Department Card --}}
                <div class="d-flex justify-content-center w-100">
                    <img src="/images/assets/position_diagram.png" class="object-fit-contain mw-100" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection
