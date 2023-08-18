import {validator} from './script.js';

Vue.createApp({
    data() {
        return {
            user: {
                first_name: '',
                last_name: '',                
                email: '',
                mobileno: '',
                street_address: '',
                city: '',
                province: '',
                zipcode: '',
                trade: '',
                skill: '',
                work_province: '',                
                password: '',
            },
            profilePic: '',
            cpassword: '',
            err: '',
            displayErrors: false,
            fieldErrors: {
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
        }
    },
    methods: {
        async createUser() {
            if(this.isErrors(this.fieldErrors)){
                this.displayErrors = true;
                return
            }
            if(this.user.password !== this.cpassword){
                this.err = "Passwords do not match"
                return
            }
            console.log("signing up");
            const formData = new FormData();
            formData.append("user", JSON.stringify(this.user));
            formData.append("profile_picture", this.profilePic);
            const res = await fetch('signup', {
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
        isErrors(errs) {
            return (errs.nameErr || errs.lnameErr || errs.emailErr || errs.mobilenoErr || errs.streetAddErr
                || errs.cityErr || errs.provinceErr || errs.zipCodeErr || errs.tradeErr || errs.skillErr ||
                errs.workProvinceErr || errs.passwordErr || errs.cpasswordErr || errs.imageErr)
        },
        validator,
    }
}).mount('#app');