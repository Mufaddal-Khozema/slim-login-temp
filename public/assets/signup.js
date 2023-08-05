import {emailValidityError, passwordValidityError, imageValidityError} from './script.js'
Vue.createApp({
    data() {
        return {
            email: '',
            password: '',
            cpassword: '',
            profilePic: '',
            err: '',
        }
    },
    methods: {
        async createUser() {
            console.log(this.profilePic);
            if(this.password !== this.cpassword){
                this.err = "Passwords do not match"
                return
            }
            console.log("signing up");
            const formData = new FormData();
            formData.append("email", this.email);
            formData.append("password", this.password);
            formData.append("profile_picture", this.profilePic);
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
        passwordValidityError,
        imageValidityError
    }
}).mount('#app');