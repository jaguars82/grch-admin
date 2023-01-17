<template>
    <app-layout title="Dashboard" :header="tm('title')">
        <template #breadcrumb>
            <t-breadcrumb :breadcrumb-style="1" :breadcrumbs="breadcrumbs" color="white"/>
        </template>
        <template #default>
            <!--Statistical Widgets-->
            <!--<grid-section :col="2">-->
                <!--With Icon, Down Direction-->
                <!--<t-statistic-widget
                    color="solid-black"
                    diff-direction="down"
                    diff-value="15%"
                    widget-value="254">
                    <template #title>
                        <span v-t="'incomes'"/>
                    </template>
                    <template #icon>
                        <t-cash-icon class="w-16 h-16"/>
                    </template>
                </t-statistic-widget>-->
                <!--With Icon, Up Direction-->
                <!--<t-statistic-widget
                    :radius="5"
                    color="solid-green"
                    diff-direction="up"
                    diff-value="8"
                    widget-value="30">
                    <template #title>
                        <span v-t="'dailyDoneCharts'"/>
                    </template>
                    <template #icon>
                        <t-shopping-bag-icon class="w-16 h-16"/>
                    </template>
                </t-statistic-widget>-->
                <!--Simple-->
                <!--<t-statistic-widget
                    :radius="5"
                    color="solid-red"
                    diff-direction="down"
                    diff-value="8%"
                    widget-value="12.254,05 TL">
                    <template #title>
                        <span v-t="'refunds'"/>
                    </template>
                </t-statistic-widget>--->
                <!--With Picture, Down Direction-->
                <!--<t-statistic-widget
                    :radius="5"
                    color="solid-white"
                    diff-direction="down"
                    diff-value="15%"
                    widget-value="254 USD">
                    <template #title>
                        <span v-t="'stationeryCost'"/>
                    </template>
                    <template #picture>
                        <img :src="'/img/samples/imgMelBaylon-6WLcOFn4HKE-unsplash.jpg'">
                    </template>
                </t-statistic-widget>-->
            <!--</grid-section>-->
            
            <!--Content Box-->
            <!--<grid-section :col="3">

                <t-content-card :width="1">
                    <template #title>
                        <span v-t="'userList'"/>
                    </template>
                    <template #content>
                        <t-list :radius="3" class="w-full" design="light" color="white" border>
                            <t-list-item>
                                <template #icon>
                                    <t-avatar :radius="8" :size="2" src="https://i.pravatar.cc/150?u=1"></t-avatar>
                                </template>
                                <template #default>{{tm('name1')}}</template>
                            </t-list-item>
                            <t-list-item>
                                <template #icon>
                                    <t-avatar :radius="8" :size="2" src="https://i.pravatar.cc/150?u=2"></t-avatar>
                                </template>
                                <template #default>{{tm('name2')}}</template>
                            </t-list-item>
                            <t-list-item>
                                <template #icon>
                                    <t-avatar :radius="8" :size="2" src="https://i.pravatar.cc/150?u=3"></t-avatar>
                                </template>
                                <template #default>{{tm('name3')}}</template>
                            </t-list-item>
                            <t-list-item>
                                <template #icon>
                                    <t-avatar :radius="8" :size="2" src="https://i.pravatar.cc/150?u=4"></t-avatar>
                                </template>
                                <template #default>{{tm('name4')}}</template>
                            </t-list-item>
                        </t-list>
                    </template>
                </t-content-card>
                <t-content-card :width="2">
                    <template #title>
                        <span v-t="'activeProjects'"/>
                    </template>
                    <template #content>

                        <t-table
                            :content="tableContent"
                            :header="tableHeader"
                            :features="tableFeatures"
                        >
                            <template #status="{props}">
                                <div class="flex justify-center">
                                    <t-progress :model-value="props.status" color="green"/>
                                </div>
                            </template>
                        </t-table>
                    </template>
                </t-content-card>
            </grid-section>-->
            
            <!--Alerts-->
            <!--<grid-section :col-tablet="3">
                <t-alert design="filled" :closeable="true" color="danger">
                    <template #icon>
                        <t-trash-icon slot="icon" class="w-6 h-6"/>
                    </template>
                    <span v-t="'alertDeleted'"/>
                </t-alert>
                <t-alert design="inline" color="info">
                    <template #icon>
                        <t-information-circle-icon class="w-6 h-6"/>
                    </template>
                    <span v-t="'alertOverwrite'"/>
                </t-alert>
                <t-alert design="outline" color="success">
                    <template #icon>
                        <t-check-circle-icon class="w-6 h-6"/>
                    </template>
                    <span v-t="'alertSaved'"/>
                </t-alert>
            </grid-section>-->

            <!--Rich Alerts-->
            <!--<grid-section :col-tablet="2">
                <t-alert :radius="3" design="gradient" color="fuchsia" :closeable="true">
                    <template #icon>
                        <t-avatar :radius="8" :size="3" src="https://i.pravatar.cc/300"/>
                    </template>
                    <span v-html="tm('alertNewUser')"/>
                </t-alert>
                <t-alert
                    :radius="3"
                    design="elegant"
                    :title="tm('alertDeletedUserTitle')"
                    color="warning"
                    :closeable="true"
                >
                    <span v-html="tm('alertDeletedUser')"/>
                </t-alert>
            </grid-section>-->
        </template>
    </app-layout>
</template>

<script>
/*Main functions*/
import {defineComponent, reactive} from "vue";

