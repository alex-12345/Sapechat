import Vue from 'vue'
import Vuex from 'vuex'
import global from './modules/global'
import user from './modules/user'
import auth from './modules/auth'
import feed from './modules/feed'
import profile from './modules/profile'
import search from './modules/search'
Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  modules: {
    global,
    user,
    auth,
    feed,
    profile,
    search
  },
  strict: debug
})
