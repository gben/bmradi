@extends('admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Mradi Wallet Deposit

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Deposit</li>
        <br />


    </ol>
</section>


<!-- Main content -->
<section class="content">
    
    <!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

{{ Form::open(array('url' => 'wallet', 'action'=>'POST')) }}

    <div class="form-group">
        {{ Form::label('amount', 'Enter Amount') }}
        {{ Form::text('amount', Input::old('amount'), array('class' => 'form-control','required'=>'true')) }}
    </div>

    {{ Form::submit('Continue!', array('class' => 'btn btn-primary', 'id'=>'bid', 'name'=>'bid')) }}

{{ Form::close() }}
    
</section><!-- /.content -->
@stop

