<template>
  <b-input-group prepend="Material" class="mb-2">
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

    <!-- Bind interno ao prop modelValue -->
    <b-form-input
      :value="modelValue"
      @input="updateValue"
      type="text"
      name="material"
    ></b-form-input>
  </b-input-group>

  <div class="menu-select" v-show="modelValue && !stateIcon">
    <div
      class="menu-select-item"
      v-for="(mt, key) in material_list"
      :key="key"
      v-show="key <= 5"
      @click="selectMaterial(mt)"
    >
      {{ mt }}
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import { defineEmits } from 'vue';
import { defineProps } from 'vue';
import { request } from '@/composables/request';

const props = defineProps({
  modelValue: String
});
const emit = defineEmits(["update:modelValue"]);

const material_list = ref([])

const stateIcon = computed(() => {
  return !(material_list.value.indexOf(props.modelValue) === -1)
})

const updateValue = (val) => {
  emit('update:modelValue', val)
}

const selectMaterial = (mt) => {
  emit('update:modelValue', mt)
}

watch(() => props.modelValue, (newValue) => {
  material_list.value = []
  if (!newValue) return

  request("post","api/materiais/all", {"notpgnt": true, "search": newValue}, true).then(res => {
    res.data.forEach(element => {
      if (!material_list.value.includes(element.name)) {
        material_list.value.push(element.name)
      }
    })
  })
})

onMounted(() => {
  request("post","api/materiais/all", {"notpgnt": true}, true).then(res => {
    res.data.forEach(element => {
      if (!material_list.value.includes(element.name)) {
        material_list.value.push(element.name)
      }
    })
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
        border-radius: 5px;
    }
    .menu-select-item:hover{
        background: #0f384c;
        color: white;
        cursor: pointer;
    }
</style>