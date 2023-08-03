<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div id="app">
        {{name}}
        <a href=".">Home</a>
        <a href="signup">Signup</a>
        <form @submit="loginUser">
            <p>{{emailErr}}</p>
            <label for="emal">Email: </label>
            <br>
            <input 
                type="email" 
                name="email" 
                placeholder="Enter your email"
                v-model="email" 
                @input="emailValidityError"
                pattern="\w+([\-\.]?\w+)*@\w+([\-\.]?\w+)*(\.\w{2,3})+" 
                required>
            <br>
            <br>
            <ul v-if="typeof passwordErrs === 'object'" v-for="pErr in passwordErrs">
                <li>{{pErr}}</li>
            </ul>
            <p v-else>{{passwordErrs}}</p>
            <label for="password">Password: </label>
            <br>
            <input 
                type="password" 
                name="password" 
                placeholder="Enter your pasword"
                minlength="8" 
                maxlength="256" 
                v-model="password" 
                @input="passwordValidityError"
                autocomplete="new-password" 
                pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(\W|_)).*"
                required>

            <br>
            <br>
            <input type="submit" value="Submit">
        </form>
    </div>
    <script src="https://unpkg.com/vue@3"></script>
    <script src="public/assets/login.js" type="module"></script>
</body>
</html>