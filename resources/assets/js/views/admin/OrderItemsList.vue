<template>
	<v-flex xs12 mb-3>
    <v-card>
        <v-toolbar color="white" light dense class="elevation-1">
          <v-toolbar-title>{{ title }}</v-toolbar-title>
          <v-spacer></v-spacer>
          <slot></slot>
        </v-toolbar>
        <v-list two-line >
          <template v-for="item in items">
            <v-list-tile  v-bind:key="item.id" @click="">
              <v-list-tile-content>
                <v-list-tile-title v-html="item.name"></v-list-tile-title>
                <v-list-tile-sub-title v-html="item.test"></v-list-tile-sub-title>
              </v-list-tile-content>
            </v-list-tile>
          </template>   
        </v-list>

      </v-card>
  </v-flex>
</template>
<script>
	export default {

		name: 'order-items-list',

		props: ['title', 'items'],
		
    data () {
      return {
        
      }
    },

    computed: {
    	hasItems: function(){
    		return ;
    	}
    },
		
	}
</script>