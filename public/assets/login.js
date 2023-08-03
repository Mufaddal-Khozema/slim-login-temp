import {validateEmail, validatePassword, emailValidityError, passwordValidityError} from './script.js'
Vue.createApp({
    data() {
        return {
            email: '',
            password: '',
            emailErr: '',
            passwordErrs: '',
        }
    },
    methods: {
        async loginUser() {
            try {
                this.validateEmail(this.email);
            } catch(err) {
                this.emailErr = err
            }
            try {
                this.validatePassword(this.password);
            } catch(err) {
                this.passwordErrs = err
            }
            if(!this.passwordErrs && !this.emailErr){
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
            }
        },
        validateEmail,
        validatePassword,
        emailValidityError,
        passwordValidityError
    }
}).mount('#app');

