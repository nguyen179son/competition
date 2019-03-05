@extends('layouts.app')
@section('title', 'Page Title')

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
                    <form class="form-horizontal" method="post" action="competition" enctype="multipart/form-data">

                        @include('competitions.fields')

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
