import Vue from "vue";
import App from "./App.vue";
// import './plugins/axios'
import ApiRoutes from "./utils/routes/apiRoutes";
import "./registerServiceWorker";
import router from "./router";
import store from "./store";
import "./mixins/global_mixins";
// register the plugin on vue
import Toasted from "vue-toasted";
import { Steps } from "ant-design-vue";
import { BootstrapVue, BootstrapVueIcons } from "bootstrap-vue"; //Importing
import VueFormGenerator from "vue-form-generator";

Vue.config.productionTip = false;
Vue.use(Toasted, {
    iconPack: "fontawesome"
});
Vue.use(VueFormGenerator);
Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
Vue.use(Steps);
window.apiRoutes = ApiRoutes;
window.axios.defaults.backEndBaseURL = document.head.querySelector(
    'meta[name="base-url"]'
).content;

window.axios.defaults.baseURL =
    document.head.querySelector('meta[name="base-url"]').content + "/api";
// Axios config
// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// window.axios.defaults.withCredentials = true;

new Vue({
    router,
    store,
    BootstrapVue,
    created() {
        const userInfo = localStorage.getItem("user");
        if (userInfo) {
            const userData = JSON.parse(userInfo);
            this.$store.commit("setUserData", userData);
        }
        axios.interceptors.response.use(
            response => response,
            error => {
                if (error.response.status === 401) {
                    this.$store.dispatch("logout");
                }
                return Promise.reject(error);
            }
        );
    },
    render: h => h(App)
}).$mount("#web-app");
