@extends('layouts.default')

@section('head')
	{{ HTML::script('js/traffic.js') }}
@stop

@section('title')
	<title>Technowell Traffic | Road Block Report</title>
@stop

@section('head-tag')
    <b>&nbsp;&nbsp;&nbsp;&nbsp;Report Road Block</b>
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
	      		<form action="api/roadblock" method="POST">
					<table class="loc-table">
						<tbody>
							<tr>
								<td>
									Location 
								</td>
								<td>
									<textarea class="location" type="text" id="location" name="location" wrap="physical" required>
									</textarea>
								</td>
							</tr>
							<tr>
								<td>
									Status
								</td>
								<td>
									<select name='status'>
										<option value="heavy">Heavy</option>
										<option value="moderate">Moderate</option>
										<option value="low">Low</option>
									</select>
								</td>
							</tr>	
							<tr>
								<td>
									Reason
								</td>
								<td>
									<select name="reason" multiple>
										<option value = "Ganapathi Idol">Ganapathi Idol</option>
										<option value = "Other">Other</option>
									</select>
								</td>
								<td>	
									<input type="hidden" name="lat" id="lat">
									<input type="hidden" name="lng" id="lng">
									<input type="hidden" name="user" id="lng" value="police">
								</td>
							</tr>
							<tr>
								<td class="loc-btn">
									<button>Save</button>
								</td>
							</tr>
						</tbody>			
					</table>	
	    </div>
	</div>
	</div>
@stop