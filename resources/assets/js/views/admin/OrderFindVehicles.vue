<template>
<v-container fluid grid-list-xl>
	<v-layout row justify-center>
		<v-flex md12>
			<v-card>
	      <table class="schedule-table">
		  		<thead>
		  			<tr><th width="80px">Vehicles</th><th v-for="item in headerDays">{{ item.format("M-D") }}</th><th>Action</th></tr>
		  		</thead>
		  		<tbody>
		  			<tr 
		  				v-if="availableVehicles.totalAvailable"
		  				v-for="vehicle in availableVehicles.totalAvailable">
		  				<td class="text-xs-center">{{ vehicle.name.slice(-4) }}</td>
		  				<td :colspan="diffDays + 1" class="available"></td>
		  				<td with="80px" class="text-xs-center"><a v-on:click.prevent="addToOrder(vehicle.id)" small>Add</a></td>
  					</tr>
  					<tr 
		  				v-if="availableVehicles.partAvailable"
		  				v-for="vehicle in availableVehicles.partAvailable">
		  				<td class="text-xs-center">{{ vehicle.name.slice(-4) }}</td>
		  				<td v-for="date in vehicle.datesMap" :class="date.class"></td>
		  				<td with="80px" class="text-xs-center"></td>
  					</tr>
		  		</tbody>
	  		</table>
			</v-card>
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
				availableVehicles : [],
				daysInHeader : [],
			}
		},
		props: [
			'pickupAt', 'dropoffAt', 'vehicleOption', 'orderId'
		],
		props: {
			vehicleOption: {
				type: Object,
				default: ()=>{
					return {}
				}
			},
			pickupAt: {
				type: String,
				default: ''
			},
			dropoffAt: {
				type: String,
				default: ''
			},
			orderId: {
				type: Number,
				default: 0
			}
		},
		created(){
			this.$eventHub.$on('checkVehicles', ()=>{
				this.findVehicles();
			})
		},
		computed: {
			headerDays(){
				return this.buildDates(this.pickupAt, this.dropoffAt);
	    },

	    diffDays(){
	    	return moment(this.dropoffAt).diff(moment(this.pickupAt), 'days')
	    },

	    vehicleTotal(){
	    	return this.vehicleOption.total;	
	    }
		},
		methods: {
			addToOrder: function(vid){
				let data = {
					orderId: this.orderId,
					vehicleId: vid
				};
				axios.post('/orders/assignvehicle', data).then(response => {
					this.$eventHub.$emit('vehicelAddedtoOrder');
					this.findVehicles();
          });
			},
			findVehicles: function(){
				let types = this.vehicleOption.needs.map( function(element, index) {
            	return element.type;
        });
        
        axios.get('/vehicles/schedules', {
          params: {
            start_at: this.pickupAt,
            end_at: this.dropoffAt,
            vehicle_type: types,
            order_id: this.orderId,
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

      	});
      }
		}
	}
</script>
<style lang="scss">
	.schedule-table{
		width: 100%;
		border-spacing: 0;

		thead{
			th {
				height: 40px;
				background-color: #ddd;
			}
		}

		th, td{
			padding:5px;
			border-bottom:1px solid #efefef;
		}

	tr td.available{
		background-color: #2196F3;
	}

	tr td.notAvailable{
		background-color: #333333;
	}
}
</style>