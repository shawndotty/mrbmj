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
        <v-btn color="primary" dark @click.native.stop="dialog = true">Add New Vehicle</v-btn>
    </v-toolbar>

    <items-schedules-view
        v-if="scheduleView"
        :itemType="itemType"
        :scheduleTypes="scheduleTypes"
    >
    </items-schedules-view>
    <vehicles-table-view v-if="!scheduleView"></vehicles-table-view> 

    <v-dialog v-model="dialog" fullscreen transition="dialog-bottom-transition" :overlay=false>
      <v-card>
        <dialog-toolbar title="Add New Vehicle" v-on:closeDialog="dialog = false"></dialog-toolbar> 
        <form-new-vehicle></form-new-vehicle>
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

export default {
    components: {
        FormNewVehicle, DialogToolbar, ItemsSchedulesView, VehiclesTableView           
    },
	data() {
		return {
            dialog: false,
            scheduleView: true,
            itemType: 'vehicle',
                scheduleTypes: [
                    { 
                name : "Order",
                color: "red",
                id: 1,
            },
            { 
                name : "Hold",
                color: "yellow",
                id: 2,
            },
            { 
                name : "Maintenance",
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
    methods: {
        toggleView(){
            this.scheduleView = !this.scheduleView;
        }
    }
}		
</script>

