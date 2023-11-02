<template>
    <Header/>
    <div class="container-fluid mt-3">
        <div class="row">

            <div class="col-3 d-none d-sm-flex">
                <a-list bordered style="width: 100%;">
                    <Menu />
                    <template #header>
                        <div>BẢNG ĐIỀU KHIỂN</div>
                    </template>
                </a-list>
            </div>
            <div class="col-sm-9 col-12">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>
<script>
import Header from '../Block/admin/header.vue';
import Menu from '../Block/admin/menu.vue';
export default {
    components: {
        Header,
        Menu
    }
}
</script>
<style>
.center-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 5px;
}

.input-danger {
    border: 1px solid red;
}

.center-icon {
    display: flex;
    align-items: center;
    justify-content: center;
}

a {
    text-decoration: none;
}
.avatar{
    width: 30px;
    height: 30px;
}
</style>

