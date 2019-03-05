<table class="table table-responsive" id="competitions-table">
    <thead>
        <tr>
            <th>Competition Name</th>
        <th>Host Id</th>
        <th>Competition Description</th>
        <th>Background Picture</th>
        <th>Start Date</th>
        <th>Start Time</th>
        <th>End Date</th>
        <th>End Time</th>
        <th>Time Zone</th>
        <th>Address Name</th>
        <th>City</th>
        <th>State</th>
        <th>Country</th>
        <th>Longitude</th>
        <th>Latitude</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($competitions as $competition)
        <tr>
            <td>{!! $competition->competition_name !!}</td>
            <td>{!! $competition->host_id !!}</td>
            <td>{!! $competition->competition_description !!}</td>
            <td>{!! $competition->background_picture !!}</td>
            <td>{!! $competition->start_date !!}</td>
            <td>{!! $competition->start_time !!}</td>
            <td>{!! $competition->end_date !!}</td>
            <td>{!! $competition->end_time !!}</td>
            <td>{!! $competition->time_zone !!}</td>
            <td>{!! $competition->address_name !!}</td>
            <td>{!! $competition->city !!}</td>
            <td>{!! $competition->state !!}</td>
            <td>{!! $competition->country !!}</td>
            <td>{!! $competition->longitude !!}</td>
            <td>{!! $competition->latitude !!}</td>
            <td>
                {!! Form::open(['route' => ['competitions.destroy', $competition->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('competitions.show', [$competition->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('competitions.edit', [$competition->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>