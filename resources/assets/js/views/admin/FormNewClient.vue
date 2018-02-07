<template>
<v-container>
  <v-layout row justify-center>
    <v-flex xs12 sm10 md8>
       <v-form v-model="valid" ref="form" lazy-validation>
          <v-card>
            <v-card-text>
             
                <v-text-field
                  label="First Name"
                  v-model="firstName"
                  :rules="nameRules"
                  required
                ></v-text-field>
                <v-text-field
                  label="Last Name"
                  v-model="lastName"
                  :rules="nameRules"
                  required
                ></v-text-field>
                <v-text-field
                  label="Email"
                  v-model="email"
                  :rules="emailRules"
                  required
                ></v-text-field>
                <v-text-field
                  label="Phone"
                  v-model="phone"
                  :rules="phoneRules"
                  required
                ></v-text-field>
                <v-text-field
                  label="Company"
                  v-model="company"
                ></v-text-field>
                <v-text-field
                  label="Address"
                  v-model="address"
                ></v-text-field>

                
              
            </v-card-text>
            <v-card-actions>
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
export default {
  name: "form-new-client",
    data: () => ({
      valid: true,
      firstName: '',
      nameRules: [
        (v) => !!v || 'Name is required',
        (v) => v && v.length <= 10 || 'Name must be less than 10 characters'
      ],
      lastName: '',
      email: '',
      emailRules: [
          (v) => !!v || 'E-mail is required',
          (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
      ],
      phone: '',
      phoneRules: [
          (v) => !!v || 'Phone is required'
      ],
      company: '',
      address:'',
      snackbar: false,
      toast: {
        timeout: 2000,
        color: 'success',
        text: 'New Client Added.'
      },
    }),
   
    methods: {
      
      submit () {
        if (this.$refs.form.validate()) {
          // Native form submission is not yet supported
          axios.post('/clients/new', {
            first_name: this.firstName,
            last_name: this.lastName,
            email: this.email,
            phone: this.phone,
            company: this.company,
            address: this.address,
            // email: this.email,
            // select: this.select,
            // checkbox: this.checkbox
          }).then(response => {
            this.snackbar = true;
            this.$eventHub.$emit('clientAdded');
            this.clear();
          } )

          

        }
      },
      clear () {
        this.$refs.form.reset()
      }
    }
  }
</script>