import {validator } from './script.js'
Vue.createApp({
    data() {
        return {
            email: '',
            password: '',
            fieldErrors: {
                emailErr: 'Email is required',
                passwordErr: 'Password is required'
            },
            err: '',
            displayErr: false,
        }
    },
    methods: {
        async loginUser() {
            console.log(this.fieldErrors);
            if(this.fieldErrors.emailErr || this.fieldErrors.passwordErr){
                this.displayErr = true;
                return;
            }
            const formData = new FormData();
            formData.append("email", this.email);
            formData.append("password", this.password);
            const res = await fetch('loginUser', {
                method: 'POST',
                body: formData
            })
            const json = await res.json();
            if(json["message"] = 'success') {
                window.location.href = "welcome"
            } 
            if(json["error"]){
                this.err = json["error"];
            };
            console.log(json);
        },
        async loginWithFacebook() {
            const formData = new FormData();
            formData.append("method", "facebook");
            const res = await fetch('createUser', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();
            if(data['message'] === 'success'){
                window.location.href = "/slim-login"
            }
        },
        validator        
    }
}).mount('#app');