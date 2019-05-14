import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/Login'
import Feed from '@/components/Feed'
import store from '../store'
import {AUTH_LOGOUT} from '../store/actions/auth'
//import axios from 'axios'
//import VueAxios from 'vue-axios'

//Vue.use(VueAxios, axios)
Vue.use(Router)

const ifNotAuthenticated = (to, from, next) => {
  if (!store.getters.isAuthenticated) {
    next()
    return
  }
  next('/feed')
}

const ifAuthenticated = (to, from, next) => {
  if (store.getters.isAuthenticated) {
    next()
    return
  }
  next('/')
}
/*
const logout = () =>{
  if (!store.getters.isAuthenticated) {
    next('/')
    return
  }
  store.dispatch(AUTH_LOGOUT).then(() => {
    next('/')
    return
  })
}
*/

export default new Router({
  mode: 'history',
  routes: [
    {
      path: "/",
      name: "login",
      component: Login,
      beforeEnter: ifNotAuthenticated,
    },
    {
      path: "/feed",
      name: "feed",
      component: Feed,
      beforeEnter: ifAuthenticated,
    },
    /*{
      path: "/logout",
      beforeEnter:logout
    }*/
  ]
})
