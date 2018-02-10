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
                    <th class="text-xs-left">Total {{title}} Needed:</th><td class="text-xs-right"><v-chip small color="primary" text-color="white">{{ driverNeeded }}</v-chip></td>
                  </tr>
                  <tr>
                    <th class="text-xs-left">Dispatched {{title}}:</th>
                    <td class="text-xs-right">
                      <template v-if="drivers.length == 0">
                        0
                      </template>
                      <template v-else>
                      <v-chip v-for="item in drivers" :key="item.name" small label close  color="primary" text-color="white" v-on:input="removeDriver(item.id)"  light>{{ item.first_name }}</v-chip>
                        
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

		name: 'order-drivers-list',
    props: {
      title: {
        type: String,
        default: ''
      },
      orderId: {
        type: Number,
        default: null,
      },
      drivers: {
        type: Array,
        default: function(){
          return []
        }
      },
      driverNeeded: {
        type: Number,
        default: 0
      }
    },
		
    data () {
      return {
        
        
      }
    },

    methods: {
      removeDriver(dId){
        axios.post('/orders/removedriver', {dId: dId, oId:this.orderId}).then(
          response => {
            this.$eventHub.$emit('removeOrderDriver');
            this.$eventHub.$emit('checkDrivers');
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