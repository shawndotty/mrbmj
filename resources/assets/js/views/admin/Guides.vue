<template>
  <v-layout row justify-center>
  	<v-flex xs12 md12>
  		<v-card>
  			<v-toolbar>
         <v-toolbar-title>All Guides</v-toolbar-title>
         <v-spacer></v-spacer>
         <v-btn color="primary" dark @click.native.stop="dialog = true">Add New Guide</v-btn>
       </v-toolbar>
       <items-schedules-view
          :itemType="itemType"
          :scheduleTypes="scheduleTypes"
        >
        </items-schedules-view>
      </v-card>
    </v-flex>
  <v-dialog v-model="dialog" fullscreen transition="dialog-bottom-transition" :overlay=false>
    <v-card>
      <dialog-toolbar title="Add New Guide" v-on:closeDialog="dialog = false"></dialog-toolbar> 
      <form-new-guide></form-new-guide>  
    </v-card>
  </v-dialog>
</v-layout>
</template>

<script>
	import FormNewGuide from "./FormNewGuide.vue"
  import DialogToolbar from "./partials/DialogToolbar.vue"
  import ItemsSchedulesView from "./ItemsSchedulesView.vue"
  export default {
  	components: {
  		FormNewGuide, DialogToolbar, ItemsSchedulesView
  	},
    data () {
      return {
        dialog: false,
        itemType: 'Guide',
        scheduleTypes: [
          { 
            name : "Order",
            color: "red",
            id: 1,
          },
          { 
            name : "Leave",
            color: "yellow",
            id: 2,
          },
          { 
            name : "Vocation",
            color: "green",
            id: 3,
          },
          { 
            name : "Training",
            color: "purple",
            id: 4,
          },
        ]
      }
    },

    methods: {

    }
  }
</script>