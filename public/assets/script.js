export function nameValidityError(e) {
    const input = e.target;
    this.nameErr = generalOneWordFieldError(input.value, 'Name');
}

export function lnameValidityError(e) {
    const input = e.target;
    this.lnameErr = generalOneWordFieldError(input.value, 'Last Name');
}

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

export function emailValidityError(e) { 
    const input = e.target; 
    if(!input.value) this.emailErr = "Email is required"; 
    else if(!/^\w+([\-\.]?\w+)*@\w+([\-\.]?\w+)*(\.\w{2,3})+$/.test(input.value)){ 
        this.emailErr = "Make sure the email is valid"; 
    } else this.emailErr = '' 
} 

export function mobilenoValidityError(e) {
    const input = e.target;
    if(!input.value) this.mobilenoErr = "Mobile No is required"
    else if(!/^\d{10}$/.test(input.value)){
        this.mobilenoErr = "Make sure you have entered your No. correctly"
    } else this.mobilenoErr = ""
}

export function addressValidationError(e) {
    const input = e.target;
    if(!input.value) this.streetAddErr = "Street Address is required";
    else if(!/^[\w\s#.\\/,\(\)-]+$/.test(input.value)) {
        this.streetAddErr = "Only limited symbols are allowed"
    } else this.streetAddErr = "";  
}

export function cityValidationError(e) {
    const input = e.target;
    this.cityErr = generalOneWordFieldError(input.value, 'City');
}

const PROVINCES = ['Balochistan', 'Khyber Pakhtunkhwa', 'Punjab', 'Sindh', 'Islamabad Capital Territory']; 

export function provinceValidationError(e) {
    const input = e.target;
    generalSelectionError(input.value, 'Province', PROVINCES);
}

export function passwordValidityError(e) { 
    const input = e.target;
    if(!input.value){ 
        this.passwordErr = "Password is required";
    } 
    else if (input.value.length < 8) { 
        this.passwordErr = "Lengthen this password to 8 or more letters"
    } 
    else if(!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(\W|_)).*$/.test(input.value)){
        this.passwordErr = `Password must contain lowercase letters uppercase letters numbers special charachers (like @,$,#,%)`;
    } else {
        this.passwordErr = '';
    }
}

export function cpasswordValidityError(e) {
    const input = e.target;
    if(!input.value){
        this.cpasswordErr = "This field is required";
    } else {
        this.cpasswordErr = '';
    }
} 
 
export function zipcodeValidationError(e) {
    const input = e.target;
    if(!input.value){
        this.zipCodeErr = "Zip Code is required";
    } else if(!/^\d{5}$/.test(input.value)) {
        this.zipCodeErr = "Make sure Zip Code is valid"
    } else this.zipCodeErr = "";
}

export function tradeValidationError(e){
    const input = e.target;
    this.tradeErr = generalSelectionError(input.value, 'Trade', ['Architect', 'Brick Layer', 'Carpenter', 'Electrician', 'Fence Installer', 'HVAC', 'Interior Designer', 'Landscaper', 'Mason', 'Plumber', 'Roofer']);
}

export function skillValidationError(e){
    const input = e.target;
    this.skillErr = generalSelectionError(input.value, 'Skill', ['No Experience', 'Helper', 'Apprentice (1st Year)', 'Apprentice (2nd Year)', 'Apprentice (3rd Year)', 'Apprentice (4th Year)', 'Journeyman', 'Master'])
}

export function workProvinceValidationErr(e) {
    const input = e.target;
    this.workProvinceErr = generalSelectionError(input.value, 'This field', PROVINCES);
}

function generalSelectionError(value, fieldName, validOptions) {
    if(!value){
        return `${fieldName} is required`;
    } else if(!validOptions.includes(value)) {
        return `${fieldName} is not valid`
    } else return ''
}

export function imageValidityError(e) {
    const input = e.target;
    const image = input.files[0]
    this.profilePic = image;
    const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    const uploadedImageSizeLimit = 500000;
    if(!image){
        this.imageErr = "Image is required"
    } else if(!validImageTypes.includes(image.type)) {
        this.imageErr = "Invalid image extension";
    } else if(image.size > uploadedImageSizeLimit) {
        this.imageErr = "Image too large";
    } else this.imageErr = ''
}