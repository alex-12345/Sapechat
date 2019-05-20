<template lang="pug">
#stream_wrapper.inline
    #stream_form_wrapper
      img.stream_user_image(alt='noimg', v-bind:src="getUserBrief.user_img", v-bind:title="getUserBrief.fullName")
      #post_text.textarea(aria-multiline='true', contenteditable='true', role='textbox', data-text='Напишите что-нибудь...')
      textarea(style='display:none;', required='')
      button(@click="sendPost") Отправить
    #posts_wrapper
      .post_wrapper(v-for="post in feed_loaded" :key="post.post_id")
        router-link(:to="'/id' + post.user_id")
          img.stream_user_image(alt='noimg', :src="post.user_img" :title="post.user_first_name + ' ' + post.user_last_name")
        .post_content
          router-link.post_user_name(:to="'/id' + post.user_id") {{post.user_first_name}} {{post.user_last_name}}
          span.post_time {{post.post_utc_date}}
          .post_text {{post.post_content}}
</template>

<script>
import store from '@/store'

export default {
  data() {
    return {
      start: 0,
      amount: 20,
      user_brief_info: {},
      feed_loaded: {}
    }
  },
  created(){
    this.user_brief_info = this.$parent.user_brief_info
    const token = localStorage['user-token']
    let start = this.start
    let amount = this.amount
    this.$store.dispatch("LOAD_MAIN_FEED", {token, start, amount})
    this.feed_loaded = this.$store.getters.mainFeed
    this.start += this.amount
    
    console.log(this.feed_loaded)
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