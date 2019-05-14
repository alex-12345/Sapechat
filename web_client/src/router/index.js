import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/Login'
import Feed from '@/components/Feed'
import {BRIEF_SET} from '../store/actions/global'
import store from '../store'

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
let router = new Router({
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
    }
    
  ]
})

router.beforeEach((to, from, next) => {
  store.dispatch(BRIEF_SET, false)
  next()
  return
})

export default router
