/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)
import datatables from 'datatables.net'
import swal from 'sweetalert'
import ListUsers from './components/user/ListUsers'
import FormUser from './components/user/FormUser'
import FormPhoto from './components/user/FormPhoto'
import FormInformation from './components/user/FormInformation'
import FormPassword from './components/user/FormPassword'

const app = new Vue({
    el: '#app',
    components:{
        'users-list': ListUsers,
        'users-form-user': FormUser,
        'users-form-photo': FormPhoto,
        'users-form-information': FormInformation,
        'users-form-password': FormPassword,
    }
});
