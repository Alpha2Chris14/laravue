/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import Router from 'vue-router';
import routes from './routes';
import moment from 'moment';
import VueProgressBar from 'vue-progressbar';
import TopComponent from './components/TopComponent';
import SideComponent from './components/SideComponent';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Gate from './gate';

const options = {
    color: '#bffaf3',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
      speed: '0.2s',
      opacity: '0.6s',
      termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
}

window.fire = new Vue();
window.token = new Vue();
window.userData = new Vue();
window.userSearch = new Vue();

Vue.prototype.$gate = new Gate();

Vue.prototype.$token = "";

token.$on("authorization",(data)=>{
    localStorage.setItem("token",data);
})

userData.$on("user",function(data){
    Vue.prototype.$gate = new Gate(data.role);
    console.log(Vue.prototype.$gate);
})

  
window.Vue = require('vue').default;
const axios = require('axios').default;
Vue.use(VueSweetalert2);


//Global Component
Vue.component("Top",TopComponent);
Vue.component("Side",SideComponent);


//Global Filters
Vue.filter('capitalize',function(value){
    if(!value)return;
          value = value.toString();
          return value.charAt(0).toUpperCase()+value.slice(1);
});


Vue.filter('formatDate',function(date){
    return moment(date).format("MMMM Do YYYY");
});

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

//Router and ProgressBar
Vue.use(Router);
Vue.use(VueProgressBar, options)

const router = new Router({
    mode:'history',
    routes:routes,
});


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
    router:router,
});

