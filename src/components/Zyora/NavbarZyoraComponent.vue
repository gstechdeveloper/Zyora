<template>
  <div>
    <b-navbar toggleable="lg" type="dark" class="background-nav">
        <b-navbar-brand href="#" class="brand">
            <img src="@/assets/logo.png"><span>Zyora</span>
        </b-navbar-brand>


        <div class="card-user mt-3 mt-lg-0" @click="showUser = !showUser">
            <h5>{{  usuario }} ▾</h5>
            <div class="card-user-menu">
                <div class="card-user-options" v-show="showUser">
                    <div class="option-link" @click="logoff">Sair</div>
                </div>
            </div>
        </div>
    </b-navbar>
  </div>
</template>

<script setup>
    import { ref } from 'vue';
    import { useRouter } from 'vue-router';
    import { request } from '@/composables/request';

    const usuario= ref(JSON.parse(localStorage.getItem("zyzydata")).username)
    
    const showUser= ref(false)
    const router= useRouter()

    const logoff= () =>{
        request("post", "api/user/logout",{}, true).then(() => {}).catch((err) => { console.log(err)})
        localStorage.removeItem('zyzy')
        localStorage.removeItem('zyzydata')
        router.push("/zyora")
    }
</script>

<style scoped>
    .background-nav{
        background: #0f384c;
        padding: 10px;
    }
    .brand{
        color: white;
        font-size: 1.7rem;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }
    .brand > img{
        width: 50px;
        margin-right: 10px;
    }

    #nav-collapse{
        justify-content: right;
    }
    
    .card-user-menu{
        position: relative;
        padding: 0px 5px 5px 5px;
    }

    .card-user-options{
        background: white;
        position: absolute;
        bottom: -70px;
        width: 100px;
        text-align: center;
        right: 0px;
        border: 1px solid #aaa;
        border-radius: 5px;
        padding: 10px;
        box-shadow: 1px 1px rgba(0, 0, 0, 0.3);
    }

    .card-user{
        cursor: pointer;
        border-radius: 5px;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px 20px;
    }

    .card-user-avatar{
        margin-right: 15px;
    }

    .card-user > h5{
        color: white;
        font-size: 1rem;
        font-weight: 400;
        align-self: center;
        height: 100%;
    }

    .card-dropdown > button {
        background-color: #0f384c !important;
        color: #fff !important;
        border: none !important;
    }

    .option-link{
        padding: 5px;
    }

    .option-link:hover{
        background: #aaa;
        color: white;
    }

    
</style>
