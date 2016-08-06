@extends('_layouts.app')

@section('content_wrapper')

@include('_templates.user_grid')
@include('_templates.user_form')

<!-- PAGE CONTENT WRAPPER -->
<div id="user_app" class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">	
			<!-- SHOW USER GRID -->		
			<user-grid v-show="!form_show"></user-grid>
			<!-- END -->	

			<!-- SHOW USER FORM -->	
			<user-form v-show="form_show"></user-form>
			<!-- END -->	
		</div>
	</div>
</div>      
<!-- END PAGE CONTENT WRAPPER --> 
@stop
