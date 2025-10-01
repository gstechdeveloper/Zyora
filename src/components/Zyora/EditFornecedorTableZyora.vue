<template>
  <div class="container-fluid mt-4">
    <div class="row">
        <div class="col-3">
             <b-input-group class="mt-3">
                <template #append>
                <b-input-group-text style="background: #0f384c; cursor: pointer" @click="search('api/fornecedor/all',true)"><strong style="color: white;"><i class="bi bi-search"></i></strong></b-input-group-text>
                </template>
                <b-form-input placeholder="Nome do Fornecedor" v-model="pesquisar"></b-form-input>
            </b-input-group>
        </div>
        <div class="col-5">
        </div>

        <div class="col-4">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table mt-5">
                <thead>
                    <tr>
                        <td>
                            ID
                        </td>
                        <td>
                            Nome do Fornecedor
                        </td>
                        <td>
                            Criador por
                        </td>
                        <td>
                            Criado em
                        </td>
                        <td>
                            Atualizado em
                        </td>
                        <td>
                            Ações
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(data, key) in datas" :key="key">
                        <td>
                            {{ data.id }}
                        </td>
                        <td>
                            {{ data.name }}
                        </td>
                        <td>
                            {{ data.created_by.name }}
                        </td>
                        <td>
                            {{ formatDate(data.created_at) }}
                        </td>
                        <td>
                            {{ formatDate(data.updated_at) }}
                        </td>
                        <td>
                            <router-link :to="'/zyora/app/fornecedores/edit/' + data.id"><i class="bi bi-pencil-square"></i></router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <button class="nav-btn" @click="search(ant)" :disabled="ant == null">Anterior</button>
            <button class="nav-btn" @click="search(prox)" :disabled="prox == null">Proximo</button>
        </div>            
        <div class="col-3"></div>
        <div class="col-4">
        
        </div>
        <div class="col-4">
        
        </div>
    </div>
    
  </div>
</template>

<script setup> 
    import { ref } from 'vue';
    import { request } from '@/composables/request';
    import { onMounted } from 'vue';

    const datas= ref({})
    const prox= ref("")
    const ant= ref("")
    const pesquisar= ref("")

    function formatDate(date, hour = true) {
        const d = new Date(date.includes("T") ? date : date + "T00:00:00")
        const day = String(d.getDate()).padStart(2, '0')
        const month = String(d.getMonth() + 1).padStart(2, '0')
        const year = d.getFullYear()

        if (hour) {
            const hours = String(d.getHours()).padStart(2, '0')
            const minutes = String(d.getMinutes()).padStart(2, '0')
            const seconds = String(d.getSeconds()).padStart(2, '0')
            return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`
        } else {
            return `${day}/${month}/${year}`
        }
    }

    const search= (url, partialink= false) => {
        request("post",url,{"search": pesquisar.value},true, partialink).then((res) => {
            datas.value= res.data.data
            ant.value= res.data.prev_page_url
            prox.value= res.data.next_page_url
            console.log(res.data)
        })
    }

    onMounted(() => {
        request("post","api/fornecedor/all",{},true).then((res) => {
            datas.value= res.data.data
            ant.value= res.data.prev_page_url
            prox.value= res.data.next_page_url
        })
        
    })

</script>

<style scoped>
    .table{
        text-align: center;
        width: 100%;
    }


    .nav-btn{
        background: transparent;
        color: #0f384c;
        border: 1px solid #0f384c;
        padding: 10px;
        margin-left: 10px;
        border-radius: 5px
    }

    .nav-btn:hover:not(:disabled) {
        background: #0f384c;
        color: white;
    }

    .nav-btn:disabled{
        border-color: gray;
        color: gray
    }
    
    thead > tr > td{
        background: #213f54;
        color: white;
    }
    
    tr{
        border: 1px solid #ccc;
    }

    h5{
        font-size: 1rem;
        font-weight: 400;
    }

    i{
        font-size: 1.5rem;
    }
</style>