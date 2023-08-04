<?php require __DIR__ . '/layout/header.php' ?>
<main class="h-auto w-full  flex items-center justify-center">
      <section class="h-1/2 md:w-1/2 lg:w-2/5 pt-10 flex flex-col items-center justify-center">
        <header class="flex flex-col  items-center justify-center mb-4">
          
          <h1 class="text-3xl mb-3 text-gray-800 font-bold">Login to your account</h1>
          <p class="text-base">
            Don't have an account yet?
            <a href="signup" class="text-blue-700">Register</a>
          </p>
        </header>
        <form @submit.prevent="loginUser" class="lg:w-3/4 w-full flex flex-col items-center text-sm justify-center">
        <span v-if="err" class="w-full p-2 bg-red-600 bg-opacity-25 text-yellow-800 text-white rounded mb-3">{{err}}</span>
                <!-- <label for="emal">Email: </label> -->
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Enter your email"
                    v-model="email" 
                    @input="emailValidityError"
                    pattern="\w+([\-\.]?\w+)*@\w+([\-\.]?\w+)*(\.\w{2,3})+" 
                    class="w-full border-2 border-gray-300 p-2 mb-3 placeholder-gray-600 rounded bg-transparent"
                    required/>
                <!-- <ul v-if="typeof passwordErrs === 'object'" v-for="pErr in passwordErrs">
                    <li>{{pErr}}</li>
                </ul>
                <p v-else>{{passwordErrs}}</p>
                <label for="password">Password: </label> -->
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
                    class="w-full border-2 border-gray-300 p-2 mb-1 placeholder-gray-600 rounded bg-transparent"
                    required/>
                <div class="w-full flex text-xs justify-between mb-3">
                    <div>
                        <input type="checkbox" name="" class="mr-1" id="remember-me" />
                        <label for="remember-me">Remember me</label>
                    </div>
                <a href="http://" class="text-blue-700">Forgot your password?</a>
                </div>
                <input 
                    type="submit" 
                    value="Login"
                    class="w-full shadow-md p-2 bg-violet-500 h-10 text-white font-semibold rounded  hover:bg-violet-600 active:bg-violet-700 focus:outline-none focus:ring focus:ring-violet-300"/>
                <div class="inline-flex items-center justify-center w-full">
              
                    <hr class="w-64 h-px my-8 bg-gray-200 border-0 dark:bg-gray-700" />
                    <span class="absolute px-3 font-medium text-gray-900 -translate-x-1/2 bg-white left-1/2 dark:text-white dark:bg-gray-900">or</span>
                </div>
                <button class="shadow-md w-full flex p-2 bg-violet-500 h-10 text-white font-semibold rounded mb-3 items-center justify-center hover:bg-violet-600 active:bg-violet-700 focus:outline-none focus:ring focus:ring-violet-300">
                    <?php require __DIR__ .'/../../public/assets/images/facebook.svg' ?>
                    <span>Login with Facebook</span>
                </button>
                <button class="shadow-md w-full flex p-2 bg-red-500 h-10 text-white font-bold rounded mb-3 flex items-center justify-center hover:bg-red-600 active:bg-red-700 focus:outline-none focus:ring focus:ring-red-300">
                    <?php require __DIR__ .'/../../public/assets/images/google.svg' ?>
                    <span>Login with Google</span>
                </button>
        </form>
    </section>
</main>
<script src="https://unpkg.com/vue@3"></script>
<script src="public/assets/login.js" type="module"></script>
</body>
</html>