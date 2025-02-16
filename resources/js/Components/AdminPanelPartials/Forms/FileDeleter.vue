<template>
  <div v-if="currentFileList.length" class="flex flex-wrap gap-2">
    <div
      v-for="(file, index) in currentFileList"
      :key="file"
      class="p-2 rounded-border flex flex-col border border-surface items-center justify-between gap-2"
    >
      <Button
        icon="pi pi-times"
        class="ml-auto p-button-sm p-button-text p-button-rounded p-button-danger"
        @click="onDeleteRequest(file)"
      />
      <div>
        <img role="presentation" :alt="file" :src="`${path}${file}`" width="100" height="50" />
      </div>
      <div class="mb-2 flex flex-col items-center gap-2">
        <span class="font-semibold text-ellipsis max-w-60 whitespace-nowrap overflow-hidden">{{ file }}</span>
        <Badge value="на сервере" severity="info" />
      </div>
    </div>
  </div>

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
import { ref } from 'vue'
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";

export default {
  props: {
    files: {
      type: Array,
      default: [],
    },
    path: {
      type: String,
      default: '/grch/'
    },
    deleteAction: {
      type: String,
      default: ''
    }
  },
  setup (props) {
    const currentFileList = ref(props.files)

    const confirm = useConfirm();

    const toast = useToast();

    const onDeleteRequest = (fileName) => {
      confirm.require({
        group: 'deleteConfirmationDialog',
        header: 'Удаление',
        message: 'Вы действительно хотите удалить этот файл?',
        accept: () => {
          axios.post(props.deleteAction)
            .then((response) => {
              let ind = currentFileList.value.indexOf(fileName);
              if (ind !== -1) {
                currentFileList.value.splice(ind, 1);
              }
              toast.add({ severity: 'info', summary: 'Готово', detail: 'Файл удален', life: 3000 });
            })
            .catch((error) => {
              console.error('Ошибка при удалении файла:', error);
              toast.add({ severity: 'error', summary: 'Ошибка', detail: 'Не удалось удалить файл', life: 3000 });
            });
        },
        reject: () => {
          toast.add({ severity: 'error', summary: 'Отмена', detail: 'Изменения не сохранены', life: 3000 });
        }
      });
    }

    return {
      currentFileList, onDeleteRequest
    }
  }
}
</script>