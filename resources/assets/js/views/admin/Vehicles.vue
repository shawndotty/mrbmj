<template>
<v-layout row justify-center>
	<v-flex>
    <v-toolbar>
        <v-toolbar-title>Vehicles</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn icon @click.native.stop="toggleView" :disabled="!scheduleView" >
          <v-icon>reorder</v-icon>
        </v-btn>
        <v-btn icon @click.native.stop="toggleView" :disabled="scheduleView" >
          <v-icon >line_style</v-icon>
        </v-btn>
        <v-btn color="secondary" dark @click.native.stop="toggleNewItem">Add New Vehicle</v-btn>
        <v-btn color="primary" dark @click.native.stop="toggleNewItemSchedule">Add Vehicle Schedule</v-btn>
    </v-toolbar>

    <items-schedules-view
        v-if="scheduleView"
        :itemType="itemType"
        :scheduleTypes="scheduleTypes"
    >
    </items-schedules-view>
    <vehicles-table-view v-if="!scheduleView"></vehicles-table-view> 

    <v-dialog v-model="newItemDialog" fullscreen transition="dialog-bottom-transition" :overlay=false>
      <v-card>
        <dialog-toolbar title="Add New Vehicle" v-on:closeDialog="toggleNewItem"></dialog-toolbar> 
        <form-new-vehicle></form-new-vehicle>
      </v-card>
    </v-dialog> 
    <v-dialog v-model="newItemScheduleDialog" fullscreen transition="dialog-bottom-transition" :overlay=false>
      <v-card>
        <dialog-toolbar title="Add New Vehicle Schedule" v-on:closeDialog="toggleNewItemSchedule"></dialog-toolbar> 
        <form-new-item-schedule
          :itemType = "itemType" :scheduleTypes="scheduleTypes"
        ></form-new-item-schedule>  
      </v-card>
    </v-dialog>
</v-flex>	
</v-layout>
</template>
<script>
import FormNewVehicle from "./FormNewVehicle.vue";
import DialogToolbar from "./partials/DialogToolbar.vue";
import ItemsSchedulesView from "./ItemsSchedulesView.vue"
import VehiclesTableView from "./VehiclesTableView.vue";
import FormNewItemSchedule from "./FormNewItemSchedule.vue";
import { vehicleScheduleType } from "../../mixins/schedule-types.js"
import itemDialog from "../../mixins/item-dialog.js"

export default {
    components: {
        FormNewVehicle, DialogToolbar, ItemsSchedulesView, VehiclesTableView, FormNewItemSchedule          
    },
    mixins:[
        vehicleScheduleType, itemDialog 
    ], 
	data() {
		return {
            dialog: false,
            scheduleView: true,
            itemType: 'vehicle',
		}
	},
    methods: {
        toggleView(){
            this.scheduleView = !this.scheduleView;
        }
    }
}		
</script>

