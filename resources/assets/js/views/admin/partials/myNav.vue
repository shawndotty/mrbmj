<template>
<v-list>
          <v-list-group v-for="item in items" :value="item.active" v-bind:key="item.title">
            <v-list-tile 
              slot="item" 
              :to="item.route"
              tag
              :ripple="true"
              href
              exact
            >
              <v-list-tile-action>
                <v-icon>{{ item.icon }}</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                <v-list-tile-title>{{ item.title }}</v-list-tile-title>
              </v-list-tile-content>
              
            </v-list-tile>
          </v-list-group>
        </v-list> 


</template>
<script>
  export default{
    data () {
      return {
        items: [
          {
            icon: 'receipt',
            title: 'Orders',
            route:'/orders'
          },
          {
            icon: 'directions_bus',
            title: 'Vehicles',
            route:'/vehicles'
          },
          {
            icon: 'airline_seat_recline_normal',
            title: 'Drivers',
            route:'/drivers'
          },
          {
            icon: 'portrait',
            title: 'Guides',
            route:'/guides'
          },
          {
            icon: 'person',
            title: 'Clients',
            route:'/clients'
          },
          ]
      }
    }
  }
</script>
<style>
  a.list__tile--active{
    background-color:#eeeeee;
  }
</style>