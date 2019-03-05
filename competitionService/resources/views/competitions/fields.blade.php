<!-- Competition Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('competition_name', 'Competition Name:') !!}
    {!! Form::text('competition_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Host Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('host_id', 'Host Id:') !!}
    {!! Form::number('host_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Competition Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('competition_description', 'Competition Description:') !!}
    {!! Form::text('competition_description', null, ['class' => 'form-control']) !!}
</div>

<!-- Background Picture Field -->
<div class="form-group col-sm-6">
    {!! Form::label('background_picture', 'Background Picture:') !!}
    {{--{!! Form::file('background_picture', null, ['class' => 'form-control']) !!}--}}
    <input type="file" class="form-control" name="background_picture" id="background_picture">
</div>

<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', 'Start Date:') !!}
    {!! Form::date('start_date', null, ['class' => 'form-control']) !!}
</div>

<!-- Start Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_time', 'Start Time:') !!}
    {!! Form::text('start_time', null, ['class' => 'form-control']) !!}
</div>

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'End Date:') !!}
    {!! Form::date('end_date', null, ['class' => 'form-control']) !!}
</div>

<!-- End Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_time', 'End Time:') !!}
    {!! Form::text('end_time', null, ['class' => 'form-control']) !!}
</div>

<!-- Time Zone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('time_zone', 'Time Zone:') !!}
    {!! Form::text('time_zone', null, ['class' => 'form-control']) !!}
</div>

<!-- Address Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address_name', 'Address Name:') !!}
    {!! Form::text('address_name', null, ['class' => 'form-control']) !!}
</div>

<!-- City Field -->
<div class="form-group col-sm-6">
    {!! Form::label('city', 'City:') !!}
    {!! Form::text('city', null, ['class' => 'form-control']) !!}
</div>

<!-- State Field -->
<div class="form-group col-sm-6">
    {!! Form::label('state', 'State:') !!}
    {!! Form::text('state', null, ['class' => 'form-control']) !!}
</div>

<!-- Country Field -->
<div class="form-group col-sm-6">
    {!! Form::label('country', 'Country:') !!}
    {!! Form::text('country', null, ['class' => 'form-control']) !!}
</div>

<!-- Longitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('longitude', 'Longitude:') !!}
    {!! Form::number('longitude', null, ['class' => 'form-control']) !!}
</div>

<!-- Latitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('latitude', 'Latitude:') !!}
    {!! Form::number('latitude', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    {{--<a href="{!! route('competitions.index') !!}" class="btn btn-default">Cancel</a>--}}
</div>
