import {
    cpasswordValidityError,
    workProvinceValidationErr,    
    skillValidationError, 
    tradeValidationError, 
    zipcodeValidationError, 
    provinceValidationError, 
    cityValidationError, 
    addressValidationError, 
    mobilenoValidityError, 
    lnameValidityError, 
    nameValidityError, 
    emailValidityError, 
    passwordValidityError, 
    imageValidityError
} from './script.js';

Vue.createApp({
    data() {
        return {
            name: '',
            email: '',
            password: '',
            cpassword: '',
            profilePic: '',
            err: '',
            displayErrors: false,

            nameErr: 'Name is required',
            lnameErr: 'Last Name is required',
            emailErr: 'Email is required',
            mobilenoErr: 'Mobile No is required',
            streetAddErr: 'Street Address is required',
            cityErr: 'City is required',
            provinceErr: 'Province is required',
            zipCodeErr: 'Zip Code is required',
            tradeErr: 'Trade is required',
            skillErr: 'Skill is required',
            workProvinceErr: 'This field is required',
            passwordErr: 'Password is required',
            cpasswordErr: 'This field is required',
            imageErr: 'Picture is required'
        }
    },
    methods: {
        async createUser() {
            this.displayErrors = true;
            if(this.nameErr || this.lnameErr || this.emailErr || this.mobilenoErr || this.streetAddErr
                || this.cityErr || this.provinceErr || this.zipCodeErr || this.tradeErr || this.skillErr ||
                this.workProvinceErr || this.passwordErr || this.cpasswordErr || this.imageErr){
                return
            }
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
        imageValidityError,
        nameValidityError,
        lnameValidityError,
        mobilenoValidityError,
        addressValidationError,
        cityValidationError,
        provinceValidationError,
        zipcodeValidationError,
        tradeValidationError,
        skillValidationError,
        workProvinceValidationErr,
        cpasswordValidityError
    }
}).mount('#app');