<template>
	<v-layout row wrap>
	<v-flex sm12 md7>
        <v-card>
          <v-card-title class="blue white--text">
          <span class="headline">{{ order.name }}</span>
          <v-spacer></v-spacer>
          <v-menu bottom left>
            <v-btn icon slot="activator" dark>
              <v-icon>more_vert</v-icon>
            </v-btn>
            <v-list>
              <v-list-tile v-for="item in items" :key="item.title" @click="">
                <v-list-tile-title>{{ item.title }}</v-list-tile-title>
              </v-list-tile>
            </v-list>
          </v-menu>
          </v-card-title>
          <v-card-text>
          	<v-text-field 
          		v-for="(value, key) in order"
              :name="key"
              :label="key"
              :value="value"
              :key = "key"
              v-model="order[key]"
              readonly
              v-if="!['guides','vehicles', 'drivers', 'id'].includes(key)"
            ></v-text-field>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex xs12 md4 offset-md1>
        <v-layout row wrap>
					<order-items-list 
            title="Drivers"
            :items="order.drivers">
          </order-items-list>
          
          <order-items-list 
            title="Guides"
            :items="order.guides">
          </order-items-list>

          <order-items-list 
            title="Vehicles"
             :items="order.vehicles">
          
              <v-btn v-on:click.prevent="dialog = true" icon>
                  <v-icon>search</v-icon>
          </v-btn>
          </order-items-list>
        </v-layout>
      </v-flex>

      <v-dialog v-model="dialog" fullscreen transition="dialog-bottom-transition" :overlay=false>
      <v-card>
        <dialog-toolbar title="Find Vehicle For Order" v-on:closeDialog="dialog = false"></dialog-toolbar> 
        <order-find-vehicles
          :pickup-at="order.pickup_at"
          :dropoff-at="order.dropoff_at"
          :vehicle-type="order.vehicle_type"
          :order-id = "order.id"
          :order-name = "order.name"
        >
        </order-find-vehicles>
      </v-card>
      </v-dialog>

 </v-layout>
</template>
<script>
	import OrderItemsList from "./OrderItemsList.vue"
  import DialogToolbar from "./partials/DialogToolbar.vue"
  import OrderFindVehicles from "./OrderFindVehicles.vue"
	export default {
		components: {
			OrderItemsList, DialogToolbar, OrderFindVehicles
		},

		data() {
			return {
        dialog: false,
				order: {},
        items: [
        { title: 'Edit Order' },
        { title: 'Delete Order' }
        ],
        availableVehicles: null,
			}

		},

		mounted(){
			axios.get('/order/' + this.$route.params.orderId)
			.then(response => this.order = response.data );
		},

    methods: {
      
    }
	}
</script>

<style>
  .card__title{
    padding: 0 16px;
  }
</style>