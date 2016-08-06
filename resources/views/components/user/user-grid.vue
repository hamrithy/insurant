<template>
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="dataTables_wrapper no-footer">	
				<div class="dataTables_length">
					<button class="btn btn-primary" v-on:click="showForm">New</button>
				</div>	
				<div class="dataTables_filter">
					<label>Search:<input class="form-control " type="search"></label>
				</div>
				<table class="table datatable dataTable no-footer">
			    <thead>
			      <tr>
			      	<th style="width: 30px; text-align: center;"><input type="checkbox" v-model="check_all" v-on:change="onSelectAll(users)"/></th>
			      	<th style="width: 200px;" class="sorting_desc">User Account</th>
			      	<th style="width: 200px;" class="sorting">Full Name</th>
			      	<th style="width: 250px;" class="sorting">Email</th>
			      	<th style="width: 69px;" class="sorting">Role</th>
			      	<th style="width: 69px;" class="sorting">Status</th>
			      </tr>
			    </thead>
			    <tbody>
			      <tr v-for="user in users">
			      		<td style="text-align: center;">
			      			<input type="checkbox" 
			      					value="{{ user.id }}" 
			      					v-model="checked_list"
			      					v-on:change="onSelectItems"/>
			      		</td>
			          <td>{{ user.user_name }}</td>
			          <td>{{ user.full_name }}</td>
			          <td>{{ user.email }}</td>
			          <td>{{ user.role.name }}</td>
			          <td>{{ user.status }}</td>
			      </tr>
			    </tbody>
				</table>
				<div class="dataTables_Footer clearfix" v-if="pagination.last_page > 1">
					<div class="footer_left">
						<label>Show 
							<select class="form-control">
								<option value="10">10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select> 
							records ({{ pagination.from }}-{{ pagination.to }} of {{ pagination.total }})
						</label>
					</div>				
					<div class="dataTables_paginate paging_simple_numbers">
						<a v-on:click.stop.prevent="previous" class="paginate_button previous" v-bind:class="{ 'paginate_button_disabled': pagination.current_page === 1}"><i class="fa fa-angle-left"></i></a>
						<span v-for="page in pagination.last_page">
							<a v-on:click.stop.prevent="goTo(page + 1)" class="paginate_button" v-bind:class="{ 'current': pagination.current_page === page + 1}">{{ page + 1 }}</a>
						</span>
						<a v-on:click.stop.prevent="next" class="paginate_button next" v-bind:class="{ 'paginate_button_disabled': pagination.current_page === pagination.last_page}"><i class="fa fa-angle-right"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default{
	props: {
    users: Array,
    pagination: Object
  },

	methods: {
  	showForm: function(){
  		this.$dispatch('show-form-msg');
  	},

  	success: function(response){ 
			var result = response.data;

			//this.data = result;
  		
  		this.users = result.data;

  		this.setPagination(result);
  	}
	},

	events: {
		'add-new-user-msg': function(){
			console.log('form grid');
		}
	}
}
</script>

<style>
.dataTables_Footer{
	font-size: 12px;
	padding: 0px 0px 5px; 
}

.dataTables_Footer .footer_left{
  float: left;     
}

.dataTables_Footer .footer_left label{
	padding: 0px;  
  height: auto; 
  margin: 0px; 
  font-weight: normal; 
}

.dataTables_Footer .footer_left select{
	width: auto;
  display: inline;
  margin: 0px 5px;
}

.dataTables_Footer .footer_right{
	float: right;
}
</style>