<template>
  <div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12 col-lg-4">
             <b-input-group class="mt-3">
                <template #append>
                <b-input-group-text style="background: #0f384c; cursor: pointer" @click="search('api/requisicoes/all',true)"><strong style="color: white;"><i class="bi bi-search"></i></strong></b-input-group-text>
                </template>
                <b-form-input placeholder="Nome do Material" v-model="pesquisar"></b-form-input>
            </b-input-group>
        </div>
        <div class="col-5 col-lg-4">
        </div>

        <div class="col-4 col-lg-4">
            <div class="container">
                <div class="row">
                    <div class="col-3">
                        <h5>Status</h5>
                        <select class="form-select" aria-label="Default select example" v-model="fstatus">
                            <option selected>Todos</option>
                            <option value="Aberta">Aberta</option>
                            <option value="Em análise">Em análise</option>
                            <option value="Cancelada">Cancelada</option>
                            <option value="Resolvida">Resolvida</option>
                        </select>
                    </div>
                </div>
            </div>
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
                    Solicitante
                </td>
                <td>
                    Descrição
                </td>
                <td>
                    Quantidade
                </td>
                <td>
                    Aprovado por
                </td>
                <td>
                    Retirado
                </td>
                <td>
                    Recebido
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
                    {{ data.created_by?.name }}
                </td>
                <td>
                    {{ data.descricao }}
                </td>
                <td>
                    {{ data.quantidade }}
                </td>
                <td>
                    {{ data.approver?.name || "Não aprovado" }}
                </td>
                <td>
                    {{ data.confirm_retirada ? "Retirado" : "Não retirado"}}
                </td>
                <td>
                    {{ data.confirm_recebimento ? "Recebido" : "Não Recebido"}}
                </td>
                <td>
                    {{ formatDate(data.created_at) }}
                </td>
                <td>
                    {{ formatDate(data.updated_at) }}
                </td>
                <td>
                    <router-link :to="'/zyora/app/saidas/edit/' + data.id"><i class="bi bi-plus-square"></i></router-link>
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
   const pesquisar= ref("")
   const fstatus= ref("")

   const search= (url, partialink= false) => {
        request("post",url,{"search": pesquisar.value, "fstatus": fstatus.value},true, partialink).then((res) => {
            datas.value= res.data.data
            ant.value= res.data.prev_page_url
            prox.value= res.data.next_page_url
            console.log(res.data)
        }).catch((err) => {
            console.log(err)
        })
    }

   onMounted(() => {
        request("post","api/requisicoes/all",{"fstatus": fstatus.value},true).then((res) => {
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