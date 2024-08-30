<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TSMCDocument</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }
        body {
            font-size: 14px
        }
    </style>
</head>
<body>
    <div class="card" id="printPaper">
        <div class="card-body px-md-5">
            <p class="text-center fs-5 mb-0 fw-bold">{{ $userDetail->getOrg->name }}</p>
            <div class="d-flex justify-content-center"><p class="text-center fw-bold w-75" style="font-size: 16px">{{ $formdata->title }}</p></div>
            <form action="{{ route('form.checked.store') }}" method="post">
                @csrf

                <input type="hidden" name="form_id" value="{{ $formdata->id }}">

                <div class="row g-3 align-items-center mb-4">
                    <div class="col-12 col-md-6">
                      <p class="mb-0">ชื่อพนักงานขับรถ : <span class="fw-bold"><u>{{ $form_resp->getUser->full_name }}</u></span></p>
                    </div>
                    <div class="col-12 col-md-6">
                      <p class="mb-0">ทะเบียนรถ : <span class="fw-bold"><u>{{ $header_data->car_plate }}</u></span></p>
                    </div>
                    <div class="col-12 col-md-6">
                      <p class="mb-0">วันที่ : <span class="fw-bold"><u>{{ $form_resp->updated_at }}</u></span></p>
                    </div>
                </div>

                <div>
                    <table class="table table-hover table-bordered">
                        <thead class="text-center table-secondary">
                            <tr>
                                <th>เกณฑ์การพิจารณา</th>
                                <th>ผลการตรวจสอบ</th>
                                <th>Comment</th>
                                {{-- <th>ผลคะแนน</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quest_groups as $group)
                                <tr><td colspan="4">{{ $group->title }}</td></tr>
                                @foreach ($group->questions as $index => $quest)
                                    @php
                                        $answer = App\Models\Form_answer::where('resp_id', $form_resp->id)->where('quest_id', $quest->id)->first(['answer', 'comment']);
                                        // dd($form_resp->id, $quest->id, $answer->answer);
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}. {{ $quest->title }}</td>
                                        <td>
                                            @foreach (optional($quest->getOption)->getOptionList ?? [] as $option)
                                                @if ($option->id == ($answer->answer ?? false))
                                                    <p class="{{ $option->score ? 'text-success' : 'text-danger' }}">{{ $option->opt_text }}</p>
                                                @endif
                                                {{-- <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="questid_{{ $quest->id }}" id="optionCheckFor{{ $quest->id . $option->id }}" {{ $option->id == $answer->answer ? 'checked' : '' }}  value="{{ $option->id }}" required disabled>
                                                    <label class="form-check-label" for="optionCheckFor{{ $quest->id . $option->id }}">{{ $option->opt_text }}</label>
                                                </div> --}}
                                            @endforeach
                                        </td>
                                        <td>{{ $answer->comment ?? '' }}</td>
                                        {{-- <td></td> --}}
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        <footer class="text-center">
            <p style="font-size: 10px">Printed on : TSMC Trainingzenter at {{ now() }}</p>
        </footer>
    </div>
    <script>
        function printAsPDF() {
            window.print();
        }
        window.addEventListener('load', printAsPDF);
    </script>
</body>
</html>
