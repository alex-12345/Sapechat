<template lang="pug">
#feed_wrapper
  #feed_params_wrapper.inline
    #feed_params_list
      h5 ОБЩАЯ ЛЕНТА
      router-link.feed_generalized_param(to='/feed', v-bind:class="{ active: main_feed.status }")
        span(@click="changeMainParam(true,false)", @mouseenter="enterMain(true,false)" @mouseleave="leaveMain()")
          img(alt='', v-bind:src="'static/images/' + main_feed.src") 
          | Моя лента
      router-link.feed_generalized_param(to='/hot', v-bind:class="{ active: hot_feed.status }")
        span(@click="changeMainParam(false,true)", @mouseenter="enterMain(false,true)" @mouseleave="leaveMain()")
          img(alt='', v-bind:src="'static/images/' + hot_feed.src") 
          | Популярное
      h5 ЗАПИСИ ДРУЗЕЙ
      router-link.feed_friend.active_friend(to='/feed/id1')
        img(title='dfv', alt= '' src='')
        | gh
      router-link.feed_friend(to='/feed/id2')
        img(title='dfv', alt= '' src='')
        | gh
      router-link.feed_friend(to='/feed/id3')
        img(title='dfv', alt= '' src='')
        | gh
      button Показать других
  router-view

</template>

<script>
export default {
  data() {
    return {
      active_friend_feed: 0,
      main_feed:{
        status:true,
        src:  'feed_white.png'
      },
      hot_feed:{
        status:false,
        src:  'hot_gray.png'
      },
      user_brief_info: {}
    }
  },
  methods:{
    changeMainParam: function(main, hot){
      if(main && !hot){
        this.main_feed.src = 'feed_white.png'
        this.hot_feed.src = 'hot_gray.png'
      }else if(!main && hot){
        this.main_feed.src = 'feed_gray.png'
        this.hot_feed.src = 'hot_white.png'
      }else if(!main && !hot){
        this.main_feed.src = 'feed_white.png'
        this.hot_feed.src = 'hot_white.png'
      }
      this.main_feed.status = main
      this.hot_feed.status = hot
      this.active_friend_feed = 0
    },
    enterMain: function(main, hot){
      if(main) this.main_feed.src = 'feed_white.png'
      else this.hot_feed.src = 'hot_white.png'
    },
    leaveMain: function(){
      if(this.main_feed.status){
        this.main_feed.src = 'feed_white.png'
      }else{
        this.main_feed.src = 'feed_gray.png'
      }
      if(this.hot_feed.status){
        this.hot_feed.src = 'hot_white.png'
      }else{
        this.hot_feed.src = 'hot_gray.png'
      }
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