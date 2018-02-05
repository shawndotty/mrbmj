<template>
	<v-toolbar dark color="primary">
        <v-toolbar-title>{{ title }}</v-toolbar-title>
        <v-spacer></v-spacer>
          <v-btn icon @click.native="closeDialog" dark>
            <v-icon>close</v-icon>
          </v-btn>
  </v-toolbar>
</template>

<script>
	export default {
		name: "dialog-toolbar",
		data() {
			return {

			}
		},
		props: [ 'title' ], 
		methods: {
			closeDialog: function(){
			  this.$emit('closeDialog');
			}
		}
	}
</script>