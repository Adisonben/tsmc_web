@extends('layouts.app')

@section('content')
<div class="" x-data="formBuilder()">
    <div class="row justify-content-center">
        <div class="px-3 px-md-5">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 fs-4">หลักสูตรความรู้ออนไลน์</p>
                        @if (session('formTableError'))
                            <div class="alert alert-danger m-0 py-2" role="alert">
                                {{ session('formTableError') }}
                            </div>
                        @endif
                        <div></div>
                    </div>
                </div>

                <div class="card-body px-md-5">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 gap-3">
                        @php
                            $header_colors = ["#007bff", "#28a745", "#fd7e14", "#6f42c1", "#e83e8c"];
                        @endphp

                        <!-- Loop through courses dynamically -->
                        <template x-for="course in courses" :key="course.id">
                            <a :href="'https://smarthub.trainingzenter.com/learn-from-tsmc/' + course.id
                                + '?name={{ urlencode(Auth::user()->getFullNameAttribute() ?? '') }}'
                                + '&username={{ urlencode(Auth::user()->username ?? '') }}'
                                + '&org={{ urlencode(Auth::user()->getOrgNameAttribute() ?? '') }}'
                                + '&is_tsm={{ urlencode(Auth::user()->is_tsm ?? '0') }}'"
                                target="_blank" class="card border-primary" style="width: 20rem;"
                            >
                                <div class="bg-secondary w-100">
                                    <img
                                        :src="course.img
                                            ? 'https://smarthub.trainingzenter.com/uploads/course_imgs/' + course.img
                                            : 'https://smarthub.trainingzenter.com/img/logo.png'"
                                        class="card-img-top object-fit-contain"
                                        height="200"
                                        alt="Course Image">
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title" x-text="course.title"></h5>
                                    <p class="card-text" x-text="course.description"></p>
                                    {{-- <a :href="`/courses/${course.id}`" class="btn btn-primary">ดูรายละเอียด</a> --}}
                                </div>
                                {{-- <div class="card-footer">
                                    <a :href="`/courses/${course.id}`" target="_blank" class="btn btn-sm btn-primary w-100">ดูรายละเอียด</a>
                                </div> --}}
                            </a>
                        </template>

                        <!-- Example static card (if API is empty) -->
                        <div x-show="courses.length === 0">
                            <p>ไม่พบหลักสูตร</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function formBuilder() {
    return {
        courses: [],

        init() {
            this.fetchCourses();
        },

        fetchCourses() {
            fetch('https://smarthub.trainingzenter.com/api/agn-course/16', {
                method: 'GET',
                headers: {
                    Authorization: 'Bearer 1|mbWkSsSxYtu0B7w0hX3mhTGW6urVt2Gk0DSm8cblfafee533'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.courses = Array.isArray(data) ? data : [data];
                console.log("Fetch success: ", this.courses);
            })
            .catch(error => {
                console.error('Error fetching courses:', error);
            });
        }
    }
}
</script>

<style>
    #elearningPage {
        background-color: var(--main-color);
    }

    .card-text {
        display: -webkit-box;
        -webkit-line-clamp: 2; /* จำกัด 3 บรรทัด */
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
