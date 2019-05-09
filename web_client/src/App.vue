<template lang="pug">
  .wrapper
    header
      #h-content
        #h-logo
          button#switch
            img(src='./assets/static/images/switch.png', alt='Переключить')
          router-link#logo(to="/") SapeChat
        #h-search
          form(action='search', method='get')
          .search
            input(type='search', name='query', placeholder='Введите запрос...', required='', maxlength='40', autocomplete='off')
            button
              img(src='./assets/static/images/search_gray.png', alt='')
        #h-links
          router-link.h-link(to="/im") Профиль
          router-link.h-link(to="/feed") Лента
          router-link.h-link(to="/messenger") Диалоги
          router-link.h-link(to="/people") Люди
          router-link.h-link(to="/logout") Выход
</template>

<script>
export default {
  data(){
    return{
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
