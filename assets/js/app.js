// assets/js/app.js
import Vue from 'vue';
import App from './components/App'
import FlashMessage from "@smartweb/vue-flash-message";
import ToggleButton from 'vue-js-toggle-button'
Vue.use(ToggleButton)
Vue.use(FlashMessage);
/**
 * Create a fresh Vue Application instance
 */
new Vue({
  el: '#app',
  components: {App}
});
