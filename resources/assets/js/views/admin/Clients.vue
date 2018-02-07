<template>
	<v-flex>
		<v-toolbar>
        <v-toolbar-title>Clients</v-toolbar-title>
        <v-spacer></v-spacer>
          <v-btn color="primary" dark @click.native.stop="dialog = true">Add New Client</v-btn>
      </v-toolbar>
      <v-card>
        <v-card-title>
          <v-text-field
            append-icon="search"
            label="Search"
            hide-details
            v-model="search"
            clearable
          ></v-text-field>
        </v-card-title>
       
                    <v-data-table
                v-bind:headers="headers"
                :items="items"
                v-bind:search="search"
                class="elevation-1"
              >
              <template slot="items" slot-scope="props">
                <td><router-link :to="{ name: 'client', params: { clientId: props.item.id }}">{{ props.item.id }}</router-link></td>
                <td class="text-xs-left">
                  
                    {{ props.item.first_name }}
                  
                </td>
                <td class="text-xs-left"> {{props.item.last_name }}</td>
                <td class="text-xs-left">{{ props.item.phone }}</td>
                <td class="text-xs-left">{{ props.item.email }}</td>
                <td class="text-xs-left">{{ props.item.company }}</td>
                <td class="text-xs-left">{{ props.item.address }}</td>
                <td class="text-xs-left">{{ props.item.orders.length }}</td>
                <td class="text-xs-left">{{ props.item.invoices.length }}</td>
              </template>
            </v-data-table>
      </v-card>
       <v-dialog v-model="dialog" fullscreen transition="dialog-bottom-transition" :overlay=false>
          <v-card>
            <dialog-toolbar title="Add New Client" v-on:closeDialog="dialog = false"></dialog-toolbar> 
            <form-new-client></form-new-client>
          </v-card>
        </v-dialog> 
</v-flex>	
</template>

<script>
  import FormNewClient from "./FormNewClient.vue"
  import DialogToolbar from "./partials/DialogToolbar.vue"
export default {
    components: {
      FormNewClient, DialogToolbar
    },
		data() {
			return {
        search: "",
        dialog: false,
				headers: [
          {
            text: 'Client ID',
            align: 'left',
            sortable: true,
            value: 'id'
          },
          { text: 'First Name', align: 'left', value: 'first_name' },
          { text: 'Last Name', align: 'left', value: 'last_name' },
          { text: 'Phone', align: 'left', value: 'phone' },
          { text: 'Email', align: 'left', value: 'email' },
          { text: 'Company', align: 'left', value: 'company' },
          { text: 'Address', align: 'left', value: 'address' },
          { text: 'Orders', align: 'left', value: 'orders' },
          { text: 'Invoices', align: 'left', value: 'invoices' },
        ],
        items: []
			}

		},

		created() {
      this.getClients();
      this.$eventHub.$on('clientAdded', () => {
        console.log('addddd');
        this.getClients();
      })
		},

    methods: {
      getClients(){
        axios.get('/clients')
        .then(response => this.items = response.data );
      },
      getResourceName(resources){

        if (resources.length != 0) {
          return resources[0].name;
        } else {
          return "Not Assigned"
        }
      }
    }

	}		
</script>