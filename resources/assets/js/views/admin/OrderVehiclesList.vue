<template>
	<v-flex xs12 mb-3>
    <v-card>
        <v-toolbar dense color="white" light class="elevation-1">
          <v-toolbar-title>{{ title }}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
             <slot name="action"></slot>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <v-layout row wrap>
              <v-flex md12 sm12>
                <table class="dispatchTable" width="100%">
                  <tr>
                    <th class="text-xs-left">Total {{title}} Needed:</th><td class="text-xs-right"> <v-chip small color="primary" text-color="white">{{ options.total }}</v-chip></td>
                  </tr>
                  <tr v-for="item in options.needs">
                      <th class="text-xs-left">{{ item.name + ":" }}</th><td class="text-xs-right"><v-chip small color="secondary" text-color="white">{{ item.num }}</v-chip> </td>
                  </tr>
                  <tr>
                    <th class="text-xs-left">Dispatched {{title}}:</th>
                    <td class="text-xs-right">
                      <template v-if="items.length == 0">
                        0
                      </template>
                      <template v-else>
                      <v-chip v-for="item in items" :key="item.name" small label close  color="primary" text-color="white" v-on:input="remove(item.id)"  light>{{ item.name }}</v-chip>
                        
                      </template>
                    </td>
                  </tr>
                </table>
                  
              </v-flex>
              
            </v-layout>
          </v-container>
        </v-card-text>
      </v-card>
  </v-flex>
</template>
<script>
	export default {

		name: 'order-vehicles-list',
    props: {
      title: {
        type: String,
        default: ''
      },
      orderId: {
        type: Number,
        default: null,
      },
      items: {
        type: Array,
        default: function(){
          return []
        }
      },
      options: {
        type: Object,
        default: function(){
          return {}
        }
      },
      vehicleTypes: {
        type: Array,
        default: function(){
          return []
        }
      }
    },
		
    data () {
      return {
        
        
      }
    },

    methods: {
      remove(vid){
        axios.post('/orders/removevehicle', {vId: vid, oId:this.orderId}).then(
          response => {
            this.$eventHub.$emit('removeOrderVehicle');
            this.$eventHub.$emit('checkVehicles');
        })
      }
    }
		
	}
</script>
<style lang="scss">
  .dispatchTable {
    th, td {
      border-bottom: 1px solid #ddd;
      height: 40px;
    }
  }
</style>