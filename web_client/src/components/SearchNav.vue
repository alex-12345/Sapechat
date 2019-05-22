<template lang="pug">
    #people_wrapper
        #people_filters.inline
            h5 Отобразить
            #filter_main_params
                a.active Все профили
                a Профили моих друзей
            h5 Отфильтровать
            .select_filter
                span.filter_header Страна
                select
                    option Не выбрана
                    option Россия
                    option Великобритания
                    option США
            .select_filter
                span.filter_header Город
                select
                    option Не выбран
                    option Москва
                    option Питер
                    option Другой
            .select_filter
                span.filter_header Возраст
                input(type="text", name="min", placeholder="От", maxlength="2")
                span#space -
                input(type="text", name="max", placeholder="До", maxlength="2")
            .select_filter
                span.filter_header Пол
                select
                    option Не выбран
                    option Мужской
                    option Женский
        #stream_people_wrapper.inline
            form#search_form
                input.inline(type="search", name="search", placeholder="Введите имя пользователя...", autocomplete="off", maxlength="40", required)
                button.inline(name="ok")
                    img(alt="", src="/static/images/search_white.png")
            router-view
</template>

<script>
export default {
    data() {
        return {
        
        }
    }
}
</script>

