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