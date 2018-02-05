import moment from 'moment' 

let utils = {
	getMonthDays(date){
		let y = moment(date).year();
		let m = moment(date).month();
		let daysInM = moment(date).daysInMonth();
		let days = [];
		for (var i = 1; i <= daysInM; i++) {
				days.push({
					dow: moment({year: y, month: m, date: i}).format('ddd'),
					date: i
				});
		}
		return days;
	},

	buildArray(target, start, end){
      	for(var i=start; i<=end; i++) {
      		target.push(i);
      	}
  }
}

export default utils;