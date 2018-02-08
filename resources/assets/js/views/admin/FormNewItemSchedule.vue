<template>
<v-container fluid>
  <v-layout row justify-center>
    <v-flex xs12 sm10 md8>
       <v-form v-model="valid" ref="form" lazy-validation>
          <v-card>
            <v-card-text>
             <v-container grid-list-md>
                <v-layout row class="mb-3">
                  <v-flex xs12 sm6 md6>
			           	  <v-select
				              :label=" 'Select ' + itemType "
				              v-bind:items="itemsNamesAndIds"
				              v-model="formData.item"
				              item-text="name"
				              item-value="id"
				          		return-object
				              autocomplete
				            >
				            </v-select>
			          	</v-flex>
			          	<v-flex xs12 sm6 md6>
			           	  <v-select
				              label="Select Schedule Type"
				              v-bind:items="scheduleTypes.slice(1)"
				              v-model="formData.scheduleType"
				              item-text="name"
				              item-value="id"
				          		return-object
				              autocomplete
				            >
				            </v-select>
			          	</v-flex>
			        </v-layout>
			        <v-layout row class="mb-3">
			        	 	<v-flex xs12 sm6 md3>
                    <v-menu
                      lazy
                      :close-on-content-click="false"
                      v-model="menu.startDate"
                      transition="scale-transition"
                      offset-y
                      full-width
                      :nudge-right="40"
                      max-width="290px"
                      min-width="290px">
                      <v-text-field
                      slot="activator"
                      label="Start Date"
                      v-model="formData.startDate"
                      placeholder="Click to Choose"
                      prepend-icon="event"
                      readonly
                      required
                      ></v-text-field>
                      <v-date-picker v-model="formData.startDate" no-title scrollable actions :allowed-dates="allowedStartDate">
                        <template slot-scope="{ save, cancel }">
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn flat color="primary" @click="cancel">Cancel</v-btn>
                            <v-btn flat color="primary" @click="save">OK</v-btn>
                          </v-card-actions>
                        </template>
                      </v-date-picker>
                    </v-menu>
                  </v-flex>
                  <v-flex xs12 sm6 md3>
                    	<v-text-field
                      label="Start Time"
                      v-model="formData.startTime"
                      type="time"
                      required
                      suffix="EST"
                      ref="startTime"
                  		></v-text-field>
                	</v-flex>
                	<v-flex xs12 sm6 md3>
                          <v-menu
                            lazy
                            :close-on-content-click="false"
                            v-model="menu.endDate"
                            transition="scale-transition"
                            offset-y
                            full-width
                            :nudge-right="40"
                            max-width="290px"
                            min-width="290px">
                            <v-text-field
                            slot="activator"
                            label="End Date"
                            v-model="formData.endDate"
                            placeholder="Click to Choose"
                            prepend-icon="event"
                            readonly
                            required
                            ></v-text-field>
                            <v-date-picker v-model="formData.endDate" no-title scrollable actions :allowed-dates="allowedEndDate">
                              <template slot-scope="{ save, cancel }">
                                <v-card-actions>
                                  <v-spacer></v-spacer>
                                  <v-btn flat color="primary" @click="cancel">Cancel</v-btn>
                                  <v-btn flat color="primary" @click="save">OK</v-btn>
                                </v-card-actions>
                              </template>
                            </v-date-picker>
                          </v-menu>
                  </v-flex>
                  <v-flex xs12 sm6 md3>
                    	<v-text-field
                      label="End Time"
                      v-model="formData.endTime"
                      type="time"
                      required
                      suffix="EST"
                      ref="endTime"
                  		></v-text-field>
                	</v-flex>
			        </v-layout>
			        <v-layout row class="mb-3">
			        	<v-flex xs12 sm12 md12>
                    <v-text-field
                      name="note"
                      label="Schedule Note"
                      v-model="formData.note"
                      textarea
                      hint=""
                    ></v-text-field>
                 </v-flex>
			        </v-layout>
			      </v-container>
            </v-card-text>
            <v-card-actions class="pa-3">
              <v-btn large color="primary"
                  @click="submit"
                  :disabled="!valid"
                >
                  submit
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn large @click="clear">clear</v-btn>
            </v-card-actions>
          </v-card>
      </v-form>
      <v-snackbar
        :timeout="toast.timeout"
        :color="toast.color"
        absolute
        top
        v-model="snackbar"
      >
        {{ toast.text }}
        <v-btn dark flat @click.native="snackbar = false">Close</v-btn>
        </v-snackbar>
    </v-flex>
  </v-layout>
</v-container>
</template>
<script>
import ItemBuilder from "../../mixins/build-items.js"
import ScheduleDateSelect from "../../mixins/schedule-date-select.js"

	export default {
		name: "form-new-item-schedule",
		mixins: [
			ItemBuilder, ScheduleDateSelect
		],
		data: ()=>({
			formData:{
				item: null,
				scheduleType: null,
        startDate:null,
        startTime:"12:30:00",
        endDate:null,
        endTime: "12:30:00",
        note: null
			},
			valid: false,
			snackbar: false,
			items: []
		}),
		props: {
			itemType :
			{
				type: String,
				default: null,
			},
			scheduleTypes: {
				type: Array,
				default: null
			},
			toast: {
				type: Object,
				default: ()=>({
					text: "New Item Added",
					timeout: 2000,
					color: "success"	
				})

			}
		},
    computed: {
      fetchUrl() {
        return '/' + this.itemType.toLowerCase() + 's';
      },
      postUrl(){
        return '/' + this.itemType.toLowerCase() + 'schedules' + '/new';
      }
    },
		created(){
      var d = new Date();
      this.formData.startDate = d.toISOString().substr(0, 10);
			this.populateItems();
		},
		methods: {
			populateItems(){
        axios.get(this.fetchUrl)
        .then(response => { 
            this.items = response.data
        }); 
			},
      storeItem(){
        axios.post(this.postUrl, this.formData).then(
          response => {
            this.clear();
            this.snackbar = true;
            this.$eventHub.$emit(this.itemType + 'Added');
          }); 
      },
			submit() {
        this.storeItem();
			},

			clear(){
        this.formData = {
        item: null,
        scheduleType: null,
        startDate:null,
        startTime:"12:30:00",
        endDate:null,
        endTime: "12:30:00",
        note: null
        }
			}
		}
	}
	
</script>