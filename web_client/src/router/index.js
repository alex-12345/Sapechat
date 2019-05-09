import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'index',
      component: HelloWorld
    },
    {
      path: '/id:user_id',
      name: 'profile',
      component: HelloWorld
    },
    {
      path: '/chats',
      name: 'chats',
      component: HelloWorld
    }
  ]
})
