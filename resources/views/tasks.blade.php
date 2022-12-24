<x-layout.master>
    <div class="card">
        <div class="rounded-0 card-body">
            <x-page-header header="Tasks"></x-page-header>

            <form class="form-inline row" method="get" action="{{url()->current()}}" role="search">
                <div class="col-4 my-1">
                    <label>Date Created</label>
                    <input type="date" value="{{request()->date}}" name="date" class="form-control input-lg" />
                </div>

                @if(!empty($projects))
                <div class="col-4 my-1">
                    <label>Project</label>
                    <select class="form-control input-lg" name='project' >
                        <option value="">Search By Project</option>
                        @foreach($projects as $project)
                        <option {{$project->id == request()->project ? 'selected' : null}} value="{{$project->id}}">{{$project->name}}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="col-4 my-1 mt-2">
                    <button type="submit" class="btn home-color text-white btn-sm mt-4">Search</button>
                </div>
            </form>

            <div class="d-flex justify-content-center">
                <a href="#" class="text-decoration-none bg-dark text-light btn" data-bs-toggle="modal" data-bs-target="#calendarModal">
                    <span class="text-center fs-1 fw-bolder">{{carbon($date)->format('jS')}}</span><br />
                    <span class="fw-bold">{{carbon($date)->format('F, Y')}}</span>
                </a>
            </div>

            <div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {!!$calendar->show($date)!!}
                    </div>
                    <div class="modal-footer">
                        <a href='{{url()->current()}}' class='btn float-end text-primary'>Today</a>
                    </div>
                  </div>
                </div>
            </div>
            <hr/>

            <div class="table-responsive">
                <table class="table table-stripped table-bordered">
                    <thead>
                        <tr class="sticky-top">
                            <th>Name</th>
                            <th>Description</th>
                            <th>Project Category</th>
                            <th>Deadline</th>
                            <th>Date Created</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                        $sn = 0;
                        @endphp

                        @foreach($activities as $activity)

                        @php
                        $sn +=1;
                        @endphp

                        <tr draggable="true" class='dragger' id='page{{$sn}}'>

                            <td class='d-none'><input class='form-control-plaintext order' type='hidden' readonly value='{{$sn}}' /></td>
                            <td class='d-none'><input class='form-control-plaintext id' type='hidden' readonly value='{{$activity->id}}' /></td>

                            <td><i class='fas fa-crosshairs fa-lg'></i>{{$activity->name}}</td>

                            <td>{{$activity->description}}</td>

                            <td>
                                @if(!empty($activity->project))
                                <a href="{{route('projects', ['id'=>optional($activity->project)->id])}}">{{optional($activity->project)->name}}</a>
                                @else
                                Nil
                                @endif
                            </td>

                            <td>{{carbon($activity->deadline)->format('l jS \\of F Y')}}</td>

                            <td>{{$activity->created_at->toDayDateTimeString()}}</td>

                            <td>
                                <a class="text-decoration-none btn btn-sm bg-warning open-as-modal" href="{{route('task.form', ['id'=>$activity->id])}}"><i
                                class="fa fa-edit text-white fa-fw"></i></a>
                            </td>
                            
                            <td>
                                <a class="text-decoration-none btn btn-sm bg-danger pre-run" data-caption="Are you sure you want to delete this task?" href="{{route('task.delete', ['id'=>$activity->id])}}"><i
                                    class="fa fa-trash text-white fa-fw"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{$activities->links()}}

            <a class='btn btn-primary save float-end d-none' href="{{route('tasks.reorder')}}">Save</a>

            <div class="d-flex justify-content-center">
                <a class="text-decoration-none text-white btn btn-lg bg-dark open-as-modal" href="{{route('task.form')}}">
                    <span>Create Task</span>
                </a>
            </div>

            <div class="fixed-bottom">
                <a class="float-end" href="#" data-bs-toggle="modal" data-bs-target="#calendarModal"><i class="fa-3x fas fa-calendar-alt bg-white text-dark"></i></a>
            </div>

        </div>
    </div>
</x-layout.master>