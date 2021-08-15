require('./bootstrap');

import Vue from 'vue';

import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';
//import Vuesax from 'vuesax'
//import 'vuesax/dist/vuesax.css' //Vuesax styles
import Antd from 'ant-design-vue';
import { FormModel } from 'ant-design-vue';
import 'ant-design-vue/dist/antd.css';

Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);
Vue.use(FormModel);
Vue.use(Antd, {
    // options here
});

const app = document.getElementById('app');

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);
