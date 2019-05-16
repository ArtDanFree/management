require('./bootstrap');

window.Vue = require('vue');

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);
Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);
Vue.component(
    'assign-underwriter',
    require('./components/AsignUnderwriter.vue')
);
Vue.component(
    'underwriter-fine',
    require('./components/UnderwriterFine.vue')
);
Vue.component(
    'home-page-lead-generator',
    require('./components/HomePage/LeadGenerator.vue')
);
Vue.component(
    'home-page-underwriter',
    require('./components/HomePage/Underwriter')
);
Vue.component(
    'home-page-admin',
    require('./components/HomePage/Admin')
);
Vue.component(
    'home-page-take-on-check',
    require('./components/HomePage/TakeOnCheck')
);
Vue.component(
    'test-telegram-message',
    require('./components/TestTelegramMessage')
);
Vue.component('pagination', require('./components/Pagination'));

const app = new Vue({
    el: '#app',
    data: {
        data: '',
    },
    methods: {
        onClick: function (data) {
            this.data = data;
        }},
});
window = require('./script');
