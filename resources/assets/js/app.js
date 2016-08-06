import Vue from 'vue'
import VueRouter from 'vue-router'
import grid_mixin from './mixins/grid'
import Dashboard from '../../views/components/dashboard.vue'
import UserAccount from '../../views/components/user/user_account.vue'


Vue.use(VueRouter);
Vue.use(require('vue-resource'))

Vue.mixin(grid_mixin);

var App = Vue.extend({});

var router = new VueRouter();

router.map({
  '/': {
    component: Dashboard
  },
  '/auth/user': {
    component: UserAccount
  }
});

router.start(App, 'body');