<template>
    <NavbarComponent></NavbarComponent>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="container-fluid">
                    <div class="row mt-2 mb-5">
                        <NavigationColetorZyoraComponent></NavigationColetorZyoraComponent>
                    </div>
                </div>  
            </div>
        </div>
        <div class="row">
            <div class="col p-3">
                <RouterView></RouterView>
            </div>
        </div>
    </div>
</template>

<script setup>
    import NavbarComponent from '@/components/Zyora/NavbarZyoraComponent.vue';
    import NavigationColetorZyoraComponent from '@/components/Zyora/NavigationColetorZyoraComponent.vue';
</script>

<style scoped>
    .col-6, .col-12{
        padding: 0
    }
</style>
