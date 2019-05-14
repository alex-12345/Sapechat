import { AUTH_REQUEST, AUTH_ERROR, AUTH_SUCCESS, AUTH_LOGOUT } from '../actions/auth'
import { USER_REQUEST } from '../actions/user'
import apiCall from '../../utils/api'
//import {getCookie, setCookie, deleteCookie} from '../../utils/cookie'

const state = { 
  token: localStorage.getItem('user-token') || '', 
  status: '', 
  hasLoadedOnce: false 
}

const getters = {
  isAuthenticated: state => { 
    return !!state.token
  },
  authStatus: state => state.status,
  getToken: state => state.token
}

const actions = {
  [AUTH_REQUEST]: ({commit, dispatch}, user) => {
    return new Promise((resolve, reject) => {
      commit(AUTH_REQUEST)
      apiCall('access-signIn','POST',user)
      .then(resp => {
        localStorage['user-token'] = resp.data.token;
        commit(AUTH_SUCCESS, resp.data)
        dispatch(USER_REQUEST, state.token)
        resolve(resp)
      })
      .catch(err => {
        commit(AUTH_ERROR, err)
        localStorage.removeItem('user-token')
        reject(err)
      })
    })
  },
  [AUTH_LOGOUT]: ({commit, dispatch}) => {
    return new Promise((resolve, reject) => {
      apiCall('access-unsetToken','POST', {"token" : state.token})
      .then(resp => {
        console.log(resp);
          commit(AUTH_LOGOUT)
          localStorage.removeItem('user-token')
          resolve()
        }
      )
    })
  }
}

const mutations = {
  [AUTH_REQUEST]: (state) => {
    state.status = 'loading'
  },
  [AUTH_SUCCESS]: (state, resp) => {
    state.status = 'success'
    state.token = resp.token
    state.hasLoadedOnce = true
  },
  [AUTH_ERROR]: (state) => {
    state.status = 'error'
    state.hasLoadedOnce = true
  },
  [AUTH_LOGOUT]: (state) => {
    state.token = ''
    state.status = ''
  }
}

export default {
  state,
  getters,
  actions,
  mutations,
}