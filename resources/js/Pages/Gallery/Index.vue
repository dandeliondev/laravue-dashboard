<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageHeader from '@/Components/Hexadash/PageHeader.vue';

const images = [
    { src: '/hexadash/img/blog2.png', title: 'Mountain Range', cat: 'Nature' },
    { src: '/hexadash/img/blog3.png', title: 'City Lights', cat: 'Urban' },
    { src: '/hexadash/img/blog4.png', title: 'Forest Path', cat: 'Nature' },
    { src: '/hexadash/img/blog5.png', title: 'Workspace', cat: 'People' },
    { src: '/hexadash/img/blog6.png', title: 'Architecture', cat: 'Urban' },
    { src: '/hexadash/img/blog7.png', title: 'Team Meeting', cat: 'People' },
    { src: '/hexadash/img/blog8.png', title: 'Ocean View', cat: 'Nature' },
    { src: '/hexadash/img/blog9.png', title: 'Street Style', cat: 'Urban' },
    { src: '/hexadash/img/blog10.png', title: 'Portrait', cat: 'People' },
    { src: '/hexadash/img/blog11.png', title: 'Sunset Hills', cat: 'Nature' },
];

const cats = ['All', 'Nature', 'Urban', 'People'];
const active = ref('All');
const filtered = computed(() => active.value === 'All' ? images : images.filter((i) => i.cat === active.value));

const lightbox = ref(null);
const lightboxIndex = ref(0);
const open = (img) => { lightboxIndex.value = filtered.value.indexOf(img); lightbox.value = img; };
const step = (d) => {
    const len = filtered.value.length;
    lightboxIndex.value = (lightboxIndex.value + d + len) % len;
    lightbox.value = filtered.value[lightboxIndex.value];
};
</script>

<template>
    <Head title="Gallery" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12"><PageHeader title="Gallery" :breadcrumbs="[{ label: 'Gallery' }]" /></div>
            </div>

            <div class="btn-group mb-3">
                <button v-for="c in cats" :key="c" type="button" class="btn btn-sm"
                    :class="active === c ? 'btn-primary' : 'btn-outline-light'" @click="active = c">{{ c }}</button>
            </div>

            <div class="hx-gallery">
                <div v-for="img in filtered" :key="img.src" class="hx-gallery__item" @click="open(img)">
                    <img :src="img.src" :alt="img.title" loading="lazy" />
                    <div class="hx-gallery__overlay">
                        <span class="fw-500">{{ img.title }}</span>
                        <small>{{ img.cat }}</small>
                        <i class="uil uil-search-plus"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lightbox -->
        <Teleport to="body">
            <Transition name="hx-fade">
                <div v-if="lightbox" class="hx-lightbox" @click.self="lightbox = null">
                    <button class="hx-lightbox__close" @click="lightbox = null"><i class="uil uil-times"></i></button>
                    <button class="hx-lightbox__nav left" @click="step(-1)"><i class="uil uil-angle-left"></i></button>
                    <figure>
                        <img :src="lightbox.src" :alt="lightbox.title" />
                        <figcaption>{{ lightbox.title }} · {{ lightbox.cat }}</figcaption>
                    </figure>
                    <button class="hx-lightbox__nav right" @click="step(1)"><i class="uil uil-angle-right"></i></button>
                </div>
            </Transition>
        </Teleport>
    </AuthenticatedLayout>
</template>

<style scoped>
.hx-gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 16px; }
.hx-gallery__item { position: relative; border-radius: 10px; overflow: hidden; cursor: pointer; aspect-ratio: 4/3; }
.hx-gallery__item img { width: 100%; height: 100%; object-fit: cover; transition: transform .35s; }
.hx-gallery__item:hover img { transform: scale(1.08); }
.hx-gallery__overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(15,18,38,.7), transparent 55%); color: #fff;
    display: flex; flex-direction: column; justify-content: flex-end; padding: 14px; opacity: 0; transition: opacity .25s; }
.hx-gallery__item:hover .hx-gallery__overlay { opacity: 1; }
.hx-gallery__overlay i { position: absolute; top: 14px; right: 14px; font-size: 20px; }
.hx-lightbox { position: fixed; inset: 0; background: rgba(10,12,28,.92); z-index: 4000; display: flex; align-items: center; justify-content: center; gap: 18px; }
.hx-lightbox figure { margin: 0; max-width: 80vw; max-height: 85vh; text-align: center; }
.hx-lightbox img { max-width: 100%; max-height: 78vh; border-radius: 8px; }
.hx-lightbox figcaption { color: #cfd2e6; margin-top: 12px; }
.hx-lightbox__close { position: absolute; top: 24px; right: 28px; }
.hx-lightbox__close, .hx-lightbox__nav { background: rgba(255,255,255,.12); color: #fff; border: 0; width: 44px; height: 44px; border-radius: 50%; font-size: 20px; cursor: pointer; }
.hx-lightbox__close:hover, .hx-lightbox__nav:hover { background: rgba(255,255,255,.24); }
.hx-fade-enter-active, .hx-fade-leave-active { transition: opacity .2s; }
.hx-fade-enter-from, .hx-fade-leave-to { opacity: 0; }
</style>
