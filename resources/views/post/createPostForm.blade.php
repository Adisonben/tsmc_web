@extends('layouts.app')
@push('scripts')
    @vite(['resources/js/post.js'])

    <script src="https://unpkg.com/slim-select@latest/dist/slimselect.min.js"></script>
    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet"></link>
@endpush
@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('โพสข้อความ / ประกาศ') }}</p>
                            <a href="/home" class="btn btn-secondary btn-sm">ย้อนกลับ</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                                {{-- "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง" --}}
                            </div>
                        @endif
                        @if ($errors->has('orgLogo'))
                            <div class="alert alert-danger">
                                {{ $errors->first('orgLogo') }}
                            </div>
                        @endif
                        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="postContent" class="form-label">ข้อความ</label>
                                <textarea class="form-control" maxlength="1000" id="postContent" name="postContent" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="postColor" class="form-label">ธีมสี</label>
                                <input type="color" class="form-control form-control-color" id="postColor"
                                    name="postColor" value="#ffffff" title="Choose your color" required>
                            </div>

                            <div class="mb-3">
                                <label for="postPerm" class="form-label">สิทธื์การเข้าถึง</label>
                                <select class="form-select" id="postPerm" name="postPerm" aria-label="Default select example">
                                    @foreach ($post_perms as $post_perm)
                                        <option value="{{ $post_perm->name }}">{{ $post_perm->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3" id="dpmTarget" hidden>
                                <label for="dpmPermTarget" class="form-label">ขอบเขตการเข้าถึง</label>
                                <select class="form-select" id="dpmPermTarget" name="dpmPermTarget[]" multiple>
                                    @foreach ($dpms as $dpm)
                                        <option value="{{ $dpm->id }}">{{ $dpm->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3" id="positTarget" hidden>
                                <label for="positPermTarget" class="form-label">ขอบเขตการเข้าถึง</label>
                                <select class="form-select" id="positPermTarget" name="positPermTarget[]" multiple>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3" id="userTarget" hidden>
                                <label for="userPermTarget" class="form-label">ขอบเขตการเข้าถึง</label>
                                <select class="form-select" id="userPermTarget" name="userPermTarget[]" multiple>
                                    @foreach ($user_list as $userdetail)
                                        <option value="{{ $userdetail->user_id }}">
                                            {{ optional($userdetail->getPrefix)->name . $userdetail->fname . ' ' . $userdetail->lname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="orgTheme" class="form-label">แนบไฟล์</label>
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
            $('#postPerm').change(function() {
                var selectedValue = $(this).val();
                switch (selectedValue) {
                    case "ฝ่าย":
                        $('#positTarget').attr('hidden', 'hidden');
                        $('#userTarget').attr('hidden', 'hidden');
                        $('#dpmTarget').removeAttr('hidden');
                        break;
                    case "ตำแหน่ง":
                        $('#dpmTarget').attr('hidden', 'hidden');
                        $('#userTarget').attr('hidden', 'hidden');
                        $('#positTarget').removeAttr('hidden');
                        break;
                    case "บุคคล":
                        $('#dpmTarget').attr('hidden', 'hidden');
                        $('#positTarget').attr('hidden', 'hidden');
                        $('#userTarget').removeAttr('hidden');
                        break;

                    default:
                        $('#dpmTarget').attr('hidden', 'hidden');
                        $('#positTarget').attr('hidden', 'hidden');
                        $('#userTarget').attr('hidden', 'hidden');
                        break;
                }
            });
        });

        new SlimSelect({
            select: '#dpmPermTarget',
            settings: {
                hideSelected: true,
                placeholderText: 'เลือกฝ่าย',
            }
        })
        new SlimSelect({
            select: '#userPermTarget',
            settings: {
                hideSelected: true,
                placeholderText: 'เลือกผู้ใช้',
            }
        })
        new SlimSelect({
            select: '#positPermTarget',
            settings: {
                hideSelected: true,
                placeholderText: 'เลือกตำแหน่ง',
            }
        })
    </script>
@endsection
<style>

</style>
