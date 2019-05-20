import {apiCall, syncApiCall} from '@/utils/api'
import Vue from 'vue'

const state = { status: '', friendsAmount: 0, friendsList: null, mainFeed: {} }


const actions = {
  'FRIENDS_LIST_REQUEST': ({commit, dispatch}, {id, start, amount}) => {
    return new Promise((resolve, reject) => {
        const url = 'user-getUserFriend?id=' + id + '&start='+start + '&amount=' + amount
        apiCall(url, 'GET')
        .then(resp => {
            commit('FRIENDS_LIST_SUCCESS', resp.data)
            resolve(resp)
        })
        .catch(err => {
            commit('FRIENDS_ERROR', err)
            reject(err)
        })
    })
  },
  'FRIENDS_AMOUNT_REQUEST': ({commit, dispatch}, id) => {
    apiCall('user-friendsAmount?id=' + id, 'GET')
      .then(resp => {
        commit('FRIENDS_AMOUNT_SUCCESS', resp.data)
      })
      .catch(resp => {
        commit('FRIENDS_ERROR')
      })
  },
  'LOAD_MAIN_FEED': ({commit, dispatch}, {token, start, amount}) => {
      const url = 'feed-getFriendsFeed?token=' + token + '&start='+start + '&amount=' + amount
      let resp = syncApiCall(url, 'GET')
      commit('MAIN_FEED_SUCCESS', resp.data)
      
      return resp.data
  }
}

const mutations = {
  'FRIENDS_LIST_SUCCESS': (state, resp) => {
    Vue.set(state, 'friendsList', resp)
  },
  
  'FRIENDS_AMOUNT_SUCCESS': (state, resp) => {
    Vue.set(state, 'friends_amount', resp)
  },
  'MAIN_FEED_SUCCESS': (state, resp) => {
    Vue.set(state, 'mainFeed', resp)
    console.log(resp)
  },
  'FRIENDS_ERROR': (state) => {
    state.status = 'error'
  },
  'FEED_ERROR': (state) => {
    state.status = 'error'
  }
}
const getters = {
  friendsList: state =>  state.friendsList,
  mainFeed: state =>  state.mainFeed
}

export default {
  state,
  getters,
  actions,
  mutations,
}