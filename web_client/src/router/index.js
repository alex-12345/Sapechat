import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/Login'
import Feed from '@/components/Feed'
//import axios from 'axios'
//import VueAxios from 'vue-axios'

//Vue.use(VueAxios, axios)
Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: "/",
      name: "login",
      component: Login
    },
    {
      path: "/feed",
      name: "feed",
      component: Feed
    }
  ]
})
