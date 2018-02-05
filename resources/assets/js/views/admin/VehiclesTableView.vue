<template>
<v-layout>
    <v-flex>
        <v-data-table
          v-bind:headers="listHeaders"
          :items="vehicles"
          hide-actions
          class="elevation-1"
        >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.name }}</td>
          <td class="text-xs-right">{{ props.item.vehicle_type }}</td>
          <td class="text-xs-right">{{ getActiveSchedules(props.item.vehicle_schedules).length }}</td>
          <td class="text-xs-right">{{ getCurrentSchedule(props.item.vehicle_schedules) }}</td>
        </template>
        </v-data-table>
    </v-flex>
</v-layout>
</template>
<script>
import moment from "moment";
export default {
		name: "vehicles-table-view",
		data() {
			return {
							vehicles: [],
							listHeaders: [
	              {
	                text: 'Vehicle Code',
	                align: 'left',
	                sortable: false,
	                value: 'name'
	              },
	              { text: 'Vehicle Type', value: 'vehicle_type' },
	              { text: 'Active Schedules', value: 'vehicle_schedules' },
	              { text: 'On Duty Today', value: 'on_duty_tody' }
	            ],
	            show: false,
			}
		},
		created() {
				this.getVehicles();
				this.$eventHub.$on('vehicleAdded', ()=>{
					this.getVehicles();
				})
		},
    methods: {
    		getVehicles(){
					axios.get('/vehicles/with-order-schedules')
	            .then(response => { 
	                this.vehicles = response.data
          }); 
    		},
        getActiveSchedules($schedules){
            let activeSchedules = [];
            if (!$schedules.length) {
                return activeSchedules; 
            } else {
                $schedules.forEach(function(item, index){
                    if(moment(item.end_at).isAfter(moment())){
                        activeSchedules.push(item);
                    }
                })
                return activeSchedules;
            }
        },
        getCurrentSchedule($schedules){
            let activeSchedules = this.getActiveSchedules($schedules);
            let workingToday = 'No';
            if (activeSchedules.length) {
                
                activeSchedules.forEach(function(item, index){
                    if (moment().isAfter(moment(item.start_at))) {
                        workingToday = 'Yes';
                    }
                })
                return workingToday;
            } else {
                return workingToday;
            }
        },
    }
}
</script>
<style>
	
</style>