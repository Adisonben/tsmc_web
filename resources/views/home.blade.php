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
                        <a href="{{ route('posts.create') }}" class="w-100"><input type="text" class="form-control rounded-pill" style="cursor: pointer" id="exampleFormControlInput1" placeholder="เขียนข้อความ หรือ ประกาศ" readonly></a>
                    </div>
                </div>
            </div>

            {{-- Post Card --}}
            @if ($posts)
                @foreach ($posts as $post)
                    <div class="card rounded-5 mb-3">
                        <div class="card-header" style="background-color: {{ $post->theme_color ?? '#F1F3F5' }}">
                            <div class="d-flex gap-2">
                                <div class="d-flex gap-2">
                                    @if (($post->getUser->icon ?? false) && file_exists(public_path('uploads/userImages/' . $post->getUser->icon)))
                                        <img src="/uploads/userImages/{{ $post->getUser->icon }}" class="object-fit-cover rounded-circle" width="40" height="40" alt="">
                                    @else
                                        <img src="/images/icons/tsmc_logo.png" class="object-fit-contain" width="40" alt="">
                                    @endif
                                </div>
                                <div class="px-2 rounded-2" style="background-color: rgba(255, 255, 255, .6)">
                                    <p class="mb-0 fw-bold fs-6">{{ optional($post->getUser->getPrefix)->name . optional($post->getUser)->fname }} {{ optional($post->getUser)->lname }}</p>
                                    <p class="mb-0" style="font-size: .8rem">{{ optional($post->getUser->getPosition)->name ?? '-' }} | <i class="bi bi-clock"></i> {{ $post->updated_at }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            {!! $post->content !!}
                        </div>
                        <div class="card-footer px-4">
                            @php
                                $comments = $post->comments;
                            @endphp
                            @if (count($comments ?? []) > 0)
                                @foreach ($comments as $comment)
                                    <div class="d-flex gap-3 mb-2">
                                        <div class="d-flex gap-2">
                                            @if ((optional($comment->getUser->userDetail)->icon ?? false) && file_exists(public_path('uploads/userImages/' . optional($comment->getUser->userDetail)->icon)))
                                                <img src="/uploads/userImages/{{ optional($comment->getUser->userDetail)->icon }}" class="object-fit-cover rounded-circle" width="35" height="35" alt="">
                                            @else
                                                <img src="/images/icons/tsmc_logo.png" class="object-fit-contain" width="30" alt="">
                                            @endif
                                        </div>
                                        <div>
                                            <div class="d-flex gap-2">
                                                <p class="mb-0 fw-bold" style="font-size: .8rem">{{ optional($comment->getUser)->full_name }}</p>
                                                <p class="mb-0" style="font-size: .6rem">{{ optional($comment->getUser->getPosition)->name }} | <i style="font-size: .6rem" class="bi bi-clock"></i> {{ $comment->updated_at }}</p>
                                            </div>
                                            {{ $comment->content }}
                                        </div>
                                        <div class="ms-auto" {{ Auth::user()->id == $comment->user_id ? '' : 'hidden' }}>
                                            <button class="btn btn-sm btn-danger delete-comment-btn" del-id="{{ $comment->id }}"><i class="bi bi-trash"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <form class="commentForm" method="POST">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->post_id }}" id="">
                                <div class="d-flex gap-3">
                                    <div class="d-flex gap-2">
                                        @if (( optional(Auth::user()->userDetail)->icon ?? false) && file_exists(public_path('uploads/userImages/' . optional(Auth::user()->userDetail)->icon)))
                                            <img src="/uploads/userImages/{{ optional(Auth::user()->userDetail)->icon }}" class="object-fit-cover rounded-circle" width="35" height="35" alt="">
                                        @else
                                            <img src="/images/icons/tsmc_logo.png" class="object-fit-contain" width="30" alt="">
                                        @endif
                                    </div>
                                    <input type="text" class="form-control rounded-pill" id="postComment" name="postComment" placeholder="เขียนความคิดเห็น..." required>
                                    <button class="btn btn-primary btn-sm" type="submit"><i class="bi bi-send"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-cemter d-flex justify-content-center"><span class="badge text-bg-secondary">ไม่มีโพสในขณะนี้</span></div>
            @endif
        </div>
    </div>
</div>
@endsection
