@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('การอนุญาต') }}</p>
                        </div>
                    </div>

                    <div class="card-body px-md-5">
                        <form action="" method="post">
                            @csrf

                            @foreach ($positions as $index => $posit)
                                {{-- @php
                                    dd($posit->hasPermission(2, optional(Auth::user()->userDetail)->org)->pivot->status);
                                @endphp --}}
                                <div class="mb-3">
                                    <p class="fw-bold">{{ $posit->name }}</p>
                                    <div class="d-flex flex-wrap gap-md-3 px-md-4">
                                        @foreach ($posit_perms as $perm)
                                            <div class="form-check">
                                                @php
                                                    $posit_perm = $posit->hasPermission($perm->id, optional(Auth::user()->userDetail)->org) ?? $posit->hasPermission($perm->id);
                                                @endphp
                                                <input class="form-check-input permCheck" type="checkbox"
                                                    posit-id="{{ $posit->id }}" value="{{ $perm->id }}" id="perm{{ $perm->id }}{{ $posit->id }}"
                                                    {{ $posit_perm->pivot->status ?? false ? "checked" : '' }}
                                                    >
                                                <label class="form-check-label" for="perm{{ $perm->id }}{{ $posit->id }}">
                                                    {{ $perm->label }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.permCheck').change(function() {
                var selectedValue = $(this).val();
                let positId = $(this).attr('posit-id');
                var isChecked = $(this).is(':checked');
                console.log(selectedValue, positId, isChecked)
                fetch(`/position-permission/update/${positId}/${selectedValue}/${isChecked}`)
                .then(response => {
                    // Check if the response was successful (status code 200)
                    if (!response.ok) {
                        throw new Error(`Network response was not ok (status ${response.status})`);
                    }
                    return response.json(); // Parse the JSON response
                    })
                .then(data => {
                    // Process the fetched data
                    // console.log(data);
                    console.log("Update success.")
                    // Update the DOM with the data (example)
                    // $('#result').text(data.message);
                })
                .catch(error => {
                    // Handle errors that occurred during the fetch process
                    console.error('Error fetching data:', error);
                    // Display an error message to the user (optional)
                    // $('#error').text('An error occurred while fetching data.');
                });
            });
        });
    </script>
@endsection
