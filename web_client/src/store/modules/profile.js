import {apiCall, syncApiCall} from '@/utils/api'
import Vue from 'vue'

const state = { 
    profileStatus: true, 
    profileInfo: {},
    friendsAmount: {},
    friendsList: {},
    postsList:{}

}

const getters = {
  pr_info: state =>  state.profileInfo,
  pr_friends_amount: state =>  state.friendsAmount,
  pr_friends_list: state =>  state.friendsList,
  pr_posts_list: state =>  state.postsList
}

const actions = {
  "PROFILE_INFO_REQUEST": ({commit, dispatch}, {id}) => {
      
        let resp = syncApiCall('user-getUserInfoByParametrs?id=' + id + "&param=user_id,user_first_name,user_img,user_last_name,user_birthday,user_about,country_name,city_name", 'GET')
        commit("PROFILE_INFO_SUCCESS", resp.data)
  },
  "PROFILE_FRIENDS_REQUEST": ({commit, dispatch}, {id, amount, start}) => {
    return new Promise((resolve, reject) => {
      const url = 'user-getUserFriend?id=' + id + '&start='+start + '&amount=' + amount + "&random_order&amount_friends"
      apiCall(url, 'GET')
      .then(resp => {
          commit('PROFILE_FRIENDS_SUCCESS', resp.data)
          resolve(resp)
      })
      .catch(err => {
          commit('PROFILE_ERROR', err)
          reject(err)
      })
    })
  },
  "PROFILE_POSTS_REQUEST": ({commit, dispatch}, {id, start, amount, flag}) => {
    return new Promise((resolve, reject) => {
      let url = 'user-outputPosts?id=' + id + '&start='+start + '&amount=' + amount
      if(flag) url += "&owm_posts"
      apiCall(url, 'GET')
      .then(resp => {
          commit('PROFILE_POSTS_SUCCESS', resp.data)
          resolve(resp)
      })
      .catch(err => {
          commit('PROFILE_ERROR', err)
          reject(err)
      })
    })
  }
}

const mutations = {
  "PROFILE_INFO_SUCCESS": (state, resp) => {
    Vue.set(state, 'profileInfo', resp)
  },
  "PROFILE_FRIENDS_SUCCESS": (state, resp) => {
    Vue.set(state, 'friendsList', resp.friends_list)
    Vue.set(state, 'friendsAmount', resp.amount_friends)
  },
  "PROFILE_POSTS_SUCCESS": (state, resp) => {
    Vue.set(state, 'postsList', resp)
  },
  "PROFILE_ERROR": (state) => {
    state.status = false
  }
}


export default {
    state,
    getters,
    actions,
    mutations,
  }