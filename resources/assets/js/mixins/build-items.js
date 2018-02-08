export default {
	computed: {
		itemsNamesAndIds(){
        let items = [];

        if (this.itemType != "vehicle") {
          this.items.forEach( function(element, index) {
            // statements
            let item = {}
            item.name = element.first_name + ' ' + element.last_name;
            item.id = element.id;
            items.push(item);
          });
        } else {
          this.items.forEach( function(element, index) {
            // statements
            let item = {}
            item.name = element.name;
            item.id = element.id;
            items.push(item);
          });
        }
        return items;
      },
	}
}