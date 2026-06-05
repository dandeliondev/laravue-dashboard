<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    title: { type: String, default: '' },
});
</script>

<template>
    <main class="main-content">
        <div class="admin">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8 col-sm-10">
                        <div class="edit-profile mt-md-25 mt-0">
                            <div class="edit-profile__logos">
                                <Link href="/">
                                    <img class="dark" src="/hexadash/img/logo-dark.png" alt="logo" />
                                    <img class="light" src="/hexadash/img/logo-white.png" alt="logo" />
                                </Link>
                            </div>
                            <div class="card border-0">
                                <div v-if="title" class="card-header">
                                    <div class="edit-profile__title">
                                        <h6>{{ title }}</h6>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="edit-profile__body">
                                        <slot />
                                    </div>
                                </div>
                                <slot name="footer" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
