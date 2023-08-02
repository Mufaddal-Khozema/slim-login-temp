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
        <form method="post">
            <p>{{emailErr}}</p>
            <label for="emal">Email: </label>
            <br>
            <input type="text" name="email" v-model="email" id="">
            <br>
            <br>
            <ul v-if="typeof passwordErrs === 'object'" v-for="pErr in passwordErrs">
                <li>{{pErr}}</li>
            </ul>
            <p v-else>{{passwordErrs}}</p>
            <label for="password">Password: </label>
            <br>
            <input type="password" name="password" v-model="password" id="">
            <br>
            <br>
            <input type="submit" @click.prevent="createUser" value="Submit">
        </form>
    </div>
    <script src="https://unpkg.com/vue@3"></script>
    <script src="app/views/Login/login.js" type="module"></script>
</body>
</html>