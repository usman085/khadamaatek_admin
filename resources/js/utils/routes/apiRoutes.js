import Vue from "vue";

const apiRoutes = {
    auth: {
        get_csrf: {
            name: "GetCsrf",
            url: "/sanctum/csrf-cookie",
            method: "get"
        },
        login: {
            name: "Login",
            url: "/api/customer/login/",
            method: "post"
        },
        user:{
            name:"get_user",
            url:"/auth/users/me/"
        }
    },
    subject:{
        url:"/subjects/"
    },
    classes:{
        url:"/classes/",
        all:"/classes/all"
    },
    tutors:{
        url:"/tutors/"
    },
    groups:{
        url:"/groups/"
    }

}

// Plugin.install = function (Vue, options) {
//     Vue.apiRoutes = _apiRoutes;
//     window.apiRoutes = _apiRoutes;
// };
//
// Vue.use(Plugin)

export default apiRoutes;