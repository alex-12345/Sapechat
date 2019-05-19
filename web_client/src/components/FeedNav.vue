<template lang="pug">
#feed_wrapper
  #feed_params_wrapper.inline
    #feed_params_list
      h5 ОБЩАЯ ЛЕНТА
      router-link.feed_generalized_param(to='/feed', v-bind:class="{ active: main_feed.status }")
        span(@click="changeMainParam(true,false)", @mouseenter="enterMain(true,false)" @mouseleave="leaveMain()")
          img(alt='', v-bind:src="'/static/images/' + main_feed.src") 
          | Моя лента
      router-link.feed_generalized_param(to='/hot', v-bind:class="{ active: hot_feed.status }")
        span(@click="changeMainParam(false,true)", @mouseenter="enterMain(false,true)" @mouseleave="leaveMain()")
          img(alt='', v-bind:src="'/static/images/' + hot_feed.src") 
          | Популярное
      h5 ЗАПИСИ ДРУЗЕЙ
      router-link.feed_friend( v-for="friend in friends_list" v-bind:to="'/feed/id' + friend.user_id", v-bind:class="{ active_friend: active_friend_feed == friend.user_id }")
        span(@click="switchOnFriend(friend.user_id)")
          img(:title="friend.user_first_name + ' ' + friend.user_last_name", alt= 'no' :src="friend.user_img")
          | {{friend.user_first_name}} {{friend.user_last_name}}
      button Показать других
  router-view

</template>

<script>
import store from '@/store'

export default {
  data() {
    return {
      active_friend_feed: this.$route.params.id || 0,
      main_feed:{
        status: this.$route.name == "feed" || false,
        src:  null
      },
      hot_feed:{
        status: this.$route.name == "hot" || false,
        src:  null
      },
      user_brief_info: {},
      friends_list: {}
    }
  },
  created(){
      this.user_brief_info = this.$parent.user_brief_info
      
      const  id = this.user_brief_info.user_id
      const start = 0
      const amount = 8 
      
      this.$store.dispatch('FRIENDS_LIST_REQUEST', { id, start, amount }).then(()=>{
          this.friends_list = this.$store.getters.friendsList
      })
      this.main_feed.status? this.main_feed.src = 'feed_white.png' : this.main_feed.src = 'feed_gray.png'
      this.hot_feed.status? this.hot_feed.src = 'hot_white.png': this.hot_feed.src = 'hot_gray.png'
  },
  methods:{
    changeMainParam: function(main, hot){
      if(main && !hot){
        this.main_feed.src = 'feed_white.png'
        this.hot_feed.src = 'hot_gray.png'
      }else if(!main && hot){
        this.main_feed.src = 'feed_gray.png'
        this.hot_feed.src = 'hot_white.png'
      }
      this.main_feed.status = main
      this.hot_feed.status = hot
        this.active_friend_feed = 0
    },
    enterMain: function(main, hot){
      main? this.main_feed.src = 'feed_white.png' : this.hot_feed.src = 'hot_white.png'
    },
    leaveMain: function(){
      this.main_feed.status ? this.main_feed.src = 'feed_white.png': this.main_feed.src = 'feed_gray.png'
      this.hot_feed.status ? this.hot_feed.src = 'hot_white.png' : this.hot_feed.src = 'hot_gray.png'
    },
    switchOnFriend:function(id){
      this.main_feed.status = false
      this.main_feed.src = 'feed_gray.png'
      this.hot_feed.status = false
      this.hot_feed.src = 'hot_gray.png'
      this.active_friend_feed=id
    }
  },
  computed: {
    getUserBrief( ){
      return this.user_brief_info = this.$parent.user_brief_info
    },
    getFriendList(){
      return 0
    }
  }
}

</script>

<style lang="stylus" scoped>
</style>