export default {
	data: function(){
		return {
			
			check_all: false,
			checked_list: []
		}
	},

	methods: {
		onSelectAll: function(data_set){
  		if(this.check_all === true){
  			data_set.forEach(function(data){
  				this.checked_list.push(data.id + '');
  			}.bind(this));
  		}
  		else{
  			this.checked_list.splice(0);
  		}
  		
  	},

  	onSelectItems: function(){
  		this.check_all = false;
  	},

  	setPagination: function(pagination){
  		this.pagination.current_page = pagination.current_page;
  		this.pagination.from = pagination.from;
  		this.pagination.to = pagination.to;
  		this.pagination.per_page = pagination.per_page;
  		this.pagination.total = pagination.total;
  		this.pagination.last_page = pagination.last_page;
  		this.pagination.next_page_url = pagination.next_page_url;
  		this.pagination.prev_page_url = pagination.prev_page_url;
  	},

  	fetchData: function(api_url, success){
  		var resource = this.$resource(api_url);

			resource.get().then(success);
  	},
  	
		previous: function(){
			if(this.pagination.current_page === 1) return;

  		this.fetchData(this.pagination.prev_page_url, this.success);	
  	},

  	next: function(){
			if(this.pagination.current_page === this.pagination.last_page) return;

  		this.fetchData(this.pagination.next_page_url, this.success);
  	},

  	goTo: function(page){
  		this.fetchData('/api/user/?page=' + page, this.success);
  	}
	}
}