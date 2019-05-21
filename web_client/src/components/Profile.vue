<template lang="pug">
#profile_wrapper
    #profile_sub_wrapper.inline
        img.user_main_img(:src="user_info.user_img", :alt="user_info.user_full_name", :title="user_info.user_full_name")
    #profile_main_wrapper.inline
        h5.user_profile_name {{user_info.user_full_name}}
        .profile_block_info
            ul
                li
                    b.inline Возраст:
                    span.inline {{user_info.user_birthday}}, 20 лет
                li
                    b.inline Город:
                    span.inline {{user_info.city_name}}, {{user_info.country_name}}
                li(v-if="user_info.user_about.length")
                    b.inline О себе:
                    span.inline {{user_info.user_about}}
        .profile_block_friends(v-if="getFriendsAmount")
            h5 Друзья ({{getFriendsAmount}})
            .friend_item.inline(v-for="friend in getFriends")
                router-link(:to="'/id' + friend.user_id")
                    img(:src="friend.user_img", alt="no_img", :title="friend.user_first_name") 
                    | {{friend.user_first_name}}
        span.post_filters
            span.post_filter(@click="loadPosts(0,20,false, true)", :class="{ active_filter: all_post_active}") Все записи
            span.post_filter(@click="loadPosts(0,20,true, true)", :class="{ active_filter: !all_post_active}") Записи Имени
        form#comment_form(v-on:submit.prevent="addPost" v-if="user_brief_info")
            img.user_image.inline(:src="user_brief_info.user_img", alt="no_img", :title="user_brief_info.user_first_name + ' ' + user_brief_info.user_last_name")
            #textarea_content.textarea.inline(aria-multiline="true", contenteditable="true", role="textbox", data-text="Напишите что-нибудь...")
            .right_wrapper
                button.button.send_post Отправить
        #stream_post_wrapper
            .post_wrapper(v-for="post in getPosts")
                router-link(:to="'/id' + post.user_id")
                    img.user_image_post(:title="post.user_first_name + ' ' +post.user_last_name", :src="post.user_img", alt="no img")
                .post_content
                    router-link.post_user_name(:to="'/id' + post.user_id") {{post.user_first_name + ' ' +post.user_last_name}}
                    span.post_time Написанно {{post.post_utc_date }}
                    .post_text {{post.post_content}}
        button.loadPosts(v-if="showLoadButton", @click="loadPosts(post_start,post_amount,!all_post_active, false)") Загрузить еще
</template>

<script>
import store from '@/store'
export default {
  data() {
    return {
        post_start: 0,
        post_amount: 20,
        user_id: 0,
        user_brief_info: null,
        user_info: {},
        friend_amount:{},
        friend_list: {},
        user_posts: {},
        all_post_active:true,
        friend_status: 0,

    }
  },
  methods: {
      setSessionInfo: function(){
        if(this.$parent.user_brief_info && this.$route.params.id && this.$route.params.id == this.$parent.user_brief_info.user_id){
            this.$router.push("/im")
            return false
        }
        if(this.$parent.user_brief_info){
            this.user_brief_info = this.$parent.user_brief_info
        }
        if(this.$route.name == "im"){
            this.user_id = this.$parent.user_brief_info.user_id
        }else if(this.$route.name == "profile"){
            this.user_id = this.$route.params.id
        }
        return true
      },
      loadPosts: function(start, amount, flag, first_loading){
          if(first_loading) this.post_start = 0
          this.all_post_active = !flag
          const id = this.user_id
          store.dispatch("PROFILE_POSTS_REQUEST", {id, start, amount, flag, first_loading}).then(resp =>{
              this.post_start += this.post_amount 
          })
      },
      
      loadFriedns: function(start, amount){
          const id = this.user_id
          return store.dispatch("PROFILE_FRIENDS_REQUEST", {id, start, amount})
      },
      loadMainInfo: function(){
        const id = this.user_id
        store.dispatch("PROFILE_INFO_REQUEST", {id})
        this.user_info = store.getters.pr_info
        this.user_info.user_full_name = this.user_info.user_first_name + ' ' + this.user_info.user_last_name  
      },
      callAllMainFunc: function(){
        this.post_start = 0
        if(!this.setSessionInfo()) return false
        this.loadMainInfo()
        this.loadFriedns(0, 8)
        this.loadPosts(0, 20, false, true)
      },
      addPost:function(){
        let text = document.getElementById("textarea_content").innerText
        if(text.length == 0 || !this.user_brief_info)
            return false
        const user_id = this.user_brief_info.user_id
        const user_img = this.user_brief_info.user_img
        const user_first_name = this.user_brief_info.user_first_name
        const user_last_name = this.user_brief_info.user_last_name
        const wall_id = this.user_id
        const token = localStorage['user-token']
        store.dispatch("PROFILE_ADD_POST_REQUEST", {user_id, text, user_img, user_first_name, user_last_name, wall_id, token}).then(resp => {
            document.getElementById("textarea_content").innerHTML = ""
        })

        
      }
  },
  beforeRouteUpdate(to, from, next){
      next()
      this.callAllMainFunc()
  },
  beforeRouteLeave (to, from, next) {
      if(to.name == "profile" && from.name == "im" || to.name == "im" && from.name == "profile"){
        next()
        this.callAllMainFunc()
      }else{
          next()
      }
  },
  created(){
      this.callAllMainFunc()
  },
  computed: {
      getPosts: function(){
          return this.user_posts = store.getters.pr_posts_list
      },
      getFriendsAmount: function(){
         // console.log(store.getters.pr_friends_amount)
          return this.friend_amount = store.getters.pr_friends_amount
      },
      getFriends: function(){
          return this.friend_list = store.getters.pr_friends_list
      },
      showLoadButton:function(){
          return this.user_posts.length ==this.post_start
      }
  }
}
</script>
