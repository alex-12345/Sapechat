<template lang="pug">
#profile_wrapper
    #profile_sub_wrapper.inline
        img.user_main_img(src="", alt="noimg", title="")
        button.add_to_friends Добавить в друзья
    #profile_main_wrapper.inline
        h5.user_profile_name Имя Фамилия
        .profile_block_info
            ul
                li
                    b.inline Возраст:
                    span.inline 24 июля 1998, 20 лет
                li
                    b.inline Город:
                    span.inline Москва
                li
                    b.inline О себе:
                    span.inline Существуют две основные трактовки понятия «текст»: имманентная (расширенная, философски нагруженная) и репрезентативная (более частная). Имманентный подход подразумевает отношение к тексту как к автономной реальности, нацеленность на выявление его внутренней структуры. Репрезентативный — рассмотрение текста как особой формы представления знаний о внешней тексту действительности.
        .profile_block_friends
            h5 Друзья (32)
            .friend_item.inline
                router-link(to="/id1")
                    img(src="", alt="no image", title="") 
                    | Имя
            .friend_item.inline
                router-link(to="/id2")
                    img(src="", alt="no image", title="") 
                    | Имя
        span.post_filters
            span.post_filter.active_filter Все записи
            span.post_filter Записи Имени
        form#comment_form(action="")
            img.user_image.inline(src="", alt="no_img", title="")
            .textarea.inline(aria-multiline="true", contenteditable="true", role="textbox", data-text="Напишите что-нибудь..." )
            textarea(style="display:none;", required)
            .right_wrapper
                button.button.send_post Отправить
        #stream_post_wrapper
            .post_wrapper
                router-link(to="/id")
                    img.user_image_post(alt="no img", src="css/files/user_img/1.jpg")
                .post_content
                    router-link.post_user_name(to="/id") Имя Фамилия
                    span.post_time Написанно 27.08 в 19:30
                    .post_text Существуют две основные трактовки понятия «текст»: имманентная (расширенная, философски нагруженная) и репрезентативная (более частная). Имманентный подход подразумевает отношение к тексту как к автономной реальности, нацеленность на выявление его внутренней структуры. Репрезентативный — рассмотрение текста как особой формы представления знаний о внешней тексту действительности
</template>

<script>
export default {
  data() {
    return {
        user_id: 0,
        user_brief_info: null,
        user_info: {},
        friend_amount:{},
        friend_list: {},
        friend_status: 0,
        user_all_posts: {},
        user_own_posts: {}

    }
  },
  methods: {
      setSessionMainInfo: function(){
        this.user_brief_info = this.$parent.user_brief_info
        this.user_id = this.user_brief_info.user_id
      }
  },
  created(){
      this.setSessionMainInfo()
  }
}
</script>
