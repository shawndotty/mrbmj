export default {
	data: ()=>({
		newItemDialog: false,
		newItemScheduleDialog: false,
	}),

	methods: {
		toggleNewItem() {
        this.newItemDialog = !this.newItemDialog;
      },
    toggleNewItemSchedule() {
      this.newItemScheduleDialog = !this.newItemScheduleDialog;
    }
	}
}