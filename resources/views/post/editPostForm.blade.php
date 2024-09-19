@extends('layouts.app')
@push('scripts')
    @vite(['resources/js/post.js'])
@endpush
@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('แก้ไขโพสข้อความ / ประกาศ') }}</p>
                            <a href="/home" class="btn btn-secondary btn-sm">ย้อนกลับ</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{-- {{ session('error') }} --}}
                                เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง
                            </div>
                        @endif
                        @if ($errors->has('orgLogo'))
                            <div class="alert alert-danger">
                                {{ $errors->first('orgLogo') }}
                            </div>
                        @endif
                        <form action="{{ route('posts.getUpdate', ['post' => $postData->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="postContent" class="form-label">ข้อความ</label>
                                <textarea class="form-control" maxlength="1000" id="postContent" name="postContent" rows="3" required>{{ $postData->content }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="postColor" class="form-label">ธีมสี</label>
                                <input type="color" class="form-control form-control-color" id="postColor" name="postColor" value="{{ $postData->theme_color ? $postData->theme_color : "#ffffff" }}" title="Choose your color" required>
                            </div>

                            {{-- <div class="mb-3">
                                <label for="orgTheme" class="form-label">ไฟล์เอกสาร</label>
                                <input class="form-control" type="file" id="formFile" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="orgLogo" class="form-label">ไฟล์ภาพ (ขนาดไฟล์ละไม่เกิน 2 MB)</label>
                                <input class="form-control" type="file" id="orgLogo" name="orgLogo" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="postPerm" class="form-label">สิทธื์การเข้าถึง</label>
                                <select class="form-select" id="postPerm" aria-label="Default select example" disabled>
                                    @foreach ($post_perms as $post_perm)
                                        <option value="{{ $post_perm->name }}">{{ $post_perm->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div class="mb-3" id="targetSelect">

                            </div>

                            <div class="mb-3">
                                <p class="mb-0">ไฟล์แนบ</p>
                                <ol class="list-group-numbered">
                                    @foreach ($postData->getMedias ?? [] as $media)
                                        <li class="list-group-item">
                                            <a href="">{{ $media->originalName }}</a>
                                            <input type="hidden" value="{{ $media->id }}" name="oldMedia[]">
                                            <button type="button" class="btn btn-sm delFile"><i class="bi bi-x-lg"></i></button>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>

                            <div class="mb-3">
                                <label for="orgTheme" class="form-label">แนบไฟล์เพิ่มเติม</label>
                                <input class="form-control filepond" type="file" id="docFileUpload" multiple
                                    data-max-file-size="5MB">
                            </div>

                            <button type="submit" class="btn btn-primary mb-3">โพสต์</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.delFile').click(function() {
                $(this).closest('li').remove();
            });
        });
    </script>
@endsection
