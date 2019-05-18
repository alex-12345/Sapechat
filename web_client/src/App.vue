<template lang="pug">
  .wrapper-content
    .wrapper-header
      header
        #h-content
          #h-logo
            button#switch(@click.prevent="switch_show")
              img(src='/static/images/switch.png', alt='Переключить')
            router-link#logo(to="/") SapeChat
          #h-search
            .search
              input(type='search', name='query', placeholder='Введите запрос...', required='', maxlength='40', autocomplete='off')
              button(@click="search()")
                img(src='/static/images/search_gray.png', alt='')
          #h-links(v-if="checkAuth")
            router-link.h-link(to="/im") Профиль
            router-link.h-link(to="/feed") Лента
            router-link.h-link(to="/messenger") Диалоги
            router-link.h-link(to="/people") Люди
            a(@click.prevent="logout" href="/logout" style="cursor:pointer") Выход
          #h-links(v-else)
            router-link.h-link(to="/signup") Регистрация
        #hidden-area()
          #hidden-block(v-show = "getBriefStatus")
            .hidden-wrapper(v-if="signin_pass")
              #hidden-profile
                router-link.h-link(to="/im" )
                  img#me-img(v-bind:src="getUserBrief.user_img", alt='Me', v-bind:title="getUserBrief.fullName")
                router-link.h-link#hidden-username(to="/im") {{ getUserBrief.fullName }}
                span#hidden-email {{ getUserBrief.user_email }}
              #hidden-list
                router-link.h-link(to="/creat_conf" )
                  div
                    img(src='/static/images/group_gray.png', alt='')
                  |        Создать конференцию
                router-link.h-link(to="/settings" )
                  div
                    img(src='/static/images/setting_gray.png', alt='')
                  |         Настройки
                a(@click.prevent="logout" href="/logout" style="cursor:pointer")
                  div
                    img(src='/static/images/logout_gray.png', alt='')
                  |         Выход
            .hidden-wrapper(v-else)
              #hidden-alert Войдите или зарегистриуйтесь

            span#hidden-version SapeChat v1.0
    #main-content-wrapper
      router-view
</template>

<script>
import {AUTH_LOGOUT} from './store/actions/auth'
import {USER_REQUEST} from './store/actions/user'
import {BRIEF_SET} from './store/actions/global'
import store from './store'

export default {
  data( ) {
    return {
      signin_pass: false,
      switchShow: false,
      user_brief_info: {}
    }
  },
  methods: {
    logout: function () {
        this.$store.dispatch(AUTH_LOGOUT).then(() => {
          this.switchShow = false
          this.$router.push('/')
        })
    },
    switch_show( ) {
      this.$store.dispatch(BRIEF_SET, !this.switchShow)
    }
  },
  computed:{
    checkAuth( ) {
      return this.signin_pass = store.getters.isAuthenticated
    },
    getUserBrief( ) {
      let brief = this.user_brief_info = store.getters.userBrief
      if(!brief.user_id && store.getters.isAuthenticated){
        this.$store.dispatch(USER_REQUEST, store.getters.getToken)
      }
      brief.fullName = brief.user_first_name + " " + brief.user_last_name
      return brief
    },
    
    getBriefStatus(){
      return this.switchShow = store.getters.briefStatus
    }
  }
}
</script>

<style lang="stylus">
@import './assets/stylus/main.styl'
</style>
