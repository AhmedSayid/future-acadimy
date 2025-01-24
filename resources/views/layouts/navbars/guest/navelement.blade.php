<?php
$stdCourse = App\Models\StudentCourse::where('id',session('stdCourseId'))->first();
?>
<nav class="navbar navbar-main navbar-expand-lg pb-4 {{ session()->has('notify') ? 'z-index-0' :'z-index-sticky' }} position-sticky  shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item ms-1" data-bs-toggle="tooltip" data-bs-title="الرجوع لصفحة الكورس"><a href="{{route('std.single_course',session('course_id'))}}">الكورس</a></li>
                <li class="breadcrumb-item active" aria-current="page">العنصر</li>
            </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 px-2" id="navbar">
            <div class="me-auto ms-0 justify-content-center d-flex">
                <div>
                    <a class="page-link" href="javascript:" aria-label="Next" data-bs-toggle="tooltip" data-bs-original-title="التالي">
                        <span aria-hidden="true"><i class="fa fa-angle-double-right text-primary" aria-hidden="true"></i></span>
                    </a>
                </div>
                <button type="button" class="btn bg-gradient-primary letter-spacing-1" data-bs-toggle="modal" data-bs-target="#exampleModalSignup">
                    العناصر
                </button>
                <div>
                    <a class="page-link" href="javascript:" aria-label="Previous" data-bs-toggle="tooltip" data-bs-original-title="السابق">
                        <span aria-hidden="true"><i class="fa fa-angle-double-left text-primary" aria-hidden="true"></i></span>
                    </a>
                </div>
            </div>
            <div class="navbar-nav me-auto ms-0 justify-content-end">
                <div class="font-weight-bold justify-content-between letter-spacing-1 ms-2">
                    <span class="text-primary text-gradient me-1">Daily</span><span class="text-dark me-1">XP</span><span class="text-gradient text-primary me-1" id="status1" countto="{{$stdCourse->XP}}">0</span>
                </div>
                <i class="ni ni-trophy text-warning mt-1"></i>
            </div>
        </div>
    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="exampleModalSignup" tabindex="-1" aria-labelledby="exampleModalSignup" aria-hidden="true">
    <div class="modal-dialog modal-danger modal-dialog-centered modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-body p-0">
                <div class="mb-3 card-body">
                    @php
                        $trues = 0; $total = 0;
                        foreach($part->elements as $element){
                            $total++;
                            if($element->status){
                                $trues++;
                            }
                        }
                        $percentage = round(($trues/$total)*100);
                    @endphp
                    <div class="flex-column text-end">
                        <div class="d-flex">
                            <span class="avatar avatar-sm rounded-circle bg-gradient-light text-dark">0</span>
                            <h5 class="text-dark font-weight-bold me-2 mt-1">{{$part['name']}}</h5>
                            <div class="progress-wrapper ms-auto w-25 position-absolute start-2 fc-direction-ltr">
                                <div class="progress-info">
                                    <div class="progress-percentage">
                                        <span class="text-sm font-weight-bold">{{$percentage}}%</span>
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{$percentage}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-3 col-10">
                            {{$part['description']}}
                        </p>
                    </div>
                    <div class="border-top">
                        <div class="accordion-body">
                            <div class="row mt-3">
                                @if($part->elements->isNotEmpty())
                                    @php
                                        $quiz_model = []; $index = 1;
                                    @endphp
                                    @foreach($part->elements as $element)
                                        @if($element->type==1)
                                            <a class="mt-2 move-on-hover {{ Str::contains(Request::path(), 'part_single&'.$element->id) ? 'card bg-light' :'' }} col-12" href="{{route('std.part_single_course',['video_id' => $element->video->id , 'pid' => $part->id , 'eId' => $element->id, '@vid'=>$element->video->name])}}">
                                                <i class="fa fa-play text-xs btn btn-sm btn-rounded btn-dark btn-icon-only  position-absolute" data-bs-toggle="tooltip" data-bs-placement="top" title="Play"></i>
                                                <div class="me-3 d-flex justify-content-between">
                                                    <span class="font-weight-bold text-sm me-3">{{$element->video->name}} , {{$element->video->time}}min</span>
                                                    <span class="">
                                                                    @if($element->status)
                                                            <i class="ni ni-check-bold text-success ms-1"></i>
                                                        @endif
                                                                    XP {{$element->video->xp}}</span>
                                                </div>
                                            </a>
                                        @elseif($element->type==2)
                                            <a class="mt-2 move-on-hover col-12" href="https://drive.google.com/uc?export=download&id={{$element->pdf->src}}" onclick="downloadAndRedirect({{$element->id}},{{$element->pdf->xp}})">
                                                <i class="fa fa-file-pdf text-xs btn btn-sm btn-rounded btn-dark btn-icon-only  position-absolute" data-bs-toggle="tooltip" data-bs-placement="top" title="تنزيل"></i>
                                                <div class="me-3 d-flex justify-content-between">
                                                    <span class="font-weight-bold text-sm me-3">{{$element->pdf->name}} , {{$element->pdf->num_pages}} صفحات</span>
                                                    <span class="">
                                                                    @if($element->status)
                                                            <i class="ni ni-check-bold text-success ms-1"></i>
                                                        @endif
                                                                    XP {{$element->pdf->xp}}</span>
                                                </div>
                                            </a>
                                        @elseif($element->type==3 and $element->quiz->models == "موحد")
                                            <a class="mt-2 move-on-hover col-12"
                                                @if(\Carbon\Carbon::now() >= \Carbon\Carbon::parse($element->quiz['start']) or $element->quiz['start'] == null)
                                                       href="{{route('std.exam_part_single_course',['exam_id' => $element->quiz->id , 'pid' => $part->id , 'eId' => $element->id, '@exam'=>$element->quiz->title])}}"
                                                @else
                                                      href="#" onclick="notify(this)" id="flexSwitchCheckDefault" data-type="warning" data-content=" لم يبدأ الكويز بعد سيبدأ عند : {{ \Carbon\Carbon::parse($quiz['start'])->format('d M H:i') }} " data-title="Warning" data-icon="ni ni-bell-55"
                                                @endif>
                                                <i class="ni ni-trophy text-xs btn btn-sm btn-rounded btn-dark btn-icon-only  position-absolute" data-bs-toggle="tooltip" data-bs-placement="top" title="تنزيل"></i>
                                                <div class="me-3 d-flex justify-content-between">
                                                    <span class="font-weight-bold text-sm me-3">{{$element->quiz->title}} , {{$element->quiz->num_qustion}} سؤال</span>
                                                    <span class="fc-direction-ltr">XP {{$element->quiz->xp}}
                                                        @if($element->status)
                                                            <i class="ni ni-check-bold text-success ms-1"></i>
                                                        @endif
                                                        @if ($element->quiz['duration'] == "close")
                                                            <span class="font-weight-bold text-warning text-gradient ms-4">
                                                                            @if (\Carbon\Carbon::now() < \Carbon\Carbon::parse($element->quiz['start']))
                                                                    {{ \Carbon\Carbon::parse($random_quiz['start'])->format('d M H:i') }}  سيبدأ عند
                                                                @elseif (\Carbon\Carbon::now() > \Carbon\Carbon::parse($element->quiz['start'])->addMinutes($element->quiz['time']))
                                                                    انتهى الوقت
                                                                @else
                                                                    جاري الآن
                                                                @endif
                                                                        </span>
                                                        @endif
                                                                </span>
                                                </div>
                                            </a>
                                        @elseif($element->type==3 and $element->quiz->models == "متعدد")
                                            @php
                                                $quiz_model['quiz'][$index] = $element->quiz;
                                                $quiz_model['elementId'][$index] = $element->id;
                                                $index++;
                                            @endphp
                                        @endif
                                    @endforeach
                                @endif
                                @php
                                    $random_quiz =0;
                                    $data = $stdCourse->quiz_model;
                                    if (!empty($quiz_model)) {
                                        foreach ($data as &$partQuiz) {
                                            $partId = $partQuiz['part_id']; $quizModel = $partQuiz['quizModel'];
                                            if($partId == $part->id){
                                                if($quizModel == null){
                                                    $random_key = array_rand($quiz_model); $random_quiz = $quiz_model['quiz'][$random_key];
                                                    $random_quizElement = $quiz_model['elementId'][$random_key];
                                                    $quizModel = $random_key; $partQuiz['quizModel'] = $quizModel;
                                                    $stdCourse->quiz_model = $data;
                                                    $stdCourse->save();
                                                }
                                                else{
                                                    $random_quiz = $quiz_model['quiz'][$quizModel];
                                                    $random_quizElement = $quiz_model['elementId'][$quizModel];
                                                }
                                                break;
                                            }
                                        }
                                    }
                                @endphp
                                @if($random_quiz)
                                    <a class="mt-2 move-on-hover col-12"
                                       @if(\Carbon\Carbon::now() >= \Carbon\Carbon::parse($random_quiz['start']) or $random_quiz['start'] == null)
                                               href="{{route('std.exam_part_single_course',['exam_id' => $random_quiz->id , 'pid' => $part->id , 'eId' => $random_quizElement, '@quiz'=>$random_quiz->title])}}"
                                       @else
                                           href="#" onclick="notify(this)" id="flexSwitchCheckDefault" data-type="warning" data-content=" لم يبدأ الامتحان بعد سيبدأ عند : {{ \Carbon\Carbon::parse($random_quiz['start'])->format('d M H:i') }} " data-title="Warning" data-icon="ni ni-bell-55"
                                       @endif>
                                        <i class="ni ni-trophy text-xs btn btn-sm btn-rounded btn-dark btn-icon-only  position-absolute" data-bs-toggle="tooltip" data-bs-placement="top" title="Play episode"></i>
                                        <div class="me-3 d-flex justify-content-between">
                                            <span class="font-weight-bold text-sm me-3">{{$random_quiz['title']}} , {{$random_quiz['num_question']}} سؤال</span>
                                            <span class="fc-direction-ltr">XP {{$random_quiz['xp']}}
                                                @if($element->status)
                                                    <i class="ni ni-check-bold text-success ms-1"></i>
                                                @endif
                                                @if ($random_quiz['duration'] == "close")
                                                    <span class="font-weight-bold text-warning text-gradient ms-4">
                                                                    @if (\Carbon\Carbon::now() < \Carbon\Carbon::parse($random_quiz['start']))
                                                            {{ \Carbon\Carbon::parse($random_quiz['start'])->format('d M H:i') }} سيبدأ عند
                                                        @elseif (\Carbon\Carbon::now() > \Carbon\Carbon::parse($random_quiz['start'])->addMinutes($random_quiz['time']))
                                                            انتهى الوقت
                                                        @else
                                                            جاري الآن
                                                        @endif
                                                               </span>
                                                @endif
                                                        </span>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
