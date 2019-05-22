<template lang="pug">
#people_results_wrapper
    .peoople_element_wrapper.inline
        router-link(to='/id1')
            img.result_people_img(src='css/files/user_img/1.jpg', alt='no_img')
        router-link.people_name(to='/id1') Имя Фамилия
        span.people_description Москва, 19 лет
        button.add_friend Добавить в друзья
    .peoople_element_wrapper.inline
        router-link(to='/id1')
            img.result_people_img(src='css/files/user_img/1.jpg', alt='no_img')
        router-link.people_name(to='/id1') Имя Фамилия
        span.people_description Москва, 19 лет
        button.friend У вас в друзьях
    .peoople_element_wrapper.inline
        router-link(to='/id1')
            img.result_people_img(src='css/files/user_img/1.jpg', alt='no_img')
        router-link.people_name(to='/id1') Имя Фамилия
        span.people_description Москва, 19 лет
        button.add_friend Добавить в друзья
    .peoople_element_wrapper.inline
        router-link(to='/id1')
            img.result_people_img(src='css/files/user_img/1.jpg', alt='no_img')
        router-link.people_name(to='/id1') Имя Фамилия
        span.people_description Москва, 19 лет
        button.add_friend Добавить в друзья
    .peoople_element_wrapper.inline
        router-link(to='/id1')
            img.result_people_img(src='css/files/user_img/1.jpg', alt='no_img')
        router-link.people_name(to='/id1') Имя Фамилия
        span.people_description Москва, 19 лет
        button.add_friend Добавить в друзья

</template>

<script>
export default {
    data(){
        return {

        }
    }
}
</script>
