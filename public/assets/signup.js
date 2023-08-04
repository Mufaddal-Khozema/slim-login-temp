import {emailValidityError, passwordValidityError} from './script.js'
Vue.createApp({
    data() {
        return {
            email: '',
            password: '',
            cpassword: '',
            err: '',
        }
    },
    methods: {
        async createUser() {
            console.log("signing up");
            const formData = new FormData();
            formData.append("email", this.email);
            formData.append("password", this.password);
            const res = await fetch('createUser', {
                method: 'POST',
                body: formData
            })
            const json = await res.json();
            if(json === "success") {
                console.log("Here");
                window.location.href = "login"
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