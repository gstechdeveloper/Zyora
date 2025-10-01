<template>
    <div class="body">
        <div class="body-transparence">
            <div class="container">
                <div class="row">
                    <div class="col col-lg-4"></div>
                    <div class="col-10 col-lg-4">
                        <div class="login-box">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <h1 class="display-5 brand">Zyora</h1>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <b-input-group prepend="Usuário" class="mt-3">
                                            <b-form-input v-model="usuario"></b-form-input>
                                        </b-input-group>

                                        <h5 class="error">{{ errors.name }}</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <b-input-group prepend="Senha" class="mt-3">
                                            <b-form-input type="password" v-model="senha"></b-form-input>
                                        </b-input-group>
                                        <h5 class="error">{{ errors.senha }}</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <h5 class="error">{{ errors.message }}</h5>
                                        <button class="btn btn-outline-success mt-2 login" @click="logar">Login</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-4"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, watch } from 'vue';
    import { request } from '@/composables/request';
    import { useRouter } from 'vue-router';

    const usuario= ref("")
    const senha= ref("")
    const errors= ref({})
    const router= useRouter()

    watch([usuario,senha],() => {
        errors.value= {}
    })

    const logar = () => {
        request("post","api/login",{
            "name": usuario.value,
            "password": senha.value
        }, false).then((res) =>{

            localStorage.setItem("zyzy",res.data.token)
            
            localStorage.setItem("zyzydata",JSON.stringify({
                "username": res.data.user.name
            }))
            console.log(res.data)

            router.push("/zyora/app")
       }).catch((error) => {
            if(error.response.data.name){
                errors.value.name= error.response.data.name[0]
            }
            if(error.response.data.password){
                errors.value.senha= error.response.data.password[0]
            }

            console.log(error)

            errors.value.message= error.response.data.message

       })
    }
</script>

<style scoped>
    .error{
        color: red;
        font-size: 0.9rem;
        margin-top: 10px;
    }
    .login{
        font-size: 1.2rem;
    }
    .brand{
        text-align: center;
    }
    .col{
        text-align: center;
    }

    .body-transparence{
        width: 100%;
        height: 100%;
        background: rgba(15, 56, 76,0.5);
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .body{
        position: relative;
        background: url("@/assets/Zyora/loginwallpaper.jpeg");
        background-repeat: no-repeat;
        background-size: cover;
        height: 100vh;
    }

    .form{
        background: white;
    }

    .login-box {
        background: rgba(255, 255, 255, 0.9); /* semitransparente */
        backdrop-filter: blur(1px); /* embaça o fundo */
        -webkit-backdrop-filter: blur(10px); /* suporte Safari */
        padding: 2rem;
        border-radius: 15px;
        color: black;
    }

    *{
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif
    }
    
</style>