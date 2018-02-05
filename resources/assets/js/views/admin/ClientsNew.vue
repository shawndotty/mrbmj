<template>
	<v-flex>
		<v-toolbar color="indigo" dark>
        <v-toolbar-title>Create Client</v-toolbar-title>
        <v-spacer></v-spacer> 
    </v-toolbar>
    <v-card>
      <v-container>
      <v-card-text>
    <v-form v-model="valid" ref="form" lazy-validation>
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
      required
    ></v-text-field>
    <v-text-field
      label="Phone"
      v-model="phone"
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

    <v-btn
      @click="submit"
      :disabled="!valid"
    >
      submit
    </v-btn>
    <v-btn @click="clear">clear</v-btn>
  </v-form>
</v-card-text>
</v-container>
  </v-card>
  </v-flex>	
</template>

<script>
export default {
    data: () => ({
      valid: true,
      firstName: '',
      nameRules: [
        (v) => !!v || 'Name is required',
        (v) => v && v.length <= 10 || 'Name must be less than 10 characters'
      ],
      lastName: '',
      email: '',
      phone: '',
      company: '',
      address:'',
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
          })

          this.clear();
        }
      },
      clear () {
        this.$refs.form.reset()
      }
    }
  }
</script>