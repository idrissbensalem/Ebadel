const routes = require('../public/js/fos_js_routes.json');
import Routing from '../bundles/fosjsrouting/js/router.min.js';
Routing.setRoutingData(routes);

window.Routing = Routing;
console.log(Routing);