<template lang="pug">
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
          form(action='search', method='get')
          .search
            input(type='search', name='query', placeholder='Введите запрос...', required='', maxlength='40', autocomplete='off')
            button
              img(src='./assets/static/images/search_gray.png', alt='')
        #h-links(v-if="signin_pass")
          router-link.h-link(to="/im") Профиль
          router-link.h-link(to="/feed") Лента
          router-link.h-link(to="/messenger") Диалоги
          router-link.h-link(to="/people") Люди
          router-link.h-link(to="/logout") Выход
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
              router-link(to="/logout")
                div
                  img(src='./assets/static/images/logout_gray.png', alt='')
                |         Выход
          .hidden-wrapper(v-else)
            #hidden-alert Войдите или зарегистриуйтесь

          span#hidden-version SapeChat v1.0

</template>

<script>
export default {
  data( ) {
    return {
      signin_pass: true,
      switchShow: false,
      linkMenu: [
        {title: 'Home', url: '/'},
      ]
    }
  }
}
</script>

<style lang="stylus">
@import './assets/stylus/main.styl'
</style>
