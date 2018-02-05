<template>
<div>
	{{ client }}	
</div>	
</template>
<script>
export default {
		data() {
			return {
				client: {}
			}

		},

		mounted(){
			axios.get('/client/' + this.$route.params.clientId)
			.then(response => this.client = response.data );
		}
	}	
</script>