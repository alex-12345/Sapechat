import { USER_REQUEST, USER_ERROR, USER_SUCCESS } from '../actions/user'
import {apiCall, syncApiCall} from '@/utils/api'
import Vue from 'vue'
import { AUTH_LOGOUT } from '../actions/auth'

const state = { status: '', userBrief: {} }

const getters = {
  userBrief: (state, token) => {
    
    /*if(!state.userBrief.user_id){
      dispatch(USER_REQUEST, token)
    }*/
    return state.userBrief

  }
}

const actions = {
  "USER_REQUEST": ({commit, dispatch}, user_token) => {
      if(localStorage['user-brief']){
        commit("USER_SUCCESS", JSON.parse(localStorage['user-brief']))
      }else{
        let resp = syncApiCall('feed-getUserDataBrief?token=' + user_token, 'GET')
        localStorage['user-brief'] = JSON.stringify(resp.data);
        commit("USER_SUCCESS", resp.data)
      }
  }
}

const mutations = {
  "USER_SUCCESS": (state, resp) => {
    Vue.set(state, 'userBrief', resp)
  },
  [USER_ERROR]: (state) => {
    state.status = 'error'
  },
  [AUTH_LOGOUT]: (state) => {
    state.profile = {}
  }
}

export default {
  state,
  getters,
  actions,
  mutations,
}