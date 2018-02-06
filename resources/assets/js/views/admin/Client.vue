<template>
<v-layout row wrap>
	<v-flex sm12 md12>
		 <v-toolbar dark color="primary">
		    <v-toolbar-title>Client: {{ client.first_name }} {{ client.last_name }}</v-toolbar-title>
		    <v-spacer></v-spacer>
		    <v-toolbar-side-icon class="hidden-md-and-up"></v-toolbar-side-icon>
		    <v-toolbar-items class="hidden-sm-and-down">
		      <v-btn v-on:click.native.stop="showOrders = true" flat>Client Orders ( {{ orders.length}} )</v-btn>
		      <v-btn flat>Client Invoices ( {{ invoices.length}} )</v-btn>

		    </v-toolbar-items>
		 </v-toolbar>
        <v-card>
          <v-card-text>
          	<v-text-field 
          		v-for="(value, key) in client"
              :name="key"
              :label="key"
              :value="value"
              :key = "key"
              v-model="client[key]"
              v-if="!['orders','invoices'].includes(key)"
              readonly
            ></v-text-field>
          </v-card-text>
        </v-card>

        <v-card v-if="showOrders">
          <v-card-text>
          	<v-data-table
				      v-bind:headers="orderHeaders"
				      :items="orders"
				      hide-actions
				      class="elevation-1"
				    >
				    <template slot="items" slot-scope="props">
				      <td>{{ props.item.id }}</td>
				      <td class="text-xs-right">{{ props.item.pickup_at }}</td>
				      <td class="text-xs-right">{{ props.item.pickup_location_id }}</td>
				      <td class="text-xs-right">{{ props.item.dropoff_at }}</td>
				      <td class="text-xs-right">{{ props.item.dropoff_location_id }}</td>
				      <td class="text-xs-right">{{ props.item.vehicle_type }}</td>
				     
				    </template>
				  </v-data-table>
         </v-card-text>
        </v-card>
      </v-flex>

   

 </v-layout>
</template>
<script>
export default {
		data() {
			return {
				client: {},
				orders:[],
				showOrders: false,
				invoices: [],  
				orderHeaders: [
          {
            text: 'Order ID',
            align: 'left',
            sortable: false,
            value: 'id'
          },
          { text: 'Start At', value: 'pickup_at' },
          { text: 'Pick Up City', value: 'pickup_location_id' },
          { text: 'End At', value: 'dropoff_at' },
          { text: 'Drop Off City', value: 'dropoff_location_id' },
          { text: 'Vehicle Type', value: 'vehicle_type' }
         
        ],
			}

		},

		mounted(){
			axios.get('/client/' + this.$route.params.clientId)
			.then(response => {
				this.client = response.data;
				this.orders = response.data.orders;
				this.invoices = response.data.invoices;
			} );
		}
	}	
</script>