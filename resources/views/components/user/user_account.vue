<template>
	<component :is="currentView" 
						:users="users"
						:pagination="pagination">
	</component>
</template>

<script>
import user_grid from './user-grid.vue'
import user_form from './user-form.vue'

export default{
	data: function () {
		return {	
			currentView: 'user_grid',
			users: [],
			pagination: {
	  		current_page: '',
	  		from: '',
	  		to: '',
	  		per_page: '',
	  		last_page: '',
	  		total: '',
	  		next_page_url: '',
	  		prev_page_url: ''
	  	}
		}
	},

	components: {
		user_grid,
		user_form
	},

	ready: function() {  	
  	this.fetchData('/api/user/', this.success);
  },

  methods: {
  	success: function(response){ 
			var result = response.data;
			  		
  		this.users = result.data;

  		this.setPagination(result);
  	}
  },

	events: {
		'show-form-msg': function(){
			this.currentView = 'user_form';
		},

		'show-grid-msg': function(){
			this.currentView = 'user_grid';
		},

		'add-new-user-msg': function(){
			console.log('parent');
		}
	}
}
</script>

<style>
</style>