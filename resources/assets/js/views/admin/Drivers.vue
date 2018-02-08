<template>
<v-layout row justify-center>
		
  	<v-flex xs12 md12>
  		<v-card>
  			<v-toolbar>
			    <v-toolbar-title>All Drivers</v-toolbar-title>
			    <v-spacer></v-spacer>
			    <v-btn color="secondary" dark @click.native.stop="toggleNewItem">Add New Driver</v-btn>
			    <v-btn color="primary" dark @click.native.stop="toggleNewItemSchedule">Add Driver Schedule</v-btn>
			  </v-toolbar>
				<items-schedules-view
					:itemType="itemType"
					:scheduleTypes="scheduleTypes"
				>
				</items-schedules-view>

  		</v-card>
  	</v-flex>
    <v-dialog v-model="newItemDialog" fullscreen transition="dialog-bottom-transition" :overlay=false>
      <v-card>
        <dialog-toolbar title="Add New Driver" v-on:closeDialog="toggleNewItem"></dialog-toolbar> 
     		<form-new-driver></form-new-driver> 
      </v-card>
    </v-dialog>
    <v-dialog v-model="newItemScheduleDialog" fullscreen transition="dialog-bottom-transition" :overlay=false>
    <v-card>
      <dialog-toolbar title="Add New Driver Schedule" v-on:closeDialog="toggleNewItemSchedule"></dialog-toolbar> 
      <form-new-item-schedule
      :itemType = "itemType"
        :scheduleTypes="scheduleTypes"></form-new-item-schedule>  
    </v-card>
  </v-dialog>
  </v-layout>
	
</template>

<script>
import FormNewDriver from "./FormNewDriver.vue"
import DialogToolbar from "./partials/DialogToolbar.vue"
// import DriversSchedulesView from "./DriversSchedulesView.vue"
import ItemsSchedulesView from './ItemsSchedulesView.vue'
import FormNewItemSchedule from "./FormNewItemSchedule.vue"
import ItemDialog from "../../mixins/item-dialog.js"
import {driverScheduleType} from "../../mixins/schedule-types.js"
export default {
		components: {
			FormNewDriver, DialogToolbar, ItemsSchedulesView, FormNewItemSchedule
		},
		mixins: [
			driverScheduleType, ItemDialog
		],
		data() {
			return {
				itemType: 'driver',
			}
		},
		created() {
			axios.get('/drivers')
			.then(response => this.drivers = response.data );
		},

	}	
</script>