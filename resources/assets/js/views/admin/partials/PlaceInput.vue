<template>
	<div class="input-group input-group--dirty input-group--text-field input-group--suffix primary--text">
		<label :for="name">{{ label }}</label><div class="input-group__input">
		<input ref="place" :placeholder="placeholder" type="search" :name="name" :id="id" v-bind:value="value" @input="updateValue($event.target.value)" />
	</div><div class="input-group__details"><div class="input-group__messages"></div></div></div>
  
</template>
<script>
import places from 'places.js';
export default {
  props: {
  	id: {
  		type: String,
  		default: '', 
  	},
  	label: {
  		type: String,
  		default: '',
  	},
  	name: {
  		type: String,
  		default: '',
  	},
    value: {
      type: String,
      default: '',
    },
    options: {
      type: Object,
      default: () => ({}),
    },
    placeholder: {
    	type: String,
    	default: 'City, Airport or Address'
    }
  },
  data() {
    return {
      placesAutocomplete: null,
    };
  },
  methods: {
    updateValue(value) {
      this.$emit('input', value);
    },
  },
  mounted() {
    this.options.container = this.options.container || this.$refs.place;
    this.placesAutocomplete = places(this.options);
    this.placesAutocomplete.on('change', (e) => {
      this.$emit('change', e.suggestion);
      this.updateValue(e.suggestion.value);
    });
    this.placesAutocomplete.on('clear', () => {
      this.$emit('change', {});
      this.updateValue(null);
    });
  },
  beforeDestroy() {
    this.placesAutocomplete.destroy();
  },
};
</script>
<style>
	.ap-input, .ap-hint{
		border:none;
	}
</style>