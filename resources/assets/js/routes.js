import VueRouter from 'vue-router';

let routes = [
	{ path: '/', redirect: '/orders'},
	{
		path: '/',
		component: require('./views/admin/Dashboard')
	},
	{
		path: '/clients',
		component: require('./views/admin/Clients')
	},
	{
		path: '/clients/new',
		component: require('./views/admin/ClientsNew')
	},
	{
		path: '/clients/client/:clientId',
    name: 'client',
    component: require('./views/admin/Client')
  },
	{
		path: '/orders',
		component: require('./views/admin/Orders')
	},
	{
		path: '/orders/new',
		component: require('./views/admin/OrdersNew')
	},
	{
		path: '/order/:orderId',
    name: 'order',
    component: require('./views/admin/Order')
  },
	{
		path: '/drivers',
		component: require('./views/admin/Drivers')
	},
	{
		path: '/driver/:driverId',
    name: 'driver',
    component: require('./views/admin/Driver')
  },
	{
		path: '/guides',
		component: require('./views/admin/Guides')
	},
	{
		path: '/guide/:guideId',
    name: 'guide',
    component: require('./views/admin/Guide')
  },
	{
		path: '/vehicles',
		component: require('./views/admin/Vehicles')
	},
	{
		path: '/vehicles/new',
		component: require('./views/admin/vehiclesNew')
	},
	{
		path: '/vehicle/:vehicleId',
    name: 'vehicle',
    component: require('./views/admin/Vehicle')
  },

];

export default new VueRouter({
	routes,
	// linkActiveClass: 'is-active'	
	base: "/admin/"
});