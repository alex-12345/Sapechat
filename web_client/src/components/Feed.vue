<template lang="pug">
#feed_wrapper
  #feed_params_wrapper.inline
    #feed_params_list
      h5 ОБЩАЯ ЛЕНТА
      router-link.feed_generalized_param.active(to='feed')
        img(alt='', src='../assets/static/images/feed_white.png')
        | Моя лента
      router-link.feed_generalized_param(to='hot')
        img(alt='', src='../assets/static/images/hot_gray.png')
        | Популярное
      h5 ЗАПИСИ ДРУЗЕЙ
      router-link.feed_friend.active_friend(to='id1')
        img(title='dfv', alt= '' src='')
        | gh
      button Показать других
  #stream_wrapper.inline
    #stream_form_wrapper(data-user-id='we')
      img.stream_user_image(alt='error 404', v-bind:src="getUserBrief.user_img", v-bind:title="getUserBrief.fullName")
      #post_text.textarea(aria-multiline='true', contenteditable='true', role='textbox', data-text='Напишите что-нибудь...')
      textarea(style='display:none;', required='')
      button(@click="sendPost") Отправить
    #posts_wrapper
      .post_wrapper
        a(href='f')
          img.stream_user_image(alt='404 error', src='df')
        .post_content
          a.post_user_name(href='df') df
          span.post_time 123 232
          .post_text ds

</template>

<script>
export default {
  data() {
    return {
      user_brief_info: {}
    }
  },
  methods: {
    sendPost: function () {
        console.log(this.$parent.user_brief_info)
    }
  },
  computed: {
    getUserBrief( ){
      return this.user_brief_info = this.$parent.user_brief_info
    }
  }
}
</script>

<style lang="stylus" scoped>
</style>