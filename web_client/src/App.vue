<template lang="pug">
  .wrapper-content
    .wrapper-header
      header
        #h-content
          #h-logo
            button#switch(
              @click="switchShow = !switchShow"
              
            )
              img(src='./assets/static/images/switch.png', alt='Переключить')
            router-link#logo(to="/") SapeChat
          #h-search
            .search
              input(type='search', name='query', placeholder='Введите запрос...', required='', maxlength='40', autocomplete='off')
              button(@click="search()")
                img(src='./assets/static/images/search_gray.png', alt='')
          #h-links(v-if="checkAuth")
            router-link.h-link(to="/im") Профиль 
            router-link.h-link(to="/feed") Лента
            router-link.h-link(to="/messenger") Диалоги
            router-link.h-link(to="/people") Люди
            a(@click.prevent="logout" href="/logout" style="cursor:pointer") Выход
          #h-links(v-else)
            router-link.h-link(to="/signup") Регистрация
        #hidden-area
          #hidden-block(v-show = "switchShow")
            .hidden-wrapper(v-if="signin_pass")
              #hidden-profile
                a(href='')
                  img#me-img(src='files/user_img/8.jpg', alt='Me')
                a#hidden-username(href='') Имя Фамилия
                span#hidden-email username@example.com
              #hidden-list
                a(href='')
                  div
                    img(src='./assets/static/images/group_gray.png', alt='')
                  |        Создать конференцию
                a(href='')
                  div
                    img(src='./assets/static/images/setting_gray.png', alt='')
                  |         Настройки
                a(@click.prevent="logout" href="/logout" style="cursor:pointer")
                  div
                    img(src='./assets/static/images/logout_gray.png', alt='')
                  |         Выход
            .hidden-wrapper(v-else)
              #hidden-alert Войдите или зарегистриуйтесь

            span#hidden-version SapeChat v1.0
    #main-content-wrapper 
      router-view
</template>

<script>
import {AUTH_LOGOUT} from './store/actions/auth'
import store from './store'

export default {
  data() {
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
    }
  },
  computed:{
    checkAuth(){
      return this.signin_pass = store.getters.isAuthenticated;
    }
  }
}
</script>

<style lang="stylus">
@import './assets/stylus/main.styl'
</style>
