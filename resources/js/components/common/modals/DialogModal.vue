<script setup>
import { onMounted, ref, reactive } from 'vue';
import ModalComponent from './baseModal.vue';

import RoundedButton from '../button/RoundedButton.vue';
import AreaInput from '../AreaInput.vue';
import TextInput from '../TextInput.vue';
import NoticeForm from '../NoticeForm.vue';

const props = defineProps({
  title: String,
  inputs: Array,
  errors: [Object, Array]
});

const data = ref({});

onMounted(() => {
  props.inputs.filter((input) => input.id && input.model)
    .forEach(({ id, model }) => data.value[id] = model.value);
});

const emit = defineEmits([ 'submit', 'cancel' ]);
</script>

<template>
  <ModalComponent>
      <template #header>
        <p>{{ title }}</p>
      </template>
      <template #content>
        <div class='flex flex-col gap-3'>
          <component
            v-for='(input, idx) of props.inputs'
            :key='idx'
            :is="input.type === 'area' ? AreaInput : TextInput"
            v-bind='input'
            v-model='data[input.id]'
          />
        <NoticeForm
          v-if='errors.value.global'
          :message='errors.value.global'
        />
        </div>
      </template>
      <template #footer>
        <div class='flex justify-end gap-2'>
          <RoundedButton
            text='Annuler'
            @click="emit('cancel')"
          />

          <RoundedButton
            text='Confirmer'
            @click="emit('submit', reactive(data))"
          />
        </div>
      </template>
  </ModalComponent>
</template>