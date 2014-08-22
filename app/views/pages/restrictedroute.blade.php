@extends('layouts.default')

@section('head')
	{{ HTML::script('js/json2.js') }}
	{{ HTML::script('js/v3_PolylineEncoder.js') }}
	{{ HTML::script('js/restrictedarea.js') }}
@stop

@section('title')
	<title>Technowell Traffic | Traffic Jam Report</title>
@stop

@section('head-tag')
    <b>&nbsp;&nbsp;&nbsp;&nbsp;Report Restricted Area</b>
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
	      		<form action="api/trafficjam" method="POST">
	      			<table class="loc-table" id="login">
						<tbody>
							<tr>
								<td>
									Source
								</td>
								<td>
									 <input id="source" name="source" type="text" class="location small">
								</td>
							</tr>
							<tr>
								<td>	
									Destination
								</td>
								<td>
									 <input id="dest" name="dest" type="text" class="location small">
								</td>
							</tr>
							<tr>
								<input id="encoded_polyline" type="hidden" name="encoded_polyline">
								<td class="loc-btn">
									<input type="button" class="button" onClick="calcRoute()" Value="Route">
								<!--	<button id="download" onclick="download()">Download</button> -->
								</td>
								<td class="loc-btn">
									<input type="submit" class="button" value="Save">
								</td>
							</tr>
						</tbody>			
					</table>
				</form>	
	    </div>
	</div>
	</div>
@stop