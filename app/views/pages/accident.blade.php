@extends('layouts.default')

@section('head')
	
@stop

@section('title')
	<title>Technowell Traffic | Citizen Tracking</title>
@stop

@section('content')
	<div id="mapcanvas"></div>
	<div class="panel-group filter-btn" id="accordion">
		<div class="panel panel-default">
		<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#collapseOne">
	  		<h4 class="panel-title">
	   			<a class="accordion-toggle">
	    			<i class="fa fa-bars fa-lg filter-menu"></i>
	    		</a>
	 		</h4>
		</div>
	    <div id="collapseOne" class="panel-collapse collapse in filter">
	      	<div class="panel-body">
	      		{{ Form::open(array('url' => 'foo/bar', 'files' => true)) }}
	      		{{ Form::label('details', 'Details', array('class' => 'awesome'))}}
				{{ Form::close() }}
	    </div>
	</div>
	</div>
@stop