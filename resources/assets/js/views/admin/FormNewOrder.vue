<template>
<v-container>
  <v-layout row justify-center>
    <v-flex xs12 sm12 md10>
      <v-form v-model="valid" ref="form" lazy-validation>
        <v-expansion-panel expand>
          <v-expansion-panel-content :value="true">
            <div slot="header"><h1 class="title">Order Basic Info <v-chip color="red" small text-color="white">Required</v-chip></h1></div>
            <v-card>
              <v-card-text  class="grey lighten-4">
              <v-container grid-list-md>
                <v-layout row class="mb-3">
                  <v-flex xs12 sm6 md3>
                    <v-select
                      v-bind:items="clientsNamesAndIds"
                      item-text="name"
                      item-value="id"
                      v-model="formData.client"
                      return-object
                      label="Client Name"
                      :autocomplete="true"
                      :error-messages="clientNameErrors"
                      @change="$v.formData.client.$touch()"
                      @blur="$v.formData.client.$touch()"
                      required
                      bottom
                    ></v-select>
                    </v-flex>
                    <v-flex xs12 sm6 md3>
                      <v-select
                        v-bind:items="orderTypes"
                        v-model="formData.orderType"
                        item-text="name"
                        item-value="id"
                        return-object
                        label="Order Type"
                        :autocomplete="true"
                        :error-messages="orderTypeErrors"
                        @change="$v.formData.orderType.$touch()"
                        @blur="$v.formData.orderType.$touch()"
                        bottom
                        required
                      ></v-select>
                    </v-flex>
                    <v-flex xs12 sm6 md3>
                    <v-text-field
                      label="PAX"
                      type="number"
                      min="1"
                      hint="Only type the number"
                      v-model="formData.pax"
                      required
                    ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md3>
                      <v-select
                        v-bind:items="groupTypes"
                        v-model="formData.groupType"
                        label="Group Type"
                        :autocomplete="true"
                        bottom
                        required
                      ></v-select>
                    </v-flex>
              </v-layout>
              <v-layout row wrap class="mb-3">
                <v-flex xs12 sm6 md3>
                          <v-menu
                            lazy
                            :close-on-content-click="false"
                            v-model="menu.pickupDate"
                            transition="scale-transition"
                            offset-y
                            full-width
                            :nudge-right="40"
                            max-width="290px"
                            min-width="290px">
                            <v-text-field
                            slot="activator"
                            label="Pickup Date"
                            v-model="formData.pickupDate"
                            placeholder="Click to Choose"
                            prepend-icon="event"
                            readonly
                            required
                            ></v-text-field>
                            <v-date-picker v-model="formData.pickupDate" no-title scrollable actions :allowed-dates="allowedDates">
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
                      label="Pickup Time"
                      v-model="formData.pickupTime"
                      type="time"
                      required
                      suffix="EST"
                      ref="pickupTime"
                  ></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md6>
                    <place-input 
                    label="Pickup Location"
                    required
                    v-model="formData.pickupLocation"
                    :option="placeOption"></place-input>
                  </v-flex>
              </v-layout>
              <v-layout row wrap class="mb-3">
                
                  <v-flex xs12 sm6 md3>
                          <v-menu
                          lazy
                          :close-on-content-click="false"
                          v-model="menu.dropoffDate"
                          transition="scale-transition"
                          offset-y
                          full-width
                          :nudge-right="40"
                          max-width="290px"
                          min-width="290px">
                          <v-text-field
                          slot="activator"
                          label="Dropoff Date"
                          v-model="formData.dropoffDate"
                          placeholder="Click to Choose"
                          prepend-icon="event"
                          readonly
                          required
                          ></v-text-field>
                          <v-date-picker v-model="formData.dropoffDate" no-title scrollable actions :allowed-dates="allowedDropoffDates">
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
                          label="Dropoff Time"
                          v-model="formData.dropoffTime"
                          type="time"
                          suffix="EST"
                          required
                          ref="dropoffTime"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm12 md6>
                      <place-input required v-model="formData.dropoffLocation" label="Dropoff Location"></place-input>
                    </v-flex>
              </v-layout>
             
              </v-container>
              </v-card-text>
            </v-card>
          </v-expansion-panel-content>
        
          <v-expansion-panel-content :value="true">
            <div slot="header"><h1 class="title">Vehicles <v-chip color="red" small text-color="white">Required</v-chip></h1></div>
            <v-card>
              <v-card-text class="grey lighten-4">
              <v-container grid-list-md>
                <v-layout row wrap class="mb-3">
                  <v-flex xs12 sm6 md6>
                    <v-text-field
                      label="Number of Vehicles Needed"
                      type="number"
                      min="1"
                      required
                      hint="Choose at least 1 vehicle"
                      v-model="formData.vehiclesNeeded"
                      v-on:input="prepareVehiclesSelect"
                    ></v-text-field>
                  </v-flex>
                </v-layout>
                 <v-layout row wrap class="mb-3">
                  <v-flex v-for="(vehicle, index) in formData.vehicles" :key="index" xs12 sm6 md6>
                    <v-select
                      v-bind:items="vehicleTypes"
                      v-model="formData.vehicles[index]"
                      item-text="typeIntro"
                      item-value="typeId"
                      :label="'Vehicle' + (index + 1)"
                      return-object
                      :autocomplete="true"
                      bottom
                      required
                    ></v-select>  
                </v-flex>
                
              </v-layout>
              </v-container>
              </v-card-text>
            </v-card>
          </v-expansion-panel-content>
          <v-expansion-panel-content :value="false">
            <div slot="header"><h1 class="title">Itinerary <v-chip color="blue" small text-color="white">Optional</v-chip></h1></div>
            <v-card>
              <v-card-text class="grey lighten-4">
              <v-container grid-list-md>
                <v-layout row wrap class="mb-3">
                  <v-flex xs12 sm12 md12>
                    <v-text-field
                      name="itinerary"
                      label="Order Itinerary"
                      v-model="formData.itinerary"
                      textarea
                      hint="Like this: Day 1, New York to Boston"
                    ></v-text-field>
                  </v-flex>
                </v-layout>
                
              </v-container>
              </v-card-text>
            </v-card>
          </v-expansion-panel-content>
        </v-expansion-panel>
      
        <v-card class="mb-5">
          <v-card-actions class="pt-5 pb-5 pl-3 pr-3">
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
  import { validationMixin } from 'vuelidate'
  import { required, maxLength, email } from 'vuelidate/lib/validators'
  import moment from "moment"
  import PlaceInput from "./partials/PlaceInput.vue"
 

 export default {
  name: "form-new-order",
  mixins: [validationMixin],
  validations: {
    formData:{
        client: {
          required
        },
        orderType: {
          required
        },
        pax: {
          required
        },
        groupType: {
          required
        },
        pickupDate: {
          required
        },
        pickupTime: {
          required
        },
        dropoffDate: {
          required
        },
        dropoffTime: {
          required
        },
        pickupLocation: {
          required
        },
        dropoffLocation: {
          required
        },
        vehicles: {
          required
        },
        vehiclesNeeded: {
          required
        }
      },
  },
  components: {
    PlaceInput
  },
  data() {
    return {
      formData:{
        client: null,
        orderType: null,
        pax: 0,
        groupType: null,
        pickupDate: null,
        pickupTime: "12:30:00",
        dropoffDate: null,
        dropoffTime: "12:30:00",
        pickupLocation: null,
        dropoffLocation: null,
        vehicles: [{}],
        vehiclesNeeded: 1,
        itinerary: ''
      },
      valid: false,
      snackbar: false,
      toast: {
        timeout: 2000,
        color: 'success',
        text: 'New Order Added.'
      },
      placeOption: {
        aroundLatLngViaIP: false,
        countries: ['us']
      },
      orderTypes: [
        {
          name: "Quote",
          id: 1,
        },
        {
          name: "Order",
          id: 2,
        }
      ],
      vehicleTypes: [
        {
          typeIntro: 'Minivan - Seated Up To 8',
          typeId: 1
        },
        {
          typeIntro: 'Van - Seated Up To 12',
          typeId: 2
        },
        {
          typeIntro: 'Sprinter - Seated Up To 14',
          typeId: 3
        },

        {
          typeIntro: 'Minibus - Seated Up To 36',
          typeId: 4
        },
        {
          typeIntro: 'Motorcoach - Seated Up To 61',
          typeId: 5
        }
      ],
      groupTypes: [
        'Military/Government', 
        'Club', 
        'Corporate',
        'Education/Academic',
        'Family',
        'Religious',
        'Sports',
        'Youth',
        'Other'        
      ],
      
        
        menu: {
          pickupDate: false,
          dropoffDate: false,
          pickupTime: false,
          dropoffTime: false,
        },
        allowedDates: {},
        allowedTime:{
          minutes: function (value) {
            return value % 15 === 0
          }
        },
        
        clients:[]
    }
  },

  watch: {
    initialDialog: function (val) {
      this.dialog = val;
    }
  },
  created() {
      axios.get('/clients')
      .then(response => this.clients = response.data );
    },
  mounted() {
    const d = new Date();
    this.allowedDates.min = d.toISOString().substr(0, 10);
  },
  computed: {
    clientsNamesAndIds(){
        let clients = [];
        this.clients.forEach( function(element, index) {
          // statements
          let client = {}
          client.name = element.first_name + ' ' + element.last_name;
          client.id = element.id;
          clients.push(client);
        });

        return clients;
      },

      allowedDropoffDates(){
        return {
          min: this.formData.pickupDate
        }
      },
      orderTypeErrors () {
        const errors = []
        if (!this.$v.formData.orderType.$dirty) return errors
        !this.$v.formData.orderType.required && errors.push('Order type is required!')
        return errors
      },
      clientNameErrors () {
        const errors = []
        if (!this.$v.formData.client.$dirty) return errors
        !this.$v.formData.client.required && errors.push('Clietn name is required')
        return errors
      },
      nameErrors () {
        const errors = []
        if (!this.$v.name.$dirty) return errors
        !this.$v.name.maxLength && errors.push('Name must be at most 10 characters long')
        !this.$v.name.required && errors.push('Name is required.')
        return errors
      },
      emailErrors () {
        const errors = []
        if (!this.$v.email.$dirty) return errors
        !this.$v.email.email && errors.push('Must be valid e-mail')
        !this.$v.email.required && errors.push('E-mail is required')
        return errors
      }
  },
  methods: {
    
    submit () {
        if (this.$refs.form.validate()) {
          // Native form submission is not yet supported
          console.log(this.$refs.pickupTime.value);
          console.log(this.dropoffTime);
          axios.post('/orders/new', this.formData).then(response => {
            this.snackbar = true;
            this.$eventHub.$emit('orderAdded');
            this.clear();
          });
        }
      },
    clear () {
      this.$refs.form.reset()
    },

    prepareVehiclesSelect(value) {
      if (value <= 0 ) {
        this.formData.vehiclesNeeded = 1;
      } else {
        this.formData.vehicles = [];
        for (var i = 1; i<=value; i++) {
          let o = {};
          this.formData.vehicles.push(o);
        }
      }
    }
  }
 }
</script>