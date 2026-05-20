import { createApp } from "vue";
import "./app/style.css";
import router from "./router";
import App from "./app/App.vue";

createApp(App).use(router).mount("#app");
