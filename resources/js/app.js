import { createApp } from "vue";
import { createPinia } from "pinia";
import router from "../views/router/index.js";
import axios from "axios";
import {
    Spin,
    Comment,
    Form,
    FormItem,
    ListItem,
    Tooltip,
    Radio,
    Upload,
    Modal,
    Dropdown,
    Checkbox,
    Input,
    Select,
    Avatar,
    Table,
    Card,
    Menu,
    List,
    Drawer,
    Button,
    message,
    Pagination
} from "ant-design-vue";

import App from "./app.vue";

const app = createApp(App);
app.use(createPinia());
app.use(router);
app.component('AForm', Form);
app.component('ACheckbox', Checkbox);
app.component('AFormItem', FormItem);
app.component('list', List);
app.use(Spin);
app.use(Tooltip);
app.use(Comment);
app.use(Pagination);
app.use(Input);
app.use(Select);
app.use(Avatar);
app.use(Table);
app.use(Card);
app.use(Menu);
app.use(List);
app.use(Button);
app.use(Drawer);
app.use(Dropdown);
app.use(Modal);
app.use(Upload);
app.use(Radio);
app.mount("#app");

app.config.globalProperties.$message = message;
