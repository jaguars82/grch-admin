<template>
  <AppLayout :title="`${developer.name} - ${t('company.developerUpdate')}`">
    <template #header>{{ developer.name }}</template>
    <template #subHeader>{{ t("company.developerUpdate") }}</template>
    <template #breadcrumb>
      <TBreadcrumb
        :breadcrumbs="breadcrumbs"
        position="left"
      >
      </TBreadcrumb>
    </template>
    <template #default>
      <DeveloperForm :developer="developer" @developer-form-changed="onFormChange" />
      <div class="mt-5 text-right">
        <Button icon="pi pi-check" :label="t('common.buttons.saveChanges')" @click="onDeveloperSave" :disabled="!formIsDirty" />
      </div>

    </template>
  </AppLayout>
</template>

<script>
import { ref } from 'vue';
import AppLayout from "@/Layouts/AppLayout";
import TBreadcrumb from "@/Components/Breadcrumb/TBreadcrumb";
import DeveloperForm from "@/Pages/Developer/Partials/DeveloperForm";
import { useLanguages } from "@/Composables/Languages";
import { useToast } from "primevue/usetoast";
import { Inertia } from "@inertiajs/inertia";

export default {
  components: { AppLayout, TBreadcrumb, DeveloperForm },
  props: {
    developer: {
      type: Object,
      default: {}
    },
  },
  setup (props) {
    const { t, tm } = useLanguages();

    const breadcrumbs = [
      { key: 'home', label: 'Главная', link: '/', active: false },
      { key: 'company', label: 'Участники рынка', link: '/company', active: false },
      { key: 'developer', label: 'Застройщики', link: '/company/developer', active: false },
      { key: 'developer-update', label: `Обновление застройщика ${props.developer.name}`, link: '', active: true, activeColor: 'solid-red' }
    ];

    const loading = ref(true);

    const toast = useToast();

    const fields = ref(null);

    const formIsDirty = ref(false);

    const onFormChange = (payload) => {
      fields.value = payload;
      formIsDirty.value = true;
    }

    const onDeveloperSave = () => {
      Inertia.post(route("developer-update"), fields.value, {
        forceFormData: true,
        /*onSuccess: () => {
          toast.add({
            severity: 'success',
            summary: 'Изменения сохранены',
            detail: 'Вы успешно отредактировали информацию о застройщике',
            life: 5000
          });
        },*/
        onError: (error) => {
          toast.add({
            severity: 'error',
            summary: 'Произошла ошибка',
            detail: 'Изменения не были сохранены',
            life: 5000
          });
        }
      });
    };

    return {
      t, tm,
      breadcrumbs,
      loading,
      formIsDirty,
      onFormChange,
      onDeveloperSave
    }
  }
}
</script>