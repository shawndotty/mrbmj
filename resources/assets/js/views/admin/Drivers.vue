<template>
<v-layout row justify-center>
		
  	<v-flex xs12 md12>
  		<v-card>
  			<v-toolbar>
			    <v-toolbar-title>All Drivers</v-toolbar-title>
			    <v-spacer></v-spacer>
			    <v-btn color="primary" dark @click.native.stop="dialog = true">Add New Driver</v-btn>
			  </v-toolbar>
				<items-schedules-view
					:itemType="itemType"
					:scheduleTypes="scheduleTypes"
				>
				</items-schedules-view>

  		</v-card>
  	</v-flex>
    <v-dialog v-model="dialog" fullscreen transition="dialog-bottom-transition" :overlay=false>
      <v-card>
        <dialog-toolbar title="Add New Driver" v-on:closeDialog="dialog = false"></dialog-toolbar> 
        <form-new-driver></form-new-driver>  
      </v-card>
    </v-dialog>
  </v-layout>
	
</template>

<script>
import FormNewDriver from "./FormNewDriver.vue"
import DialogToolbar from "./partials/DialogToolbar.vue"
// import DriversSchedulesView from "./DriversSchedulesView.vue"
import ItemsSchedulesView from './ItemsSchedulesView.vue'
export default {
		components: {
			FormNewDriver, DialogToolbar, ItemsSchedulesView
		},
		data() {
			return {
				dialog: false,
				itemType: 'driver',
				scheduleTypes: [
					{ 
	        	name : "Order",
	        	color: "red",
	        	id: 1,
	        },
	        { 
	        	name : "Leave",
	        	color: "yellow",
	        	id: 2,
	        },
	        { 
	        	name : "Vocation",
	        	color: "green",
	        	id: 3,
	        },
	        { 
	        	name : "Other",
	        	color: "purple",
	        	id: 4,
	        },
				]
			}
		},

		created() {
			axios.get('/drivers')
			.then(response => this.drivers = response.data );
		},

	}	
</script>