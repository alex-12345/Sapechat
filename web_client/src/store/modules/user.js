import { USER_REQUEST, USER_ERROR, USER_SUCCESS } from '../actions/user'
import apiCall from '../../utils/api'
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
  [USER_REQUEST]: ({commit, dispatch}, user_token) => {
    apiCall('feed-getUserDataBrief?token=' + user_token, 'GET')
      .then(resp => {
        commit(USER_SUCCESS, resp.data)
      })
      .catch(resp => {
        commit(USER_ERROR)
        dispatch(AUTH_LOGOUT)
      })
  },
}

const mutations = {
  [USER_REQUEST]: (state) => {
  },
  [USER_SUCCESS]: (state, resp) => {
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