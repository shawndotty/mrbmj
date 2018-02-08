<template>
  <v-layout row justify-center>
  	<v-flex xs12 md12>
  		<v-card>
  			<v-toolbar>
         <v-toolbar-title>All Guides</v-toolbar-title>
         <v-spacer></v-spacer>
         <v-btn color="secondary" dark @click.native.stop="toggleNewItem">Add New Guide</v-btn>

         <v-btn color="primary" dark @click.native.stop="toggleNewItemSchedule">Add Guide Schedule</v-btn>
       </v-toolbar>
       <items-schedules-view
          :itemType="itemType"
          :scheduleTypes="scheduleTypes"
        >
        </items-schedules-view>
      </v-card>
    </v-flex>
    
    <v-dialog v-model="newItemScheduleDialog" fullscreen transition="dialog-bottom-transition" :overlay=false>
      <v-card>
        <dialog-toolbar title="Add New Guide Schedule" v-on:closeDialog="toggleNewItemSchedule"></dialog-toolbar> 
        <form-new-item-schedule
          :itemType = "itemType" :scheduleTypes="scheduleTypes"
        ></form-new-item-schedule>  
      </v-card>
    </v-dialog>

    <v-dialog v-model="newItemDialog" fullscreen transition="dialog-bottom-transition" :overlay=false>
      <v-card>
        <dialog-toolbar title="Add New Guide" v-on:closeDialog="toggleNewItem"></dialog-toolbar> 
        <form-new-guide></form-new-guide>  
      </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
	import FormNewGuide from "./FormNewGuide.vue"
  import DialogToolbar from "./partials/DialogToolbar.vue"
  import ItemsSchedulesView from "./ItemsSchedulesView.vue"
  import { guideScheduleType } from "../../mixins/schedule-types.js"
  import FormNewItemSchedule from "./FormNewItemSchedule.vue"
  import ItemDialog from "../../mixins/item-dialog.js"
  export default {
  	components: {
  		FormNewGuide, DialogToolbar, ItemsSchedulesView, FormNewItemSchedule
  	},
    mixins: [
      guideScheduleType, ItemDialog
    ],
    data () {
      return {
        itemType: 'guide',
      }
    },

    methods: {
    }
  }
</script>