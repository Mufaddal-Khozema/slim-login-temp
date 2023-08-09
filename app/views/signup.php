<?php require __DIR__ .'/layout/header.php' ?>
  <div id="app">
    <main class="w-full py-10 flex flex-col lg:flex-row gap-x-1 items-center justify-center">
      <section class="md:w-3/4 w-4/5 lg:w2/5 flex flex-col items-center justify-center">
        <header class="flex flex-col items-center justify-center mb-4">
          <h1 class="text-3xl mb-3 text-gray-800 font-bold">
            Register your account
          </h1>
          <p class="text-base">
            Already have an account?
            <a href="register.html" class="text-blue-700">Login</a>
          </p>
        </header>
        <form @input="displayErrors = false" @submit.prevent="createUser" class="lg:w-3/4 w-full flex flex-col items-center gap-y-2 text-sm justify-center" method="post">
            <span v-if="err" class="w-full p-2 bg-red-600 bg-opacity-25 text-yellow-800 text-white rounded mb-3">{{err}}</span>
            <div id="name" class="w-full mb-3">
                <label for="first-name" class="text-gray-600 font-bold">Name</label>
                <div class="grid grid-cols-2 gap-x-2 placeholder-gray-200">
                <input
                    id="first-name"
                    type="text"
                    class="w-full border border-gray-300 p-1 mr-3 rounded bg-transparent"
                    placeholder="First Name"
                    @input="nameValidityError"
                />
                <input
                    id="last-name"
                    type="text"
                    class="w-full border border-gray-300 p-1 rounded bg-transparent"
                    placeholder="Last Name"
                    @input="lnameValidityError"
                />
                <transition>
                    <span class="text-red-600" v-if="displayErrors">{{nameErr}}</span>
                </transition>
                <transition>
                    <span class="text-red-600" v-if="displayErrors">{{lnameErr}}</span>
                </transition>
                </div>
            </div>
            <div id="row2" class="w-full lg:grid lg:grid-cols-2 lg:gap-2 mb-3">
                <div id="email" class="placeholder-gray-200 mb-3 lg:mb-0 flex-1">
                    <label for="email" class="text-gray-600 font-bold">Email</label>
                    <input 
                        type="text" 
                        name="email" 
                        placeholder="Enter your email"
                        v-model="email" 
                        @input="emailValidityError"
                        class="w-full border border-gray-300 p-1 rounded bg-transparent"
                        />
                    <transition>
                        <span class="text-red-600" v-if="displayErrors">{{emailErr}}</span>
                    </transition>
                </div>
                <div id="phone-number" class="placeholder-gray-200 flex-1">
                    <label for="phone-number" class="text-gray-600 font-bold">Mobile Phone</label>
                    <div class="w-full flex border border-gray-300 p-1 rounded bg-transparent">
                    <label class="px-1" for="phoneNumber">
                    +92
                    </label>
                    <input
                        id="phone-number"
                        name="phoneNumber"
                        type="text"
                        class="flex-grow bg-transparent focus:outline-none"
                        placeholder="Phone Number"
                        @input="mobilenoValidityError"
                        />
                    </div>
                    <transition>
                        <span class="text-red-600" v-if="displayErrors">{{mobilenoErr}}</span>
                    </transition>
                </div>
            </div>
            <div id="address-form" class="w-full grid-cols-3 mb-3">
                <label for="first-name" class="text-gray-600 font-bold">Address</label>
                <div id="address" class="w-full lg:grid lg:grid-cols-2 grid-rows-3 lg:gap-x-2 placeholder-gray-200">
                <div id="street-address" class="col-span-2 mb-2">
                    <label for="street-adress">Street Address</label>
                    <input
                      id="street-adress"
                      type="text"
                      class="w-full border border-gray-300 p-1 mr-3 rounded bg-transparent"
                      placeholder="Enter Your Location"
                      @input="addressValidationError"
                      />
                      <transition>
                        <span class="text-red-600" v-if="displayErrors">{{streetAddErr}}</span>
                      </transition>
                </div> 
                <div id="city" class="flex-1 mb-2">
                    <label for="city">City</label>
                        <input
                        id="city"
                        type="text"
                        class="w-full border border-gray-300 p-1 mr-3 rounded bg-transparent"
                        placeholder="City Name"
                        @input="cityValidationError"
                        />
                    <transition>
                        <span class="text-red-600" v-if="displayErrors">{{cityErr}}</span>
                    </transition>
                </div>
                <div id="province" class="flex-1 mb-2">
                    <label for="province">Province</label>
                    <select
                        class="w-full border border-gray-300 p-1 rounded bg-transparent"
                        name="Provinces"
                        id="province"
                        @input="provinceValidationError"
                    >
                        <option value=""></option>
                        <option value="Balochistan">Balochistan</option>
                        <option value="Khyber Pakhtunkhwa">
                            Khyber Pakhtunkhwa
                        </option>
                        <option value="Punjab">Punjab</option>
                        <option value="Sindh">Sindh</option>
                        <option value="Islamabad Capital Territory">
                            Islamabad Capital Territory
                        </option>
                    </select> 
                    <transition>
                        <span class="text-red-600" v-if="displayErrors">{{provinceErr}}</span>
                    </transition>
                </div>
                <div id="zip-code" class="flex flex-col">
                    <label for="zip-code">Zip Code</label>
                    <input
                    id="zip-code"
                    type="text"
                    class="w-full border border-gray-300 p-1 rounded bg-transparent"
                    placeholder="Zip Code"
                    @input="zipcodeValidationError"
                    />
                    <transtion>
                        <span class="text-red-600" v-if="displayErrors">{{zipCodeErr}}</span>
                    </transtion>
                </div>
                </div>
            </div>
            <div id="info" class="w-full grid lg:grid-cols-3 text-gray-600 grid-cols-1 gap-y-2 lg:gap-y-0 gap-x-2 mb-3">
                <div id="trade" class="flex flex-col">
                    <label for="trade" class="font-bold">Trade</label>
                    <select 
                        class="w-full border border-gray-300 p-1 rounded bg-transparent" 
                        name="Trades" 
                        id="trade"
                        @input="tradeValidationError"
                    >
                        <option value=""></option>
                        <option value="Architect">Architect</option>
                        <option value="Brick Layer">Brick Layer</option>
                        <option value="Carpenter">Carpenter</option>
                        <option value="Electrician">Electrician</option>
                        <option value="Fence Installer">Fence Installer</option>
                        <option value="HVAC">HVAC</option>
                        <option value="Interior Designer">Interior Designer</option>
                        <option value="Landscaper">Landscaper</option>
                        <option value="Mason">Mason</option>
                        <option value="Plumber">Plumber</option>
                        <option value="Roofer">Roofer</option>
                    </select>
                    <transition>
                        <span class="text-red-600" v-if="displayErrors">{{tradeErr}}</span>
                    </transition> 
                </div>
                <div id="skill" class="flex text-gray-600 flex-col">
                    <label for="skill" class="font-bold">Skill</label>
                    <select 
                        class="w-full border border-gray-300 p-1 rounded bg-transparent" 
                        name="Skills" 
                        id="skill"
                        @input="skillValidationError"
                    >
                        <option value=""></option>
                        <option value="No Experience">No Experience</option>
                        <option value="Helper">Helper</option>
                        <option value="Apprentice (1st Year)">Apprentice (1st Year)</option>
                        <option value="Apprentice (2nd Year)">Apprentice (2nd Year)</option>
                        <option value="Apprentice (3rd Year)">Apprentice (3rd Year)</option>
                        <option value="Apprentice (4th Year)">Apprentice (4th Year)</option>
                        <option value="Journeyman">Journeyman</option>
                        <option value="Master">Master</option>
                    </select>
                    <span class="text-red-600" v-if="displayErrors">{{skillErr}}</span>
                </div>
                <div class="flex-1 text-gray-600">
                    <label class="font-bold" for="province">Looking to work in?</label>
                    <select
                    class="w-full border border-gray-300 p-1 rounded bg-transparent"
                    name="Provinces"
                    id="province"
                    @input="workProvinceValidationErr"
                    >
                    <option value=""></option>
                    <option value="Balochistan">Balochistan</option>
                    <option value="Khyber Pakhtunkhwa">
                        Khyber Pakhtunkhwa
                    </option>
                    <option value="Punjab">Punjab</option>
                    <option value="Sindh">Sindh</option>
                    <option value="Islamabad Capital Territory">
                        Islamabad Capital Territory
                    </option>
                    </select>
                    <span class="text-red-600" v-if="displayErrors">{{workProvinceErr}}</span>
                </div>
            </div>
            <div id="password-form" v-model="password" class="w-full grid gap-2 lg:grid-cols-2 text-gray-600 grid-cols-1 mb-3">
                <div id="password">
                    <label for="password" class="font-bold">Password</label>
                    <input 
                    type="password" 
                    name="password" 
                    placeholder="Enter your password"
                    v-model="password"
                    @input="passwordValidityError"
                    class="w-full border border-gray-300 p-1 rounded bg-transparent" 
                    />
                    <transition>
                        <span class="text-red-600" v-if="displayErrors">{{passwordErr}}</span>
                    </transition>
                </div>
                <div id="confirm-password">
                    <label for="password" class="font-bold">Confirm Password</label>
                    <input 
                    type="password" 
                    name="cpassword" 
                    placeholder="Enter your password again"
                    v-model="cpassword"
                    @input="cpasswordValidityError" 
                    autocomplete="password-new"
                    class="w-full border border-gray-300 p-1 rounded bg-transparent" id="password"
                    />
                    <transition>
                        <span class="text-red-600" v-if="displayErrors">{{cpasswordErr}}</span>
                    </transition>
                </div>
            </div>
            <div id="picture" class="text-gray-600 w-full">
                <span class="font-bold">
                    Choose a picture
                </span>
                <input 
                    type="file" 
                    @change="imageValidityError" 
                    accept="image/png, image/gif, image/jpeg, image/jpg">
                <transition>
                    <span class="text-red-600" v-if="displayErrors">{{imageErr}}</span>
                </transition>
            </div>
            <div id="rememberme"class="w-full flex text-xs justify-between mb-3">
                <div class="w-full flex text-xs mb-3">
                    <input type="checkbox" name="" class="mr-1" id="remember-me" />
                    <label for="remember-me">Remember me</label>
                </div>
            </div>
            <input
                type="submit"
                class="w-full shadow-md p-2 bg-violet-500 text-white font-semibold rounded hover:bg-violet-600 active:bg-violet-700 focus:outline-none focus:ring focus:ring-violet-300"
                value="Signup"
            /> 
        </form>
    </section>
    <div class="h-screen hidden lg:block">
        <div id="vertical-line" class="h-48 border-l border-gray-200"></div>
        <span class="relative right-2 font-medium text-gray-900 text-left dark:text-white dark:bg-gray-900"> or </span>
        <div id="vertical-line" class="h-48 border-l border-gray-200"></div>
    </div>
    <div class="inline-flex items-center lg:hidden justify-center w-full">
        <hr class="w-64 h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
        <span class="absolute px-3 font-medium text-gray-900 -translate-x-1/2 left-1/2 dark:text-white dark:bg-gray-900">or</span>
    </div>
      <div class="lg:h-screen md:w-1/2 lg:w-2/5 text-sm lg:text-base w-4/5 lg:pt-24 flex flex-col items-center ">
        <button class="shadow-md w-3/4 flex p-2 bg-violet-500 h-10 text-white font-semibold rounded mb-3 items-center justify-center hover:bg-violet-600 active:bg-violet-700 focus:outline-none focus:ring focus:ring-violet-300"
          >
          <?php require __DIR__ . '/../../public/assets/images/facebook.svg' ?>
          <span>Sign In with Facebook</span>
        </button>
        <button class="shadow-md w-3/4 flex p-2 bg-red-500 h-10 text-white font-bold rounded mb-3 flex items-center justify-center hover:bg-red-600 active:bg-red-700 focus:outline-none focus:ring focus:ring-red-300"
        >
        <?php require __DIR__ . '/../../public/assets/images/google.svg' ?>
        <span>Sign In with Google</span>
    </button>
</div>
    </main>
</div>
<script src="https://unpkg.com/vue@3"></script>
<script src="public/assets/signup.js" type="module"></script>
</body>
</html>