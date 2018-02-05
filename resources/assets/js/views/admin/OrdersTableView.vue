<template>

      <v-layout>
            <v-flex xs12>
               <v-data-table
					      v-bind:headers="headers"
					      :items="items"
					      class="elevation-1"
					        >
					        <template slot="items" slot-scope="props">
					          <td>{{ props.item.id }}</td>
					          <td class="text-xs-left">
					            <router-link :to="{ name: 'order', params: { orderId: props.item.id }}">
					            {{ props.item.name }}
					            </router-link>
					          </td>
					          <td class="text-xs-right">
					            <router-link :to="{ name: 'client', params: { clientId: props.item.client_id }}">
					            {{ props.item.client.first_name }} {{ props.item.client.last_name }}
					            </router-link>
					          </td>
					          <td class="text-xs-right">{{ props.item.pickup_at }}</td>
					          <td class="text-xs-right">{{ props.item.pickup_location_id }}</td>
					          <td class="text-xs-right">{{ props.item.dropoff_at }}</td>
					          <td class="text-xs-right">{{ props.item.dropoff_location_id }}</td>
					          <td class="text-xs-right">{{ getResourceName(props.item.drivers) }}</td>
					          <td class="text-xs-right">{{ getResourceName(props.item.guides) }}</td>
					          <td class="text-xs-right">{{ getResourceName(props.item.vehicles) }}</td>
					          <td class="text-xs-right">{{ props.item.vehicle_type }}</td>
					        </template>
					      </v-data-table> 
            </v-flex>
        </v-layout>

</template>
<script>
export default {
	name: "orders-table-view",
	data() {
		return {
			headers: [
          {
            text: 'Order ID',
            align: 'left',
            sortable: true,
            value: 'id'
          },
          { text: 'Order Name', align: 'left', value: 'name' },
          { text: 'Client', value: 'name' },
          { text: 'Pick Up', value: 'pickup_at' },
          { text: 'Pick Up Location', value: 'pickup_location_id' },
          { text: 'Drop Off', value: 'dropoff_at' },
          { text: 'Drop Off Location', value: 'dropoff_location_id' },
          { text: 'Drivers', value: 'drivers' },
          { text: 'Guides', value: 'guides' },
          { text: 'Vehicles', value: 'vehicles' },
          { text: 'Vehicle Type', value: 'vehicle_type' },
        ],
      items: []
		}
	},

	created() {
				this.getOrders();
        this.$eventHub.$on("orderAdded", ()=>this.getOrders());
		},

  methods: {
  	getOrders(){
			axios.get('/orders')
			.then(response => this.items = response.data );
  	},
    getResourceName(resources){

      if (resources.length != 0) {
        return resources[0].name;
      } else {
        return "Not Assigned"
      }
    }
  }
}
</script>