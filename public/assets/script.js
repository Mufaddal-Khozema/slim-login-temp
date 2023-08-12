const PROVINCES = ['Balochistan', 'Khyber Pakhtunkhwa', 'Punjab', 'Sindh', 'Islamabad Capital Territory']; 

function generalOneWordFieldError(text, fieldname) {
    if(!fieldname) fieldname = "This field"
    if(!text){
        return `${fieldname} is required`;
    } else if(!/^[a-zA-Z\.\-]*$/.test(text)) {
        return `${fieldname} must not contain numbers, symbols or spaces!`;
    } else {
        return "";
    } 
}

function generalSelectionError(value, fieldName, validOptions) {
    if(!value){
        return `${fieldName} is required`;
    } else if(!validOptions.includes(value)) {
        return `${fieldName} is not valid`
    } else return ''
}

export function validator(e) {
    const input = e.target;
    switch(input.name){
        case 'profilePic':
            const image = input.files[0]
            this.user.profilePic = image;
            const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            const uploadedImageSizeLimit = 500000;
            if(!image){
                this.fieldErrors.imageErr = "Picture is required"
            } else if(!validImageTypes.includes(image.type)) {
                this.fieldErrors.imageErr = "Invalid image extension";
            } else if(image.size > uploadedImageSizeLimit) {
                this.fieldErrors.imageErr = "Image too large";
            } else this.imageErr = ''
            break;
        case 'cpassword':
            this.cpasswordErr = input.value? '' : "This field is required";
            break;
        case 'password':
            if(!input.value){ 
                this.passwordErr = "Password is required";
            } else if (input.value.length < 8) { 
                this.passwordErr = "Lengthen this password to 8 or more letters"
            } else if(!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(\W|_)).*$/.test(input.value)){
                this.passwordErr = `Password must contain lowercase letters uppercase letters numbers special charachers (like @,$,#,%)`;
            } else this.passwordErr = '';
            break;
        case 'work_province': 
            this.workProvinceErr = generalSelectionError(input.value, 'This field', PROVINCES);
            break;
        case 'skill':
            this.skillErr = generalSelectionError(input.value, 'Skill', ['No Experience', 'Helper', 'Apprentice (1st Year)', 'Apprentice (2nd Year)', 'Apprentice (3rd Year)', 'Apprentice (4th Year)', 'Journeyman', 'Master'])
            break;
        case 'trade':
            this.tradeErr = generalSelectionError(input.value, 'Trade', ['Architect', 'Brick Layer', 'Carpenter', 'Electrician', 'Fence Installer', 'HVAC', 'Interior Designer', 'Landscaper', 'Mason', 'Plumber', 'Roofer']);
            break;
        case 'zipcode':
            if(!input.value){
                this.zipCodeErr = "Zip Code is required";
            } else if(!/^\d{5}$/.test(input.value)) {
                this.zipCodeErr = "Make sure Zip Code is valid"
            } else this.zipCodeErr = "";
            break;
        case 'province':
            this.provinceErr = generalSelectionError(input.value, 'Province', PROVINCES);
            break;
        case 'city': 
            this.cityErr = generalOneWordFieldError(input.value, 'City');
            break;
        case 'street_address':
            if(!input.value) this.streetAddErr = "Street Address is required";
            else if(!/^[\w\s#.\\/,\(\)-]+$/.test(input.value)) {
                this.streetAddErr = "Only limited symbols are allowed"
            } else this.streetAddErr = "";  
            break;
        case 'mobileno':
            if(!input.value) this.mobilenoErr = "Mobile No is required"
            else if(!/^\d{10}$/.test(input.value)){
                this.mobilenoErr = "Make sure you have entered your No. correctly"
            } else this.mobilenoErr = ""
            break;
        case 'email': 
            if(!input.value) this.emailErr = "Email is required"; 
            else if(!/^\w+([\-\.]?\w+)*@\w+([\-\.]?\w+)*(\.\w{2,3})+$/.test(input.value)){ 
                this.emailErr = "Make sure the email is valid"; 
            } else this.emailErr = '' 
            break;
        case 'fname':
            this.nameErr = generalOneWordFieldError(input.value, 'Name');
            break;
        case 'lname':
            this.lnameErr = generalOneWordFieldError(input.value, 'Last Name');
            break;
        default:
            console.log("Cannot validate this input");
    }
}