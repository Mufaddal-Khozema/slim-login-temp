<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
</head>
<body>
    <a href=".">Home</a>
    <a href="login">Login</a>
    <div id="app">
        <form method="post">
            {{emailErr}}
            <label for="emal">Email: </label>
            <br>
            <input type="text" name="email" v-model="email">
            <br>
            <br>
            <ul v-if="typeof passwordErrs === 'object'" v-for="pErr in passwordErrs">
                <li>{{pErr}}</li>
            </ul>
            <p v-else>{{passwordErrs}}</p>
            <label for="password">Password: </label>
            <br>
            <input type="password" name="password"  v-model="password">
            <br>
            <br>
            <label for="password">Confirm Password: </label>
            <br>
            <input type="password" name="cpassword" v-model="cpassword">
            <br>
            <br>
            <input type="submit" @click.prevent="createUser" value="Submit">
        </form>
    </div>
    <script src="https://unpkg.com/vue@3"></script>
    <script src="public/assets/signup.js" type="module"></script>
</body>
</html>