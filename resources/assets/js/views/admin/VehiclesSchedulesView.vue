<template>
		<v-layout row wrap> 
			<v-flex xs12 sm12>
				<v-toolbar
			      color="white"
			    >
        <v-menu
					lazy
					:close-on-content-click="false"
					v-model="monthPickMenu"
					transition="scale-transition"
					offset-y
					full-width
					:nudge-right="40"
					max-width="290px"
					min-width="290px"
					>
					<v-text-field
					slot="activator"
					label="Choose Date"
					v-model="checkDate"
					prepend-icon="event"
					:hide-details="true"
					readonly
					single-line
					></v-text-field>
					<v-date-picker type="month" v-model="checkDate" no-title scrollable actions >
						<template slot-scope="{ save, cancel }">
							<v-card-actions>
								<v-spacer></v-spacer>
								<v-btn flat color="primary" @click="cancel">Cancel</v-btn>
								<v-btn flat color="primary" @click="save">OK</v-btn>
							</v-card-actions>
						</template>
					</v-date-picker>
				</v-menu>
				<v-spacer></v-spacer>
        <v-switch label="Order"
                  v-model="scheduleType"
                  color="red"
                  value="1"
                  hide-details
                  required> 	
        </v-switch>
        <v-switch label="Quote"
                  v-model="scheduleType"
                  color="yellow"
                  value="2"
                  hide-details> 	
        </v-switch>
        <v-switch label="Hold"
                  v-model="scheduleType"
                  color="blue"
                  value="3"
                  hide-details> 	
        </v-switch>
        <v-switch label="Check"
                  v-model="scheduleType"
                  color="green"
                  value="4"
                  hide-details> 	
        </v-switch>
        <v-switch label="OoD"
                  v-model="scheduleType"
                  color="purple"
                  value="5"
                  hide-details> 	
        </v-switch>
        <v-switch label="Other"
                  v-model="scheduleType"
                  color="orange"
                  value="6"
                  hide-details> 	
        </v-switch>
    </v-toolbar>
				
			</v-flex>
		
			<v-flex xl12>
				<v-card>
					
				
				<table class="my-table" >
					<thead>
						<tr><th width="80px">Vehicles</th><th v-for="item in getHeaderDays">{{ item.date}} {{ item.dow }}</th></tr>
					</thead>
					<tbody>
						<tr v-for="item in getTdItems">
							<td class="text-xs-center">{{ item.name.slice(-4) }}</td>
							<td v-for="(day, index) in item.daysMap" :class="day.class.join(' ')" :title="day.ids.join(' ')"> 
								
							</td>
						</tr>
					</tbody>
				</table>
				</v-card>
			</v-flex>
</v-layout>
</template>

