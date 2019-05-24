<template lang="pug">
    #chats_wrapper
        #chats_list_wrapper.inline
            #chat_search
                form#search_chat_wrapper
                    input(type="text", placeholder="Искать...")
                    button
                        img(src="/static/images/search_gray.png")
            #chat_list_content
                .chat_element_wrapper
                    router-link.chat_element_img_wrapper(to="/id1")
                        img.chat_img(alt="", title="", src="/static/dev/1.jpg") 
                    router-link.chat_element_name(to="/id1") Название чата
                    .last_msg Последнее сообщение
                .chat_element_wrapper
                    .chat_element_img_wrapper
                        router-link.image_half_left(to="/id1")
                            img.chat_img(alt="", title="", src="/static/dev/2.jpg")
                        router-link.image_half_right(to="/id2") 
                            img.chat_img(alt="", title="", src="/static/dev/7.jpg")  
                    span.chat_element_name Название чата
                    .last_msg_conf
                        img.last_msg_user_img(alt="", title="", src="/static/dev/2.jpg") 
                        span    Последнее сообщение
                .chat_element_wrapper
                    .chat_element_img_wrapper
                        router-link.image_half_left(to="/id1")
                            img.chat_img(alt="", title="", src="/static/dev/3.jpg")
                        .image_half_right
                            router-link.image_half_top(to="/id2")
                                img.chat_img(alt="", title="", src="/static/dev/4.jpg") 
                            router-link.image_half_bottom(to="/id4")
                                img.chat_img(alt="", title="", src="/static/dev/5.jpg") 
                    router-link.chat_element_name(to="/id1") Название чата
                    .last_msg_conf
                        img.last_msg_user_img(alt="", title="", src="/static/dev/5.jpg") 
                        span    Последнее сообщение
                .chat_element_wrapper
                    .chat_element_img_wrapper
                        .image_half_left
                            router-link.image_half_top(to="/id1")
                                img.chat_img(alt="", title="", src="/static/dev/8.jpg") 
                            router-link.image_half_bottom(to="/id4")
                                img.chat_img(alt="", title="", src="/static/dev/9.jpg")
                        .image_half_right
                            router-link.image_half_top(to="/id2")
                                img.chat_img(alt="", title="", src="/static/dev/11.jpg") 
                            router-link.image_half_bottom(to="/id4")
                                img.chat_img(alt="", title="", src="/static/dev/10.jpg")
                    router-link.chat_element_name(to="/id1") Название чата
                    .last_msg_conf
                        img.last_msg_user_img(alt="", title="", src="/static/dev/3.jpg") 
                        span    Последнее сообщение
                .chat_element_wrapper
                    router-link.chat_element_img_wrapper(to="/id1")
                        img.chat_img(alt="", title="", src="/static/dev/1.jpg") 
                    router-link.chat_element_name(to="/id1") Название чата
                    .last_msg Последнее сообщение
                .chat_element_wrapper
                    router-link.chat_element_img_wrapper.single_img(to="/id1")
                        img.chat_img(alt="", title="", src="/static/dev/3.jpg") 
                    router-link.chat_element_name(to="/id1") Название чата
                    p.last_msg Последнее сообщение
                .chat_element_wrapper
                    router-link.chat_element_img_wrapper.single_img(to="/id1")
                        img.chat_img(alt="", title="", src="/static/dev/3.jpg") 
                    router-link.chat_element_name(to="/id1") Название чата
                    .last_msg Последнее сообщение
                .chat_element_wrapper
                    router-link.chat_element_img_wrapper.single_img(to="/id1")
                        img.chat_img(alt="", title="", src="/static/dev/1.jpg") 
                    router-link.chat_element_name(to="/id1") Название чата
                    .last_msg Последнее сообщение
                .chat_element_wrapper
                    router-link.chat_element_img_wrapper.single_img(to="/id1")
                        img.chat_img(alt="", title="", src="/static/dev/2.jpg") 
                    router-link.chat_element_name(to="/id1") Название чата
                    .last_msg Последнее сообщение
                .chat_element_wrapper
                    router-link.chat_element_img_wrapper.single_img(to="/id1")
                        img.chat_img(alt="", title="", src="/static/dev/3.jpg") 
                    router-link.chat_element_name(to="/id1") Название чата
                    .last_msg Последнее сообщение
                button.loading#load_chat(name="load_chat") Загрузить еще
        #chat_wrapper.inline
            #chat_header_wrapper
                #chat_title Название чата
                #chat_subtitle 20 участников
                button#chat_options(@click.prevent="option_show = !option_show")
                #options_list(v-show="option_show")
                    .option_item(@click="openInfo") Основная информация
                    .option_row
                    .option_item Добавить собеседников
                    .option_item Покинуть беседу
            #chat_content_wrapper
                .message
                    router-link(to='/id1')
                        img.message_user_img(src='/static/dev/1.jpg', alt='')
                    router-link.message_username(to='/id1') Имя Фамилия
                    span.message_time 17:59
                    p.message_text
                        | Формальный язык описания внешнего вида документа, написанного с использованием языка разметки. Преимущественно используется как средство описания, оформления внешнего вида веб-страниц, написанных с помощью языков разметки HTML и XHTML
                .message
                    router-link(to='/id9')
                        img.message_user_img(src='/static/dev/9.jpg', alt='')
                    router-link.message_username(to='/id1') Имя Фамилия
                    span.message_time 17:59
                    p.message_text
                        | Формальный язык описания внешнего вида документа, написанного с использованием языка разметки. Преимущественно используется как средство описания, оформления внешнего вида веб-страниц, написанных с помощью языков разметки HTML и XHTML
                .message
                    router-link(to='/id10')
                        img.message_user_img(src='/static/dev/10.jpg', alt='')
                    router-link.message_username(to='/id1') Имя Фамилия
                    span.message_time 17:59
                    p.message_text
                        | Формальный язык описания внешнего вида документа, написанного с использованием языка разметки. Преимущественно используется как средство описания, оформления внешнего вида веб-страниц, написанных с помощью языков разметки HTML и XHTML
                .message
                    router-link(to='/id11')
                        img.message_user_img(src='/static/dev/11.jpg', alt='')
                    router-link.message_username(to='/id1') Имя Фамилия
                    span.message_time 17:59
                    p.message_text
                        | Формальный язык описания внешнего вида документа, написанного с использованием языка разметки. Преимущественно используется как средство описания, оформления внешнего вида веб-страниц, написанных с помощью языков разметки HTML и XHTML
                .message
                    router-link(to='/id5')
                        img.message_user_img(src='/static/dev/2.jpg', alt='')
                    router-link.message_username(to='/id1') Имя Фамилия
                    span.message_time 17:59
                    p.message_text
                        | Формальный язык описания внешнего вида документа, написанного с использованием языка разметки. Преимущественно используется как средство описания, оформления внешнего вида веб-страниц, написанных с помощью языков разметки HTML и XHTML
                .message
                    router-link(to='/id4')
                        img.message_user_img(src='/static/dev/4.jpg', alt='')
                    router-link.message_username(to='/id1') Имя Фамилия
                    span.message_time 17:59
                    p.message_text
                        | Формальный язык описания внешнего вида документа, написанного с использованием языка разметки. Преимущественно используется как средство описания, оформления внешнего вида веб-страниц, написанных с помощью языков разметки HTML и XHTML
                .message
                    router-link(to='/id3')
                        img.message_user_img(src='/static/dev/3.jpg', alt='')
                    router-link.message_username(to='/id1') Имя Фамилия
                    span.message_time 17:59
                    p.message_text
                        | Формальный язык описания внешнего вида документа, написанного с использованием языка разметки. Преимущественно используется как средство описания, оформления внешнего вида веб-страниц, написанных с помощью языков разметки HTML и XHTML
            #chat_input_wrapper
                #textarea_wrapper
                    img#chat_input_img(src='/static/dev/3.jpg', alt='')
                    .textarea(aria-multiline='true', contenteditable='true', role='textbox', data-text='Введите сообщение...')
        .window_area(v-show="window_area_show")
            .window_content(v-show="chat_info_show")
                h2.window_title Информация
                form.chat_info_header_wrapper
                    .chat_element_img_wrapper
                        .image_half_left
                            router-link.image_half_top(to="/id1")
                                img.chat_img(alt="", title="", src="/static/dev/8.jpg") 
                            router-link.image_half_bottom(to="/id4")
                                img.chat_img(alt="", title="", src="/static/dev/9.jpg")
                        .image_half_right
                            router-link.image_half_top(to="/id2")
                                img.chat_img(alt="", title="", src="/static/dev/11.jpg") 
                            router-link.image_half_bottom(to="/id4")
                                img.chat_img(alt="", title="", src="/static/dev/10.jpg")
                    .chat_name_wrapper
                        input.chat_name(type="text", value="Название чата", placeholder="Введите название чата", require)
                h3 Администратор чата
                .chat_user_wrapper
                    img.chat_user_img(src="/static/dev/ava.jpg" alt="")
                    router-link.chat_user_name(to="/id1") Имя Фамилия
                    .chat_user_description Создал чат 12.05.2019   
                h3 Участники чата (20)
                .chat_user_wrapper
                    img.chat_user_img(src="/static/dev/2.jpg" alt="")
                    router-link.chat_user_name(to="/id1") Имя Фамилия
                    .chat_user_description Приглашен 12.05.2019
                .chat_user_wrapper
                    img.chat_user_img(src="/static/dev/4.jpg" alt="")
                    router-link.chat_user_name(to="/id1") Имя Фамилия
                    .chat_user_description Приглашен 12.05.2019
                .chat_user_wrapper
                    img.chat_user_img(src="/static/dev/5.jpg" alt="")
                    router-link.chat_user_name(to="/id1") Имя Фамилия
                    .chat_user_description Приглашен 12.05.2019
                .chat_user_wrapper
                    img.chat_user_img(src="/static/dev/6.jpg" alt="")
                    router-link.chat_user_name(to="/id1") Имя Фамилия
                    .chat_user_description Приглашен 12.05.2019
                .chat_user_wrapper
                    img.chat_user_img(src="/static/dev/7.jpg" alt="")
                    router-link.chat_user_name(to="/id1") Имя Фамилия
                    .chat_user_description Приглашен 12.05.2019
                .chat_user_wrapper
                    img.chat_user_img(src="/static/dev/8.jpg" alt="")
                    router-link.chat_user_name(to="/id1") Имя Фамилия
                    .chat_user_description Приглашен 12.05.2019





</template>

<script>
export default {
    data(){
        return {
            "option_show": false,
            "window_area_show": false,
            "chat_info_show": false
        }
    },
    methods: {
        hideOption: function(){
            this.option_show = false
        },
        openInfo: function(){
            this.window_area_show = true,
            this.chat_info_show = true
            document.getElementsByTagName('body')[0].classList.add("body_no_scroll");
            document.addEventListener('mouseup', (e) => {
               const win_area = document.getElementsByClassName('window_area')[0]
               if(e.target == win_area) {
                    this.window_area_show = false,
                    this.chat_info_show = false
                    document.getElementsByTagName('body')[0].classList.remove("body_no_scroll");
               }
            });
        }
    },
    created() {
           document.addEventListener('mouseup', (e) => {
               const op_but = document.getElementById('chat_options');
               const op_area = document.getElementById('options_list');
               if(e.target != op_but || e.target != op_but) {
                   this.hideOption()
               }
            });
    },
    mounted(){
        const chat_height = Math.max(
            document.body.scrollHeight, document.documentElement.scrollHeight,
            document.body.offsetHeight, document.documentElement.offsetHeight,
            document.body.clientHeight, document.documentElement.clientHeight
        )
        window.scrollTo(0, chat_height)

    }
}
</script>
