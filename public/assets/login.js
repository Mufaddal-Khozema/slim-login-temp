import {emailValidityError, passwordValidityError} from './script.js'
Vue.createApp({
    data() {
        return {
            email: '',
            password: '',
            emailErr: 'Email is required',
            passwordErr: 'Password is required',
            err: '',
            displayErr: false,
        }
    },
    methods: {
        async loginUser() {
            this.displayErr = true;
            if(this.emailErr || this.passwordErr){
                return
            }
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