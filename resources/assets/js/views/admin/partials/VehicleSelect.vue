<template>
<v-select
  v-bind:items="vehicleTypes"
  v-model="selectedType"
  item-text="name"
  item-value="id"
  :label="selectLabel"
  return-object
  :autocomplete="true"
  bottom
  v-on:input="typeChanged"
></v-select>	
</template>
<script>
export default {
	data() {
		return {
			name: 'vehicle-select',
			selectedType: null,
			vehicleTypes: [
        {
          name: 'Minivan',
          id: 1
        },
        {
          name: 'Van',
          id: 2
        },
        {
          name: 'Sprinter',
          id: 3
        },

        {
          name: 'Minibus',
          id: 4
        },
        {
          name: 'Motorcoach',
          id: 5
        }
      ],
		}
	},
	props: [
		'selectLabel'
	],
	methods: {
		typeChanged() {
			this.$emit('vehicleTypeChanged', this.selectedType);
		}
	}

}
</script>