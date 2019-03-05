@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Competition
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($competition, ['route' => ['competitions.update', $competition->id], 'method' => 'patch']) !!}

                        @include('competitions.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection