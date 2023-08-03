export function validateEmail(email){

    if(!email){

        throw "Email is required"

    }

    if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){

        throw "Invalid Email"

    } 

}

export function validatePassword(password) {
    let errorMsgs = [];
    if(!password) {
        throw "Password is required";
    }

    if (!/^.{8,256}$/.test(password)) {
        errorMsgs.push('Password length must be 8 or more');
    }

    if (!/^(?=.*[a-z]).*$/.test(password)) {
        errorMsgs.push("Must have a lowercase character");
    }

    if (!/^(?=.*[A-Z]).*$/.test(password)) {
        errorMsgs.push("Must have a uppercase character");
    }

    if (!/^(?=.*\d).*$/.test(password)) {
        errorMsgs.push("Must have a number");
    }

    if (!/^(?=.*(\W|_)).*$/.test(password)) {
        errorMsgs.push("Must have a special symbol");
    }
    if(errorMsgs.length > 0) throw errorMsgs;
}

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