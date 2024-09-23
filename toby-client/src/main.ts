import { createApp, reactive } from "vue";
import "./style.css";
import router from "./router"; // import the router
import App from "./App.vue";

const app = createApp(App);

app.use(router); // use the router in your app
app.mount("#app");
