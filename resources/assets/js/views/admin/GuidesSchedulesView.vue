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
		        <v-spacer></v-spacer>
		        <v-btn-toggle mandatory v-model="scheduleView">
             
              <v-btn flat value="collapse">
                Collapse
              </v-btn>
               <v-btn flat value="expand">
                Expand
              </v-btn>
            </v-btn-toggle>
		    </v-toolbar>
			</v-flex>
		
			<v-flex xl12>
				<v-card>
					
				<table class="my-table" >
					<thead>
						<tr><th width="80px">Guides</th><th v-for="item in headerDays">{{ item.date}} {{ item.dow }}</th></tr>
					</thead>
					<tbody>
						<template v-if="scheduleView == 'collapse'">
							<tr v-for="item in getTdItems">
							<td class="text-xs-center">{{ item.first_name }}</td>
							<td v-for="(day, index) in item.daysMap" :class="day.class.join(' ')" :title="day.ids.join(' ')">
							</td>
						</tr>
						</template>
						
						<template v-if="scheduleView == 'expand'" v-for="item in getTdItems">
							<tr class="expand-view" v-for="(schedule, index) in item.guide_schedules">
								<td class="text-xs-center name" v-if="item.guide_schedules.length && index == 0" :rowspan="item.guide_schedules.length">
								{{ item.first_name }}
								</td>
								<td 
								v-for="(day, index) in schedule.daysMap"
								:colspan = "day.span"
								:class="day.class"
								>
								</td>
							</tr>
						</template>
					</tbody>
				</table>
				<v-card-text>
				</v-card-text>
				</v-card>
			</v-flex>
</v-layout>
</template>
<script>
import moment from "moment";
import utils from "../../utils.js";

	export default {
		name: 'guides-schedules-view',
		data() {
			return {
				scheduleView: 'collapse',
				guides: [],
				monthPickMenu: false,
        checkDate : moment().format("YYYY-MM"),
				chooseDate: '',
        headers: [],
        show: false,
        scheduleType: ['1','2','3']
			}
		},
		computed: {
			startOfM() {
        return moment(this.checkDate).startOf('month');
	    },

	    endOfM(){
        return moment(this.checkDate).endOf('month');          
	    },
	    daysInM(){
	    	return moment(this.checkDate).daysInMonth();
	    },
	    headerDays(){
					return utils.getMonthDays(this.checkDate);
	    },
	    getTdItems(){
		  	let daysInM = this.daysInM;
		  	let startOfM = this.startOfM
		  	let endOfM = this.endOfM;
				let newItems = this.guides;

				newItems.forEach( function(item, index) {
					let daysTaken = [];
		     
					item.guide_schedules.forEach( function(schedule, index) {
					    let startOfS = moment(schedule.start_at);
		          let   endOfS = moment(schedule.end_at);
		          let maxStart = moment.max(startOfM, startOfS).date();
		          let   minEnd = moment.min(endOfM, endOfS).date();
		          let  daysMap = {
					          type : null,
					          days : [],
					          id   : null,
					          span : null
					      	};
		          utils.buildArray(daysMap.days, maxStart, minEnd);
		          daysMap.type = schedule.type;
		          daysMap.id = schedule.id;
		          daysMap.start = maxStart;
		          daysMap.span = daysMap.days.length;
		          daysTaken.push(daysMap);

		          let scheduleTdItems = [];

		          for (var i=1; i <= daysInM; i++) {
		          	if ( i == daysMap.start ) {
									scheduleTdItems.push({
										day: i,
										span: daysMap.span,
										class: "type-" + schedule.type,
										info: true, 
									});
								} else if ( i != daysMap.start && daysMap.days.includes(i)) {
									
								} else {
									scheduleTdItems.push({
										day: i,
										span: 1,
										info: false, 
									});
								}
		          }

		          schedule.daysMap = scheduleTdItems;

					});


					let tdItems = [];
					
					for (var i = 1; i <= daysInM; i++) {
						tdItems.push({
							day: i,
							class: [],
							ids: []
						});
					}

					

					tdItems.forEach( function(item, index) {
						daysTaken.forEach( function(schedule){
							if(schedule.days.includes(item.day)){
								item.class.push('type-' + schedule.type);
								item.ids.push('schedule-' + schedule.id);
							}
						})
					});


					newItems[index].daysMap = tdItems;
				});
			
				return newItems;
		  },
		  getSchedulesDaymap(){
		  	let daysInM = this.daysInM;
		  	let startOfM = this.startOfM
		  	let endOfM = this.endOfM;
				let newItems = this.guides;

				newItems.forEach( function(item, index) {
					let daysTaken = [];
		     
					item.guide_schedules.forEach( function(schedule, index) {
					    let startOfS = moment(schedule.start_at);
		          let   endOfS = moment(schedule.end_at);
		          let maxStart = moment.max(startOfM, startOfS).date();
		          let   minEnd = moment.min(endOfM, endOfS).date();
		          let  daysMap = {
					          type : null,
					          days : [],
					          id   : null
					      	};
		          utils.buildArray(daysMap.days, maxStart, minEnd);
		          daysMap.type = schedule.type;
		          daysMap.id = schedule.id;
		          daysTaken.push(daysMap);
					});

					console.dir(daysTaken);

					let tdItems = [];
					
					for (var i = 1; i <= daysInM; i++) {
						tdItems.push({
							day: i,
							class: [],
							ids: []
						});
					}

					

					tdItems.forEach( function(item, index) {
						daysTaken.forEach( function(schedule){
							if(schedule.days.includes(item.day)){
								item.class.push('type-' + schedule.type);
								item.ids.push('schedule-' + schedule.id);
							}
						})
					});


					newItems[index].daysMap = tdItems;
				});
			
				return newItems;
		  }
		},
		created() {
				this.getGuidesWithRangeSchedule();
				this.$eventHub.$on("vehicleAdded", ()=>{this.getGuidesWithRangeSchedule()});
		},
		watch: {
  
      checkDate: function (newDate, oldDate) {
        this.getGuidesWithRangeSchedule();
      },

      scheduleType: function(newTypes, oldTypes){
      	if(newTypes.length) {
      		this.getGuidesWithRangeSchedule();
      	} else {
      		this.scheduleType = oldTypes;
      	}
      	
      }
  },
		methods: {
			getGuidesWithRangeSchedule(){
            axios.get('/guides/range-schedules', {
              params: {
                start_at: this.startOfM.format("YYYY-MM-DD"),
                end_at: this.endOfM.format("YYYY-MM-DD"),
                types: this.scheduleType
              }
            })
            .then(response => { 
                this.guides = response.data
            }); 
    	}

		  
		}

	}
</script>
<style lang="scss">
.my-table{
	border-spacing: 0;
	.expand-view {
		td {
			height: 20px;
			padding: 0 5px;
		}

		.name {
			background-color: #dddddd;
		}
	}
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
