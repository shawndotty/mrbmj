<template>
   <v-layout row fluid>
	   <v-flex md12>
	    <v-toolbar>
          <v-toolbar-title>All Orders</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn icon @click.native.stop="toggleView" :disabled="!scheduleView" >
            <v-icon>reorder</v-icon>
          </v-btn>
          <v-btn icon @click.native.stop="toggleView" :disabled="scheduleView" >
            <v-icon >line_style</v-icon>
          </v-btn>
          <v-btn color="primary" dark @click.native.stop="dialog = true">Add New Order</v-btn>
      </v-toolbar>
      <orders-table-view v-if="!scheduleView"></orders-table-view>
      <orders-schedules-view v-if="scheduleView"></orders-schedules-view>
      <v-dialog v-model="dialog" fullscreen transition="dialog-bottom-transition" :overlay=false>
        <v-card>
          <dialog-toolbar title="Add New Order" v-on:closeDialog="dialog = false"></dialog-toolbar> 
          <form-new-order></form-new-order> 
        </v-card>
      </v-dialog>
    </v-flex>	
  </v-layout>
</template>

<script>
import FormNewOrder from "./FormNewOrder.vue"
import DialogToolbar from "./partials/DialogToolbar.vue"
import OrdersTableView from "./OrdersTableView.vue"
import OrdersSchedulesView from "./OrdersSchedulesView.vue"
export default {
  components: {
    FormNewOrder, DialogToolbar, OrdersTableView, OrdersSchedulesView
  },
		data() {
			return {
        dialog: false,
        scheduleView: true
			}

		},
    methods: {
        toggleView(){
            this.scheduleView = !this.scheduleView;
        }
    }
	}		
</script>