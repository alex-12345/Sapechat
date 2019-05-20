import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/Login'
import FeedNav from '@/components/FeedNav'
import Feed from '@/components/Feed'
import Hot from '@/components/Hot'
import Profile from '@/components/Profile'
import {BRIEF_SET} from '@/store/actions/global'
import store from '@/store'

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
      component: Login,
      beforeEnter: ifNotAuthenticated,
    },
    {
      path: "/feed",
      component: FeedNav,
      beforeEnter: ifAuthenticated,
      children: [{path: '',component: Feed, name: "feed", props: true}, {path: 'id:id',component: Hot, props: true}]
    },
    {
      path: "/hot",
      component: FeedNav,
      beforeEnter: ifAuthenticated,
      children: [{path: '',component: Hot, name: "hot"}]
    },
    {
      path: "/im",
      name: "im",
      component: Profile,
      beforeEnter: ifAuthenticated, 
      props: true
    },
    {
      path: "/id:id",
      name: "profile",
      component: Profile, 
      props: true 
    }
    
  ]
})

router.beforeEach((to, from, next) => {
  store.dispatch(BRIEF_SET, false)
  next()
  return
})

export default router
