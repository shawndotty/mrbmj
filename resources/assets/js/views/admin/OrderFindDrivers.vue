<template>
<v-container fluid grid-list-xl>
	<v-layout row justify-center>
		<v-flex md12>
			<v-card>
	      <table class="schedule-table">
		  		<thead>
		  			<tr><th width="80px">Drivers</th><th v-for="item in headerDays">{{ item.format("M-D") }}</th><th>Action</th></tr>
		  		</thead>
		  		<tbody>
		  			<tr 
		  				v-if="availableDrivers.totalAvailable"
		  				v-for="driver in availableDrivers.totalAvailable">
		  				<td class="text-xs-center">{{ driver.first_name.slice(-4) }}</td>
		  				<td :colspan="diffDays + 1" class="available"></td>
		  				<td with="80px" class="text-xs-center"><a v-on:click.prevent="addToOrder(driver.id)" small>Add</a></td>
  					</tr>
  					<tr 
		  				v-if="availableDrivers.partAvailable"
		  				v-for="driver in availableDrivers.partAvailable">
		  				<td class="text-xs-center">{{ driver.first_name.slice(-4) }}</td>
		  				<td v-for="date in driver.datesMap" :class="date.class"></td>
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
		name: "order-find-drivers",
		data() {
			return {
				availableDrivers : [],
				daysInHeader : [],
			}
		},
		props: [
			'pickupAt', 'dropoffAt', 'orderId'
		],
		props: {
			
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
			this.$eventHub.$on('checkDrivers', ()=>{
				this.findDrivers();
			})
		},
		computed: {
			headerDays(){
				return this.buildDates(this.pickupAt, this.dropoffAt);
	    },

	    diffDays(){
	    	return moment(this.dropoffAt).diff(moment(this.pickupAt), 'days')
	    },

		},
		methods: {
			addToOrder: function(did){
				let data = {
					oId: this.orderId,
					dId: did
				};
				axios.post('/orders/assigndriver', data).then(response => {
					this.$eventHub.$emit('driverAddedtoOrder');
					this.findDrivers();
          });
			},
			findDrivers: function(){
        
        axios.get('/drivers/schedules', {
          params: {
            start_at: this.pickupAt,
            end_at: this.dropoffAt,
            order_id: this.orderId,
          }
        })
        .then(response => { 
        	this.availableDrivers = response.data 
        	if (this.availableDrivers.partAvailable.length) {
        			this.buildDatesMap(this.availableDrivers.partAvailable);
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