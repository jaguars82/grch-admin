<template>
  <div class="card">
    <h5 v-if="label" class="mb-2">{{ label }}</h5>
    <div v-if="currentFiles.length" class="mb-4">
      <FileDeleter :files="currentFiles" :deleteAction="deleteAction" />
    </div>
    <FileUpload
      mode="basic"
      :multiple="multiple"
      :accept="accept"
      :maxFileSize="maxFileSize"
      @select="onSelectedFiles"
      @clear="onClearTemplatingUpload"
    />
    <div v-if="files.length > 0" class="mt-4">
      <h5 v-if="files.length > 1">Ожидают загрузки</h5>
      <div class="flex flex-wrap gap-2">
        <div
          v-for="(file, index) in files"
          :key="file.name + file.type + file.size"
          class="p-2 rounded-border flex flex-col border border-surface items-center justify-between gap-2"
        >
          <div>
            <img role="presentation" :alt="file.name" :src="file.objectURL" width="100" height="50" />
          </div>
          <div class="flex flex-col items-center gap-2">
            <span class="font-semibold text-ellipsis max-w-60 whitespace-nowrap overflow-hidden">{{ file.name }}</span>
            <div>{{ formatSize(file.size) }} Кб</div>
            <Badge value="ожидание" severity="warning" />
            <Button
              icon="pi pi-times"
              class="p-button-rounded p-button-outlined p-button-danger"
              @click="onRemoveTemplatingFile(file, index)"
            />
          </div>
        </div>
      </div>
    </div>

    <div v-if="totalSize > 0" class="mt-4">
      <ProgressBar v-if="maxFileSize > 0" :value="totalSizePercent" :showValue="false" class="w-full h-1"></ProgressBar>
      <span v-if="multiple === true && maxFileSize === 0">Общий размер: </span>
      <span v-if="multiple === true">{{ totalSize }}B</span>
      <span v-if="maxFileSize > 0"> / {{ maxFileSize }}B</span>
    </div>
  </div>
</template>

<script>
import { ref, watch } from 'vue';
import { usePrimeVue } from 'primevue/config';
import { useToast } from 'primevue/usetoast';
import FileDeleter from '@/Components/AdminPanelPartials/Forms/FileDeleter'

export default {
  components: { FileDeleter },
  props: {
    label: {
      type: String,
      default: '',
    },
    accept: {
      type: String,
      default: '*',
    },
    multiple: {
      type: Boolean,
      default: false,
    },
    maxFileSize: {
      type: Number,
      default: 0,
    },
    currentFiles: {
      type: Array,
      default: [],
    },
    deleteAction: {
      type: String,
      default: '',
    }
  },
  setup(props, { emit }) {
    const $primevue = usePrimeVue();
    const toast = useToast();

    const totalSize = ref(0);
    const totalSizePercent = ref(0);
    const files = ref([]);

    watch (files, () => {
      emit('uploading-files-changed', files.value)
    }, { deep: true })

    const onRemoveTemplatingFile = (file, index) => {
      files.value.splice(index, 1);
      totalSize.value -= file.size;
      if (props.maxFileSize > 0) {
        totalSizePercent.value = Math.min((totalSize.value / props.maxFileSize) * 100, 100);
      }
    };

    const onClearTemplatingUpload = () => {
      files.value = [];
      totalSize.value = 0;
      totalSizePercent.value = 0;
    };

    const onSelectedFiles = (event) => {
      files.value = event.files;
      totalSize.value = files.value.reduce((sum, file) => sum + file.size, 0);
      if (props.maxFileSize > 0) {
        totalSizePercent.value = Math.min((totalSize.value / props.maxFileSize) * 100, 100);
      }
    };

    const formatSize = (bytes) => {
      const k = 1024;
      const dm = 2;
      if (bytes === 0) {
        return '0';
      }
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      const formattedSize = parseFloat((bytes / Math.pow(k, i)).toFixed(dm));
      return `${formattedSize}`;
    };

    return {
      totalSize,
      totalSizePercent,
      files,
      onRemoveTemplatingFile,
      onClearTemplatingUpload,
      onSelectedFiles,
      formatSize,
    };
  },
};
</script>