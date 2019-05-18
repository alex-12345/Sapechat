<template lang="pug">
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
      return this.$parent.user_brief_info
    }
  }
}
</script>

<style lang="stylus" scoped>
</style>