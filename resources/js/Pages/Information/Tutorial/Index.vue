<template>
  <AppLayout :title="t('tutorial.tutorial')">
    <template #header>{{ t("tutorial.tutorial") }}</template>
    <template #subHeader>{{ t("tutorial.lessonList") }}</template>
    <template #breadcrumb>
      <TBreadcrumb
        :breadcrumbs="breadcrumbs"
        position="left"
      >
      </TBreadcrumb>
    </template>
    <template #default>

      <div class="mb-3 flex">
        <div class="flex-col mr-2">
          <Button :label="t('tutorial.lessonCreate')" icon="pi pi-plus-circle" @click="goToLessonCreate" />
        </div>
      </div>

      <DataTable :value="lessonsTable" tableStyle="" @rowReorder="onRowReorder">
        <Column rowReorder headerStyle="width: 3rem" />
        <Column field="sort_order" headerStyle="width: 3rem" header="№"></Column>
        <Column field="title" header="Урок">
          <template #body="slotProps">
            <h4>{{ slotProps.data.title }}</h4>
            <h5 v-if="slotProps.data.subtitle">{{ slotProps.data.subtitle }}</h5>
          </template>
        </Column>
        <Column field="video_source" header="Видеоисточник">
          <template #body="slotProps">
            <a target="_blank" :href="slotProps.data.video_source">{{ slotProps.data.video_source }}</a>
          </template>
        </Column>
        <Column headerStyle="width: 7rem">
          <template #body="slotProps">
            <Button icon="pi pi-pencil" class="p-button-rounded" v-tooltip.top="'Редактировать урок'" @click="goToLessonEdit(slotProps.data.id)" />
            <Button icon="pi pi-times" class="ml-1 p-button-rounded p-button-outlined p-button-danger" v-tooltip.left="'Удалить урок'" @click="requireDeleteConfirmation(slotProps.data.id)" />
          </template>
        </Column>
      </DataTable>

      <ConfirmDialog group="reoderConfirmationDialog">
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
  </AppLayout>
</template>

<script>
import { ref, computed } from 'vue';
import AppLayout from "@/Layouts/AppLayout";
import TBreadcrumb from "@/Components/Breadcrumb/TBreadcrumb";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import { useLanguages } from "@/Composables/Languages";
import { Inertia } from "@inertiajs/inertia";

export default {
  components: { AppLayout, TBreadcrumb },
  props: {
    lessons: {
      type: Array,
      default: []
    },
  },
  setup (props) {
    const { t, tm } = useLanguages();

    const breadcrumbs = [
      { key: 'home', label: 'Главная', link: '/', active: false },
      { key: 'information', label: 'Информация', link: '/information', active: false },
      { key: 'tutorial', label: 'Обучение', link: '', active: true, activeColor: 'solid-red' }
    ];

    const lessonsTable = ref(props.lessons);

    const confirm = useConfirm();

    const toast = useToast();

    const goToLessonCreate = () => {
      Inertia.get('tutorial/lesson/create');
    }

    const goToLessonEdit = (lessonId) => {
      Inertia.get('tutorial/lesson/update', { id: lessonId });
    }

    const requireReoderConfirmation = () => {
        confirm.require({
          group: 'reoderConfirmationDialog',
          header: 'Реорганизация',
          message: 'Вы изменили порядок расположения уроков. Сохранить его?',
          accept: () => {
            Inertia.post(
              'tutorial/lesson/reoder', 
              {
                lessons: lessonsTable.value
              },
              {
                onSuccess: (page) => {
                  lessonsTable.value = props.lessons;
                  toast.add({ severity: 'info', summary: 'Готово', detail: 'Новый порядок расположения уроков сохранен', life: 3000 });
                },
              }
            );
          },
          reject: () => {
            lessonsTable.value = props.lessons;
            toast.add({ severity: 'error', summary: 'Отмена', detail: 'Изменения не сохранены', life: 3000 });
          }
      });
    }
    
    const requireDeleteConfirmation = (lessonId) => {
        confirm.require({
          group: 'reoderConfirmationDialog',
          header: 'Удаление',
          message: 'Вы действительно хотите удалить этот урок?',
          accept: () => {
            Inertia.post(
              'tutorial/lesson/delete', 
              {
                id: lessonId
              },
              {
                onSuccess: (page) => {
                  lessonsTable.value = props.lessons;
                  toast.add({ severity: 'info', summary: 'Готово', detail: 'Урок удален', life: 3000 });
                },
              }
            );
          },
          reject: () => {
            // lessonsTable.value = props.lessons;
            // toast.add({ severity: 'error', summary: 'Отмена', detail: 'Изменения не сохранены', life: 3000 });
          }
      });
    }

    const onRowReorder = (event) => {
      lessonsTable.value = event.value;
      requireReoderConfirmation();
      //toast.add({severity:'success', summary: 'Rows Reordered', life: 3000});
    };

    return {
      t, tm,
      breadcrumbs,
      goToLessonCreate,
      goToLessonEdit,
      lessonsTable,
      onRowReorder,
      requireDeleteConfirmation,
    }
  }
}

</script>