/*Components*/
import AppLayout from "@/Layouts/AppLayout.vue";
import GridSection from "@/Layouts/GridSection";
import TStatisticWidget from "@/Components/Card/TStatisticWidget";
import TCashIcon from "@/Components/Icon/TCashIcon";
import TShoppingBagIcon from "@/Components/Icon/TShoppingBagIcon";
import TContentCard from "@/Components/Card/TContentCard";
import TList from "@/Components/List/TList";
import TListItem from "@/Components/List/TListItem";
import TAvatar from "@/Components/Avatar/TAvatar";
import TTable from "@/Components/Table/TTable";
import TBreadcrumb from "@/Components/Breadcrumb/TBreadcrumb";
import TProgress from "@/Components/Progress/TProgress";
import TAlert from "@/Components/Alert/TAlert";
import TInformationCircleIcon from "@/Components/Icon/TInformationCircleIcon";
import TTrashIcon from "@/Components/Icon/TTrashIcon";
import TCheckCircleIcon from "@/Components/Icon/TCheckCircleIcon";

/*Multi language*/
import {useI18n} from "vue-i18n";

export default defineComponent({
    components: {
        AppLayout,
        TCheckCircleIcon,
        TTrashIcon,
        TInformationCircleIcon,
        TAlert,
        TProgress,
        TBreadcrumb,
        TTable,
        TAvatar,
        TListItem,
        TList,
        TContentCard,
        TShoppingBagIcon,
        TCashIcon,
        TStatisticWidget,
        GridSection
    },
    setup() {
        const {tm} = useI18n({
            messages: {
                en: {
                    title: "Welcome to Anemon",
                    home: "Home",
                    dashboard: "Dashboard",
                    incomes: "Incomes",
                    dailyDoneCharts: "Daily Done Charts",
                    refunds: "Refunds",
                    stationeryCost: "Refunds",
                    userList: "Users List",
                    activeProjects: "Active Projects",
                    name: "Name",
                    startDate: "Start Date",
                    endDate: "End Date",
                    status: "Status",
                    simpleSearch: "Simple Search",
                    name1: "Sinem Aydoğan",
                    name2: "Reema Oconnor",
                    name3: "Mia-Rose Justice",
                    name4: "Louise Watts",
                    alertDeleted: "The user deleted successfully,click me",
                    alertOverwrite: "The all of changes overwrite to themself",
                    alertSaved: "New item saved successfully",
                    alertNewUser: "The new user is successfully added." +
                        "<br/><b>User:</b> Sinan AYDOĞAN",
                    alertDeletedUserTitle: "warning",
                    alertDeletedUser: "The user deleted successfully" +
                        "<br/><b>User:</b> Zuhal TAŞÇI"
                },
                ru: {
                    title: "Добро пожаловать в Панель Управления ГРЧ",
                    home: "Главная",
                    dashboard: "Панель управления",
                    incomes: "Доходы",
                    dailyDoneCharts: "Ежедневные диаграммы",
                    refunds: "Возвраты",
                    stationeryCost: "Возврат",
                    userList: "Список пользователей",
                    activeProjects: "Активные проекты",
                    name: "Имя",
                    startDate: "Дата начала",
                    endDate: "Дата окончания",
                    status: "Статус",
                    simpleSearch: "Простой поиск",
                    name1: "Siyan Alekov Hristov",
                    name2: "Shepkin Onufri Victorovich",
                    name3: "Eybozhenko Lada Nikolayevna",
                    name4: "Mager Vlada Makarovna",
                    alertDeleted: "Пользователь успешно удален, нажмите на меня",
                    alertOverwrite: "Все изменения перезаписываются на себя",
                    alertSaved: "Новый элемент успешно сохранен",
                    alertNewUser: "Новый пользователь успешно добавлен." +
                        "<br/><b>Пользователь:</b> Синан АЙДОГАН",
                    alertDeletedUserTitle: "предупреждение",
                    alertDeletedUser: "Пользователь успешно удален" +
                        "<br/><b>Пользователь:</b> Зухал ТАШИ"
                },
            }
        });
        const breadcrumbs = reactive([
            {label: tm("home"), link: "/", active: false},
            {label: tm("dashboard"), link: "", active: true, activeColor: "blue"}
        ]);
        const tableHeader = reactive([
            {key: "id", label: "ID", align: "center"},
            {key: "name", label: "Name", align: "left", searchable: true, status: true},
            {key: "start", label: "Start Date", align: "left", status: true},
            {key: "end", label: "End Date", align: "left", status: true},
            {key: "status", label: "Status", align: "center", status: true}
        ])
        const tableContent = reactive([
            {id: 1, name: "VueJS Components", start: "01.03.2021", end: "14.09.2021", status: 10},
            {id: 2, name: "Custom Style Optimize", start: "02.05.2021", end: "25.08.2021", status: 20},
            {id: 3, name: "Error Management", start: "25.04.2021", end: "30.12.2021", status: 70}
        ])
        const tableFeatures = reactive({
            table: {
                design: 'elegant',
                rowBorder: true,
                zebraRow: true,
                radius: 3,
                perPage: 5
            },
            pagination: {
                status: true,
                radius: 3,
                range: 5,
                jump: true,
                nextText: "Sonraki",
                previousText: "Önceki",
                detailText: "Sayfa: $a - $b"
            },
            actions: {
                status: true,
                headerText: "Aksiyonlar"
            },
            deleteModal: {
                headerText: "Item's deleting",
                contentText: "You are going to delete <br><b></b><br>Are you sure ?",
                icon: "warning"
            }
        });
        return {tm, breadcrumbs, tableHeader, tableContent, tableFeatures};
    }
});
</script>
