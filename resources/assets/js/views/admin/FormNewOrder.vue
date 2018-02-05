<template>
<v-container>
  <v-layout row justify-center>
    <v-flex xs12 sm12 md10>
      <v-card>
        <v-card-title>
          Add New Order
        </v-card-title>
        <v-card-text>
          <v-form v-model="valid" ref="form" lazy-validation>
            <v-container grid-list-md>
              <v-layout row wrap>
                <v-flex xs11 sm6>
                  <v-select
                    v-bind:items="clientsNamesAndIds"
                    item-text="name"
                    item-value="id"
                    v-model="client"
                    return-object
                    label="Client Name"
                    required
                    bottom
                  ></v-select>
                </v-flex>
                          <v-flex xs11 sm6>
                            <v-select
                            v-bind:items="vehicleTypes"
                            item-text="name"
                            item-value="id"
                            v-model="vehicleType"
                            return-object
                            label="Vehicle Type"
                            bottom
                            ></v-select>
                          </v-flex>
                          <v-flex xs11 sm6 md4>
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
                            v-model="pickupDate"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                            <v-date-picker v-model="pickupDate" no-title scrollable actions :allowed-dates="allowedDates">
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
                        <v-flex xs11 sm6 md4>
                          <v-menu
                          lazy
                          :close-on-content-click="false"
                          v-model="menu.pickupTime"
                          transition="scale-transition"
                          offset-y
                          full-width
                          :nudge-right="40"
                          max-width="290px"
                          min-width="290px"
                          >
                          <v-text-field
                          slot="activator"
                          label="Pickup Time"
                          v-model="pickupTime"
                          prepend-icon="access_time"

                          readonly
                          ></v-text-field>
                          <v-time-picker v-model="pickupTime" autosave :allowed-minutes="allowedTime.minutes"></v-time-picker>
                        </v-menu>
                      </v-flex>
                      <v-flex xs11 sm6 md4>
                        <v-select
                        v-bind:items="cities"
                        item-text="name"
                        item-value="id"
                        prepend-icon="map"
                        v-model="pickupCity"
                        return-object
                        label="Pickup City"
                        bottom
                        ></v-select>
                      </v-flex>
                      <v-flex xs11 sm6 md4>
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
                        v-model="dropoffDate"
                        prepend-icon="event"
                        readonly
                        ></v-text-field>
                        <v-date-picker v-model="dropoffDate" no-title scrollable actions :allowed-dates="allowedDropoffDates">
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
                    <v-flex xs11 sm6 md4>
                      <v-menu
                      lazy
                      :close-on-content-click="false"
                      v-model="menu.dropoffTime"
                      transition="scale-transition"
                      offset-y
                      full-width
                      :nudge-right="40"
                      max-width="290px"
                      min-width="290px"
                      >
                      <v-text-field
                      slot="activator"
                      label="Dropoff Time"
                      v-model="dropoffTime"
                      prepend-icon="access_time"

                      readonly
                      ></v-text-field>
                      <v-time-picker v-model="dropoffTime" autosave :allowed-minutes="allowedTime.minutes"></v-time-picker>
                    </v-menu>
                  </v-flex>
                  <v-flex xs11 sm6 md4>
                    <v-select
                    v-bind:items="cities"
                    item-text="name"
                    item-value="id"
                    prepend-icon="map"
                    v-model="dropoffCity"
                    return-object
                    label="Dropoff City"
                    bottom
                    ></v-select>
                  </v-flex>

                  <v-flex xs11 sm6 md4>
                    <v-btn
                    @click="submit"
                    :disabled="!valid"
                    >
                    submit
                  </v-btn>
                  <v-btn @click="clear">clear</v-btn>
                </v-flex>
              </v-layout>
            </v-container>
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
        </v-card-text>
      </v-card>
    </v-flex>
  </v-layout>
</v-container>      
</template>

<script>
 export default {
  name: "form-new-order",

  data() {
    return {
      
      valid: false,
        client: null,
        vehicleType: null,
        snackbar: false,
        toast: {
          timeout: 2000,
          color: 'success',
          text: 'New Order Added.'
        },
        vehicleTypes: [
        {
          name: 'Coach Bus',
          id: 1
        },
        {
          name: 'Mid Bus',
          id: 2
        },
        {
          name: 'Mini Bus',
          id: 3
        },

        {
          name: 'Mini Van',
          id: 4
        },
        {
          name: 'Full Size Sub',
          id: 5
        },

        {
          name: 'Limo',
          id: 6
        }

        ],
        pickupDate: null,
        pickupTime: null,
        dropoffDate: null,
        dropoffTime: null,
        pickupCity: null,
        dropoffCity: null,
        menu: {
          pickupDate: false,
          dropoffDate: false,
          pickupTime: false,
          dropoffTime: false,
        },

        cities: [
        {
          name: 'New York',
          id: 1
        },
        {
          name: 'Boston',
          id: 2
        },
        {
          name: 'Washington DC',
          id: 3
        },
        {
          name: 'Phili',
          id: 4
        },
        ],
        allowedDates: {},
        allowedTime:{
          minutes: function (value) {
            return value % 15 === 0
          }
        },
        
        clients:[]
    }
  },

  props: [
    'initialDialog'
  ],

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
          min: this.pickupDate
        }
      }
  },
  methods: {
    
    submit () {
        if (this.$refs.form.validate()) {
          // Native form submission is not yet supported
          axios.post('/orders/new', {
            client: this.client.id,
            vehicle_type: this.vehicleType.id,
            pickup_at: this.pickupDate + ' ' + this.pickupTime,
            dropoff_at: this.dropoffDate + ' ' + this.dropoffTime,
            pickup_city: this.pickupCity.id,
            dropoff_city: this.dropoffCity.id,
            // email: this.email,
            // select: this.select,
            // checkbox: this.checkbox
          }).then(response => {
            this.snackbar = true;
            this.$eventHub.$emit('orderAdded');
            this.clear();
          });
        }
      },
      clear () {
        this.$refs.form.reset()
      }
  }
 }
</script>