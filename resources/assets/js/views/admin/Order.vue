<template>
	<v-layout row>
     <v-flex sm12 md6>
        <v-card>
          <v-card-title class="blue white--text">
          <span class="headline">Order: {{ order.id }}</span>
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
              v-if="!['guides','vehicles', 'drivers', 'id', 'vehicle_option'].includes(key)"
            ></v-text-field>
          </v-card-text>
        </v-card>
    </v-flex>
    <v-flex sm12 md6>
        <v-layout row wrap>
          <order-vehicles-list 
             title="Vehicles"
             :items="order.vehicles"
             :options="order.vehicle_option"
             :vehicleTypes="vehicleTypes"
             :orderId = "order.id">
             <v-btn v-if="dispatchV" small flat color="primary" slot="action" v-on:click.prevent="openDispatch('vehicle')">
              Dispatch
            </v-btn>
          </order-vehicles-list>
        </v-layout>
        <v-layout row wrap>
          <order-drivers-list 
             title="Drivers"
             :drivers="order.drivers"
             :orderId = "order.id"
             :driverNeeded = "driverNeeded"
             >
             <v-btn v-if="dispatchD" small flat color="primary"  slot="action" v-on:click.prevent="openDispatch('driver')">
              Dispatch
            </v-btn>
          </order-drivers-list>
        </v-layout>
        <v-layout row wrap>
          <order-guides-list 
             title="Guides"
             :guides="order.guides"
             :orderId = "order.id"
             :guideNeeded = "guideNeeded"
             >
             <v-btn v-if="dispatchG" small flat color="primary"  slot="action" v-on:click.prevent="openDispatch('guide')">
              Dispatch
            </v-btn>
          </order-guides-list>
        </v-layout>
    </v-flex>
	 

    <v-dialog v-model="dialogV" persistent max-width="800px" :overlay=false>
      <v-card>
        <dialog-toolbar title="Find Vehicle For Order" v-on:closeDialog="dialogV = false"></dialog-toolbar> 
        <order-find-vehicles
          :pickup-at="order.pickup_at"
          :dropoff-at="order.dropoff_at"
          :vehicle-option="order.vehicle_option"
          :order-id = "order.id"
        >
        </order-find-vehicles>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialogD" persistent max-width="800px" :overlay=false>
      <v-card>
        <dialog-toolbar title="Find Drivers For Order" v-on:closeDialog="dialogD = false"></dialog-toolbar> 
        <order-find-drivers
          :pickup-at="order.pickup_at"
          :dropoff-at="order.dropoff_at"
          :order-id = "order.id"
       
        >
        </order-find-drivers>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialogG" persistent max-width="800px" :overlay=false>
      <v-card>
        <dialog-toolbar title="Find Guides For Order" v-on:closeDialog="dialogG = false"></dialog-toolbar> 
        <order-find-guides
          :pickup-at="order.pickup_at"
          :dropoff-at="order.dropoff_at"
          :order-id = "order.id"
        >
        </order-find-guides>
      </v-card>
    </v-dialog>

 </v-layout>
</template>
<script>
	import OrderVehiclesList from "./OrderVehiclesList.vue"
  import OrderFindVehicles from "./OrderFindVehicles.vue"
  import OrderDriversList from "./OrderDriversList.vue"
  import OrderFindDrivers from "./OrderFindDrivers.vue"
  import OrderGuidesList from "./OrderGuidesList.vue"
  import OrderFindGuides from "./OrderFindGuides.vue"
  import DialogToolbar from "./partials/DialogToolbar.vue"
  
  import vehicleTypes from "../../mixins/vehicle-types.js"
	export default {
		components: {
			OrderVehiclesList,
      OrderFindVehicles,
      OrderDriversList,
      OrderFindDrivers,
      OrderGuidesList,
      OrderFindGuides,
      DialogToolbar,
		},
    mixins: [
      vehicleTypes
    ],

		data() {
			return {
        dialogV: false,
        dialogD: false,
        dialogG: false,
        dispatchV: true,
        dispatchD: true,
        dispatchG: true,
				order: {},
        guideNeeded: 0,
        driverNeeded: 0,
        items: [
        { title: 'Edit Order' },
        { title: 'Delete Order' }
        ],
        availableVehicles: null,
			}

		},

    computed: {
    
    },

		created(){
      this.getOrder();
      this.$eventHub.$on(['vehicelAddedtoOrder', 'driverAddedtoOrder', 'guideAddedtoOrder'], ()=>{
        this.getOrder();
      });
      this.$eventHub.$on(['removeOrderVehicle', 'removeOrderDriver', 'removeOrderGuide'], ()=>{
        this.getOrder();
      })
		},

    methods: {
      getOrder(){
        axios.get('/order/' + this.$route.params.orderId)
        .then(response => {
          this.order = response.data;
          this.driverNeeded = this.order.vehicle_option.total;
          this.guideNeeded = this.order.guide_option.total;
          this.checkLeftVehicles();
          this.checkLeftDrivers();
          this.checkLeftGuides();
        } );
      },
      openDispatch(item){
        if(item == 'vehicle') {
          this.dialogV = true;
          this.$eventHub.$emit('checkVehicles');
        } else if (item == 'driver') {
          this.dialogD = true;
          this.$eventHub.$emit('checkDrivers');
        } else if (item == 'guide') {
          this.dialogG = true;
          this.$eventHub.$emit('checkGuides');
        }
      },
      checkLeftVehicles(){  
        if (this.order.vehicle_option.total == this.order.vehicles.length) {
          this.dialogV = false;
          this.dispatchV = false;
        } else {
          this.dispatchV = true;
        }
      },
      checkLeftDrivers(){  
        if (this.order.vehicle_option.total == this.order.drivers.length) {
          this.dialogD = false;
          this.dispatchD = false;
        } else {
          this.dispatchD = true;
        }
      },
      checkLeftGuides(){  
        if (this.order.guide_option.total == this.order.guides.length) {
          this.dialogG = false;
          this.dispatchG = false;
        } else {
          this.dispatchG = true;
        }
      }
    }
	}
</script>

<style>
  .card__title{
    padding: 0 16px;
  }
</style>