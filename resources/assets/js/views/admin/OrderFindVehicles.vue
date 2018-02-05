<template>
<v-container fluid grid-list-xl>
	<v-layout row justify-center>
		<v-flex md10>
				<v-toolbar>
	        <v-toolbar-title> {{ orderName }} - 
	        	<v-chip label>
	        		<v-icon left>star</v-icon>
				      {{ pickupAt }}
				      
				    </v-chip> 
				    <v-chip label>
				    	<v-icon left>star</v-icon>
				      {{ dropoffAt}}
				    </v-chip> 
   				</v-toolbar-title>
	        <v-spacer></v-spacer>
	       	<v-btn color="primary" v-on:click.preven="findVehicles">Check Vehicles</v-btn> 
    		</v-toolbar>
	      <table class="my-table">
		  		<thead>
		  			<tr><th width="80px">Vehicles</th><th v-for="item in headerDays">{{ item.format("M-D") }}</th><th>Action</th></tr>
		  		</thead>
		  		<tbody>
		  			<tr 
		  				v-if="availableVehicles.totalAvailable"
		  				v-for="vehicle in availableVehicles.totalAvailable">
		  				<td class="text-xs-center">{{ vehicle.name.slice(-4) }}</td>
		  				<td :colspan="diffDays + 1" class="available"></td>
		  				<td with="80px" class="text-xs-center">Add</td>
  					</tr>
  					<tr 
		  				v-if="availableVehicles.partAvailable"
		  				v-for="vehicle in availableVehicles.partAvailable">
		  				<td class="text-xs-center">{{ vehicle.name.slice(-4) }}</td>
		  				<td v-for="date in vehicle.datesMap" :class="date.class"></td>
		  				<td with="80px" class="text-xs-center">Add</td>
  					</tr>
		  		</tbody>
	  		</table>

		</v-flex>
	</v-layout>
</v-container>	
</template>
<script>
	import moment from "moment";

	export default {
		name: "order-find-vehicles",
		data() {
			return {
				'availableVehicles' : [],
				'daysInHeader' : [],
			}
		},
		props: [
			'pickupAt', 'dropoffAt', 'vehicleType', 'orderId', 'orderName'
		],
		updated(){

		},
		computed: {
			headerDays(){
				return this.buildDates(this.pickupAt, this.dropoffAt);
	    },

	    diffDays(){
	    	return moment(this.dropoffAt).diff(moment(this.pickupAt), 'days')
	    }
		},
		methods: {
			findVehicles: function(){
				
        axios.get('/vehicles/schedules', {
          params: {
            start_at: this.pickupAt,
            end_at: this.dropoffAt,
            vehicle_type: this.vehicleType, 
          }
        })
        .then(response => { 
        	this.availableVehicles = response.data 
        	if (this.availableVehicles.partAvailable.length) {
        			this.buildDatesMap(this.availableVehicles.partAvailable);
        	}
        }); 
      },

      buildDates: function(start, end){
      	let diff = moment(end).diff(moment(start), 'days');
      	let days = [];
      	for (var i = 0; i <= diff; i++) {
					let d = moment(start).add(i, 'd');
					days.push(d);
				}	
				return days;
      },

      buildDatesMap: function(items) {
      	const vm = this;
      	items.forEach( function(item, index) {

      		let overlaps = item.overlaps.map(function(obj) {
      			let date = '';
      			date = moment(obj.date).format("MM-DD-YYYY");
      			return date;
      		})


      		item.datesMap = vm.headerDays.map(function(day){
      			let dayObj = {};
      			let dateString = day.format('MM-DD-YYYY');
      			dayObj['date'] = dateString;
      			if (overlaps.includes(dateString)) {
      				dayObj['class'] = 'notAvailable'
      				return dayObj ;
      			} else {
      				dayObj['class'] = 'available'
      				return dayObj ;
      			}
      		});

      		console.dir(item.datesMap);

      	});
      }
		}
	}
</script>
<style lang="scss">
	.my-table{
		width: 100%;
		border-spacing: 0;

		thead{
			th {
				height: 60px;
				background-color: #ccc;
			}
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

	tr td.available{
		background-color: #2196F3;
	}

	tr td.notAvailable{
		background-color: #333333;
	}
}
</style>