import {emailValidityError, passwordValidityError} from './script.js'
Vue.createApp({
    data() {
        return {
            email: '',
            password: '',
            err: ''
        }
    },
    methods: {
        async loginUser() {
            const formData = new FormData();
            formData.append("email", this.email);
            formData.append("password", this.password);
            const res = await fetch('loginUser', {
                method: 'POST',
                body: formData
            })
            const json = await res.json();
            if(json["success"]) {
                window.location.href = "welcome"
            } 
            if(json["error"]){
                this.err = json["error"]["databaseError"]
            };
            console.log(json);
        },
        emailValidityError,
        passwordValidityError
    }
}).mount('#app');