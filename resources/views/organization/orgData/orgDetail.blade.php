@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('หน่วยงาน') }}</p>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <p>ชื่อหน่วยงาน : {{ $org->name }}</p>
                    </div>
                </div>

                {{-- Branch Card --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('สาขา') }}</p>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#createBrnModal">
                                เพิ่ม
                            </button>
                        </div>
                    </div>
                    <!-- Create Modal -->
                    <div class="modal fade" id="createBrnModal" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="createBrnModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="createBrnModalLabel">เพิ่มสาขา</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('org.store.brn') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="brnName" class="form-label">ชื่อสาขา</label>
                                            <input type="text" class="form-control" maxlength="150" id="brnName" name="brnName"
                                                placeholder="กรุณากรอกชื่อสาขา" required>
                                        </div>

                                        <input type="hidden" name="orgId" value="{{ $org->id }}">
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
                        @if (session('brnSuccess'))
                            <div class="alert alert-success" role="alert">
                                {{ session('brnSuccess') }}
                            </div>
                        @elseif (session('brnError'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('brnError') }}
                            </div>
                        @endif

                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ชื่อสาขา</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brns as $index => $brn)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $brn->name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#updateBrnModal{{ $index }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm delete-orgdata-btn"
                                                del-id="{{ $brn->id }}" del-target="branch"
                                                ><i
                                                    class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <!-- Update Modal -->
                                    <div class="modal fade" id="updateBrnModal{{ $index }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateBrnModalLabel{{ $index }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="updateBrnModalLabel{{ $index }}">แก้ไขสาขา</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('org.update.brn', ['brnId' => $brn->id]) }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="brnName" class="form-label">ชื่อสาขา</label>
                                                            <input type="text" class="form-control" id="brnName" value="{{ $brn->name }}"
                                                                name="brnName" placeholder="กรุณากรอกชื่อสาขา" required>
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
                </div> {{-- End Branch Card --}}

                {{-- Department Card --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ฝ่าย') }}</p>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#updateDpmModal">
                                เพิ่ม
                            </button>
                        </div>
                    </div>
                    <!-- Create Modal -->
                    <div class="modal fade" id="updateDpmModal" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="updateDpmModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="updateDpmModalLabel">เพิ่มฝ่าย</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('org.store.dpm') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="dpmName" class="form-label">ชื่อฝ่าย</label>
                                            <input type="text" class="form-control" maxlength="150" id="dpmName" name="dpmName"
                                                placeholder="กรุณากรอกชื่อฝ่าย" required>
                                        </div>

                                        <select class="form-select" aria-label="Default select example" name="brnId" required>
                                            <option selected disabled>เลือกสาขา</option>
                                            @foreach ($brns as $brn)
                                                <option value="{{ $brn->id }}">{{ $brn->name }}</option>
                                            @endforeach
                                        </select>
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
                        @if (session('dpmSuccess'))
                            <div class="alert alert-success" role="alert">
                                {{ session('dpmSuccess') }}
                            </div>
                        @elseif (session('dpmError'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('dpmError') }}
                            </div>
                        @endif

                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ชื่อฝ่าย</th>
                                    <th scope="col">สาขา</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dpms as $index => $dpm)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $dpm->name }}</td>
                                        <td>{{ optional($dpm->getBrn)->name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#updateDpmModal{{ $index }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm delete-orgdata-btn"
                                                del-id="{{ $dpm->id }}" del-target="department"
                                                ><i
                                                    class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <!-- Update Modal -->
                                    <div class="modal fade" id="updateDpmModal{{ $index }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateDpmModalLabel{{ $index }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="updateDpmModalLabel{{ $index }}">แก้ไขสาขา</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('org.update.dpm', ['dpmId' => $dpm->id]) }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="dpmName" class="form-label">ชื่อฝ่าย</label>
                                                            <input type="text" class="form-control" id="dpmName" value="{{ $dpm->name }}"
                                                                name="dpmName" placeholder="กรุณากรอกชื่อฝ่าย" required>
                                                        </div>

                                                        <select class="form-select" aria-label="Default select example" name="brnId" required>
                                                            <option selected disabled>เลือกสาขา</option>
                                                            @foreach ($brns as $brn)
                                                                <option value="{{ $brn->id }}" {{ $dpm->brn_id === $brn->id ? 'selected' : '' }}>{{ $brn->name }}</option>
                                                            @endforeach
                                                        </select>
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
            </div>
        </div>
    </div>
@endsection
