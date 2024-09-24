@extends('layouts.app')
@push('scripts')
    @vite(['resources/js/post.js'])
@endpush
@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                {{-- @php
                dd((optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_post', optional(Auth::user()->userDetail)->org) ?? false));
            @endphp --}}
                @if (
                    (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                        'can_post',
                        optional(Auth::user()->userDetail)->org) ?? false) || Auth::user()->userDetail->fname === 'admin')
                    <div class="card rounded-5 mb-3">
                        <div class="card-body">
                            <div class="d-flex gap-3">
                                <div class="d-flex gap-2">
                                    <img src="/images/icons/tsmc_logo.png" width="40" alt="">
                                </div>
                                <a href="{{ route('posts.create') }}" class="w-100"><input type="text"
                                        class="form-control rounded-pill" style="cursor: pointer"
                                        id="exampleFormControlInput1" placeholder="เขียนข้อความ หรือ ประกาศ" readonly></a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Post Card --}}
                @if ($posts)
                    @foreach ($posts as $post)
                        <div class="card rounded-5 mb-3">
                            <div class="card-header d-flex justify-content-between"
                                style="background-color: {{ $post->theme_color ?? '#F1F3F5' }}">
                                <div class="d-flex gap-2">
                                    <div class="d-flex gap-2">
                                        @if (($post->getUser->icon ?? false) && file_exists(public_path('uploads/userImages/' . $post->getUser->icon)))
                                            <img src="/uploads/userImages/{{ $post->getUser->icon }}"
                                                class="object-fit-cover rounded-circle" width="40" height="40"
                                                alt="">
                                        @else
                                            <img src="/images/icons/tsmc_logo.png" class="object-fit-contain" width="40"
                                                alt="">
                                        @endif
                                    </div>
                                    @php
                                        $createdDate = new Carbon\Carbon($post->updated_at);
                                        $diffDay = $createdDate->diffInDays(Carbon\Carbon::now());
                                        $diffDate = $createdDate->diffForHumans(Carbon\Carbon::now());
                                    @endphp
                                    <div class="px-2 rounded-2" style="background-color: rgba(255, 255, 255, .6)">
                                        <p class="mb-0 fw-bold fs-6">
                                            {{ optional($post->getUser->getPrefix)->name . optional($post->getUser)->fname }}
                                            {{ optional($post->getUser)->lname }}</p>
                                        <p class="mb-0" style="font-size: .8rem">
                                            {{ optional($post->getUser->getPosition)->name ?? '-' }} | <i
                                                class="bi bi-clock"></i>
                                            {{ $diffDay > 2 ? $createdDate->thaidate('j M Y') : $diffDate }}</p>
                                    </div>
                                </div>
                                <div {{ Auth::user()->id == $post->created_by || Auth::user()->id == 1 ? '' : 'hidden' }}>
                                    <a href="{{ route('posts.edit', ['post' => $post->post_id]) }}"
                                        class="btn btn-secondary btn-sm"><i class="bi bi-pencil-square"></i></a>
                                    <button type="button" class="btn btn-danger btn-sm delete-data-btn"
                                        del-id="{{ $post->id }}" del-target="posts" data-bs-toggle="tooltip"
                                        data-bs-title="ลบ">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    {!! $post->content !!}
                                </div>
                                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 gap-2">
                                    @foreach ($post->getMedias ?? [] as $media)
                                        @if (in_array($media->extension, ['jpg', 'png', 'jpeg']))
                                            <div class="col rounded-4">
                                                {{-- if image --}}
                                                <img src="/{{ $media->folder }}/{{ $media->file_name }}"
                                                    class="object-fit-contain rounded-4" width="100%" height="100%"
                                                    style="max-height: 400px" alt="" data-bs-toggle="modal"
                                                    data-bs-target="#showImageModal{{ $media->id }}">
                                                <!-- Modal -->
                                                <div class="modal fade" id="showImageModal{{ $media->id }}"
                                                    tabindex="-1" aria-labelledby="showImageModalLabel{{ $media->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <img src="/{{ $media->folder }}/{{ $media->file_name }}"
                                                            width="100%" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                {{-- if Document --}}
                                <div class="d-flex mt-2 gap-2">
                                    @foreach ($post->getMedias ?? [] as $media)
                                        @if (in_array($media->extension, ['pdf', 'doc', 'excel']))
                                            <div>
                                                <a href="/{{ $media->folder }}/{{ $media->file_name }}" class="btn btn-info btn-sm" target="_BLANK">{{ $media->originalName }}</a>
                                                {{-- <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#showDocumentModal{{ $media->id }}">
                                                    <i class="bi bi-file-earmark-pdf"></i> {{ $media->originalName }}
                                                </button>
                                                <div class="modal fade" id="showDocumentModal{{ $media->id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="showDocumentModalLabel{{ $media->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <iframe src="/{{ $media->folder }}/{{ $media->file_name }}"
                                                                id="document-frame" frameborder="0"></iframe>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer px-4">
                                @php
                                    $comments = $post->comments;
                                @endphp
                                @if (count($comments ?? []) > 0)
                                    @foreach ($comments as $comment)
                                        <div class="d-flex gap-3 mb-2">
                                            <div class="d-flex gap-2">
                                                @if (
                                                    (optional($comment->getUser->userDetail)->icon ?? false) &&
                                                        file_exists(public_path('uploads/userImages/' . optional($comment->getUser->userDetail)->icon)))
                                                    <img src="/uploads/userImages/{{ optional($comment->getUser->userDetail)->icon }}"
                                                        class="object-fit-cover rounded-circle" width="35"
                                                        height="35" alt="">
                                                @else
                                                    <img src="/images/icons/tsmc_logo.png" class="object-fit-contain"
                                                        width="30" alt="">
                                                @endif
                                            </div>
                                            <div>
                                                <div class="d-flex gap-2">
                                                    <p class="mb-0 fw-bold" style="font-size: .8rem">
                                                        {{ optional($comment->getUser)->full_name }}</p>
                                                    <p class="mb-0" style="font-size: .6rem">
                                                        {{ optional($comment->getUser->getPosition)->name }} | <i
                                                            style="font-size: .6rem" class="bi bi-clock"></i>
                                                        {{ $comment->updated_at }}</p>
                                                </div>
                                                {{ $comment->content }}
                                            </div>
                                            <div class="ms-auto"
                                                {{ Auth::user()->id == $comment->user_id ? '' : 'hidden' }}>
                                                <button class="btn btn-sm btn-danger delete-comment-btn"
                                                    del-id="{{ $comment->id }}"><i class="bi bi-trash"></i></button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <form class="commentForm" method="POST">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->post_id }}" id="">
                                    <div class="d-flex gap-3">
                                        <div class="d-flex gap-2">
                                            @if (
                                                (optional(Auth::user()->userDetail)->icon ?? false) &&
                                                    file_exists(public_path('uploads/userImages/' . optional(Auth::user()->userDetail)->icon)))
                                                <img src="/uploads/userImages/{{ optional(Auth::user()->userDetail)->icon }}"
                                                    class="object-fit-cover rounded-circle" width="35" height="35"
                                                    alt="">
                                            @else
                                                <img src="/images/icons/tsmc_logo.png" class="object-fit-contain"
                                                    width="30" alt="">
                                            @endif
                                        </div>
                                        <input type="text" class="form-control rounded-pill" id="postComment"
                                            name="postComment" placeholder="เขียนความคิดเห็น..." required>
                                        <button class="btn btn-primary btn-sm" type="submit"><i
                                                class="bi bi-send"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-cemter d-flex justify-content-center"><span
                            class="badge text-bg-secondary">ไม่มีโพสในขณะนี้</span></div>
                @endif
            </div>
        </div>
    </div>
    <style>
        #document-frame {
          width: 100%;
          height: 60vh; /* Set height to 60% of viewport height */
        }
    </style>
@endsection
