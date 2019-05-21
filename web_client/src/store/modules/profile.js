import {apiCall, syncApiCall} from '@/utils/api'
import Vue from 'vue'

const state = {
    status:null,
    wall_status:null, 

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
  "PROFILE_POSTS_REQUEST": ({commit, dispatch}, {id, start, amount, flag, first_loading}) => {
    return new Promise((resolve, reject) => {
      let url = 'user-outputPosts?id=' + id + '&start='+start + '&amount=' + amount
      if(flag) url += "&owm_posts"
      apiCall(url, 'GET')
      .then(resp => {
          if(first_loading)
            commit('PROFILE_POSTS_SUCCESS', resp.data)
          else 
            commit('PROFILE_PUSH_POSTS', resp.data)
          resolve(resp)
      })
      .catch(err => {
          commit('PROFILE_ERROR', err)
          reject(err)
      })
    })
  },
  "PROFILE_ADD_POST_REQUEST": ({commit, dispatch}, data) => {
    
    return new Promise((resolve, reject) => {
      let url = 'wall-addPost'
      apiCall(url, 'POST', data)
      .then(resp => {
        console.log(resp)
          commit('PROFILE_ADD_POST_SUCCESS', {resp, data})
          resolve(resp)
      })
      .catch(err => {
          commit('WALL_ERROR', err)
          reject(err)
      })
    })
  },
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
  "PROFILE_PUSH_POSTS": (state, resp) => {
    state.postsList = state.postsList.concat(resp)
  },
  "PROFILE_ADD_POST_SUCCESS": (state, {resp, data}) => {
    const date = new Date()
    const new_post ={
      post_content: data.text,
      post_id: resp.data.post_id,
      post_time: '',
      post_utc_date: date.toString(),
      user_first_name: data.user_first_name,
      user_last_name:data.user_last_name,
      user_id: data.user_id,
      user_img: data.user_img,
      wall_id:data.wall_id
    }
    state.postsList.unshift(new_post)
    console.log(new_post);
    //Vue.set(state, 'postsList', resp)
  },
  "PROFILE_ERROR": (state) => {
    state.status = false
  },
  "WALL_ERROR": (state) => {
    state.status = false
  }
}


export default {
    state,
    getters,
    actions,
    mutations,
  }