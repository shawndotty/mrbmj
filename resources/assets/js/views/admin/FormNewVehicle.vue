<template>
<v-container>
  <v-layout row justify-center>
    <v-flex xs12 sm10 md8>
                <v-card>
                  <v-card-text>
                    <v-form v-model="valid" ref="form" lazy-validation>
                    <v-text-field label="Vehicle Code" v-model="vehicleCode" required></v-text-field>
                    <v-select
                        v-bind:items="vehicleTypes"
                        item-text="name"
                        item-value="id"
                        v-model="vehicleType"
                        return-object
                        label="Vehicle Type"
                        bottom
                        ></v-select>
                    <v-btn
                    @click="submit"
                    :disabled="!valid"
                    >
                    submit
                    </v-btn>
                    <v-btn @click="clear">clear</v-btn>
                     </v-form>
                  </v-card-text>
                </v-card>
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
import VehicleTypes from "../../mixins/vehicle-types.js"

 export default {
  name: "form-new-vehicle",
  mixins: [
    VehicleTypes
  ],
  data() {
    return {
      vehicleCode: '',
      valid: false,
      vehicleType: null,
      snackbar: false,
      toast: {
        timeout: 2000,
        color: 'success',
        text: 'Vehicle Created'
      },
    }
  },
  methods: {
    submit () {
        if (this.$refs.form.validate()) {
          // Native form submission is not yet supported
          axios.post('/vehicles/new', {
            vehicle_code: this.vehicleCode,
            vehicle_type: this.vehicleType.id,
          }).then(response => {
            this.clear();
            this.snackbar = true;
            this.$eventHub.$emit('vehicleAdded')
          })
        }
      },
      clear () {
        this.$refs.form.reset()
        console.log("cleared");
      }
  }
 }
</script>s