"use strict";

import Vue from "vue";
import axios from "axios";

// Full config:  https://github.com/axios/axios#request-config
// axios.defaults.baseURL = process.env.baseURL || process.env.apiUrl || '';
// axios.defaults.headers.common['Authorization'] = AUTH_TOKEN;
// axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

let config = {
    baseURL: process.env.MIX_APP_URL
    // timeout: 60 * 1000, // Timeout
    // withCredentials: true, // Check cross-site Access-Control
};

const _axios = axios.create(config);
_axios.interceptors.request.use(
    function(config) {
        // Do something before request is sent
        config.baseURL = process.env.MIX_APP_URL;
        // config.headers.commons['Authorization']='0ff02652f3c2318a7e9dd636b9616328e5543dac'
        return config;
    },
    function(error) {
        // Do something with request error
        return Promise.reject(error);
    }
);
const token = localStorage.getItem("auth_token");
if (token) {
    _axios.defaults.headers.common["Authorization"] = "Token " + token;
}

// Add a response interceptor
_axios.interceptors.response.use(
    function(response) {
        // Do something with response data
        return response;
    },
    function(error) {
        // Do something with response error
        return Promise.reject(error);
    }
);

Plugin.install = function(Vue, options) {
    Vue.axios = _axios;
    window.axios = _axios;
    Object.defineProperties(Vue.prototype, {
        axios: {
            get() {
                return _axios;
            }
        },
        $axios: {
            get() {
                return _axios;
            }
        }
    });
};

Vue.use(Plugin);

export default Plugin;
