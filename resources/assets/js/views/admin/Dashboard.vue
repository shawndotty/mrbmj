<template>
	<v-flex>
		<v-toolbar color="indigo" dark>
        <v-toolbar-title>Orders</v-toolbar-title>
        <v-spacer></v-spacer>
        
      </v-toolbar>
  <v-data-table
      v-bind:headers="headers"
      :items="items"
      hide-actions
      class="elevation-1"
    >
    <template slot="items" slot-scope="props">
      <td>{{ props.item.name }}</td>
      <td class="text-xs-right">{{ props.item.calories }}</td>
      <td class="text-xs-right">{{ props.item.fat }}</td>
    </template>
      <v-alert slot="no-data" :value="true" color="error" icon="warning">
        Sorry, nothing to display here :(
      </v-alert>
  </v-data-table>
</v-flex>
</template>

<script>
  export default {
    data () {
      return {
        headers: [
          {
            text: 'Order ID',
            align: 'left',
            sortable: false,
            value: 'id'
          },
          { text: 'Order Name', value: 'orderName' },
          { text: 'Client', value: 'client' }
        
        ],
        items: []
      }
    }
  }
</script>