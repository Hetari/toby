import { ref, watch } from 'vue';
import Collections from './Collections.vue';
import sideBar from './SideBar.vue';
import Users from './Users.vue';

const isShow = ref(true);
const sideBarGridShow = ref('col-span-2 lg:col-span-1');
const collectionsGridShow = ref('col-span-16 lg:col-span-19');
const userGridShow = ref('col-span-6 lg:col-span-4');

const sideBarGridHide = ref('col-span-0 -translate-x-full hidden');
const collectionsGridHide = ref('col-span-19');
const userGridHide = ref('col-span-5');

const sideBarGrid = ref(sideBarGridShow.value);
const collectionsGrid = ref(collectionsGridShow.value);
const userGrid = ref(userGridShow.value);

const show = () => {
  collectionsGrid.value = collectionsGridShow.value;
  sideBarGrid.value = sideBarGridShow.value;
  userGrid.value = userGridShow.value;
};

const hide = () => {
  collectionsGrid.value = collectionsGridHide.value;
  sideBarGrid.value = sideBarGridHide.value;
  userGrid.value = userGridHide.value;
};

const toggleShow = () => {
  isShow.value = !isShow.value;
};

watch(isShow, (newVal) => {
  if (newVal) {
    show();
  } else {
    hide();
  }
});

export {
  Collections,
  sideBar,
  Users,
  toggleShow,
  collectionsGrid,
  sideBarGrid,
  userGrid,
};
