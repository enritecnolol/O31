<template>
    <div class="limiter">
        <div class="container-login100" style="background: linear-gradient(-135deg, #0e3bbb, #384865);">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="../../../../../public/Loginv2/images/img-01.png" alt="IMG">
                </div>

                <div class="login100-form validate-form">
					<span class="login100-form-title">
						Admin Login
					</span>

                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="text" v-model="username" name="username" placeholder="username">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate = "Password is required">
                        <input class="input100" type="password" v-model="password" name="pass" placeholder="Password" @keypress.enter="login">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" @click="login">
                            Login
                        </button>
                    </div>

                    <div class="text-center p-t-12">
						<!--<span class="txt1">-->
							<!--Forgot-->
						<!--</span>-->
                        <!--<a class="txt2" href="#">-->
                            <!--Username / Password?-->
                        <!--</a>-->
                    </div>

                    <div class="text-center p-t-136">
                        <!--<a class="txt2" href="#">-->
                            <!--Create your Account-->
                            <!--<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>-->
                        <!--</a>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name:'login',
    data()
    {
        return{
            username:'',
            password:''
        }
    },
    methods:{
        login(){
            if (this.username && this.password)
            {
                axios.post('/login/admin', {
                    username: this.username,
                    password: this.password
                })
                    .then( (response) => {
                        if (response.data == "402")
                        {
                            console.log("aqui")
                            this.$toastr.warning("credenciales incorrectas", "Validador");
                        }
                    })
                    .catch( (error) => {
                        console.log(error);
                    });
            }
        }
    },
    computed:{

    }
}
</script>
<style>

</style>