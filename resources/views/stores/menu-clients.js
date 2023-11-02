import { defineStore } from 'pinia'

export const menuClients = defineStore('menuId', {
  state: () => ({
      selectedKeys:[],
  }),
  actions:{
    onSlectedKeys(data){
      this.selectedKeys = data;
    },
  }
});
