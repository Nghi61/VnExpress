<template>
    <div>
        <Header></Header>
        <div class="container">
            <div class="row">
                <div class="col-12 d-sm-flex d-none ">
                    <a-list style="width: 100%;">
                        <Menu />
                    </a-list>
                </div>
                <div class="col-12">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Header from '../Block/clients/header.vue';
import Menu from '../Block/clients/menu.vue';
export default {
    components: {
        Header,
        Menu
    }
}
</script>

