import {validateEmail, validatePassword} from './../script.js'
Vue.createApp({
    data() {
        return {
            email: '',
            password: '',
            cpassword: '',
            emailErr: '',
            passwordErrs: '',
        }
    },
    methods: {
        async createUser() {
            this.passwordErrs = ''
            this.emailErr = ''
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
            console.log(this.passwordErrs, this.emailErr);
            if(!this.passwordErrs && this.password != this.cpassword){
                this.passwordErrs = "Password does not match"
            }

            if(!this.passwordErrs && !this.emailErr){
                const formData = new FormData();
                formData.append("email", this.email);
                formData.append("password", this.password);
                const res = await fetch('createUser', {
                    method: 'POST',
                    body: formData
                })
                const json = await res.json();
                if(json["success"]) {
                    console.log("Here");
                    window.location.href = "views/welcome.php"
                } 
            }
            
        },
        validateEmail
        ,
        validatePassword
    }
}).mount('#app');