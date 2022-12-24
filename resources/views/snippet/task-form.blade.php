<form action="{{route('task.form.post')}}" id="form" data-bc="activity_trigger" method="post" role="form">

        @if(request()->filled('id'))
            <input type="hidden" value="{{request()->id}}" name="id" />
        @endif

        <div class="form-group mt-3">
            <label>Task Name/Title</label>
            <input type='text' value="{{$activity->name ?? null}}" class="form-control-lg form-control" name="name"/>
        </div>

        <div class="form-group mt-3">
            <label>Priority</label>
            <input type='number' value="{{$activity->priority ?? 1}}" class="form-control-lg form-control" name="priority"/>
        </div>

        <div class="form-group mt-3">
            <label>Deadline</label>
            <input type='date' value="{{$activity->deadline ?? request()->date}}" class="form-control-lg form-control" name="deadline"/>
        </div>

        @if(!empty($projects))
            <div class="form-group mt-3">
                <label>Project</label>
                <select class="form-control form-control-lg" name='project_id' >
                    <option value="">Select Project Category</option>
                    @foreach($projects as $project)
                    <option {{$project->id == optional($activity)->project_id ? 'selected' : null}} value="{{$project->id}}">{{$project->name}}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="form-group mt-3">
            <label>Description</label>
            <textarea class="form-control-lg form-control" style="border-radius:10px;" col="2" rows="2" name="description">{{$activity->description ?? null}}</textarea>
        </div>


        <div class="form-group mt-3">
            <input type="submit" value="Submit" class="btn btn-primary w-100 btn-lg" />
        </div>
    </form>