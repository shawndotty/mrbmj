<template>
<v-container>
  <v-layout row justify-center>
    <v-flex xs12 sm10 md8>
      <v-card>
        <v-card-text>
          <v-form v-model="valid" ref="form" lazy-validation>
            <v-text-field label="Legal first name" required></v-text-field>
             
            <v-text-field label="Legal middle name" hint="example of helper text only on focus"></v-text-field>
            
            <v-btn>Submit</v-btn>
          </v-form>
        </v-card-text>
      </v-card>
    </v-flex>
  </v-layout>
</v-container>
     
</template>

<script>
 export default {
  name: "form-new-driver",

  data() {
    return {
      valid: false,
    }
  },
 }
</script>