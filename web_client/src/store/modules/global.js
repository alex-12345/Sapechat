import { BRIEF_SET } from '../actions/global'
import Vue from 'vue'

const state = { showBrief: false}

const getters = {
    briefStatus: sate => state.showBrief
}

const actions = {
    [BRIEF_SET]: ({commit, dispatch}, status) => {
        commit(BRIEF_SET, status)
    }
}

const mutations = {
    [BRIEF_SET]: (state, status) => {
        Vue.set(state, 'showBrief', status)
    }
}

export default {
    state,
    getters,
    actions,
    mutations,
  }