<script>
import moment from "moment";
export default {
	name: "vehicles-schedules-view",

	data() {
		return {
            monthPickMenu: false,
            checkDate : moment().format("YYYY-MM"),
						chooseDate: '',
            headers: [],
            vehicles: [],
            show: false,
            scheduleType: ['1']
		}
	},
	created() {
        this.getVehiclesWithRangeSchedule();
        this.$eventHub.$on("vehicleAdded", ()=>{this.getVehiclesWithRangeSchedule()});
    },

  watch: {
  
      checkDate: function (newDate, oldDate) {
        this.getVehiclesWithRangeSchedule();
      },

      scheduleType: function(newTypes, oldTypes){
      	if(newTypes.length) {
      		this.getVehiclesWithRangeSchedule();
      	} else {
      		this.scheduleType = oldTypes;
      	}
      	
      }
  },
  methods: {
  	getVehiclesWithRangeSchedule(){
            axios.get('/vehicles/range-schedules', {
              params: {
                start_at: this.startOfM.format("YYYY-MM-DD"),
                end_at: this.endOfM.format("YYYY-MM-DD"),
                types: this.scheduleType
              }
            })
            .then(response => { 
                this.vehicles = response.data
            }); 
    },
    buildArray(target, start, end){
      	for(var i=start; i<=end; i++) {
      		target.push(i);
      	}
    }
  },
  computed: {
    startOfM() {
        return moment(this.checkDate).startOf('month');
    },

    endOfM(){
        return moment(this.checkDate).endOf('month');          
    },

		getHeaderDays(){
			let y = moment(this.checkDate).year();
			let m = moment(this.checkDate).month();
			let daysInM = moment(this.checkDate).daysInMonth();
			let days = [];
			for (var i = 1; i <= daysInM; i++) {
					days.push({
						dow: moment({year: y, month: m, date: i}).format('ddd'),
						date: i
					});
			}

			this.headers = days;
			return this.headers;
	  },

	  getTdItems(){
	  	let daysInM = moment(this.checkDate).daysInMonth();
	  	let startOfM = moment(this.checkDate).startOf('month');
	  	let endOfM = moment(this.checkDate).endOf('month');
			let comp = this;
			let newItems = this.vehicles;

			newItems.forEach( function(item, index) {
				let daysTaken = [];
				let newDaysTaken = [];
	      let infoMap = { startIndex : [], range : []};
	     

				item.vehicle_schedules.forEach( function(schedule, index) {
				    let startOfS = moment(schedule.start_at);
	          let   endOfS = moment(schedule.end_at);
	          let maxStart = moment.max(startOfM, startOfS).date();
	          let   minEnd = moment.min(endOfM, endOfS).date();
	          let  daysMap = {
				          type : null,
				          days : [],
				          id   : null
				      	};
	          comp.buildArray(daysTaken, maxStart, minEnd); 
	          comp.buildArray(daysMap.days, maxStart, minEnd);
	          daysMap.type = schedule.type;
	          daysMap.id = schedule.id;
	          newDaysTaken.push(daysMap);
				});

				

				let tdItems = [];
				let newTdItems = [];
				
				for (var i = 1; i <= daysInM; i++) {
					tdItems.push({
						day: i
					});

					newTdItems.push({
						day: i,
						class: [],
						ids: []
					});
				}

				tdItems.forEach( function(item, index) {
				if(daysTaken.includes(item.day)) {
					item.class="active";
				}	else {
					item.class="inactive";
				}
				});

				newTdItems.forEach( function(item, index) {
					newDaysTaken.forEach( function(schedule){
						if(schedule.days.includes(item.day)){
							item.class.push('type-' + schedule.type);
							item.ids.push('schedule-' + schedule.id);
						}
					})
				});

				console.dir(newTdItems);

				newItems[index].daysMap = newTdItems;
			});
		
			return newItems;
	  }
} 
}
</script>
<style lang="scss">
.my-table{
	border-spacing: 0;

	tr:hover{
		background-color:#bbb;
	}	
	th, td{
		padding:5px;
		border-bottom:1px solid #efefef;
        position: relative;
        
        a {
            position:absolute;
            display: block;
            height: 100%;
            left: 0;
            top: 0;
        }
	}


	tr:nth-child(2n+1) td.active{
		background-color: #FFC107;
	}
	tr:nth-child(3n+1) td.active{
		background-color: #2196F3;
	}

	tr td.type-6{
		background-color: orange;        
	}

	tr td.type-5{
		background-color: purple;        
	}

	tr td.type-4{
		background-color: green;        
	}

	tr td.type-3{
		background-color: blue;        
	}

	tr td.type-2{
		background-color: yellow;        
	}

	tr td.type-1{
		background-color: red;        
	}

    td.active:hover{
      cursor: pointer;
    };

    @for $i from 1 through 31 {
    .w-#{$i} { width: 100% * $i; }
}
}
.my-calender{
	table.table tbody td, table.table tbody th{
		height:12px;
	}
	table.table tbody td:first-child, table.table tbody td:not(:first-child), table.table tbody th:first-child, table.table tbody th:not(:first-child), table.table thead td:first-child, table.table thead td:not(:first-child), table.table thead th:first-child, table.table thead th:not(:first-child){
		padding: 0px 10px;
	}
}
</style>
