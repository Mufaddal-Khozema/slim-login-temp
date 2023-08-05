export function emailValidityError(e) {
    const input = e.target;
    if (checkPatternMismatch(input.validity)) {
        input.setCustomValidity("Make sure the email is valid")
    }
    else input.setCustomValidity("");
    input.customError = false;
}

export function passwordValidityError(e) {
    const input = e.target;
    if (checkPatternTooShort(input.validity)) {
        input.setCustomValidity("Please lengthen this text to 8 characters or more")
    }
    else if (checkPatternMismatch(input.validity)) {
        input.setCustomValidity(`Password must contain 
        lowercase letters
        uppercase letters
        numbers
        special charachers (like @,$,#,%)`)

    }
    else  input.setCustomValidity("");
}

export function imageValidityError(e) {
    const input = e.target;
    if(input.validity.customError){
        input.setCustomValidity("");
    }
    const uploadedImageFile = input.files[0]
    this.profilePic = uploadedImageFile;

    const uploadedImageType = uploadedImageFile.type;
    const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    if(!validImageTypes.includes(uploadedImageType)){
        input.setCustomValidity('Invalid File Extension');
    }
    const uploadedImageSize = uploadedImageFile.size;
    const uploadedImageSizeLimit = 500000;
    if(uploadedImageSize > uploadedImageSizeLimit){
        input.setCustomValidity(`Image too large >${uploadedImageSizeLimit/1000}kb`)
    }
    
}

function checkPatternMismatch(validity) {
    return (
        validity.patternMismatch === true &&
        validity.tooLong === false &&
        validity.tooShort === false &&
        validity.valid === false &&
        validity.valueMissing === false
    )
}

function checkPatternTooShort(validity) {
    return (
        validity.patternMismatch === true &&
        validity.tooLong === false &&
        validity.tooShort === true &&
        validity.valid === false &&
        validity.valueMissing === false
    )
}