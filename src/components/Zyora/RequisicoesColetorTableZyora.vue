<template>
  <div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12 col-lg-4">
             <b-input-group class="mt-3">
                <template #append>
                <b-input-group-text style="background: #0f384c; cursor: pointer" @click="search('api/requisicoes/me',true)"><strong style="color: white;"><i class="bi bi-search"></i></strong></b-input-group-text>
                </template>
                <b-form-input placeholder="Nome do Material" v-model="pesquisar"></b-form-input>
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
                    Status
                </td>
                <td>
                    Material
                </td>
                <td>
                    Descrição
                </td>
                <td>
                    Aprovador
                </td>
                <td>
                    Quantidade
                </td>
                <td>
                    Retirado
                </td>
                <td>
                    Criado em
                </td>
                <td>
                    Última atualização
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
                    {{ data.status }}
                </td>
                <td>
                    {{ data.material_req }}
                </td>
                <td>
                    {{ data.descricao || 'N/A'}}
                </td>
                <td>
                    {{ data.approver?.name || "Aguardando aprovação" }}
                </td>
                <td>
                    {{ data.quantidade }}
                </td>
                <td>
                    {{ data.confirm_retirada ? "Retirado" : "Não retirado"}}
                </td>
                <td>
                    {{ formatDate(data.created_at) }}
                </td>
                <td>
                    {{ formatDate(data.updated_at) }}
                </td>
                <td>
                    <div v-show="data.confirm_retirada">
                        <div v-show="!data.confirm_recebimento">
                            <button class="btn btn-primary" @click="confirmar_recebimento(data.id)">Confirmar Recebimento</button>
                        </div>
                        <div v-show="data.confirm_recebimento">
                            <button class="btn btn-outline-success">Recebido</button>
                        </div>
                    </div>
                    <div v-show="!data.confirm_retirada">
                        N/A
                    </div>
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
   import { request } from '@/composables/request';
   import { formatDate } from '@/composables/auxiliars';
   import { onMounted, ref } from 'vue';

   const datas= ref("")
   const ant= ref("")
   const prox= ref("")
   const current= ref("")
   const pesquisar= ref("")

   const confirmar_recebimento= (id) => {
        request("post","api/requisicoes/update",{ "id": id, "confirm_recebimento": true},true).then((res) => {
            console.log(res)
        }).catch((err) => {
            console.log(err)
        })

        search(current.value, false)
   }

   const search= (url, partialink= false) => {
        request("post",url,{"search": pesquisar.value},true, partialink).then((res) => {
            datas.value= res.data.data
            current.value= url
            ant.value= res.data.prev_page_url
            
            prox.value= res.data.next_page_url
            console.log(res.data)
        }).catch((err) => {
            console.log(err)
        })
    }



   onMounted(() => {
        request("post","api/requisicoes/me",{},true).then((res) => {
            datas.value= res.data.data
            current.value= res.data.path
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