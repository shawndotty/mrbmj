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
		    </v-toolbar>
			</v-flex>
		
			<v-flex xl12>
				<v-card>
					
				<table class="my-table" >
					<thead>
						<tr><th width="80px">Order</th><th v-for="item in getHeaderDays">{{ item.date}} {{ item.dow }}</th></tr>
					</thead>
					<tbody>
						<tr v-for="item in getTdItems">
							<td class="text-xs-center">{{ item.id }}</td>
							<td v-for="(day, index) in item.daysMap" :colspan="day.span" :class="day.class" title="test"> 
								<!-- <div v-if="day.info" class="order-info">
									some thing to say here
								</div> -->
							</td>
						</tr>	
					</tbody>
				</table>
				<v-card-text v-if="noOrders">
					<v-alert :value="true" color="error" icon="warning">
		        Sorry, nothing to display here :(
		      </v-alert>	
				</v-card-text>
				</v-card>
			</v-flex>
</v-layout>

</template>
<script>
import moment from "moment";
export default {
	name: "orders-schedules-view",
	data(){
		return {
			monthPickMenu: false,
      checkDate : moment().format("YYYY-MM"),
			chooseDate: '',
      headers: [],
      show: false,
      noOrders: false,
      orders:[]
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
			let newItems = this.orders;

			newItems.forEach( function(item, index) {
		    let startOfS = moment(item.pickup_at);
        let   endOfS = moment(item.dropoff_at);
        let maxStart = moment.max(startOfM, startOfS).date();
        let   minEnd = moment.min(endOfM, endOfS).date();
        let  daysMap = {
		          start : null,
		          days : [],
		          span   : null
		      	};
        comp.buildArray(daysMap.days, maxStart, minEnd);
        daysMap.span = daysMap.days.length;
        daysMap.start = maxStart

	      let tdItems = [];
				
				for (var i = 1; i <= daysInM; i++) {
					if ( i == daysMap.start ) {
						tdItems.push({
							day: i,
							span: daysMap.span,
							class: "order",
							info: true, 
						});
					} else if ( i != daysMap.start && daysMap.days.includes(i)) {
						
					} else {
						tdItems.push({
							day: i,
							span: 1,
							info: false, 
						});
					}
				}

				newItems[index].daysMap = tdItems;

			});
		
			return newItems;
	  }
	},
	created() {
        this.getOrdersWithRangeSchedule();
        this.$eventHub.$on("orderAdded", ()=>this.getOrdersWithRangeSchedule());
    },

  watch: {
  
      checkDate: function (newDate, oldDate) {
        this.getOrdersWithRangeSchedule();
      },

      scheduleType: function(newTypes, oldTypes){
      	if(newTypes.length) {
      		this.getOrdersWithRangeSchedule();
      	} else {
      		this.scheduleType = oldTypes;
      	}
      	
      }
  },
  methods: {
  	getOrdersWithRangeSchedule(){
            axios.get('/orders/in-range', {
              params: {
                start_at: this.startOfM.format("YYYY-MM-DD"),
                end_at: this.endOfM.format("YYYY-MM-DD"),
              }
            })
            .then(response => { 
                this.orders = response.data
                if (!this.orders.length) {
                	this.noOrders = true;
                } else {
                	this.noOrders = false;
                }
            }); 
    },
    buildArray(target, start, end){
      	for(var i=start; i<=end; i++) {
      		target.push(i);
      	}
    }
  }
}
</script>
<style lang="scss">


	.my-table{
	border-spacing: 0;

	.order-info {
		display: none;
		position: absolute;
		top: 0px;
		left: 0px;
		z-index: 100;
		background-color: #dddddd;
		padding: 6px;
	}

	tr:hover{
		background-color:#bbb;
	}

	td:hover .order-info{
		display: block;
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

	tr td.order{
		background-color: orange;        
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