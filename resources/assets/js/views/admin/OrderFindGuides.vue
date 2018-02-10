<template>
<v-container fluid grid-list-xl>
	<v-layout row justify-center>
		<v-flex md12>
			<v-card>
	      <table class="schedule-table">
		  		<thead>
		  			<tr><th width="80px">Guides</th><th v-for="item in headerDays">{{ item.format("M-D") }}</th><th>Action</th></tr>
		  		</thead>
		  		<tbody>
		  			<tr 
		  				v-if="availableGuides.totalAvailable"
		  				v-for="guide in availableGuides.totalAvailable">
		  				<td class="text-xs-center">{{ guide.first_name.slice(-4) }}</td>
		  				<td :colspan="diffDays + 1" class="available"></td>
		  				<td with="80px" class="text-xs-center"><a v-on:click.prevent="addToOrder(guide.id)" small>Add</a></td>
  					</tr>
  					<tr 
		  				v-if="availableGuides.partAvailable"
		  				v-for="guide in availableGuides.partAvailable">
		  				<td class="text-xs-center">{{ guide.first_name.slice(-4) }}</td>
		  				<td v-for="date in guide.datesMap" :class="date.class"></td>
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
		name: "order-find-guides",
		data() {
			return {
				availableGuides : [],
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
			this.$eventHub.$on('checkGuides', ()=>{
				this.findGuides();
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
				axios.post('/orders/assignguide', data).then(response => {
					this.$eventHub.$emit('guideAddedtoOrder');
					this.findGuides();
          });
			},
			findGuides: function(){
        
        axios.get('/guides/schedules', {
          params: {
            start_at: this.pickupAt,
            end_at: this.dropoffAt,
            order_id: this.orderId,
          }
        })
        .then(response => { 
        	this.availableGuides = response.data 
        	if (this.availableGuides.partAvailable.length) {
        			this.buildDatesMap(this.availableGuides.partAvailable);
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