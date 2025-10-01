<template>
    <div>
        <b-input-group prepend="Fornecedor" class="mb-2">
            <template #append>
                <b-input-group-text>
                    <div v-show="stateIcon">
                        <i class="bi bi-hand-thumbs-up" style="color: green"></i>
                    </div>
                    <div v-show="!stateIcon">
                        <i class="bi bi-x-circle" style="color: red"></i>
                    </div>
                </b-input-group-text>
            </template>
            <b-form-input v-model="fornecedor" type="text"></b-form-input>
        </b-input-group>
        <div class="menu-select" v-show="dropdownShow">
            <div v-for="(forn, key) in fornecedor_list_search" class="menu-select-item" :key="key" @click="selectFornecedor(forn.id,forn.name)" v-show="key <= 7">
                {{ forn.name }}
            </div>
        </div>
    </div>
</template>

<script setup>
    import { computed, onMounted, ref, watch } from 'vue';
    import { request } from '@/composables/request';
    import { useStore } from 'vuex';

    import { defineProps } from 'vue';

    const props= defineProps({
        "fornecedor_txt": {
            "type": String,
            "default": ""
        }
    })

    const state= useStore().state
    const fornecedor_list= ref([])
    const fornecedor_list_search= ref([])
    const fornecedor= ref(props.fornecedor_txt)
    var fornecedor_id= ref(-1)
    var dropdownShow= ref(false);
    var bdcolor= ref("")


    watch(fornecedor,(newValue) =>{
        if(newValue == "" || fornecedor_list.value.some(f => f.name === newValue)){
            fornecedor_id.value= -1
            dropdownShow.value= false
            bdcolor.value= "1px solid green !important"
        }else{
            fornecedor_id.value= -1
            dropdownShow.value= true
            state.searchfornecedor.finded= false
            fornecedor_list_search.value= Array.from(fornecedor_list.value)
            fornecedor_list_search.value= fornecedor_list_search.value.filter(f => f.name.includes(newValue))
        }
    })

    watch(
    () => props.fornecedor_txt,
    (newValue) => {
        fornecedor.value = newValue
    }
    )

    const selectFornecedor= (id,name) =>{
        fornecedor.value= name
        fornecedor_id.value= id
        state.searchfornecedor.finded= true
        state.searchfornecedor.id= id
        dropdownShow.value= false
    }
    
    const stateIcon= computed(() =>{
        return fornecedor_list.value.some(f => f.name === fornecedor.value) || props.fornecedor_txt == fornecedor.value;
    })


    onMounted(() =>{
        request("post","api/fornecedor/all",{"notpgnt": true},true).then((res) => {
            res.data.forEach(element => {
                fornecedor_list.value.push({
                    "id": element.id,
                    "name": element.name
                })
            });
        })
    })

</script>

<style scoped>
    .menu-select{
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 5px;
        transition: 5s height;
    }

    .menu-select-item{
        padding: 5px;
        border-radius: 2px;
    }
    .menu-select-item:hover{
        background: #0f384c;
        color: white;
        cursor: pointer;
    }
</style>

