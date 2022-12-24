<x-layout.master>
    <div class="card">
        <div class="rounded-0 card-body">
            <x-page-header header="Projects"></x-page-header>

            <form class="form-inline row" method="get" action="{{url()->current()}}" role="search">
                <div class="col-4 my-1">
                    <label>Date Created</label>
                    <input type="date" value="{{request()->date}}" name="date" class="form-control input-lg" />
                </div>

                @if(request()->filled('user_id'))
                <input type="hidden" value="{{request()->user_id}}" name="user_id" />
                @endif

                <div class="col-4 my-1 mt-2">
                    <button type="submit" class="btn home-color text-white btn-sm mt-4">Search</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-stripped table-bordered">
                    <thead>
                        <tr class="sticky-top">
                            <th>S/N</th>
                            <th>Title</th>
                            <th>Description</th>
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

                        <tr>

                            <td>{{$sn}}</td>

                            <td>{{$activity->name}}</td>

                            <td>{{$activity->description}}</td>

                            <td>{{carbon($activity->deadline)->format('l jS \\of F Y')}}</td>

                            <td>{{$activity->created_at->toDayDateTimeString()}}</td>

                            <td>
                                <a class="text-decoration-none btn btn-sm bg-dark text-white" href="{{route('tasks', ['project'=>$activity->id])}}">Tasks</a>
                            </td>

                            <td>
                                <a class="text-decoration-none btn btn-sm bg-warning open-as-modal" href="{{route('project.form', ['id'=>$activity->id, 'user_id'=>request()->user_id])}}"><i
                                class="fa fa-edit text-white fa-fw"></i></a>
                            </td>
                            
                            <td>
                                <a class="text-decoration-none btn btn-sm bg-danger pre-run" data-caption="Are you sure you want to delete this project?" href="{{route('project.delete', ['id'=>$activity->id])}}"><i
                                    class="fa fa-trash text-white fa-fw"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{$activities->links()}}

            <div class="d-flex justify-content-center">
                <a class="text-decoration-none text-white btn btn-lg bg-dark open-as-modal" href="{{route('project.form', ['date'=>$date, 'user_id'=>request()->user_id])}}">
                    <span>Create Project</span>
                </a>
            </div>

        </div>
    </div>
</x-layout.master>