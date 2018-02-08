export default {
	data: ()=>({
		menu: {
	      startDate: false,  
	      endDate: false,
	      startTime: false,
	      endTime: false,
    },
    allowedDates:{}
	}),
	computed: {
		allowedStartDate(){
			return {
				min: this.formData.startDate
			}
		},
		allowedEndDate(){
			return {
          min: this.formData.startDate
      }	
		}
	}
}