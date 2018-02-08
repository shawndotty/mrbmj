import moment from 'moment'

export default {
	data: () => ({
		checkDate : moment().format("YYYY-MM"),
		headers: [],

	}),

	computed: {
		startOfM() {
      return moment(this.checkDate).startOf('month');
    },

    endOfM(){
      return moment(this.checkDate).endOf('month');          
    },
    daysInM(){
    	return moment(this.checkDate).daysInMonth();
    },        
		getHeaderDays(){
			let y = moment(this.checkDate).year();
			let m = moment(this.checkDate).month();
			let daysInM = moment(this.checkDate).daysInMonth();
			let days = [];
			for (var i = 1; i <= daysInM; i++) {
					days.push({
						dow: moment({year: y, month: m, date: i}).format('ddd'),
						date: i
					});
			}

			this.headers = days;
			return this.headers;
	  },
	}
}