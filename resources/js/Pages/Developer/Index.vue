<template>
  <AppLayout :title="t('company.developers')">
    <template #header>{{ t("company.developers") }}</template>
    <template #subHeader>{{ t("company.developersList") }}</template>
    <template #breadcrumb>
      <TBreadcrumb
        :breadcrumbs="breadcrumbs"
        position="left"
      >
      </TBreadcrumb>
    </template>
    <template #default>
      <div class="mb-4">
        <Button icon="pi pi-plus" :label="t('company.developerCreate')" @click="goToDeveloperCreate" />
      </div>
      <DataTable :value="developers" tableStyle="">
        <Column field="id" header="ID"></Column>
        <Column field="name" header="Название">
          <template #body="slotProps">
            <span class="font-bold cursor-pointer" @click="onEdit(slotProps.data.id)">{{ slotProps.data.name }}</span>
          </template>
        </Column>
        <Column field="logo" header="Лого">
          <template #body="slotProps">
            <Image v-if="slotProps.data.logo" :src="`/grch/${slotProps.data.logo}`" alt="Logo" width="100" />
          </template>
        </Column>
        <Column field="actions" header="">
          <template #body="slotProps">
            <div class="flex items-center">
              <Button icon="pi pi-times" class="p-button-rounded p-button-danger p-button-outlined mr-1" v-tooltip="t('company.developerRemove')" @click="onRemove(slotProps.data)" />
              <Button icon="pi pi-pencil" class="p-button-rounded p-button-info p-button-outlined" v-tooltip="t('company.developerUpdate')" @click="onEdit(slotProps.data.id)" />
            </div>
          </template>
        </Column>
      </DataTable>
    </template>
  </AppLayout>

  <ConfirmDialog group="deleteConfirmationDialog">
    <template #container="{ message, acceptCallback, rejectCallback }">
      <div class="flex flex-column align-items-center p-5 surface-overlay border-round">
        <span class="font-bold text-2xl block mb-2 mt-4">{{ message.header }}</span>
        <p class="mb-0">{{ message.message }}</p>
        <div class="flex align-items-center gap-2 mt-4">
          <Button label="Save" @click="acceptCallback" class="w-8rem"></Button>
          <Button label="Cancel" outlined @click="rejectCallback" class="w-8rem"></Button>
        </div>
      </div>
    </template>
  </ConfirmDialog>
</template>

<script>
import { ref } from 'vue';
import AppLayout from "@/Layouts/AppLayout";
import TBreadcrumb from "@/Components/Breadcrumb/TBreadcrumb";
import { useLanguages } from "@/Composables/Languages";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import { Inertia } from "@inertiajs/inertia";

export default {
  components: { AppLayout, TBreadcrumb },
  props: {
    developers: {
      type: Array,
      default: []
    },
  },
  setup (props) {
    const { t, tm } = useLanguages();

    const breadcrumbs = [
      { key: 'home', label: 'Главная', link: '/', active: false },
      { key: 'company', label: 'Участники рынка', link: '/company', active: false },
      { key: 'developer', label: 'Застройщики', link: '', active: true, activeColor: 'solid-red' }
    ];

    const loading = ref(true);

    const goToDeveloperCreate = () => {
      Inertia.get('/company/developer/create');
    }

    const onEdit = (developerId) => {
      Inertia.get(`/company/developer/${developerId}/edit`);
    }

    /*const onRemove = (developerId) => {
      console.log(`remove ${developerId}`);
    }*/
    const confirm = useConfirm();

    const toast = useToast();

    const onRemove = (developer) => {
      confirm.require({
        group: 'deleteConfirmationDialog',
        header: 'Удаление застройщика',
        message: `Вы действительно хотите удалить застройщика ${developer.name}`,
        accept: () => {
          axios.delete(`/company/developer/${developer.id}/delete`)
            .then((response) => {
              toast.add({ severity: 'info', summary: 'Готово', detail: 'Застройщик удален', life: 3000 });
            })
            .catch((error) => {
              console.error('Ошибка при удалении застройщика:', error);
              toast.add({ severity: 'error', summary: 'Ошибка', detail: `Не удалось удалить застройщика`, life: 3000 });
            });
        },
        reject: () => {
          toast.add({ severity: 'error', summary: 'Отмена', detail: 'Изменения не сохранены', life: 3000 });
        }
      });
    }

    return {
      t, tm,
      breadcrumbs,
      loading,
      goToDeveloperCreate,
      onEdit,
      onRemove,
    }
  }
}
</script>