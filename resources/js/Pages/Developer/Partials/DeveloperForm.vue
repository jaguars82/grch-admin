<template>
  <div class="formgrid grid">
    <div class="field col-12 md:col-6">
      <label for="name">Название*</label>
      <InputText
        class="w-full"
        inputId="name"
        v-model="fields.name"
        placeholder="Название застройщика"
        required
      />
    </div>
    <div class="field col-12 md:col-6">
      <label for="address">Адрес</label>
      <InputText
        class="w-full"
        inputId="address"
        v-model="fields.address"
        placeholder="Адрес застройщика"
      />
    </div>
    <div class="field col-12 md:col-4">
      <label for="phone">Номер телефона</label>
      <InputText
        class="w-full"
        inputId="phone"
        v-model="fields.phone"
        placeholder="Номер телефона"
      />
    </div>
    <div class="field col-12 md:col-4">
      <label for="url">Адрес сайта</label>
      <InputText
        class="w-full"
        inputId="url"
        v-model="fields.url"
        placeholder="Адрес сайта"
      />
    </div>
    <div class="field col-12 md:col-4">
      <label for="email">Email</label>
      <InputText
        class="w-full"
        inputId="email"
        v-model="fields.email"
        placeholder="Адрес электронной почты"
      />
    </div>
    <div class="col-12 mb-3">
      <h5 class="mb-2">Информация</h5>
      <Editor class="w-full" inputId="developer_detail" v-model="fields.detail" editorStyle="height: 320px" @load="initEditorValue" />
    </div>
    <div class="col-12">
      <FileUploader
        label="Логотип"
        :currentFiles="developer.logo ? [developer.logo] : []"
        :deleteAction="`/company/developer/${developer.id}/logo-delete`"
        accept="image/*"
        @uploading-files-changed="updateLogo"
      />
    </div>
  </div>
</template>

<script>
import { ref, watch } from 'vue';
import FileUploader from '@/Components/AdminPanelPartials/Forms/FileUploader';

export default {
  components: { FileUploader },
  props: {
    developer: {
      type: Object,
      default: {}
    },
  },
  setup (props, { emit }) {

    const fields = ref({
      id: props.developer.id ?? '',
      name: props.developer.name ?? '',
      detail: props.developer.detail ?? '',
      address: props.developer.address ?? '',
      phone: props.developer.phone ?? '',
      url: props.developer.url ?? '',
      email: props.developer.email ?? '',
      logofile: '',
    })

    // fix Editior display its model on load
    const initEditorValue = function ({ instance }) {
      instance.setContents(instance.clipboard.convert({
        html: fields.value.detail,
      }));
    }

    watch (fields, () => {
      emit('developer-form-changed', fields.value)
    }, { deep: true })

    const updateLogo = (payload) => {
      fields.value.logofile = payload
    }

    return { fields, initEditorValue, updateLogo }
  }
}
</script>