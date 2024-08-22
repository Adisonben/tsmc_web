@extends('layouts.app')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="px-3 px-md-5">
            <div class="card rounded-5 mb-3">
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <div class="d-flex gap-2">
                            <img src="/images/icons/tsmc_logo.png" width="40" alt="">
                        </div>
                        <a href="{{ route('posts.index') }}" class="w-100"><input type="text" class="form-control rounded-pill" style="cursor: pointer" id="exampleFormControlInput1" placeholder="เขียนข้อความ หรือ ประกาศ" readonly></a>
                    </div>
                </div>
            </div>

            <div class="card rounded-4 mb-3">
                <div class="card-header">
                    <div class="d-flex gap-3">
                        <div class="d-flex gap-2">
                            <img src="/images/icons/tsmc_logo.png" class="object-fit-contain" width="40" alt="">
                        </div>
                        <div>
                            <p class="mb-0 fw-bold fs-6">{{ Auth::user()->full_name }}</p>
                            <p class="mb-0" style="font-size: .8rem"><i class="bi bi-clock"></i> {{ date('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    Post Content
                </div>
                <div class="card-footer px-4">
                    <div class="d-flex gap-3 mb-2">
                        <div class="d-flex gap-2">
                            <img src="/images/icons/tsmc_logo.png" class="object-fit-contain" width="30" alt="">
                        </div>
                        <div>
                            <div class="d-flex gap-2">
                                <p class="mb-0 fw-bold" style="font-size: .8rem">{{ Auth::user()->full_name }}</p>
                                <p class="mb-0" style="font-size: .6rem"><i style="font-size: .6rem" class="bi bi-clock"></i> {{ date('Y-m-d H:i:s') }}</p>
                            </div>
                            comment contents
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="d-flex gap-2">
                            <img src="/images/icons/tsmc_logo.png" class="object-fit-contain" width="30" alt="">
                        </div>
                        <input type="text" class="form-control rounded-pill" id="exampleFormControlInput1" placeholder="เขียนความคิดเห็น...">
                        <button class="btn btn-primary btn-sm"><i class="bi bi-send"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
